/*
| Статический экспорт витрины для GitHub Pages.
|
| Скрипт обходит поднятое приложение по списку `php artisan site:urls`,
| раскладывает ответы файлами `<путь>/index.html` и копирует публичные файлы.
| Корневые пути переписываются под подкаталог, в котором Pages отдаёт проект
| (`https://<логин>.github.io/<репозиторий>/`), а фотографии товаров — на
| боевой домен: в репозитории их нет и быть не должно.
|
| Запуск:
|   node tools/static-export.mjs --origin=http://127.0.0.1:8000 \
|       --base=radop-app --site=https://denisbocharov12.github.io \
|       --media=https://radop.md --out=dist
*/

import fs from 'node:fs/promises'
import path from 'node:path'
import { execFileSync } from 'node:child_process'
import { createHash } from 'node:crypto'

const args = Object.fromEntries(
    process.argv.slice(2).map((item) => {
        // Делим по первому знаку равенства: значение --urls само состоит из
        // ключей вида --max-products=600 и при обычном split теряется.
        const raw = item.replace(/^--/, '')
        const at = raw.indexOf('=')

        return at === -1 ? [raw, ''] : [raw.slice(0, at), raw.slice(at + 1)]
    }),
)

const origin = (args.origin || 'http://127.0.0.1:8000').replace(/\/$/, '')
const base = args.base === undefined || args.base === '' ? '' : `/${args.base.replace(/^\/|\/$/g, '')}`
const site = (args.site || '').replace(/\/$/, '')
const mediaOrigin = (args.media || '').replace(/\/$/, '')
const outDir = path.resolve(args.out || 'dist')
const urlsArgs = (args.urls || '').split(' ').filter(Boolean)

/*
| Каталоги public, которые уезжают в статику как есть.
|
| Из наследного public/v1 берём только то, на что ссылаются страницы: целиком
| это 41 МБ примеров и шрифтов старой темы, которые витрине уже не нужны.
*/
const assetDirs = [
    'build',
    'brand',
    'fonts',
    'images',
    'v1/frontend/assets/js',
    'v1/frontend/assets/libs',
    'v1/frontend/assets/images',
    'v1/frontend/assets/font-icon',
]

/** Отдельные файлы из public. */
const assetFiles = ['favicon.ico', 'default.png']

/*
| Корневые пути, зашитые в разметку и в собранный бандл: на Pages проект
| живёт в подкаталоге, поэтому /build/app.css превращается в
| /radop-app/build/app.css.
*/
const rootPrefixes = ['/build/', '/brand/', '/v1/', '/fonts/', '/images/', '/favicon.ico', '/default.png']

/** Пути, которые отдаёт приложение, а не репозиторий: фото товаров и баннеров. */
const remotePrefixes = ['/media/', '/storage/', '/cert/']

const publicRoot = site === '' ? base : `${site}${base}`

const originVariants = [...new Set([
    origin,
    origin.replace(/^https:/, 'http:'),
    origin.replace(/^http:/, 'https:'),
])]

function escapeSlashes(value) {
    return value.replaceAll('/', '\\/')
}

/**
 * Переписывает адреса: домен приложения — на адрес публикации, корневые пути —
 * под подкаталог, фотографии — на боевой домен.
 */
