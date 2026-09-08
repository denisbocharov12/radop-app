/**
 * Radop storefront icon set.
 *
 * Replaces the two icon fonts the old storefront loaded (FontAwesome 4 — 40 KB
 * of CSS plus ~400 KB of webfonts — and the bespoke `radop` icon font) with
 * ~28 inline SVG paths: stroke-based, 24×24, `currentColor`, no flash of
 * unstyled icons and no extra request.
 *
 * The paths live in `resources/icons/storefront.json` because both sides of the
 * stack need them: this module for Vue islands, and the `<x-sf-icon>` Blade
 * component for server-rendered markup. Edit the JSON, never a copy.
 */
import icons from '../../../icons/storefront.json';

export { icons };

export const iconNames = Object.keys(icons);