function rewrite(text) {
    let result = text

    for (const variant of originVariants) {
        result = result
            .replaceAll(variant, publicRoot)
            .replaceAll(escapeSlashes(variant), escapeSlashes(publicRoot))
    }

    /*
    | Фотографии: /media/... → https://radop.md/media/...
    |
    | Адрес снимка собирается из настроек диска, и перед путём может стоять
    | любой хост: адрес приложения, адрес публикации или хост из .env. Поэтому
    | сначала срезаем хост целиком, а потом добавляем боевой.
    */
    if (mediaOrigin !== '') {
        for (const prefix of remotePrefixes) {
            const target = `${mediaOrigin}${prefix}`
            const escapedPrefix = prefix.replaceAll('/', '\\\\?/')

            // С хостом: https://любой.хост/media/...
            result = result.replace(
                new RegExp(`https?:(\\\\?/\\\\?/|//)[^"'\\s\\\\]+${escapedPrefix}`, 'g'),
                (match) => (match.includes('\\/') ? escapeSlashes(target) : target),
            )

            // Без хоста: "/media/...
            result = result.replaceAll(`"${prefix}`, `"${target}`)
            result = result.replaceAll(`'${prefix}`, `'${target}`)
            result = result.replaceAll(`=${prefix}`, `=${target}`)
            result = result.replaceAll(`"${escapeSlashes(prefix)}`, `"${escapeSlashes(target)}`)
        }
    }

    if (base === '') {
        return result
    }

    for (const prefix of rootPrefixes) {
        result = result.replaceAll(`"${prefix}`, `"${base}${prefix}`)
        result = result.replaceAll(`'${prefix}`, `'${base}${prefix}`)
        result = result.replaceAll(`(${prefix}`, `(${base}${prefix}`)
        result = result.replaceAll(`=${prefix}`, `=${base}${prefix}`)

        const escaped = escapeSlashes(prefix)
        const escapedBase = escapeSlashes(base)

        result = result.replaceAll(`"${escaped}`, `"${escapedBase}${escaped}`)
        result = result.replaceAll(`&quot;${escaped}`, `&quot;${escapedBase}${escaped}`)
    }

    return result
}

async function writeFile(relative, contents) {
    const target = path.join(outDir, relative)

    await fs.mkdir(path.dirname(target), { recursive: true })
    await fs.writeFile(target, contents)
}

async function copyAssets() {
    for (const dir of assetDirs) {
        const source = path.resolve('public', dir)

        try {
            await fs.access(source)
        } catch {
            console.warn(`  пропуск public/${dir} — каталога нет`)

            continue
        }

        await fs.cp(source, path.join(outDir, dir), { recursive: true, dereference: true })
        console.log(`  скопирован public/${dir}`)
    }

    for (const file of assetFiles) {
        try {
            await fs.copyFile(path.resolve('public', file), path.join(outDir, file))
        } catch {
            // Файла нет — не беда
        }
    }

    if (base !== '' || mediaOrigin !== '') {
        await rewriteTree(path.join(outDir, 'build'))
    }
}

async function rewriteTree(dir) {
    let entries = []

    try {
        entries = await fs.readdir(dir, { withFileTypes: true })
    } catch {
        return
    }

    for (const entry of entries) {
        const target = path.join(dir, entry.name)

        if (entry.isDirectory()) {
            await rewriteTree(target)

            continue
        }

        if (!/\.(js|css|json|map)$/.test(entry.name)) {
            continue
        }

        await fs.writeFile(target, rewrite(await fs.readFile(target, 'utf8')))
    }
}

/*
| Витрина на Pages только показывает: корзина и формы без сервера не работают.
|
| Кнопку выгрузки каталога в Excel убираем совсем: файл собирает сервер, а на
| статике ссылка вела бы на 404 — это единственное место, где такие ссылки
| оставались.
*/
function withStaticNotice(html) {
    const notice = `<script>window.__radopStatic = true;</script>`

    return html
        .replace(/<a\b[^>]*\bdata-sf-export\b[\s\S]*?<\/a>/g, '')
        // Скрипт согласия на cookie отдаёт сервер: на статике браузер получал
        // бы вместо него страницу 404 и ругался на разметку в консоли.
        .replace(/<script\b[^>]*src="[^"]*\/cookie-consent\/[^"]*"[^>]*><\/script>/g, '')
        .replace('</head>', `${notice}</head>`)
}

/*
| Повторяющиеся встроенные скрипты — в общий файл.
|
| Один и тот же код шапки, аналитики и подсказок повторяется на каждой
| странице и занимает около 100 КБ. На тысяче страниц это больше сотни
| мегабайт выгрузки, поэтому одинаковые блоки выносим в отдельные файлы и
| подключаем ссылкой: порядок выполнения тот же, зато браузер берёт их из
| кеша.
*/
async function hoistInlineScripts() {
    const inlineScript = /<script(?![^>]*\bsrc=)([^>]*)>([\s\S]*?)<\/script>/g
    const minLength = 2000
    const minPages = 10

    const pages = []
    const counts = new Map()

    async function walk(dir) {
        const entries = await fs.readdir(dir, { withFileTypes: true })

        for (const entry of entries) {
            const target = path.join(dir, entry.name)

            if (entry.isDirectory()) {
                await walk(target)
            } else if (entry.name.endsWith('.html')) {
                pages.push(target)
            }
        }
    }

    await walk(outDir)

    // Первый проход: считаем, сколько страниц делят каждый блок
    for (const page of pages) {
        const html = await fs.readFile(page, 'utf8')
        const seen = new Set()

        for (const match of html.matchAll(inlineScript)) {
            const body = match[2]

            if (body.length < minLength) {
                continue
            }

            const key = hashOf(body)

            if (seen.has(key)) {
                continue
            }

            seen.add(key)
            counts.set(key, (counts.get(key) ?? 0) + 1)
        }
    }

    const shared = new Map()

    // Второй проход: заменяем общие блоки ссылкой на файл
    let saved = 0

    for (const page of pages) {
        const html = await fs.readFile(page, 'utf8')
        let changed = false

        const next = html.replace(inlineScript, (full, attrs, body) => {
            const key = hashOf(body)

            if (body.length < minLength || (counts.get(key) ?? 0) < minPages) {
                return full
            }

            if (! shared.has(key)) {
                shared.set(key, body)
            }

            changed = true
            saved += full.length

            return `<script${attrs} src="${publicRoot}/assets/inline-${key}.js"></script>`
        })

        if (changed) {
            await fs.writeFile(page, next)
        }
    }

    for (const [key, body] of shared) {
        await writeFile(path.join('assets', `inline-${key}.js`), body)
    }

    console.log(`  вынесено блоков: ${shared.size}, из страниц убрано ~${Math.round(saved / 1048576)} МБ`)
}

function hashOf(text) {
    return createHash('sha1').update(text).digest('hex').slice(0, 12)
}
async function main() {
    try {
        await fs.access(path.resolve('public/hot'))

        console.error('Найден public/hot: остановите dev-сервер Vite и выполните npm run build')
        process.exit(1)
    } catch {
        // Файла нет — используется собранный бандл
    }

    const paths = execFileSync('php', ['artisan', 'site:urls', ...urlsArgs], { encoding: 'utf8', maxBuffer: 64 * 1024 * 1024 })
        .split('\n')
        .map((line) => line.trim())
        .filter(Boolean)

    console.log(`Экспорт ${paths.length} страниц из ${origin} в ${outDir}`)

    await fs.rm(outDir, { recursive: true, force: true })
    await fs.mkdir(outDir, { recursive: true })

    let failed = 0
    let done = 0

    for (const route of paths) {
        const response = await fetch(`${origin}${route}`, { redirect: 'follow' })

        if (!response.ok) {
            console.error(`  ${response.status} ${route}`)
            failed += 1

            continue
        }

        const html = withStaticNotice(rewrite(await response.text()))
        const relative = route === '/' ? 'index.html' : path.join(route.replace(/^\//, ''), 'index.html')

        await writeFile(relative, html)

        done += 1

        if (done % 50 === 0) {
            console.log(`  готово ${done} из ${paths.length}`)
        }
    }

    // Pages отдаёт 404.html на любой неизвестный адрес
    const notFound = await fetch(`${origin}/stranica-ne-naydena-404`)
    await writeFile('404.html', withStaticNotice(rewrite(await notFound.text())))

    for (const file of ['robots.txt']) {
        const response = await fetch(`${origin}/${file}`)

        if (response.ok) {
            await writeFile(file, await response.text())
        }
    }

    // Иначе Pages прогоняет выгрузку через Jekyll и режет служебные файлы
    await writeFile('.nojekyll', '')

    console.log('Вынос повторяющихся скриптов…')
    await hoistInlineScripts()

    console.log('Копирование файлов…')
    await copyAssets()

    console.log(`Готово: ${done} страниц, ошибок ${failed}`)

    if (failed > 0 && done === 0) {
        process.exit(1)
    }
}

await main()
