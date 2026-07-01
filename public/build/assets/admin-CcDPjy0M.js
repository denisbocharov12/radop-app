import{a as za}from"./index-BZ84_VUH.js";var R1=!1,B1=!1,T=[],T1=-1,X1=!1;function te(a){ee(a)}function ae(){X1=!0}function he(){X1=!1,Da()}function ee(a){T.includes(a)||T.push(a),Da()}function ce(a){let h=T.indexOf(a);h!==-1&&h>T1&&T.splice(h,1)}function Da(){if(!B1&&!R1){if(X1)return;R1=!0,queueMicrotask(de)}}function de(){R1=!1,B1=!0;for(let a=0;a<T.length;a++)T[a](),T1=a;T.length=0,T1=-1,B1=!1}var G,I,K,qa,E1=!0;function pe(a){E1=!1,a(),E1=!0}function ne(a){G=a.reactive,K=a.release,I=h=>a.effect(h,{scheduler:e=>{E1?te(e):e()}}),qa=a.raw}function f2(a){I=a}function se(a){let h=()=>{};return[c=>{let d=I(c);return a._x_effects||(a._x_effects=new Set,a._x_runEffects=()=>{a._x_effects.forEach(p=>p())}),a._x_effects.add(d),h=()=>{d!==void 0&&(a._x_effects.delete(d),K(d))},d},()=>{h()}]}function Ua(a,h){let e=!0,c,d,p=I(()=>{let n=a(),s=JSON.stringify(n);if(!e&&(typeof n=="object"||n!==c)){let r=typeof c=="object"?JSON.parse(d):c;queueMicrotask(()=>{h(n,r)})}c=n,d=s,e=!1});return()=>K(p)}async function re(a){ae();try{await a(),await Promise.resolve()}finally{he()}}var Ia=[],Na=[],$a=[];function ie(a){$a.push(a)}function J1(a,h){typeof h=="function"?(a._x_cleanups||(a._x_cleanups=[]),a._x_cleanups.push(h)):(h=a,Na.push(h))}function Wa(a){Ia.push(a)}function ja(a,h,e){a._x_attributeCleanups||(a._x_attributeCleanups={}),a._x_attributeCleanups[h]||(a._x_attributeCleanups[h]=[]),a._x_attributeCleanups[h].push(e)}function Ga(a,h){a._x_attributeCleanups&&Object.entries(a._x_attributeCleanups).forEach(([e,c])=>{(h===void 0||h.includes(e))&&(c.forEach(d=>d()),delete a._x_attributeCleanups[e])})}function oe(a){var h,e;for((h=a._x_effects)==null||h.forEach(ce);(e=a._x_cleanups)!=null&&e.length;)a._x_cleanups.pop()()}var Y1=new MutationObserver(h2),Q1=!1;function t2(){Y1.observe(document,{subtree:!0,childList:!0,attributes:!0,attributeOldValue:!0}),Q1=!0}function Ka(){le(),Y1.disconnect(),Q1=!1}var Q=[];function le(){let a=Y1.takeRecords();Q.push(()=>a.length>0&&h2(a));let h=Q.length;queueMicrotask(()=>{if(Q.length===h)for(;Q.length>0;)Q.shift()()})}function y(a){if(!Q1)return a();Ka();let h=a();return t2(),h}var a2=!1,y1=[];function Me(){a2=!0}function ve(){a2=!1,h2(y1),y1=[]}function h2(a){if(a2){y1=y1.concat(a);return}let h=[],e=new Set,c=new Map,d=new Map;for(let p=0;p<a.length;p++)if(!a[p].target._x_ignoreMutationObserver&&(a[p].type==="childList"&&(a[p].removedNodes.forEach(n=>{n.nodeType===1&&n._x_marker&&e.add(n)}),a[p].addedNodes.forEach(n=>{if(n.nodeType===1){if(e.has(n)){e.delete(n);return}n._x_marker||h.push(n)}})),a[p].type==="attributes")){let n=a[p].target,s=a[p].attributeName,r=a[p].oldValue,i=()=>{c.has(n)||c.set(n,[]),c.get(n).push({name:s,value:n.getAttribute(s)})},o=()=>{d.has(n)||d.set(n,[]),d.get(n).push(s)};n.hasAttribute(s)&&r===null?i():n.hasAttribute(s)?(o(),i()):o()}d.forEach((p,n)=>{Ga(n,p)}),c.forEach((p,n)=>{Ia.forEach(s=>s(n,p))});for(let p of e)h.some(n=>n.contains(p))||Na.forEach(n=>n(p));for(let p of h)p.isConnected&&$a.forEach(n=>n(p));h=null,e=null,c=null,d=null}function Xa(a){return q(D(a))}function s1(a,h,e){return a._x_dataStack=[h,...D(e||a)],()=>{a._x_dataStack=a._x_dataStack.filter(c=>c!==h)}}function D(a){return a._x_dataStack?a._x_dataStack:typeof ShadowRoot=="function"&&a instanceof ShadowRoot?D(a.host):a.parentNode?D(a.parentNode):[]}function q(a){return new Proxy({objects:a},ge)}function Ja(a,h){return a===null||a===Object.prototype?null:Object.prototype.hasOwnProperty.call(a,h)?a:Ja(Object.getPrototypeOf(a),h)}var ge={ownKeys({objects:a}){return Array.from(new Set(a.flatMap(h=>Object.keys(h))))},has({objects:a},h){return h==Symbol.unscopables?!1:a.some(e=>Object.prototype.hasOwnProperty.call(e,h)||Reflect.has(e,h))},get({objects:a},h,e){return h=="toJSON"?xe:Reflect.get(a.find(c=>Reflect.has(c,h))||{},h,e)},set({objects:a},h,e,c){let d;for(const n of a)if(d=Ja(n,h),d)break;d||(d=a[a.length-1]);const p=Object.getOwnPropertyDescriptor(d,h);return p!=null&&p.set&&(p!=null&&p.get)?p.set.call(c,e)||!0:Reflect.set(d,h,e)}};function xe(){return Reflect.ownKeys(this).reduce((h,e)=>(h[e]=Reflect.get(this,e),h),{})}function e2(a){let h=c=>typeof c=="object"&&!Array.isArray(c)&&c!==null,e=(c,d="")=>{Object.entries(Object.getOwnPropertyDescriptors(c)).forEach(([p,{value:n,enumerable:s}])=>{if(s===!1||n===void 0||typeof n=="object"&&n!==null&&n.__v_skip)return;let r=d===""?p:`${d}.${p}`;typeof n=="object"&&n!==null&&n._x_interceptor?c[p]=n.initialize(a,r,p):h(n)&&n!==c&&!(n instanceof Element)&&e(n,r)})};return e(a)}function Ya(a,h=()=>{}){let e={initialValue:void 0,_x_interceptor:!0,initialize(c,d,p){return a(this.initialValue,()=>ye(c,d),n=>F1(c,d,n),d,p)}};return h(e),c=>{if(typeof c=="object"&&c!==null&&c._x_interceptor){let d=e.initialize.bind(e);e.initialize=(p,n,s)=>{let r=c.initialize(p,n,s);return e.initialValue=r,d(p,n,s)}}else e.initialValue=c;return e}}function ye(a,h){return h.split(".").reduce((e,c)=>e[c],a)}function F1(a,h,e){if(typeof h=="string"&&(h=h.split(".")),h.length===1)a[h[0]]=e;else{if(h.length===0)throw error;return a[h[0]]||(a[h[0]]={}),F1(a[h[0]],h.slice(1),e)}}var Qa={};function A(a,h){Qa[a]=h}function d1(a,h){let e=ue(h);return Object.entries(Qa).forEach(([c,d])=>{Object.defineProperty(a,`$${c}`,{get(){return d(h,e)},enumerable:!1})}),a}function ue(a){let[h,e]=ph(a),c={interceptor:Ya,...h};return J1(a,e),c}function fe(a,h,e,...c){try{return e(...c)}catch(d){p1(d,a,h)}}function p1(...a){return th(...a)}var th=we;function me(a){th=a}function we(a,h,e=void 0){a=Object.assign(a??{message:"No error message given."},{el:h,expression:e}),console.warn(`Alpine Expression Error: ${a.message}

${e?'Expression: "'+e+`"

`:""}`,h),setTimeout(()=>{throw a},0)}var W=!0;function ah(a){let h=W;W=!1;let e=a();return W=h,e}function E(a,h,e={}){let c;return w(a,h)(d=>c=d,e),c}function w(...a){return hh(...a)}var hh=()=>{};function He(a){hh=a}var eh;function Ve(a){eh=a}function Ce(a,h){let e={};d1(e,a);let c=[e,...D(a)],d=typeof h=="function"?Ae(c,h):Se(c,h,a);return fe.bind(null,a,h,d)}function Ae(a,h){return(e=()=>{},{scope:c={},params:d=[],context:p}={})=>{if(!W){n1(e,h,q([c,...a]),d);return}let n=h.apply(q([c,...a]),d);n1(e,n)}}var b1={};function _e(a,h){if(b1[a])return b1[a];let e=Object.getPrototypeOf(async function(){}).constructor,c=/^[\n\s]*if.*\(.*\)/.test(a.trim())||/^(let|const)\s/.test(a.trim())?`(async()=>{ ${a} })()`:a,p=(()=>{try{let n=new e(["__self","scope"],`with (scope) { __self.result = ${c} }; __self.finished = true; return __self.result;`);return Object.defineProperty(n,"name",{value:`[Alpine] ${a}`}),n}catch(n){return p1(n,h,a),Promise.resolve()}})();return b1[a]=p,p}function Se(a,h,e){let c=_e(h,e);return(d=()=>{},{scope:p={},params:n=[],context:s}={})=>{c.result=void 0,c.finished=!1;let r=q([p,...a]);if(typeof c=="function"){let i=c.call(s,c,r).catch(o=>p1(o,e,h));c.finished?(n1(d,c.result,r,n,e),c.result=void 0):i.then(o=>{n1(d,o,r,n,e)}).catch(o=>p1(o,e,h)).finally(()=>c.result=void 0)}}}function n1(a,h,e,c,d){if(W&&typeof h=="function"){let p=h.apply(e,c);p instanceof Promise?p.then(n=>n1(a,n,e,c)).catch(n=>p1(n,d,h)):a(p)}else typeof h=="object"&&h instanceof Promise?h.then(p=>a(p)):a(h)}function Le(...a){return eh(...a)}function be(a,h,e={}){let c={};d1(c,a);let d=[c,...D(a)],p=q([e.scope??{},...d]),n=e.params??[];if(h.includes("await")){let s=Object.getPrototypeOf(async function(){}).constructor,r=/^[\n\s]*if.*\(.*\)/.test(h.trim())||/^(let|const)\s/.test(h.trim())?`(async()=>{ ${h} })()`:h;return new s(["scope"],`with (scope) { let __result = ${r}; return __result }`).call(e.context,p)}else{let s=/^[\n\s]*if.*\(.*\)/.test(h.trim())||/^(let|const)\s/.test(h.trim())?`(()=>{ ${h} })()`:h,i=new Function(["scope"],`with (scope) { let __result = ${s}; return __result }`).call(e.context,p);return typeof i=="function"&&W?i.apply(p,n):i}}var c2="x-";function X(a=""){return c2+a}function Ze(a){c2=a}var u1={};function u(a,h){return u1[a]=h,{before(e){if(!u1[e]){console.warn(String.raw`Cannot find directive \`${e}\`. \`${a}\` will use the default order of execution`);return}const c=B.indexOf(e);B.splice(c>=0?c:B.indexOf("DEFAULT"),0,a)}}}function Pe(a){return Object.keys(u1).includes(a)}function d2(a,h,e){if(h=Array.from(h),a._x_virtualDirectives){let p=Object.entries(a._x_virtualDirectives).map(([s,r])=>({name:s,value:r})),n=ch(p);p=p.map(s=>n.find(r=>r.name===s.name)?{name:`x-bind:${s.name}`,value:`"${s.value}"`}:s),h=h.concat(p)}let c={};return h.map(rh((p,n)=>c[p]=n)).filter(oh).map(Re(c,e)).sort(Be).map(p=>Oe(a,p))}function ch(a){return Array.from(a).map(rh()).filter(h=>!oh(h))}var z1=!1,h1=new Map,dh=Symbol();function ke(a){z1=!0;let h=Symbol();dh=h,h1.set(h,[]);let e=()=>{for(;h1.get(h).length;)h1.get(h).shift()();h1.delete(h)},c=()=>{z1=!1,e()};a(e),c()}function ph(a){let h=[],e=s=>h.push(s),[c,d]=se(a);return h.push(d),[{Alpine:Y,effect:c,cleanup:e,evaluateLater:w.bind(w,a),evaluate:E.bind(E,a)},()=>h.forEach(s=>s())]}function Oe(a,h){let e=()=>{},c=u1[h.type]||e,[d,p]=ph(a);ja(a,h.original,p);let n=()=>{a._x_ignore||a._x_ignoreSelf||(c.inline&&c.inline(a,h,d),c=c.bind(c,a,h,d),z1?h1.get(dh).push(c):c())};return n.runCleanups=p,n}var nh=(a,h)=>({name:e,value:c})=>(e.startsWith(a)&&(e=e.replace(a,h)),{name:e,value:c}),sh=a=>a;function rh(a=()=>{}){return({name:h,value:e})=>{let{name:c,value:d}=ih.reduce((p,n)=>n(p),{name:h,value:e});return c!==h&&a(c,h),{name:c,value:d}}}var ih=[];function p2(a){ih.push(a)}function oh({name:a}){return lh().test(a)}var lh=()=>new RegExp(`^${c2}([^:^.]+)\\b`);function Re(a,h){return({name:e,value:c})=>{e===c&&(c="");let d=e.match(lh()),p=e.match(/:([a-zA-Z0-9\-_:]+)/),n=e.match(/\.[^.\]]+(?=[^\]]*$)/g)||[],s=h||a[e]||e;return{type:d?d[1]:null,value:p?p[1]:null,modifiers:n.map(r=>r.replace(".","")),expression:c,original:s}}}var D1="DEFAULT",B=["ignore","ref","id","data","anchor","bind","init","for","model","modelable","transition","show","if",D1,"teleport"];function Be(a,h){let e=B.indexOf(a.type)===-1?D1:a.type,c=B.indexOf(h.type)===-1?D1:h.type;return B.indexOf(e)-B.indexOf(c)}function e1(a,h,e={},c={}){return a.dispatchEvent(new CustomEvent(h,{detail:e,bubbles:!0,composed:!0,cancelable:!0,...c}))}function U(a,h){if(typeof ShadowRoot=="function"&&a instanceof ShadowRoot){Array.from(a.children).forEach(d=>U(d,h));return}let e=!1;if(h(a,()=>e=!0),e)return;let c=a.firstElementChild;for(;c;)U(c,h),c=c.nextElementSibling}function S(a,...h){console.warn(`Alpine Warning: ${a}`,...h)}var m2=!1;function Te(){m2&&S("Alpine has already been initialized on this page. Calling Alpine.start() more than once can cause problems."),m2=!0,document.body||S("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?"),e1(document,"alpine:init"),e1(document,"alpine:initializing"),t2(),ie(h=>b(h,U)),J1(h=>J(h)),Wa((h,e)=>{d2(h,e).forEach(c=>c())});let a=h=>!w1(h.parentElement,!0);Array.from(document.querySelectorAll(gh().join(","))).filter(a).forEach(h=>{b(h)}),e1(document,"alpine:initialized"),setTimeout(()=>{De()})}var n2=[],Mh=[];function vh(){return n2.map(a=>a())}function gh(){return n2.concat(Mh).map(a=>a())}function xh(a){n2.push(a)}function yh(a){Mh.push(a)}function w1(a,h=!1){return L(a,e=>{if((h?gh():vh()).some(d=>e.matches(d)))return!0})}function L(a,h){if(a){if(h(a))return a;if(a._x_teleportBack)return L(a._x_teleportBack,h);if(a.parentNode instanceof ShadowRoot)return L(a.parentNode.host,h);if(a.parentElement)return L(a.parentElement,h)}}function Ee(a){return vh().some(h=>a.matches(h))}var uh=[];function Fe(a){uh.push(a)}var ze=1;function b(a,h=U,e=()=>{}){L(a,c=>c._x_ignore)||ke(()=>{h(a,(c,d)=>{c._x_marker||(e(c,d),uh.forEach(p=>p(c,d)),d2(c,c.attributes).forEach(p=>p()),c._x_ignore||(c._x_marker=ze++),c._x_ignore&&d())})})}function J(a,h=U){h(a,e=>{oe(e),Ga(e),delete e._x_marker})}function De(){[["ui","dialog",["[x-dialog], [x-popover]"]],["anchor","anchor",["[x-anchor]"]],["sort","sort",["[x-sort]"]]].forEach(([h,e,c])=>{Pe(e)||c.some(d=>{if(document.querySelector(d))return S(`found "${d}", but missing ${h} plugin`),!0})})}var q1=[],s2=!1;function r2(a=()=>{}){return queueMicrotask(()=>{s2||setTimeout(()=>{U1()})}),new Promise(h=>{q1.push(()=>{a(),h()})})}function U1(){for(s2=!1;q1.length;)q1.shift()()}function qe(){s2=!0}function i2(a,h){return Array.isArray(h)?w2(a,h.join(" ")):typeof h=="object"&&h!==null?Ue(a,h):typeof h=="function"?i2(a,h()):w2(a,h)}function I1(a){return a.split(/\s/).filter(Boolean)}function w2(a,h){let e=d=>I1(d).filter(p=>!a.classList.contains(p)).filter(Boolean),c=d=>(a.classList.add(...d),()=>{a.classList.remove(...d)});return h=h===!0?h="":h||"",c(e(h))}function Ue(a,h){let e=Object.entries(h).flatMap(([n,s])=>s?I1(n):!1).filter(Boolean),c=Object.entries(h).flatMap(([n,s])=>s?!1:I1(n)).filter(Boolean),d=[],p=[];return c.forEach(n=>{a.classList.contains(n)&&(a.classList.remove(n),p.push(n))}),e.forEach(n=>{a.classList.contains(n)||(a.classList.add(n),d.push(n))}),()=>{p.forEach(n=>a.classList.add(n)),d.forEach(n=>a.classList.remove(n))}}function H1(a,h){return typeof h=="object"&&h!==null?Ie(a,h):Ne(a,h)}function Ie(a,h){let e={};return Object.entries(h).forEach(([c,d])=>{e[c]=a.style[c],c.startsWith("--")||(c=$e(c)),a.style.setProperty(c,d)}),setTimeout(()=>{a.style.length===0&&a.removeAttribute("style")}),()=>{H1(a,e)}}function Ne(a,h){let e=a.getAttribute("style",h);return a.setAttribute("style",h),()=>{a.setAttribute("style",e||"")}}function $e(a){return a.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase()}function N1(a,h=()=>{}){let e=!1;return function(){e?h.apply(this,arguments):(e=!0,a.apply(this,arguments))}}u("transition",(a,{value:h,modifiers:e,expression:c},{evaluate:d})=>{typeof c=="function"&&(c=d(c)),c!==!1&&(!c||typeof c=="boolean"?je(a,e,h):We(a,c,h))});function We(a,h,e){fh(a,i2,""),{enter:d=>{a._x_transition.enter.during=d},"enter-start":d=>{a._x_transition.enter.start=d},"enter-end":d=>{a._x_transition.enter.end=d},leave:d=>{a._x_transition.leave.during=d},"leave-start":d=>{a._x_transition.leave.start=d},"leave-end":d=>{a._x_transition.leave.end=d}}[e](h)}function je(a,h,e){fh(a,H1);let c=!h.includes("in")&&!h.includes("out")&&!e,d=c||h.includes("in")||["enter"].includes(e),p=c||h.includes("out")||["leave"].includes(e);h.includes("in")&&!c&&(h=h.filter((m,N)=>N<h.indexOf("out"))),h.includes("out")&&!c&&(h=h.filter((m,N)=>N>h.indexOf("out")));let n=!h.includes("opacity")&&!h.includes("scale"),s=n||h.includes("opacity"),r=n||h.includes("scale"),i=s?0:1,o=r?t1(h,"scale",95)/100:1,l=t1(h,"delay",0)/1e3,g=t1(h,"origin","center"),x="opacity, transform",H=t1(h,"duration",150)/1e3,M=t1(h,"duration",75)/1e3,f="cubic-bezier(0.4, 0.0, 0.2, 1)";d&&(a._x_transition.enter.during={transformOrigin:g,transitionDelay:`${l}s`,transitionProperty:x,transitionDuration:`${H}s`,transitionTimingFunction:f},a._x_transition.enter.start={opacity:i,transform:`scale(${o})`},a._x_transition.enter.end={opacity:1,transform:"scale(1)"}),p&&(a._x_transition.leave.during={transformOrigin:g,transitionDelay:`${l}s`,transitionProperty:x,transitionDuration:`${M}s`,transitionTimingFunction:f},a._x_transition.leave.start={opacity:1,transform:"scale(1)"},a._x_transition.leave.end={opacity:i,transform:`scale(${o})`})}function fh(a,h,e={}){a._x_transition||(a._x_transition={enter:{during:e,start:e,end:e},leave:{during:e,start:e,end:e},in(c=()=>{},d=()=>{}){$1(a,h,{during:this.enter.during,start:this.enter.start,end:this.enter.end},c,d)},out(c=()=>{},d=()=>{}){$1(a,h,{during:this.leave.during,start:this.leave.start,end:this.leave.end},c,d)}})}window.Element.prototype._x_toggleAndCascadeWithTransitions=function(a,h,e,c){const d=document.visibilityState==="visible"?requestAnimationFrame:setTimeout;let p=()=>d(e);if(h){a._x_transition&&(a._x_transition.enter||a._x_transition.leave)?a._x_transition.enter&&(Object.entries(a._x_transition.enter.during).length||Object.entries(a._x_transition.enter.start).length||Object.entries(a._x_transition.enter.end).length)?a._x_transition.in(e):p():a._x_transition?a._x_transition.in(e):p();return}a._x_hidePromise=a._x_transition?new Promise((n,s)=>{a._x_transition.out(()=>{},()=>n(c)),a._x_transitioning&&a._x_transitioning.beforeCancel(()=>s({isFromCancelledTransition:!0}))}):Promise.resolve(c),queueMicrotask(()=>{let n=mh(a);n?(n._x_hideChildren||(n._x_hideChildren=[]),n._x_hideChildren.push(a)):d(()=>{let s=r=>{let i=Promise.all([r._x_hidePromise,...(r._x_hideChildren||[]).map(s)]).then(([o])=>o==null?void 0:o());return delete r._x_hidePromise,delete r._x_hideChildren,i};s(a).catch(r=>{if(!r.isFromCancelledTransition)throw r})})})};function mh(a){let h=a.parentNode;if(h)return h._x_hidePromise?h:mh(h)}function $1(a,h,{during:e,start:c,end:d}={},p=()=>{},n=()=>{}){if(a._x_transitioning&&a._x_transitioning.cancel(),Object.keys(e).length===0&&Object.keys(c).length===0&&Object.keys(d).length===0){p(),n();return}let s,r,i;Ge(a,{start(){s=h(a,c)},during(){r=h(a,e)},before:p,end(){s(),i=h(a,d)},after:n,cleanup(){r(),i()}})}function Ge(a,h){let e,c,d,p=N1(()=>{y(()=>{e=!0,c||h.before(),d||(h.end(),U1()),h.after(),a.isConnected&&h.cleanup(),delete a._x_transitioning})});a._x_transitioning={beforeCancels:[],beforeCancel(n){this.beforeCancels.push(n)},cancel:N1(function(){for(;this.beforeCancels.length;)this.beforeCancels.shift()();p()}),finish:p},y(()=>{h.start(),h.during()}),qe(),requestAnimationFrame(()=>{if(e)return;let n=Number(getComputedStyle(a).transitionDuration.replace(/,.*/,"").replace("s",""))*1e3,s=Number(getComputedStyle(a).transitionDelay.replace(/,.*/,"").replace("s",""))*1e3;n===0&&(n=Number(getComputedStyle(a).animationDuration.replace("s",""))*1e3),y(()=>{h.before()}),c=!0,requestAnimationFrame(()=>{e||(y(()=>{h.end()}),U1(),setTimeout(a._x_transitioning.finish,n+s),d=!0)})})}function t1(a,h,e){if(a.indexOf(h)===-1)return e;const c=a[a.indexOf(h)+1];if(!c||h==="scale"&&isNaN(c))return e;if(h==="duration"||h==="delay"){let d=c.match(/([0-9]+)ms/);if(d)return d[1]}return h==="origin"&&["top","right","left","center","bottom"].includes(a[a.indexOf(h)+2])?[c,a[a.indexOf(h)+2]].join(" "):c}var P=!1;function O(a,h=()=>{}){return(...e)=>P?h(...e):a(...e)}function Ke(a){return(...h)=>P&&a(...h)}var wh=[];function V1(a){wh.push(a)}function Xe(a,h){wh.forEach(e=>e(a,h)),P=!0,Hh(()=>{b(h,(e,c)=>{c(e,()=>{})})}),P=!1}var W1=!1;function Je(a,h){h._x_dataStack||(h._x_dataStack=a._x_dataStack),P=!0,W1=!0,Hh(()=>{Ye(h)}),P=!1,W1=!1}function Ye(a){let h=!1;b(a,(c,d)=>{U(c,(p,n)=>{if(h&&Ee(p))return n();h=!0,d(p,n)})})}function Hh(a){let h=I;f2((e,c)=>{let d=h(e);return K(d),()=>{}}),a(),f2(h)}function Vh(a,h,e,c=[]){switch(a._x_bindings||(a._x_bindings=G({})),a._x_bindings[h]=e,h=c.includes("camel")?p4(h):h,h){case"value":Qe(a,e);break;case"style":a4(a,e);break;case"class":t4(a,e);break;case"selected":case"checked":h4(a,h,e);break;default:Ch(a,h,e);break}}function Qe(a,h){if(o2(a))a.attributes.value===void 0&&(a.value=h);else if(f1(a))Number.isInteger(h)?a.value=h:!Array.isArray(h)&&typeof h!="boolean"&&![null,void 0].includes(h)?a.value=String(h):Array.isArray(h)?a.checked=h.some(e=>n4(e,a.value)):a.checked=!!h;else if(a.tagName==="SELECT")d4(a,h);else{if(a.value===h)return;a.value=h===void 0?"":h}}function t4(a,h){a._x_undoAddedClasses&&a._x_undoAddedClasses(),a._x_undoAddedClasses=i2(a,h)}function a4(a,h){a._x_undoAddedStyles&&a._x_undoAddedStyles(),a._x_undoAddedStyles=H1(a,h)}function h4(a,h,e){Ch(a,h,e),c4(a,h,e)}function Ch(a,h,e){[null,void 0,!1].includes(e)&&r4(h)?a.removeAttribute(h):(Ah(h)&&(e=h),e4(a,h,e))}function e4(a,h,e){a.getAttribute(h)!=e&&a.setAttribute(h,e)}function c4(a,h,e){a[h]!==e&&(a[h]=e)}function d4(a,h){const e=[].concat(h).map(c=>c+"");Array.from(a.options).forEach(c=>{c.selected=e.includes(c.value)})}function p4(a){return a.toLowerCase().replace(/-(\w)/g,(h,e)=>e.toUpperCase())}function n4(a,h){return a==h}function x1(a){return[1,"1","true","on","yes",!0].includes(a)?!0:[0,"0","false","off","no",!1].includes(a)?!1:a?!!a:null}var s4=new Set(["allowfullscreen","async","autofocus","autoplay","checked","controls","default","defer","disabled","formnovalidate","inert","ismap","itemscope","loop","multiple","muted","nomodule","novalidate","open","playsinline","readonly","required","reversed","selected","shadowrootclonable","shadowrootdelegatesfocus","shadowrootserializable"]);function Ah(a){return s4.has(a)}function r4(a){return!["aria-pressed","aria-checked","aria-expanded","aria-selected"].includes(a)}function i4(a,h,e){return a._x_bindings&&a._x_bindings[h]!==void 0?a._x_bindings[h]:_h(a,h,e)}function o4(a,h,e,c=!0){if(a._x_bindings&&a._x_bindings[h]!==void 0)return a._x_bindings[h];if(a._x_inlineBindings&&a._x_inlineBindings[h]!==void 0){let d=a._x_inlineBindings[h];return d.extract=c,ah(()=>E(a,d.expression))}return _h(a,h,e)}function _h(a,h,e){let c=a.getAttribute(h);return c===null?typeof e=="function"?e():e:c===""?!0:Ah(h)?!![h,"true"].includes(c):c}function f1(a){return a.type==="checkbox"||a.localName==="ui-checkbox"||a.localName==="ui-switch"}function o2(a){return a.type==="radio"||a.localName==="ui-radio"}function Sh(a,h){let e;return function(){const c=this,d=arguments,p=function(){e=null,a.apply(c,d)};clearTimeout(e),e=setTimeout(p,h)}}function Lh(a,h){let e;return function(){let c=this,d=arguments;e||(a.apply(c,d),e=!0,setTimeout(()=>e=!1,h))}}function bh({get:a,set:h},{get:e,set:c}){let d=!0,p,n=I(()=>{let s=a(),r=e();if(d)c(Z1(s)),d=!1;else{let i=JSON.stringify(s),o=JSON.stringify(r);i!==p?c(Z1(s)):i!==o&&h(Z1(r))}p=JSON.stringify(a()),JSON.stringify(e())});return()=>{K(n)}}function Z1(a){return typeof a=="object"?JSON.parse(JSON.stringify(a)):a}function l4(a){(Array.isArray(a)?a:[a]).forEach(e=>e(Y))}var R={},H2=!1;function M4(a,h){if(H2||(R=G(R),H2=!0),h===void 0)return R[a];R[a]=h,e2(R[a]),typeof h=="object"&&h!==null&&h.hasOwnProperty("init")&&typeof h.init=="function"&&R[a].init()}function v4(){return R}var Zh={};function g4(a,h){let e=typeof h!="function"?()=>h:h;return a instanceof Element?Ph(a,e()):(Zh[a]=e,()=>{})}function x4(a){return Object.entries(Zh).forEach(([h,e])=>{Object.defineProperty(a,h,{get(){return(...c)=>e(...c)}})}),a}function Ph(a,h,e){let c=[];for(;c.length;)c.pop()();let d=Object.entries(h).map(([n,s])=>({name:n,value:s})),p=ch(d);return d=d.map(n=>p.find(s=>s.name===n.name)?{name:`x-bind:${n.name}`,value:`"${n.value}"`}:n),d2(a,d,e).map(n=>{c.push(n.runCleanups),n()}),()=>{for(;c.length;)c.pop()()}}var kh={};function y4(a,h){kh[a]=h}function u4(a,h){return Object.entries(kh).forEach(([e,c])=>{Object.defineProperty(a,e,{get(){return(...d)=>c.bind(h)(...d)},enumerable:!1})}),a}var f4={get reactive(){return G},get release(){return K},get effect(){return I},get raw(){return qa},get transaction(){return re},version:"3.15.12",flushAndStopDeferringMutations:ve,dontAutoEvaluateFunctions:ah,disableEffectScheduling:pe,startObservingMutations:t2,stopObservingMutations:Ka,setReactivityEngine:ne,onAttributeRemoved:ja,onAttributesAdded:Wa,closestDataStack:D,skipDuringClone:O,onlyDuringClone:Ke,addRootSelector:xh,addInitSelector:yh,setErrorHandler:me,interceptClone:V1,addScopeToNode:s1,deferMutations:Me,mapAttributes:p2,evaluateLater:w,interceptInit:Fe,initInterceptors:e2,injectMagics:d1,setEvaluator:He,setRawEvaluator:Ve,mergeProxies:q,extractProp:o4,findClosest:L,onElRemoved:J1,closestRoot:w1,destroyTree:J,interceptor:Ya,transition:$1,setStyles:H1,mutateDom:y,directive:u,entangle:bh,throttle:Lh,debounce:Sh,evaluate:E,evaluateRaw:Le,initTree:b,nextTick:r2,prefixed:X,prefix:Ze,plugin:l4,magic:A,store:M4,start:Te,clone:Je,cloneNode:Xe,bound:i4,$data:Xa,watch:Ua,walk:U,data:y4,bind:g4},Y=f4;function m4(a,h){const e=Object.create(null),c=a.split(",");for(let d=0;d<c.length;d++)e[c[d]]=!0;return d=>!!e[d]}var w4=Object.freeze({}),H4=Object.prototype.hasOwnProperty,C1=(a,h)=>H4.call(a,h),F=Array.isArray,c1=a=>Oh(a)==="[object Map]",V4=a=>typeof a=="string",l2=a=>typeof a=="symbol",A1=a=>a!==null&&typeof a=="object",C4=Object.prototype.toString,Oh=a=>C4.call(a),Rh=a=>Oh(a).slice(8,-1),M2=a=>V4(a)&&a!=="NaN"&&a[0]!=="-"&&""+parseInt(a,10)===a,A4=a=>{const h=Object.create(null);return e=>h[e]||(h[e]=a(e))},_4=A4(a=>a.charAt(0).toUpperCase()+a.slice(1)),Bh=(a,h)=>a!==h&&(a===a||h===h),j1=new WeakMap,a1=[],_,z=Symbol("iterate"),G1=Symbol("Map key iterate");function S4(a){return a&&a._isEffect===!0}function L4(a,h=w4){S4(a)&&(a=a.raw);const e=P4(a,h);return h.lazy||e(),e}function b4(a){a.active&&(Th(a),a.options.onStop&&a.options.onStop(),a.active=!1)}var Z4=0;function P4(a,h){const e=function(){if(!e.active)return a();if(!a1.includes(e)){Th(e);try{return O4(),a1.push(e),_=e,a()}finally{a1.pop(),Eh(),_=a1[a1.length-1]}}};return e.id=Z4++,e.allowRecurse=!!h.allowRecurse,e._isEffect=!0,e.active=!0,e.raw=a,e.deps=[],e.options=h,e}function Th(a){const{deps:h}=a;if(h.length){for(let e=0;e<h.length;e++)h[e].delete(a);h.length=0}}var j=!0,v2=[];function k4(){v2.push(j),j=!1}function O4(){v2.push(j),j=!0}function Eh(){const a=v2.pop();j=a===void 0?!0:a}function C(a,h,e){if(!j||_===void 0)return;let c=j1.get(a);c||j1.set(a,c=new Map);let d=c.get(e);d||c.set(e,d=new Set),d.has(_)||(d.add(_),_.deps.push(d),_.options.onTrack&&_.options.onTrack({effect:_,target:a,type:h,key:e}))}function k(a,h,e,c,d,p){const n=j1.get(a);if(!n)return;const s=new Set,r=o=>{o&&o.forEach(l=>{(l!==_||l.allowRecurse)&&s.add(l)})};if(h==="clear")n.forEach(r);else if(e==="length"&&F(a))n.forEach((o,l)=>{(l==="length"||l>=c)&&r(o)});else switch(e!==void 0&&r(n.get(e)),h){case"add":F(a)?M2(e)&&r(n.get("length")):(r(n.get(z)),c1(a)&&r(n.get(G1)));break;case"delete":F(a)||(r(n.get(z)),c1(a)&&r(n.get(G1)));break;case"set":c1(a)&&r(n.get(z));break}const i=o=>{o.options.onTrigger&&o.options.onTrigger({effect:o,target:a,key:e,type:h,newValue:c,oldValue:d,oldTarget:p}),o.options.scheduler?o.options.scheduler(o):o()};s.forEach(i)}var R4=m4("__proto__,__v_isRef,__isVue"),Fh=new Set(Object.getOwnPropertyNames(Symbol).map(a=>Symbol[a]).filter(l2)),B4=zh(),T4=zh(!0),V2=E4();function E4(){const a={};return["includes","indexOf","lastIndexOf"].forEach(h=>{a[h]=function(...e){const c=v(this);for(let p=0,n=this.length;p<n;p++)C(c,"get",p+"");const d=c[h](...e);return d===-1||d===!1?c[h](...e.map(v)):d}}),["push","pop","shift","unshift","splice"].forEach(h=>{a[h]=function(...e){k4();const c=v(this)[h].apply(this,e);return Eh(),c}}),a}function zh(a=!1,h=!1){return function(c,d,p){if(d==="__v_isReactive")return!a;if(d==="__v_isReadonly")return a;if(d==="__v_raw"&&p===(a?h?J4:Ih:h?X4:Uh).get(c))return c;const n=F(c);if(!a&&n&&C1(V2,d))return Reflect.get(V2,d,p);const s=Reflect.get(c,d,p);return(l2(d)?Fh.has(d):R4(d))||(a||C(c,"get",d),h)?s:K1(s)?!n||!M2(d)?s.value:s:A1(s)?a?Nh(s):u2(s):s}}var F4=z4();function z4(a=!1){return function(e,c,d,p){let n=e[c];if(!a&&(d=v(d),n=v(n),!F(e)&&K1(n)&&!K1(d)))return n.value=d,!0;const s=F(e)&&M2(c)?Number(c)<e.length:C1(e,c),r=Reflect.set(e,c,d,p);return e===v(p)&&(s?Bh(d,n)&&k(e,"set",c,d,n):k(e,"add",c,d)),r}}function D4(a,h){const e=C1(a,h),c=a[h],d=Reflect.deleteProperty(a,h);return d&&e&&k(a,"delete",h,void 0,c),d}function q4(a,h){const e=Reflect.has(a,h);return(!l2(h)||!Fh.has(h))&&C(a,"has",h),e}function U4(a){return C(a,"iterate",F(a)?"length":z),Reflect.ownKeys(a)}var I4={get:B4,set:F4,deleteProperty:D4,has:q4,ownKeys:U4},N4={get:T4,set(a,h){return console.warn(`Set operation on key "${String(h)}" failed: target is readonly.`,a),!0},deleteProperty(a,h){return console.warn(`Delete operation on key "${String(h)}" failed: target is readonly.`,a),!0}},g2=a=>A1(a)?u2(a):a,x2=a=>A1(a)?Nh(a):a,y2=a=>a,_1=a=>Reflect.getPrototypeOf(a);function r1(a,h,e=!1,c=!1){a=a.__v_raw;const d=v(a),p=v(h);h!==p&&!e&&C(d,"get",h),!e&&C(d,"get",p);const{has:n}=_1(d),s=c?y2:e?x2:g2;if(n.call(d,h))return s(a.get(h));if(n.call(d,p))return s(a.get(p));a!==d&&a.get(h)}function i1(a,h=!1){const e=this.__v_raw,c=v(e),d=v(a);return a!==d&&!h&&C(c,"has",a),!h&&C(c,"has",d),a===d?e.has(a):e.has(a)||e.has(d)}function o1(a,h=!1){return a=a.__v_raw,!h&&C(v(a),"iterate",z),Reflect.get(a,"size",a)}function C2(a){a=v(a);const h=v(this);return _1(h).has.call(h,a)||(h.add(a),k(h,"add",a,a)),this}function A2(a,h){h=v(h);const e=v(this),{has:c,get:d}=_1(e);let p=c.call(e,a);p?qh(e,c,a):(a=v(a),p=c.call(e,a));const n=d.call(e,a);return e.set(a,h),p?Bh(h,n)&&k(e,"set",a,h,n):k(e,"add",a,h),this}function _2(a){const h=v(this),{has:e,get:c}=_1(h);let d=e.call(h,a);d?qh(h,e,a):(a=v(a),d=e.call(h,a));const p=c?c.call(h,a):void 0,n=h.delete(a);return d&&k(h,"delete",a,void 0,p),n}function S2(){const a=v(this),h=a.size!==0,e=c1(a)?new Map(a):new Set(a),c=a.clear();return h&&k(a,"clear",void 0,void 0,e),c}function l1(a,h){return function(c,d){const p=this,n=p.__v_raw,s=v(n),r=h?y2:a?x2:g2;return!a&&C(s,"iterate",z),n.forEach((i,o)=>c.call(d,r(i),r(o),p))}}function M1(a,h,e){return function(...c){const d=this.__v_raw,p=v(d),n=c1(p),s=a==="entries"||a===Symbol.iterator&&n,r=a==="keys"&&n,i=d[a](...c),o=e?y2:h?x2:g2;return!h&&C(p,"iterate",r?G1:z),{next(){const{value:l,done:g}=i.next();return g?{value:l,done:g}:{value:s?[o(l[0]),o(l[1])]:o(l),done:g}},[Symbol.iterator](){return this}}}}function Z(a){return function(...h){{const e=h[0]?`on key "${h[0]}" `:"";console.warn(`${_4(a)} operation ${e}failed: target is readonly.`,v(this))}return a==="delete"?!1:this}}function $4(){const a={get(p){return r1(this,p)},get size(){return o1(this)},has:i1,add:C2,set:A2,delete:_2,clear:S2,forEach:l1(!1,!1)},h={get(p){return r1(this,p,!1,!0)},get size(){return o1(this)},has:i1,add:C2,set:A2,delete:_2,clear:S2,forEach:l1(!1,!0)},e={get(p){return r1(this,p,!0)},get size(){return o1(this,!0)},has(p){return i1.call(this,p,!0)},add:Z("add"),set:Z("set"),delete:Z("delete"),clear:Z("clear"),forEach:l1(!0,!1)},c={get(p){return r1(this,p,!0,!0)},get size(){return o1(this,!0)},has(p){return i1.call(this,p,!0)},add:Z("add"),set:Z("set"),delete:Z("delete"),clear:Z("clear"),forEach:l1(!0,!0)};return["keys","values","entries",Symbol.iterator].forEach(p=>{a[p]=M1(p,!1,!1),e[p]=M1(p,!0,!1),h[p]=M1(p,!1,!0),c[p]=M1(p,!0,!0)}),[a,e,h,c]}var[W4,j4]=$4();function Dh(a,h){const e=a?j4:W4;return(c,d,p)=>d==="__v_isReactive"?!a:d==="__v_isReadonly"?a:d==="__v_raw"?c:Reflect.get(C1(e,d)&&d in c?e:c,d,p)}var G4={get:Dh(!1)},K4={get:Dh(!0)};function qh(a,h,e){const c=v(e);if(c!==e&&h.call(a,c)){const d=Rh(a);console.warn(`Reactive ${d} contains both the raw and reactive versions of the same object${d==="Map"?" as keys":""}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`)}}var Uh=new WeakMap,X4=new WeakMap,Ih=new WeakMap,J4=new WeakMap;function Y4(a){switch(a){case"Object":case"Array":return 1;case"Map":case"Set":case"WeakMap":case"WeakSet":return 2;default:return 0}}function Q4(a){return a.__v_skip||!Object.isExtensible(a)?0:Y4(Rh(a))}function u2(a){return a&&a.__v_isReadonly?a:$h(a,!1,I4,G4,Uh)}function Nh(a){return $h(a,!0,N4,K4,Ih)}function $h(a,h,e,c,d){if(!A1(a))return console.warn(`value cannot be made reactive: ${String(a)}`),a;if(a.__v_raw&&!(h&&a.__v_isReactive))return a;const p=d.get(a);if(p)return p;const n=Q4(a);if(n===0)return a;const s=new Proxy(a,n===2?c:e);return d.set(a,s),s}function v(a){return a&&v(a.__v_raw)||a}function K1(a){return!!(a&&a.__v_isRef===!0)}A("nextTick",()=>r2);A("dispatch",a=>e1.bind(e1,a));A("watch",(a,{evaluateLater:h,cleanup:e})=>(c,d)=>{let p=h(c),s=Ua(()=>{let r;return p(i=>r=i),r},d);e(s)});A("store",v4);A("data",a=>Xa(a));A("root",a=>w1(a));A("refs",a=>(a._x_refs_proxy||(a._x_refs_proxy=q(tc(a))),a._x_refs_proxy));function tc(a){let h=[];return L(a,e=>{e._x_refs&&h.push(e._x_refs)}),h}var P1={};function Wh(a){return P1[a]||(P1[a]=0),++P1[a]}function ac(a,h){return L(a,e=>{if(e._x_ids&&e._x_ids[h])return!0})}function hc(a,h){a._x_ids||(a._x_ids={}),a._x_ids[h]||(a._x_ids[h]=Wh(h))}A("id",(a,{cleanup:h})=>(e,c=null)=>{let d=`${e}${c?`-${c}`:""}`;return ec(a,d,h,()=>{let p=ac(a,e),n=p?p._x_ids[e]:Wh(e);return c?`${e}-${n}-${c}`:`${e}-${n}`})});V1((a,h)=>{a._x_id&&(h._x_id=a._x_id)});function ec(a,h,e,c){if(a._x_id||(a._x_id={}),a._x_id[h])return a._x_id[h];let d=c();return a._x_id[h]=d,e(()=>{delete a._x_id[h]}),d}A("el",a=>a);jh("Focus","focus","focus");jh("Persist","persist","persist");function jh(a,h,e){A(h,c=>S(`You can't use [$${h}] without first installing the "${a}" plugin here: https://alpinejs.dev/plugins/${e}`,c))}u("modelable",(a,{expression:h},{effect:e,evaluateLater:c,cleanup:d})=>{let p=c(h),n=()=>{let o;return p(l=>o=l),o},s=c(`${h} = __placeholder`),r=o=>s(()=>{},{scope:{__placeholder:o}}),i=n();r(i),queueMicrotask(()=>{if(!a._x_model)return;a._x_removeModelListeners.default();let o=a._x_model.get,l=a._x_model.setWithModifiers,g=bh({get(){return o()},set(x){l(x)}},{get(){return n()},set(x){r(x)}});d(g)})});u("teleport",(a,{modifiers:h,expression:e},{cleanup:c})=>{a.tagName.toLowerCase()!=="template"&&S("x-teleport can only be used on a <template> tag",a);let d=L2(e),p=a.content.cloneNode(!0).firstElementChild;a._x_teleport=p,p._x_teleportBack=a,a.setAttribute("data-teleport-template",!0),p.setAttribute("data-teleport-target",!0),a._x_forwardEvents&&a._x_forwardEvents.forEach(s=>{p.addEventListener(s,r=>{r.stopPropagation(),a.dispatchEvent(new r.constructor(r.type,r))})}),s1(p,{},a);let n=(s,r,i)=>{i.includes("prepend")?r.parentNode.insertBefore(s,r):i.includes("append")?r.parentNode.insertBefore(s,r.nextSibling):r.appendChild(s)};y(()=>{O(()=>{n(p,d,h),b(p)})()}),a._x_teleportPutBack=()=>{let s=L2(e);y(()=>{n(a._x_teleport,s,h)})},c(()=>y(()=>{p.remove(),J(p)}))});var cc=document.createElement("div");function L2(a){let h=O(()=>document.querySelector(a),()=>cc)();return h||S(`Cannot find x-teleport element for selector: "${a}"`),h}var Gh=()=>{};Gh.inline=(a,{modifiers:h},{cleanup:e})=>{h.includes("self")?a._x_ignoreSelf=!0:a._x_ignore=!0,e(()=>{h.includes("self")?delete a._x_ignoreSelf:delete a._x_ignore})};u("ignore",Gh);u("effect",O((a,{expression:h},{effect:e})=>{e(w(a,h))}));function $(a,h,e,c){let d=a,p=r=>c(r),n={},s=(r,i)=>o=>i(r,o);return e.includes("dot")&&(h=dc(h)),e.includes("camel")&&(h=pc(h)),e.includes("capture")&&(n.capture=!0),e.includes("window")&&(d=window),e.includes("document")&&(d=document),e.includes("passive")&&(n.passive=e[e.indexOf("passive")+1]!=="false"),p=Kh(e,p),e.includes("prevent")&&(p=s(p,(r,i)=>{i.preventDefault(),r(i)})),e.includes("stop")&&(p=s(p,(r,i)=>{i.stopPropagation(),r(i)})),e.includes("once")&&(p=s(p,(r,i)=>{r(i),d.removeEventListener(h,p,n)})),(e.includes("away")||e.includes("outside"))&&(d=document,p=s(p,(r,i)=>{a.contains(i.target)||i.target.isConnected!==!1&&(a.offsetWidth<1&&a.offsetHeight<1||a._x_isShown!==!1&&r(i))})),e.includes("self")&&(p=s(p,(r,i)=>{i.target===a&&r(i)})),h==="submit"&&(p=s(p,(r,i)=>{i.target._x_pendingModelUpdates&&i.target._x_pendingModelUpdates.forEach(o=>o()),r(i)})),(sc(h)||Xh(h))&&(p=s(p,(r,i)=>{rc(i,e)||r(i)})),d.addEventListener(h,p,n),()=>{d.removeEventListener(h,p,n)}}function Kh(a,h){if(a.includes("debounce")){let e=a[a.indexOf("debounce")+1]||"invalid-wait",c=m1(e.split("ms")[0])?Number(e.split("ms")[0]):250;h=Sh(h,c)}if(a.includes("throttle")){let e=a[a.indexOf("throttle")+1]||"invalid-wait",c=m1(e.split("ms")[0])?Number(e.split("ms")[0]):250;h=Lh(h,c)}return h}function dc(a){return a.replace(/-/g,".")}function pc(a){return a.toLowerCase().replace(/-(\w)/g,(h,e)=>e.toUpperCase())}function m1(a){return!Array.isArray(a)&&!isNaN(a)}function nc(a){return[" ","_"].includes(a)?a:a.replace(/([a-z])([A-Z])/g,"$1-$2").replace(/[_\s]/,"-").toLowerCase()}function sc(a){return["keydown","keyup"].includes(a)}function Xh(a){return["contextmenu","click","mouse"].some(h=>a.includes(h))}function rc(a,h){let e=h.filter(p=>!["window","document","prevent","stop","once","capture","self","away","outside","passive","preserve-scroll","blur","change","lazy"].includes(p));if(e.includes("debounce")){let p=e.indexOf("debounce");e.splice(p,m1((e[p+1]||"invalid-wait").split("ms")[0])?2:1)}if(e.includes("throttle")){let p=e.indexOf("throttle");e.splice(p,m1((e[p+1]||"invalid-wait").split("ms")[0])?2:1)}if(e.length===0||e.length===1&&b2(a.key).includes(e[0]))return!1;const d=["ctrl","shift","alt","meta","cmd","super"].filter(p=>e.includes(p));return e=e.filter(p=>!d.includes(p)),!(d.length>0&&d.filter(n=>((n==="cmd"||n==="super")&&(n="meta"),a[`${n}Key`])).length===d.length&&(Xh(a.type)||b2(a.key).includes(e[0])))}function b2(a){if(!a)return[];a=nc(a);let h={ctrl:"control",slash:"/",space:" ",spacebar:" ",cmd:"meta",esc:"escape",up:"arrow-up",down:"arrow-down",left:"arrow-left",right:"arrow-right",period:".",comma:",",equal:"=",minus:"-",underscore:"_"};return h[a]=a,Object.keys(h).map(e=>{if(h[e]===a)return e}).filter(e=>e)}u("model",(a,{modifiers:h,expression:e},{effect:c,cleanup:d})=>{let p=a;h.includes("parent")&&(p=L(a,M=>M!==a));let n=w(p,e),s;typeof e=="string"?s=w(p,`${e} = __placeholder`):typeof e=="function"&&typeof e()=="string"?s=w(p,`${e()} = __placeholder`):s=()=>{};let r=()=>{let M;return n(f=>M=f),Z2(M)?M.get():M},i=M=>{let f;n(m=>f=m),Z2(f)?f.set(M):s(()=>{},{scope:{__placeholder:M}})};typeof e=="string"&&a.type==="radio"&&y(()=>{a.hasAttribute("name")||a.setAttribute("name",e)});let o=h.includes("change")||h.includes("lazy"),l=h.includes("blur"),g=h.includes("enter"),x=o||l||g,H;if(P)H=()=>{};else if(x){let M=[],f=m=>i(v1(a,h,m,r()));if(o&&M.push($(a,"change",h,f)),l&&(M.push($(a,"blur",h,f)),a.form)){let m=a.form,N=()=>f({target:a});m._x_pendingModelUpdates||(m._x_pendingModelUpdates=[]),m._x_pendingModelUpdates.push(N),d(()=>{m._x_pendingModelUpdates&&m._x_pendingModelUpdates.splice(m._x_pendingModelUpdates.indexOf(N),1)})}g&&M.push($(a,"keydown",h,m=>{m.key==="Enter"&&f(m)})),H=()=>M.forEach(m=>m())}else{let M=a.tagName.toLowerCase()==="select"||["checkbox","radio"].includes(a.type)?"change":"input";H=$(a,M,h,f=>{i(v1(a,h,f,r()))})}if(h.includes("fill")&&([void 0,null,""].includes(r())||f1(a)&&Array.isArray(r())||a.tagName.toLowerCase()==="select"&&a.multiple)&&i(v1(a,h,{target:a},r())),a._x_removeModelListeners||(a._x_removeModelListeners={}),a._x_removeModelListeners.default=H,d(()=>a._x_removeModelListeners.default()),a.form){let M=$(a.form,"reset",[],f=>{r2(()=>a._x_model&&a._x_model.set(v1(a,h,{target:a},r())))});d(()=>M())}a._x_model={get(){return r()},set(M){i(M)},setWithModifiers:Kh(h,i)},a._x_forceModelUpdate=M=>{M===void 0&&typeof e=="string"&&e.match(/\./)&&(M=""),y(()=>{f1(a)?Array.isArray(M)?a.checked=M.some(f=>f==a.value):a.checked=!!M:o2(a)?typeof M=="boolean"?a.checked=x1(a.value)===M:a.checked=a.value==M:Vh(a,"value",M)})},c(()=>{let M=r();h.includes("unintrusive")&&document.activeElement.isSameNode(a)||a._x_forceModelUpdate(M)})});function v1(a,h,e,c){return y(()=>{if(e instanceof CustomEvent&&e.detail!==void 0)return e.detail!==null&&e.detail!==void 0?e.detail:e.target.value;if(f1(a))if(Array.isArray(c)){let d=null;return h.includes("number")?d=k1(e.target.value):h.includes("boolean")?d=x1(e.target.value):d=e.target.value,e.target.checked?c.includes(d)?c:c.concat([d]):c.filter(p=>!ic(p,d))}else return e.target.checked;else{if(a.tagName.toLowerCase()==="select"&&a.multiple)return h.includes("number")?Array.from(e.target.selectedOptions).map(d=>{let p=d.value||d.text;return k1(p)}):h.includes("boolean")?Array.from(e.target.selectedOptions).map(d=>{let p=d.value||d.text;return x1(p)}):Array.from(e.target.selectedOptions).map(d=>d.value||d.text);{let d;return o2(a)?e.target.checked?d=e.target.value:d=c:d=e.target.value,h.includes("number")?k1(d):h.includes("boolean")?x1(d):h.includes("trim")?d.trim():d}}})}function k1(a){let h=a?parseFloat(a):null;return oc(h)?h:a}function ic(a,h){return a==h}function oc(a){return!Array.isArray(a)&&!isNaN(a)}function Z2(a){return a!==null&&typeof a=="object"&&typeof a.get=="function"&&typeof a.set=="function"}u("cloak",a=>queueMicrotask(()=>y(()=>a.removeAttribute(X("cloak")))));yh(()=>`[${X("init")}]`);u("init",O((a,{expression:h},{evaluate:e})=>typeof h=="string"?!!h.trim()&&e(h,{},!1):e(h,{},!1)));u("text",(a,{expression:h},{effect:e,evaluateLater:c})=>{let d=c(h);e(()=>{d(p=>{y(()=>{a.textContent=p})})})});u("html",(a,{expression:h},{effect:e,evaluateLater:c})=>{let d=c(h);e(()=>{d(p=>{y(()=>{a.innerHTML=p??"",a._x_ignoreSelf=!0,b(a),delete a._x_ignoreSelf})})})});p2(nh(":",sh(X("bind:"))));var Jh=(a,{value:h,modifiers:e,expression:c,original:d},{effect:p,cleanup:n})=>{if(!h){let r={};x4(r),w(a,c)(o=>{Ph(a,o,d)},{scope:r});return}if(h==="key")return lc(a,c);if(a._x_inlineBindings&&a._x_inlineBindings[h]&&a._x_inlineBindings[h].extract)return;let s=w(a,c);p(()=>s(r=>{r===void 0&&typeof c=="string"&&c.match(/\./)&&(r=""),y(()=>Vh(a,h,r,e))})),n(()=>{a._x_undoAddedClasses&&a._x_undoAddedClasses(),a._x_undoAddedStyles&&a._x_undoAddedStyles()})};Jh.inline=(a,{value:h,modifiers:e,expression:c})=>{h&&(a._x_inlineBindings||(a._x_inlineBindings={}),a._x_inlineBindings[h]={expression:c,extract:!1})};u("bind",Jh);function lc(a,h){a._x_keyExpression=h}xh(()=>`[${X("data")}]`);u("data",(a,{expression:h},{cleanup:e})=>{if(Mc(a))return;h=h===""?"{}":h;let c={};d1(c,a);let d={};u4(d,c);let p=E(a,h,{scope:d});(p===void 0||p===!0)&&(p={}),d1(p,a);let n=G(p);e2(n);let s=s1(a,n);n.init&&E(a,n.init),e(()=>{n.destroy&&E(a,n.destroy),s()})});V1((a,h)=>{a._x_dataStack&&(h._x_dataStack=a._x_dataStack,h.setAttribute("data-has-alpine-state",!0))});function Mc(a){return P?W1?!0:a.hasAttribute("data-has-alpine-state"):!1}u("show",(a,{modifiers:h,expression:e},{effect:c})=>{let d=w(a,e);a._x_doHide||(a._x_doHide=()=>{y(()=>{a.style.setProperty("display","none",h.includes("important")?"important":void 0)})}),a._x_doShow||(a._x_doShow=()=>{y(()=>{a.style.length===1&&a.style.display==="none"?a.removeAttribute("style"):a.style.removeProperty("display")})});let p=()=>{a._x_doHide(),a._x_isShown=!1},n=()=>{a._x_doShow(),a._x_isShown=!0},s=()=>setTimeout(n),r=N1(l=>l?n():p(),l=>{typeof a._x_toggleAndCascadeWithTransitions=="function"?a._x_toggleAndCascadeWithTransitions(a,l,n,p):l?s():p()}),i,o=!0;c(()=>d(l=>{!o&&l===i||(h.includes("immediate")&&(l?s():p()),r(l),i=l,o=!1)}))});u("for",(a,{expression:h},{effect:e,cleanup:c})=>{let d=xc(h),p=w(a,d.items),n=w(a,a._x_keyExpression||"index");a._x_lookup=new Map,e(()=>gc(a,d,p,n)),c(()=>{a._x_lookup.forEach(s=>y(()=>{J(s),s.remove()})),delete a._x_lookup})});function vc(a){return h=>{Object.entries(h).forEach(([e,c])=>{a[e]=c})}}function gc(a,h,e,c){e(d=>{uc(d)&&(d=Array.from({length:d},(i,o)=>o+1)),d==null&&(d=[]),d instanceof Set&&(d=Array.from(d)),d instanceof Map&&(d=Array.from(d));let p=a._x_lookup,n=new Map;a._x_lookup=n;let s=fc(d),r=Object.entries(d).map(([i,o])=>{s||(i=parseInt(i));let l=yc(h,o,i,d),g;return c(x=>{typeof x=="object"&&S("x-for key cannot be an object, it must be a string or an integer",a),p.has(x)&&(n.set(x,p.get(x)),p.delete(x)),g=x},{scope:{index:i,...l}}),[g,l]});y(()=>{p.forEach(l=>{J(l),l.remove()});let i=new Set,o=a;r.forEach(([l,g])=>{if(n.has(l)){let M=n.get(l);M._x_refreshXForScope(g),o.nextElementSibling!==M&&(o.nextElementSibling&&M.replaceWith(o.nextElementSibling),o.after(M)),o=M,M._x_currentIfEl&&(M.nextElementSibling!==M._x_currentIfEl&&o.after(M._x_currentIfEl),o=M._x_currentIfEl);return}a.content.children.length>1&&S("x-for templates require a single root element, additional elements will be ignored.",a);let x=document.importNode(a.content,!0).firstElementChild,H=G(g);s1(x,H,a),x._x_refreshXForScope=vc(H),n.set(l,x),i.add(x),o.after(x),o=x}),O(()=>i.forEach(l=>b(l)))()})})}function xc(a){let h=/,([^,\}\]]*)(?:,([^,\}\]]*))?$/,e=/^\s*\(|\)\s*$/g,c=/([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,d=a.match(c);if(!d)return;let p={};p.items=d[2].trim();let n=d[1].replace(e,"").trim(),s=n.match(h);return s?(p.item=n.replace(h,"").trim(),p.index=s[1].trim(),s[2]&&(p.collection=s[2].trim())):p.item=n,p}function yc(a,h,e,c){let d={};return/^\[.*\]$/.test(a.item)&&Array.isArray(h)?a.item.replace("[","").replace("]","").split(",").map(n=>n.trim()).forEach((n,s)=>{d[n]=h[s]}):/^\{.*\}$/.test(a.item)&&!Array.isArray(h)&&typeof h=="object"?a.item.replace("{","").replace("}","").split(",").map(n=>n.trim()).forEach(n=>{d[n]=h[n]}):d[a.item]=h,a.index&&(d[a.index]=e),a.collection&&(d[a.collection]=c),d}function uc(a){return typeof a!="object"&&!isNaN(a)}function fc(a){return typeof a=="object"&&!Array.isArray(a)}function Yh(){}Yh.inline=(a,{expression:h},{cleanup:e})=>{let c=w1(a);c&&(c._x_refs||(c._x_refs={}),c._x_refs[h]=a,e(()=>delete c._x_refs[h]))};u("ref",Yh);u("if",(a,{expression:h},{effect:e,cleanup:c})=>{a.tagName.toLowerCase()!=="template"&&S("x-if can only be used on a <template> tag",a);let d=w(a,h),p=()=>{if(a._x_currentIfEl)return a._x_currentIfEl;let s=a.content.cloneNode(!0).firstElementChild;return s1(s,{},a),y(()=>{a.after(s),O(()=>b(s))()}),a._x_currentIfEl=s,a._x_undoIf=()=>{y(()=>{J(s),s.remove()}),delete a._x_currentIfEl},s},n=()=>{a._x_undoIf&&(a._x_undoIf(),delete a._x_undoIf)};e(()=>d(s=>{s?p():n()})),c(()=>a._x_undoIf&&a._x_undoIf())});u("id",(a,{expression:h},{evaluate:e})=>{e(h).forEach(d=>hc(a,d))});V1((a,h)=>{a._x_ids&&(h._x_ids=a._x_ids)});p2(nh("@",sh(X("on:"))));u("on",O((a,{value:h,modifiers:e,expression:c},{cleanup:d})=>{let p=c?w(a,c):()=>{};a.tagName.toLowerCase()==="template"&&(a._x_forwardEvents||(a._x_forwardEvents=[]),a._x_forwardEvents.includes(h)||a._x_forwardEvents.push(h));let n=$(a,h,e,s=>{p(()=>{},{scope:{$event:s},params:[s]})});d(()=>n())}));S1("Collapse","collapse","collapse");S1("Intersect","intersect","intersect");S1("Focus","trap","focus");S1("Mask","mask","mask");function S1(a,h,e){u(h,c=>S(`You can't use [x-${h}] without first installing the "${a}" plugin here: https://alpinejs.dev/plugins/${e}`,c))}Y.setEvaluator(Ce);Y.setRawEvaluator(be);Y.setReactivityEngine({reactive:u2,effect:L4,release:b4,raw:v});var mc=Y,V=mc;function wc(a){a.directive("collapse",h),h.inline=(e,{modifiers:c})=>{c.includes("min")&&(e._x_doShow=()=>{},e._x_doHide=()=>{})};function h(e,{modifiers:c}){let d=P2(c,"duration",250)/1e3,p=P2(c,"min",0),n=!c.includes("min");e._x_isShown||(e.style.height=`${p}px`),!e._x_isShown&&n&&(e.hidden=!0),e._x_isShown||(e.style.overflow="hidden");let s=(i,o)=>{let l=a.setStyles(i,o);return o.height?()=>{}:l},r={transitionProperty:"height",transitionDuration:`${d}s`,transitionTimingFunction:"cubic-bezier(0.4, 0.0, 0.2, 1)"};e._x_transition={in(i=()=>{},o=()=>{}){n&&(e.hidden=!1),n&&(e.style.display=null);let l=e.getBoundingClientRect().height;e.style.height="auto";let g=e.getBoundingClientRect().height;l===g&&(l=p),a.transition(e,a.setStyles,{during:r,start:{height:l+"px"},end:{height:g+"px"}},()=>e._x_isShown=!0,()=>{Math.abs(e.getBoundingClientRect().height-g)<1&&(e.style.overflow=null)})},out(i=()=>{},o=()=>{}){let l=e.getBoundingClientRect().height;a.transition(e,s,{during:r,start:{height:l+"px"},end:{height:p+"px"}},()=>e.style.overflow="hidden",()=>{e._x_isShown=!1,e.style.height==`${p}px`&&n&&(e.style.display="none",e.hidden=!0)})}}}}function P2(a,h,e){if(a.indexOf(h)===-1)return e;const c=a[a.indexOf(h)+1];if(!c)return e;if(h==="duration"){let d=c.match(/([0-9]+)ms/);if(d)return d[1]}if(h==="min"){let d=c.match(/([0-9]+)px/);if(d)return d[1]}return c}var Hc=wc;/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qh=(a,h,e=[])=>{const c=document.createElementNS("http://www.w3.org/2000/svg",a);return Object.keys(h).forEach(d=>{c.setAttribute(d,String(h[d]))}),e.length&&e.forEach(d=>{const p=Qh(...d);c.appendChild(p)}),c};var Vc=([a,h,e])=>Qh(a,h,e);/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cc=a=>Array.from(a.attributes).reduce((h,e)=>(h[e.name]=e.value,h),{}),Ac=a=>typeof a=="string"?a:!a||!a.class?"":a.class&&typeof a.class=="string"?a.class.split(" "):a.class&&Array.isArray(a.class)?a.class:"",_c=a=>a.flatMap(Ac).map(e=>e.trim()).filter(Boolean).filter((e,c,d)=>d.indexOf(e)===c).join(" "),Sc=a=>a.replace(/(\w)(\w*)(_|-|\s*)/g,(h,e,c)=>e.toUpperCase()+c.toLowerCase()),k2=(a,{nameAttr:h,icons:e,attrs:c})=>{var H;const d=a.getAttribute(h);if(d==null)return;const p=Sc(d),n=e[p];if(!n)return console.warn(`${a.outerHTML} icon name was not found in the provided icons object.`);const s=Cc(a),[r,i,o]=n,l={...i,"data-lucide":d,...c,...s},g=_c(["lucide",`lucide-${d}`,s,c]);g&&Object.assign(l,{class:g});const x=Vc([r,l,o]);return(H=a.parentNode)==null?void 0:H.replaceChild(x,a)};/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":2,"stroke-linecap":"round","stroke-linejoin":"round"};/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lc=["svg",t,[["path",{d:"M3.5 13h6"}],["path",{d:"m2 16 4.5-9 4.5 9"}],["path",{d:"M18 7v9"}],["path",{d:"m14 12 4 4 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bc=["svg",t,[["path",{d:"M3.5 13h6"}],["path",{d:"m2 16 4.5-9 4.5 9"}],["path",{d:"M18 16V7"}],["path",{d:"m14 11 4-4 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zc=["svg",t,[["path",{d:"M21 14h-5"}],["path",{d:"M16 16v-3.5a2.5 2.5 0 0 1 5 0V16"}],["path",{d:"M4.5 13h6"}],["path",{d:"m3 16 4.5-9 4.5 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pc=["svg",t,[["circle",{cx:"16",cy:"4",r:"1"}],["path",{d:"m18 19 1-7-6 1"}],["path",{d:"m5 8 3-3 5.5 3-2.36 3.5"}],["path",{d:"M4.24 14.5a5 5 0 0 0 6.88 6"}],["path",{d:"M13.76 17.5a5 5 0 0 0-6.88-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kc=["svg",t,[["path",{d:"M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Oc=["svg",t,[["path",{d:"M6 12H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"}],["path",{d:"M6 8h12"}],["path",{d:"M18.3 17.7a2.5 2.5 0 0 1-3.16 3.83 2.53 2.53 0 0 1-1.14-2V12"}],["path",{d:"M6.6 15.6A2 2 0 1 0 10 17v-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rc=["svg",t,[["path",{d:"M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"}],["path",{d:"m12 15 5 6H7Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O2=["svg",t,[["circle",{cx:"12",cy:"13",r:"8"}],["path",{d:"M5 3 2 6"}],["path",{d:"m22 6-3-3"}],["path",{d:"M6.38 18.7 4 21"}],["path",{d:"M17.64 18.67 20 21"}],["path",{d:"m9 13 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R2=["svg",t,[["circle",{cx:"12",cy:"13",r:"8"}],["path",{d:"M5 3 2 6"}],["path",{d:"m22 6-3-3"}],["path",{d:"M6.38 18.7 4 21"}],["path",{d:"M17.64 18.67 20 21"}],["path",{d:"M9 13h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bc=["svg",t,[["path",{d:"M6.87 6.87a8 8 0 1 0 11.26 11.26"}],["path",{d:"M19.9 14.25a8 8 0 0 0-9.15-9.15"}],["path",{d:"m22 6-3-3"}],["path",{d:"M6.26 18.67 4 21"}],["path",{d:"m2 2 20 20"}],["path",{d:"M4 4 2 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B2=["svg",t,[["circle",{cx:"12",cy:"13",r:"8"}],["path",{d:"M5 3 2 6"}],["path",{d:"m22 6-3-3"}],["path",{d:"M6.38 18.7 4 21"}],["path",{d:"M17.64 18.67 20 21"}],["path",{d:"M12 10v6"}],["path",{d:"M9 13h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tc=["svg",t,[["circle",{cx:"12",cy:"13",r:"8"}],["path",{d:"M12 9v4l2 2"}],["path",{d:"M5 3 2 6"}],["path",{d:"m22 6-3-3"}],["path",{d:"M6.38 18.7 4 21"}],["path",{d:"M17.64 18.67 20 21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ec=["svg",t,[["path",{d:"M11 21c0-2.5 2-2.5 2-5"}],["path",{d:"M16 21c0-2.5 2-2.5 2-5"}],["path",{d:"m19 8-.8 3a1.25 1.25 0 0 1-1.2 1H7a1.25 1.25 0 0 1-1.2-1L5 8"}],["path",{d:"M21 3a1 1 0 0 1 1 1v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a1 1 0 0 1 1-1z"}],["path",{d:"M6 21c0-2.5 2-2.5 2-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fc=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["polyline",{points:"11 3 11 11 14 8 17 11 17 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zc=["svg",t,[["path",{d:"M2 12h20"}],["path",{d:"M10 16v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4"}],["path",{d:"M10 8V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"}],["path",{d:"M20 16v1a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-1"}],["path",{d:"M14 8V7c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dc=["svg",t,[["path",{d:"M12 2v20"}],["path",{d:"M8 10H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h4"}],["path",{d:"M16 10h4a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-4"}],["path",{d:"M8 20H7a2 2 0 0 1-2-2v-2c0-1.1.9-2 2-2h1"}],["path",{d:"M16 14h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qc=["svg",t,[["line",{x1:"21",x2:"3",y1:"6",y2:"6"}],["line",{x1:"17",x2:"7",y1:"12",y2:"12"}],["line",{x1:"19",x2:"5",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uc=["svg",t,[["rect",{width:"6",height:"16",x:"4",y:"2",rx:"2"}],["rect",{width:"6",height:"9",x:"14",y:"9",rx:"2"}],["path",{d:"M22 22H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ic=["svg",t,[["rect",{width:"16",height:"6",x:"2",y:"4",rx:"2"}],["rect",{width:"9",height:"6",x:"9",y:"14",rx:"2"}],["path",{d:"M22 22V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nc=["svg",t,[["rect",{width:"6",height:"14",x:"4",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"14",y:"7",rx:"2"}],["path",{d:"M17 22v-5"}],["path",{d:"M17 7V2"}],["path",{d:"M7 22v-3"}],["path",{d:"M7 5V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $c=["svg",t,[["rect",{width:"6",height:"14",x:"4",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"14",y:"7",rx:"2"}],["path",{d:"M10 2v20"}],["path",{d:"M20 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wc=["svg",t,[["rect",{width:"6",height:"14",x:"4",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"14",y:"7",rx:"2"}],["path",{d:"M4 2v20"}],["path",{d:"M14 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jc=["svg",t,[["rect",{width:"6",height:"14",x:"2",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"16",y:"7",rx:"2"}],["path",{d:"M12 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gc=["svg",t,[["rect",{width:"6",height:"14",x:"2",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"12",y:"7",rx:"2"}],["path",{d:"M22 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kc=["svg",t,[["rect",{width:"6",height:"14",x:"6",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"16",y:"7",rx:"2"}],["path",{d:"M2 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xc=["svg",t,[["rect",{width:"6",height:"10",x:"9",y:"7",rx:"2"}],["path",{d:"M4 22V2"}],["path",{d:"M20 22V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jc=["svg",t,[["rect",{width:"6",height:"14",x:"3",y:"5",rx:"2"}],["rect",{width:"6",height:"10",x:"15",y:"7",rx:"2"}],["path",{d:"M3 2v20"}],["path",{d:"M21 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yc=["svg",t,[["line",{x1:"3",x2:"21",y1:"6",y2:"6"}],["line",{x1:"3",x2:"21",y1:"12",y2:"12"}],["line",{x1:"3",x2:"21",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qc=["svg",t,[["line",{x1:"21",x2:"3",y1:"6",y2:"6"}],["line",{x1:"15",x2:"3",y1:"12",y2:"12"}],["line",{x1:"17",x2:"3",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const td=["svg",t,[["line",{x1:"21",x2:"3",y1:"6",y2:"6"}],["line",{x1:"21",x2:"9",y1:"12",y2:"12"}],["line",{x1:"21",x2:"7",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ad=["svg",t,[["rect",{width:"6",height:"16",x:"4",y:"6",rx:"2"}],["rect",{width:"6",height:"9",x:"14",y:"6",rx:"2"}],["path",{d:"M22 2H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hd=["svg",t,[["rect",{width:"9",height:"6",x:"6",y:"14",rx:"2"}],["rect",{width:"16",height:"6",x:"6",y:"4",rx:"2"}],["path",{d:"M2 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ed=["svg",t,[["path",{d:"M22 17h-3"}],["path",{d:"M22 7h-5"}],["path",{d:"M5 17H2"}],["path",{d:"M7 7H2"}],["rect",{x:"5",y:"14",width:"14",height:"6",rx:"2"}],["rect",{x:"7",y:"4",width:"10",height:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cd=["svg",t,[["rect",{width:"14",height:"6",x:"5",y:"14",rx:"2"}],["rect",{width:"10",height:"6",x:"7",y:"4",rx:"2"}],["path",{d:"M2 20h20"}],["path",{d:"M2 10h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dd=["svg",t,[["rect",{width:"14",height:"6",x:"5",y:"14",rx:"2"}],["rect",{width:"10",height:"6",x:"7",y:"4",rx:"2"}],["path",{d:"M2 14h20"}],["path",{d:"M2 4h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pd=["svg",t,[["rect",{width:"14",height:"6",x:"5",y:"16",rx:"2"}],["rect",{width:"10",height:"6",x:"7",y:"2",rx:"2"}],["path",{d:"M2 12h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nd=["svg",t,[["rect",{width:"14",height:"6",x:"5",y:"12",rx:"2"}],["rect",{width:"10",height:"6",x:"7",y:"2",rx:"2"}],["path",{d:"M2 22h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sd=["svg",t,[["rect",{width:"14",height:"6",x:"5",y:"16",rx:"2"}],["rect",{width:"10",height:"6",x:"7",y:"6",rx:"2"}],["path",{d:"M2 2h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rd=["svg",t,[["rect",{width:"10",height:"6",x:"7",y:"9",rx:"2"}],["path",{d:"M22 20H2"}],["path",{d:"M22 4H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const id=["svg",t,[["rect",{width:"14",height:"6",x:"5",y:"15",rx:"2"}],["rect",{width:"10",height:"6",x:"7",y:"3",rx:"2"}],["path",{d:"M2 21h20"}],["path",{d:"M2 3h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const od=["svg",t,[["path",{d:"M10 10H6"}],["path",{d:"M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"}],["path",{d:"M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"}],["path",{d:"M8 8v4"}],["path",{d:"M9 18h6"}],["circle",{cx:"17",cy:"18",r:"2"}],["circle",{cx:"7",cy:"18",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ld=["svg",t,[["path",{d:"M17.5 12c0 4.4-3.6 8-8 8A4.5 4.5 0 0 1 5 15.5c0-6 8-4 8-8.5a3 3 0 1 0-6 0c0 3 2.5 8.5 12 13"}],["path",{d:"M16 12h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Md=["svg",t,[["path",{d:"M10 17c-5-3-7-7-7-9a2 2 0 0 1 4 0c0 2.5-5 2.5-5 6 0 1.7 1.3 3 3 3 2.8 0 5-2.2 5-5"}],["path",{d:"M22 17c-5-3-7-7-7-9a2 2 0 0 1 4 0c0 2.5-5 2.5-5 6 0 1.7 1.3 3 3 3 2.8 0 5-2.2 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vd=["svg",t,[["path",{d:"M12 22V8"}],["path",{d:"M5 12H2a10 10 0 0 0 20 0h-3"}],["circle",{cx:"12",cy:"5",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gd=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M16 16s-1.5-2-4-2-4 2-4 2"}],["path",{d:"M7.5 8 10 9"}],["path",{d:"m14 9 2.5-1"}],["path",{d:"M9 10h0"}],["path",{d:"M15 10h0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xd=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M8 15h8"}],["path",{d:"M8 9h2"}],["path",{d:"M14 9h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yd=["svg",t,[["path",{d:"M2 12 7 2"}],["path",{d:"m7 12 5-10"}],["path",{d:"m12 12 5-10"}],["path",{d:"m17 12 5-10"}],["path",{d:"M4.5 7h15"}],["path",{d:"M12 16v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ud=["svg",t,[["path",{d:"M7 10H6a4 4 0 0 1-4-4 1 1 0 0 1 1-1h4"}],["path",{d:"M7 5a1 1 0 0 1 1-1h13a1 1 0 0 1 1 1 7 7 0 0 1-7 7H8a1 1 0 0 1-1-1z"}],["path",{d:"M9 12v5"}],["path",{d:"M15 12v5"}],["path",{d:"M5 20a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3 1 1 0 0 1-1 1H6a1 1 0 0 1-1-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fd=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m14.31 8 5.74 9.94"}],["path",{d:"M9.69 8h11.48"}],["path",{d:"m7.38 12 5.74-9.94"}],["path",{d:"M9.69 16 3.95 6.06"}],["path",{d:"M14.31 16H2.83"}],["path",{d:"m16.62 12-5.74 9.94"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const md=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"M6 8h.01"}],["path",{d:"M10 8h.01"}],["path",{d:"M14 8h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wd=["svg",t,[["rect",{x:"2",y:"4",width:"20",height:"16",rx:"2"}],["path",{d:"M10 4v4"}],["path",{d:"M2 8h20"}],["path",{d:"M6 4v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hd=["svg",t,[["path",{d:"M12 20.94c1.5 0 2.75 1.06 4 1.06 3 0 6-8 6-12.22A4.91 4.91 0 0 0 17 5c-2.22 0-4 1.44-5 2-1-.56-2.78-2-5-2a4.9 4.9 0 0 0-5 4.78C2 14 5 22 8 22c1.25 0 2.5-1.06 4-1.06Z"}],["path",{d:"M10 2c1 .5 2 2 2 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vd=["svg",t,[["rect",{width:"20",height:"5",x:"2",y:"3",rx:"1"}],["path",{d:"M4 8v11a2 2 0 0 0 2 2h2"}],["path",{d:"M20 8v11a2 2 0 0 1-2 2h-2"}],["path",{d:"m9 15 3-3 3 3"}],["path",{d:"M12 12v9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cd=["svg",t,[["rect",{width:"20",height:"5",x:"2",y:"3",rx:"1"}],["path",{d:"M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"}],["path",{d:"m9.5 17 5-5"}],["path",{d:"m9.5 12 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ad=["svg",t,[["rect",{width:"20",height:"5",x:"2",y:"3",rx:"1"}],["path",{d:"M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"}],["path",{d:"M10 12h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _d=["svg",t,[["path",{d:"M3 3v18h18"}],["path",{d:"M7 12v5h12V8l-5 5-4-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sd=["svg",t,[["path",{d:"M19 9V6a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v3"}],["path",{d:"M3 16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v2H7v-2a2 2 0 0 0-4 0Z"}],["path",{d:"M5 18v2"}],["path",{d:"M19 18v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ld=["svg",t,[["path",{d:"M15 5H9"}],["path",{d:"M15 9v3h4l-7 7-7-7h4V9z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bd=["svg",t,[["path",{d:"M15 6v6h4l-7 7-7-7h4V6h6z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zd=["svg",t,[["path",{d:"M19 15V9"}],["path",{d:"M15 15h-3v4l-7-7 7-7v4h3v6z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pd=["svg",t,[["path",{d:"M18 15h-6v4l-7-7 7-7v4h6v6z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kd=["svg",t,[["path",{d:"M5 9v6"}],["path",{d:"M9 9h3V5l7 7-7 7v-4H9V9z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Od=["svg",t,[["path",{d:"M6 9h6V5l7 7-7 7v-4H6V9z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rd=["svg",t,[["path",{d:"M9 19h6"}],["path",{d:"M9 15v-3H5l7-7 7 7h-4v3H9z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bd=["svg",t,[["path",{d:"M9 18v-6H5l7-7 7 7h-4v6H9z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Td=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 20V4"}],["rect",{x:"15",y:"4",width:"4",height:"6",ry:"2"}],["path",{d:"M17 20v-6h-2"}],["path",{d:"M15 20h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ed=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 20V4"}],["path",{d:"M17 10V4h-2"}],["path",{d:"M15 10h4"}],["rect",{x:"15",y:"14",width:"4",height:"6",ry:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T2=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 20V4"}],["path",{d:"M20 8h-5"}],["path",{d:"M15 10V6.5a2.5 2.5 0 0 1 5 0V10"}],["path",{d:"M15 14h5l-5 6h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fd=["svg",t,[["path",{d:"M19 3H5"}],["path",{d:"M12 21V7"}],["path",{d:"m6 15 6 6 6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zd=["svg",t,[["path",{d:"M17 7 7 17"}],["path",{d:"M17 17H7V7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dd=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 20V4"}],["path",{d:"M11 4h4"}],["path",{d:"M11 8h7"}],["path",{d:"M11 12h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qd=["svg",t,[["path",{d:"m7 7 10 10"}],["path",{d:"M17 7v10H7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ud=["svg",t,[["path",{d:"M12 2v14"}],["path",{d:"m19 9-7 7-7-7"}],["circle",{cx:"12",cy:"21",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Id=["svg",t,[["path",{d:"M12 17V3"}],["path",{d:"m6 11 6 6 6-6"}],["path",{d:"M19 21H5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nd=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 20V4"}],["path",{d:"m21 8-4-4-4 4"}],["path",{d:"M17 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E2=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 20V4"}],["path",{d:"M11 4h10"}],["path",{d:"M11 8h7"}],["path",{d:"M11 12h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F2=["svg",t,[["path",{d:"m3 16 4 4 4-4"}],["path",{d:"M7 4v16"}],["path",{d:"M15 4h5l-5 6h5"}],["path",{d:"M15 20v-3.5a2.5 2.5 0 0 1 5 0V20"}],["path",{d:"M20 18h-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $d=["svg",t,[["path",{d:"M12 5v14"}],["path",{d:"m19 12-7 7-7-7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wd=["svg",t,[["path",{d:"m9 6-6 6 6 6"}],["path",{d:"M3 12h14"}],["path",{d:"M21 19V5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jd=["svg",t,[["path",{d:"M8 3 4 7l4 4"}],["path",{d:"M4 7h16"}],["path",{d:"m16 21 4-4-4-4"}],["path",{d:"M20 17H4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gd=["svg",t,[["path",{d:"M3 19V5"}],["path",{d:"m13 6-6 6 6 6"}],["path",{d:"M7 12h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kd=["svg",t,[["path",{d:"m12 19-7-7 7-7"}],["path",{d:"M19 12H5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xd=["svg",t,[["path",{d:"M3 5v14"}],["path",{d:"M21 12H7"}],["path",{d:"m15 18 6-6-6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jd=["svg",t,[["path",{d:"m16 3 4 4-4 4"}],["path",{d:"M20 7H4"}],["path",{d:"m8 21-4-4 4-4"}],["path",{d:"M4 17h16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yd=["svg",t,[["path",{d:"M17 12H3"}],["path",{d:"m11 18 6-6-6-6"}],["path",{d:"M21 5v14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qd=["svg",t,[["path",{d:"M5 12h14"}],["path",{d:"m12 5 7 7-7 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t5=["svg",t,[["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}],["rect",{x:"15",y:"4",width:"4",height:"6",ry:"2"}],["path",{d:"M17 20v-6h-2"}],["path",{d:"M15 20h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a5=["svg",t,[["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}],["path",{d:"M17 10V4h-2"}],["path",{d:"M15 10h4"}],["rect",{x:"15",y:"14",width:"4",height:"6",ry:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z2=["svg",t,[["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}],["path",{d:"M20 8h-5"}],["path",{d:"M15 10V6.5a2.5 2.5 0 0 1 5 0V10"}],["path",{d:"M15 14h5l-5 6h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h5=["svg",t,[["path",{d:"m21 16-4 4-4-4"}],["path",{d:"M17 20V4"}],["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e5=["svg",t,[["path",{d:"m5 9 7-7 7 7"}],["path",{d:"M12 16V2"}],["circle",{cx:"12",cy:"21",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c5=["svg",t,[["path",{d:"m18 9-6-6-6 6"}],["path",{d:"M12 3v14"}],["path",{d:"M5 21h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d5=["svg",t,[["path",{d:"M7 17V7h10"}],["path",{d:"M17 17 7 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D2=["svg",t,[["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}],["path",{d:"M11 12h4"}],["path",{d:"M11 16h7"}],["path",{d:"M11 20h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p5=["svg",t,[["path",{d:"M7 7h10v10"}],["path",{d:"M7 17 17 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n5=["svg",t,[["path",{d:"M5 3h14"}],["path",{d:"m18 13-6-6-6 6"}],["path",{d:"M12 7v14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s5=["svg",t,[["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}],["path",{d:"M11 12h10"}],["path",{d:"M11 16h7"}],["path",{d:"M11 20h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q2=["svg",t,[["path",{d:"m3 8 4-4 4 4"}],["path",{d:"M7 4v16"}],["path",{d:"M15 4h5l-5 6h5"}],["path",{d:"M15 20v-3.5a2.5 2.5 0 0 1 5 0V20"}],["path",{d:"M20 18h-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r5=["svg",t,[["path",{d:"m5 12 7-7 7 7"}],["path",{d:"M12 19V5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i5=["svg",t,[["path",{d:"m4 6 3-3 3 3"}],["path",{d:"M7 17V3"}],["path",{d:"m14 6 3-3 3 3"}],["path",{d:"M17 17V3"}],["path",{d:"M4 21h16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o5=["svg",t,[["path",{d:"M12 6v12"}],["path",{d:"M17.196 9 6.804 15"}],["path",{d:"m6.804 9 10.392 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l5=["svg",t,[["circle",{cx:"12",cy:"12",r:"4"}],["path",{d:"M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M5=["svg",t,[["circle",{cx:"12",cy:"12",r:"1"}],["path",{d:"M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"}],["path",{d:"M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v5=["svg",t,[["path",{d:"M2 10v3"}],["path",{d:"M6 6v11"}],["path",{d:"M10 3v18"}],["path",{d:"M14 8v7"}],["path",{d:"M18 5v13"}],["path",{d:"M22 10v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g5=["svg",t,[["path",{d:"M2 13a2 2 0 0 0 2-2V7a2 2 0 0 1 4 0v13a2 2 0 0 0 4 0V4a2 2 0 0 1 4 0v13a2 2 0 0 0 4 0v-4a2 2 0 0 1 2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x5=["svg",t,[["path",{d:"m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"}],["circle",{cx:"12",cy:"8",r:"6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y5=["svg",t,[["path",{d:"m14 12-8.5 8.5a2.12 2.12 0 1 1-3-3L11 9"}],["path",{d:"M15 13 9 7l4-4 6 6h3a8 8 0 0 1-7 7z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U2=["svg",t,[["path",{d:"M4 4v16h16"}],["path",{d:"m4 20 7-7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u5=["svg",t,[["path",{d:"M9 12h.01"}],["path",{d:"M15 12h.01"}],["path",{d:"M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"}],["path",{d:"M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f5=["svg",t,[["path",{d:"M4 10a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"}],["path",{d:"M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"}],["path",{d:"M8 21v-5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v5"}],["path",{d:"M8 10h8"}],["path",{d:"M8 18h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["line",{x1:"12",x2:"12",y1:"8",y2:"12"}],["line",{x1:"12",x2:"12.01",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M12 7v10"}],["path",{d:"M15.4 10a4 4 0 1 0 0 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I2=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"m9 12 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"}],["path",{d:"M12 18V6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M7 12h5"}],["path",{d:"M15 9.4a4 4 0 1 0 0 5.2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"}],["line",{x1:"12",x2:"12.01",y1:"17",y2:"17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M8 8h8"}],["path",{d:"M8 12h8"}],["path",{d:"m13 17-5-1h1a4 4 0 0 0 0-8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["line",{x1:"12",x2:"12",y1:"16",y2:"12"}],["line",{x1:"12",x2:"12.01",y1:"8",y2:"8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"m9 8 3 3v7"}],["path",{d:"m12 11 3-3"}],["path",{d:"M9 12h6"}],["path",{d:"M9 16h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["line",{x1:"8",x2:"16",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"m15 9-6 6"}],["path",{d:"M9 9h.01"}],["path",{d:"M15 15h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["line",{x1:"12",x2:"12",y1:"8",y2:"16"}],["line",{x1:"8",x2:"16",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M8 12h4"}],["path",{d:"M10 16V9.5a2.5 2.5 0 0 1 5 0"}],["path",{d:"M8 16h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M9 16h5"}],["path",{d:"M9 12h5a2 2 0 1 0 0-4h-3v9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["path",{d:"M11 17V8h4"}],["path",{d:"M11 12h3"}],["path",{d:"M9 16h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}],["line",{x1:"15",x2:"9",y1:"9",y2:"15"}],["line",{x1:"9",x2:"15",y1:"9",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B5=["svg",t,[["path",{d:"M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T5=["svg",t,[["path",{d:"M22 18H6a2 2 0 0 1-2-2V7a2 2 0 0 0-2-2"}],["path",{d:"M17 14V4a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v10"}],["rect",{width:"13",height:"8",x:"8",y:"6",rx:"1"}],["circle",{cx:"18",cy:"20",r:"2"}],["circle",{cx:"9",cy:"20",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E5=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m4.9 4.9 14.2 14.2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F5=["svg",t,[["path",{d:"M4 13c3.5-2 8-2 10 2a5.5 5.5 0 0 1 8 5"}],["path",{d:"M5.15 17.89c5.52-1.52 8.65-6.89 7-12C11.55 4 11.5 2 13 2c3.22 0 5 5.5 5 8 0 6.5-4.2 12-10.49 12C5.11 22 2 22 2 20c0-1.5 1.14-1.55 3.15-2.11Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z5=["svg",t,[["rect",{width:"20",height:"12",x:"2",y:"6",rx:"2"}],["circle",{cx:"12",cy:"12",r:"2"}],["path",{d:"M6 12h.01M18 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D5=["svg",t,[["line",{x1:"18",x2:"18",y1:"20",y2:"10"}],["line",{x1:"12",x2:"12",y1:"20",y2:"4"}],["line",{x1:"6",x2:"6",y1:"20",y2:"14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q5=["svg",t,[["path",{d:"M3 3v18h18"}],["path",{d:"M18 17V9"}],["path",{d:"M13 17V5"}],["path",{d:"M8 17v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U5=["svg",t,[["path",{d:"M3 3v18h18"}],["path",{d:"M13 17V9"}],["path",{d:"M18 17V5"}],["path",{d:"M8 17v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I5=["svg",t,[["path",{d:"M3 3v18h18"}],["rect",{width:"4",height:"7",x:"7",y:"10",rx:"1"}],["rect",{width:"4",height:"12",x:"15",y:"5",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N5=["svg",t,[["path",{d:"M3 3v18h18"}],["rect",{width:"12",height:"4",x:"7",y:"5",rx:"1"}],["rect",{width:"7",height:"4",x:"7",y:"13",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $5=["svg",t,[["path",{d:"M3 3v18h18"}],["path",{d:"M7 16h8"}],["path",{d:"M7 11h12"}],["path",{d:"M7 6h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W5=["svg",t,[["line",{x1:"12",x2:"12",y1:"20",y2:"10"}],["line",{x1:"18",x2:"18",y1:"20",y2:"4"}],["line",{x1:"6",x2:"6",y1:"20",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j5=["svg",t,[["path",{d:"M3 5v14"}],["path",{d:"M8 5v14"}],["path",{d:"M12 5v14"}],["path",{d:"M17 5v14"}],["path",{d:"M21 5v14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G5=["svg",t,[["path",{d:"M4 20h16"}],["path",{d:"m6 16 6-12 6 12"}],["path",{d:"M8 12h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K5=["svg",t,[["path",{d:"M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"}],["line",{x1:"10",x2:"8",y1:"5",y2:"7"}],["line",{x1:"2",x2:"22",y1:"12",y2:"12"}],["line",{x1:"7",x2:"7",y1:"19",y2:"21"}],["line",{x1:"17",x2:"17",y1:"19",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X5=["svg",t,[["path",{d:"M15 7h1a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-2"}],["path",{d:"M6 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h1"}],["path",{d:"m11 7-3 5h4l-3 5"}],["line",{x1:"22",x2:"22",y1:"11",y2:"13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J5=["svg",t,[["rect",{width:"16",height:"10",x:"2",y:"7",rx:"2",ry:"2"}],["line",{x1:"22",x2:"22",y1:"11",y2:"13"}],["line",{x1:"6",x2:"6",y1:"11",y2:"13"}],["line",{x1:"10",x2:"10",y1:"11",y2:"13"}],["line",{x1:"14",x2:"14",y1:"11",y2:"13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y5=["svg",t,[["rect",{width:"16",height:"10",x:"2",y:"7",rx:"2",ry:"2"}],["line",{x1:"22",x2:"22",y1:"11",y2:"13"}],["line",{x1:"6",x2:"6",y1:"11",y2:"13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q5=["svg",t,[["rect",{width:"16",height:"10",x:"2",y:"7",rx:"2",ry:"2"}],["line",{x1:"22",x2:"22",y1:"11",y2:"13"}],["line",{x1:"6",x2:"6",y1:"11",y2:"13"}],["line",{x1:"10",x2:"10",y1:"11",y2:"13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tp=["svg",t,[["path",{d:"M14 7h2a2 2 0 0 1 2 2v6c0 1-1 2-2 2h-2"}],["path",{d:"M6 7H4a2 2 0 0 0-2 2v6c0 1 1 2 2 2h2"}],["line",{x1:"22",x2:"22",y1:"11",y2:"13"}],["line",{x1:"10",x2:"10",y1:"7",y2:"13"}],["line",{x1:"10",x2:"10",y1:"17",y2:"17.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ap=["svg",t,[["rect",{width:"16",height:"10",x:"2",y:"7",rx:"2",ry:"2"}],["line",{x1:"22",x2:"22",y1:"11",y2:"13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hp=["svg",t,[["path",{d:"M4.5 3h15"}],["path",{d:"M6 3v16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V3"}],["path",{d:"M6 14h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ep=["svg",t,[["path",{d:"M9 9c-.64.64-1.521.954-2.402 1.165A6 6 0 0 0 8 22a13.96 13.96 0 0 0 9.9-4.1"}],["path",{d:"M10.75 5.093A6 6 0 0 1 22 8c0 2.411-.61 4.68-1.683 6.66"}],["path",{d:"M5.341 10.62a4 4 0 0 0 6.487 1.208M10.62 5.341a4.015 4.015 0 0 1 2.039 2.04"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cp=["svg",t,[["path",{d:"M10.165 6.598C9.954 7.478 9.64 8.36 9 9c-.64.64-1.521.954-2.402 1.165A6 6 0 0 0 8 22c7.732 0 14-6.268 14-14a6 6 0 0 0-11.835-1.402Z"}],["path",{d:"M5.341 10.62a4 4 0 1 0 5.279-5.28"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dp=["svg",t,[["path",{d:"M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"}],["path",{d:"M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"}],["path",{d:"M12 4v6"}],["path",{d:"M2 18h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pp=["svg",t,[["path",{d:"M3 20v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8"}],["path",{d:"M5 10V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"}],["path",{d:"M3 18h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const np=["svg",t,[["path",{d:"M2 4v16"}],["path",{d:"M2 8h18a2 2 0 0 1 2 2v10"}],["path",{d:"M2 17h20"}],["path",{d:"M6 8v9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sp=["svg",t,[["circle",{cx:"12.5",cy:"8.5",r:"2.5"}],["path",{d:"M12.5 2a6.5 6.5 0 0 0-6.22 4.6c-1.1 3.13-.78 3.9-3.18 6.08A3 3 0 0 0 5 18c4 0 8.4-1.8 11.4-4.3A6.5 6.5 0 0 0 12.5 2Z"}],["path",{d:"m18.5 6 2.19 4.5a6.48 6.48 0 0 1 .31 2 6.49 6.49 0 0 1-2.6 5.2C15.4 20.2 11 22 7 22a3 3 0 0 1-2.68-1.66L2.4 16.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rp=["svg",t,[["path",{d:"M13 13v5"}],["path",{d:"M17 11.47V8"}],["path",{d:"M17 11h1a3 3 0 0 1 2.745 4.211"}],["path",{d:"m2 2 20 20"}],["path",{d:"M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3"}],["path",{d:"M7.536 7.535C6.766 7.649 6.154 8 5.5 8a2.5 2.5 0 0 1-1.768-4.268"}],["path",{d:"M8.727 3.204C9.306 2.767 9.885 2 11 2c1.56 0 2 1.5 3 1.5s1.72-.5 2.5-.5a1 1 0 1 1 0 5c-.78 0-1.5-.5-2.5-.5a3.149 3.149 0 0 0-.842.12"}],["path",{d:"M9 14.6V18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ip=["svg",t,[["path",{d:"M17 11h1a3 3 0 0 1 0 6h-1"}],["path",{d:"M9 12v6"}],["path",{d:"M13 12v6"}],["path",{d:"M14 7.5c-1 0-1.44.5-3 .5s-2-.5-3-.5-1.72.5-2.5.5a2.5 2.5 0 0 1 0-5c.78 0 1.57.5 2.5.5S9.44 2 11 2s2 1.5 3 1.5 1.72-.5 2.5-.5a2.5 2.5 0 0 1 0 5c-.78 0-1.5-.5-2.5-.5Z"}],["path",{d:"M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const op=["svg",t,[["path",{d:"M19.4 14.9C20.2 16.4 21 17 21 17H3s3-2 3-9c0-3.3 2.7-6 6-6 .7 0 1.3.1 1.9.3"}],["path",{d:"M10.3 21a1.94 1.94 0 0 0 3.4 0"}],["circle",{cx:"18",cy:"8",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lp=["svg",t,[["path",{d:"M18.8 4A6.3 8.7 0 0 1 20 9"}],["path",{d:"M9 9h.01"}],["circle",{cx:"9",cy:"9",r:"7"}],["rect",{width:"10",height:"6",x:"4",y:"16",rx:"2"}],["path",{d:"M14 19c3 0 4.6-1.6 4.6-1.6"}],["circle",{cx:"20",cy:"16",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mp=["svg",t,[["path",{d:"M18.4 12c.8 3.8 2.6 5 2.6 5H3s3-2 3-9c0-3.3 2.7-6 6-6 1.8 0 3.4.8 4.5 2"}],["path",{d:"M10.3 21a1.94 1.94 0 0 0 3.4 0"}],["path",{d:"M15 8h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vp=["svg",t,[["path",{d:"M8.7 3A6 6 0 0 1 18 8a21.3 21.3 0 0 0 .6 5"}],["path",{d:"M17 17H3s3-2 3-9a4.67 4.67 0 0 1 .3-1.7"}],["path",{d:"M10.3 21a1.94 1.94 0 0 0 3.4 0"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gp=["svg",t,[["path",{d:"M19.3 14.8C20.1 16.4 21 17 21 17H3s3-2 3-9c0-3.3 2.7-6 6-6 1 0 1.9.2 2.8.7"}],["path",{d:"M10.3 21a1.94 1.94 0 0 0 3.4 0"}],["path",{d:"M15 8h6"}],["path",{d:"M18 5v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xp=["svg",t,[["path",{d:"M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"}],["path",{d:"M10.3 21a1.94 1.94 0 0 0 3.4 0"}],["path",{d:"M4 2C2.8 3.7 2 5.7 2 8"}],["path",{d:"M22 8c0-2.3-.8-4.3-2-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yp=["svg",t,[["path",{d:"M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"}],["path",{d:"M10.3 21a1.94 1.94 0 0 0 3.4 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N2=["svg",t,[["rect",{width:"13",height:"7",x:"3",y:"3",rx:"1"}],["path",{d:"m22 15-3-3 3-3"}],["rect",{width:"13",height:"7",x:"3",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $2=["svg",t,[["rect",{width:"13",height:"7",x:"8",y:"3",rx:"1"}],["path",{d:"m2 9 3 3-3 3"}],["rect",{width:"13",height:"7",x:"8",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const up=["svg",t,[["rect",{width:"7",height:"13",x:"3",y:"3",rx:"1"}],["path",{d:"m9 22 3-3 3 3"}],["rect",{width:"7",height:"13",x:"14",y:"3",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fp=["svg",t,[["rect",{width:"7",height:"13",x:"3",y:"8",rx:"1"}],["path",{d:"m15 2-3 3-3-3"}],["rect",{width:"7",height:"13",x:"14",y:"8",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mp=["svg",t,[["circle",{cx:"18.5",cy:"17.5",r:"3.5"}],["circle",{cx:"5.5",cy:"17.5",r:"3.5"}],["circle",{cx:"15",cy:"5",r:"1"}],["path",{d:"M12 17.5V14l-3-3 4-3 2 3h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wp=["svg",t,[["rect",{x:"14",y:"14",width:"4",height:"6",rx:"2"}],["rect",{x:"6",y:"4",width:"4",height:"6",rx:"2"}],["path",{d:"M6 20h4"}],["path",{d:"M14 10h4"}],["path",{d:"M6 14h2v6"}],["path",{d:"M14 4h2v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hp=["svg",t,[["circle",{cx:"12",cy:"11.9",r:"2"}],["path",{d:"M6.7 3.4c-.9 2.5 0 5.2 2.2 6.7C6.5 9 3.7 9.6 2 11.6"}],["path",{d:"m8.9 10.1 1.4.8"}],["path",{d:"M17.3 3.4c.9 2.5 0 5.2-2.2 6.7 2.4-1.2 5.2-.6 6.9 1.5"}],["path",{d:"m15.1 10.1-1.4.8"}],["path",{d:"M16.7 20.8c-2.6-.4-4.6-2.6-4.7-5.3-.2 2.6-2.1 4.8-4.7 5.2"}],["path",{d:"M12 13.9v1.6"}],["path",{d:"M13.5 5.4c-1-.2-2-.2-3 0"}],["path",{d:"M17 16.4c.7-.7 1.2-1.6 1.5-2.5"}],["path",{d:"M5.5 13.9c.3.9.8 1.8 1.5 2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vp=["svg",t,[["path",{d:"M16 7h.01"}],["path",{d:"M3.4 18H12a8 8 0 0 0 8-8V7a4 4 0 0 0-7.28-2.3L2 20"}],["path",{d:"m20 7 2 .5-2 .5"}],["path",{d:"M10 18v3"}],["path",{d:"M14 17.75V21"}],["path",{d:"M7 18a6 6 0 0 0 3.84-10.61"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cp=["svg",t,[["path",{d:"M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ap=["svg",t,[["circle",{cx:"9",cy:"9",r:"7"}],["circle",{cx:"15",cy:"15",r:"7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _p=["svg",t,[["path",{d:"M3 3h18"}],["path",{d:"M20 7H8"}],["path",{d:"M20 11H8"}],["path",{d:"M10 19h10"}],["path",{d:"M8 15h12"}],["path",{d:"M4 3v14"}],["circle",{cx:"4",cy:"19",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sp=["svg",t,[["rect",{width:"7",height:"7",x:"14",y:"3",rx:"1"}],["path",{d:"M10 21V8a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lp=["svg",t,[["path",{d:"m7 7 10 10-5 5V2l5 5L7 17"}],["line",{x1:"18",x2:"21",y1:"12",y2:"12"}],["line",{x1:"3",x2:"6",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bp=["svg",t,[["path",{d:"m17 17-5 5V12l-5 5"}],["path",{d:"m2 2 20 20"}],["path",{d:"M14.5 9.5 17 7l-5-5v4.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zp=["svg",t,[["path",{d:"m7 7 10 10-5 5V2l5 5L7 17"}],["path",{d:"M20.83 14.83a4 4 0 0 0 0-5.66"}],["path",{d:"M18 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pp=["svg",t,[["path",{d:"m7 7 10 10-5 5V2l5 5L7 17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kp=["svg",t,[["path",{d:"M6 12h9a4 4 0 0 1 0 8H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h7a4 4 0 0 1 0 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Op=["svg",t,[["path",{d:"M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"}],["circle",{cx:"12",cy:"12",r:"4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rp=["svg",t,[["circle",{cx:"11",cy:"13",r:"9"}],["path",{d:"M14.35 4.65 16.3 2.7a2.41 2.41 0 0 1 3.4 0l1.6 1.6a2.4 2.4 0 0 1 0 3.4l-1.95 1.95"}],["path",{d:"m22 2-1.5 1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bp=["svg",t,[["path",{d:"M17 10c.7-.7 1.69 0 2.5 0a2.5 2.5 0 1 0 0-5 .5.5 0 0 1-.5-.5 2.5 2.5 0 1 0-5 0c0 .81.7 1.8 0 2.5l-7 7c-.7.7-1.69 0-2.5 0a2.5 2.5 0 0 0 0 5c.28 0 .5.22.5.5a2.5 2.5 0 1 0 5 0c0-.81-.7-1.8 0-2.5Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"m8 13 4-7 4 7"}],["path",{d:"M9.1 11h5.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ep=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M8 8v3"}],["path",{d:"M12 6v7"}],["path",{d:"M16 8v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"m9 9.5 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zp=["svg",t,[["path",{d:"M2 16V4a2 2 0 0 1 2-2h11"}],["path",{d:"M5 14H4a2 2 0 1 0 0 4h1"}],["path",{d:"M22 18H11a2 2 0 1 0 0 4h11V6H11a2 2 0 0 0-2 2v12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W2=["svg",t,[["path",{d:"M20 22h-2"}],["path",{d:"M20 15v2h-2"}],["path",{d:"M4 19.5V15"}],["path",{d:"M20 8v3"}],["path",{d:"M18 2h2v2"}],["path",{d:"M4 11V9"}],["path",{d:"M12 2h2"}],["path",{d:"M12 22h2"}],["path",{d:"M12 17h2"}],["path",{d:"M8 22H6.5a2.5 2.5 0 0 1 0-5H8"}],["path",{d:"M4 5v-.5A2.5 2.5 0 0 1 6.5 2H8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M12 13V7"}],["path",{d:"m9 10 3 3 3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["circle",{cx:"9",cy:"12",r:"1"}],["path",{d:"M8 12v-2a4 4 0 0 1 8 0v2"}],["circle",{cx:"15",cy:"12",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Up=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M16 8.2C16 7 15 6 13.8 6c-.8 0-1.4.3-1.8.9-.4-.6-1-.9-1.8-.9C9 6 8 7 8 8.2c0 .6.3 1.2.7 1.6h0C10 11.1 12 13 12 13s2-1.9 3.3-3.1h0c.4-.4.7-1 .7-1.7z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ip=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["circle",{cx:"10",cy:"8",r:"2"}],["path",{d:"m20 13.7-2.1-2.1c-.8-.8-2-.8-2.8 0L9.7 17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Np=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H14"}],["path",{d:"M20 8v14H6.5a2.5 2.5 0 0 1 0-5H20"}],["circle",{cx:"14",cy:"8",r:"2"}],["path",{d:"m20 2-4.5 4.5"}],["path",{d:"m19 3 1 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $p=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H10"}],["path",{d:"M20 15v7H6.5a2.5 2.5 0 0 1 0-5H20"}],["rect",{width:"8",height:"5",x:"12",y:"6",rx:"1"}],["path",{d:"M18 6V4a2 2 0 1 0-4 0v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["polyline",{points:"10 2 10 10 13 7 16 10 16 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M9 10h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gp=["svg",t,[["path",{d:"M8 3H2v15h7c1.7 0 3 1.3 3 3V7c0-2.2-1.8-4-4-4Z"}],["path",{d:"m16 12 2 2 4-4"}],["path",{d:"M22 6V3h-6c-2.2 0-4 1.8-4 4v14c0-1.7 1.3-3 3-3h7v-2.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kp=["svg",t,[["path",{d:"M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"}],["path",{d:"M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"}],["path",{d:"M6 8h2"}],["path",{d:"M6 12h2"}],["path",{d:"M16 8h2"}],["path",{d:"M16 12h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xp=["svg",t,[["path",{d:"M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"}],["path",{d:"M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M9 10h6"}],["path",{d:"M12 7v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M8 7h6"}],["path",{d:"M8 11h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qp=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M16 8V6H8v2"}],["path",{d:"M12 6v7"}],["path",{d:"M10 13h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tn=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2"}],["path",{d:"M18 2h2v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M12 13V7"}],["path",{d:"m9 10 3-3 3 3"}],["path",{d:"m9 5 3-3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const an=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"M12 13V7"}],["path",{d:"m9 10 3-3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hn=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["circle",{cx:"12",cy:"8",r:"2"}],["path",{d:"M15 13a3 3 0 1 0-6 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const en=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}],["path",{d:"m14.5 7-5 5"}],["path",{d:"m9.5 7 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cn=["svg",t,[["path",{d:"M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dn=["svg",t,[["path",{d:"m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"}],["path",{d:"m9 10 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pn=["svg",t,[["path",{d:"m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"}],["line",{x1:"15",x2:"9",y1:"10",y2:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nn=["svg",t,[["path",{d:"m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"}],["line",{x1:"12",x2:"12",y1:"7",y2:"13"}],["line",{x1:"15",x2:"9",y1:"10",y2:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sn=["svg",t,[["path",{d:"m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2Z"}],["path",{d:"m14.5 7.5-5 5"}],["path",{d:"m9.5 7.5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rn=["svg",t,[["path",{d:"m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const on=["svg",t,[["path",{d:"M4 9V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"}],["path",{d:"M8 8v1"}],["path",{d:"M12 8v1"}],["path",{d:"M16 8v1"}],["rect",{width:"20",height:"12",x:"2",y:"9",rx:"2"}],["circle",{cx:"8",cy:"15",r:"2"}],["circle",{cx:"16",cy:"15",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ln=["svg",t,[["path",{d:"M12 6V2H8"}],["path",{d:"m8 18-4 4V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2Z"}],["path",{d:"M2 12h2"}],["path",{d:"M9 11v2"}],["path",{d:"M15 11v2"}],["path",{d:"M20 12h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mn=["svg",t,[["path",{d:"M13.67 8H18a2 2 0 0 1 2 2v4.33"}],["path",{d:"M2 14h2"}],["path",{d:"M20 14h2"}],["path",{d:"M22 22 2 2"}],["path",{d:"M8 8H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 1.414-.586"}],["path",{d:"M9 13v2"}],["path",{d:"M9.67 4H12v2.33"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vn=["svg",t,[["path",{d:"M12 8V4H8"}],["rect",{width:"16",height:"12",x:"4",y:"8",rx:"2"}],["path",{d:"M2 14h2"}],["path",{d:"M20 14h2"}],["path",{d:"M15 13v2"}],["path",{d:"M9 13v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gn=["svg",t,[["path",{d:"M5 3a2 2 0 0 0-2 2"}],["path",{d:"M19 3a2 2 0 0 1 2 2"}],["path",{d:"M21 19a2 2 0 0 1-2 2"}],["path",{d:"M5 21a2 2 0 0 1-2-2"}],["path",{d:"M9 3h1"}],["path",{d:"M9 21h1"}],["path",{d:"M14 3h1"}],["path",{d:"M14 21h1"}],["path",{d:"M3 9v1"}],["path",{d:"M21 9v1"}],["path",{d:"M3 14v1"}],["path",{d:"M21 14v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xn=["svg",t,[["path",{d:"M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"}],["path",{d:"m3.3 7 8.7 5 8.7-5"}],["path",{d:"M12 22V12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yn=["svg",t,[["path",{d:"M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"}],["path",{d:"m7 16.5-4.74-2.85"}],["path",{d:"m7 16.5 5-3"}],["path",{d:"M7 16.5v5.17"}],["path",{d:"M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"}],["path",{d:"m17 16.5-5-3"}],["path",{d:"m17 16.5 4.74-2.85"}],["path",{d:"M17 16.5v5.17"}],["path",{d:"M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"}],["path",{d:"M12 8 7.26 5.15"}],["path",{d:"m12 8 4.74-2.85"}],["path",{d:"M12 13.5V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j2=["svg",t,[["path",{d:"M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5c0 1.1.9 2 2 2h1"}],["path",{d:"M16 21h1a2 2 0 0 0 2-2v-5c0-1.1.9-2 2-2a2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const un=["svg",t,[["path",{d:"M16 3h3v18h-3"}],["path",{d:"M8 21H5V3h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fn=["svg",t,[["path",{d:"M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"}],["path",{d:"M9 13a4.5 4.5 0 0 0 3-4"}],["path",{d:"M6.003 5.125A3 3 0 0 0 6.401 6.5"}],["path",{d:"M3.477 10.896a4 4 0 0 1 .585-.396"}],["path",{d:"M6 18a4 4 0 0 1-1.967-.516"}],["path",{d:"M12 13h4"}],["path",{d:"M12 18h6a2 2 0 0 1 2 2v1"}],["path",{d:"M12 8h8"}],["path",{d:"M16 8V5a2 2 0 0 1 2-2"}],["circle",{cx:"16",cy:"13",r:".5"}],["circle",{cx:"18",cy:"3",r:".5"}],["circle",{cx:"20",cy:"21",r:".5"}],["circle",{cx:"20",cy:"8",r:".5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mn=["svg",t,[["path",{d:"M12 5a3 3 0 1 0-5.997.142 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588 4 4 0 0 0 7.636 2.106 3.2 3.2 0 0 0 .164-.546c.028-.13.306-.13.335 0a3.2 3.2 0 0 0 .163.546 4 4 0 0 0 7.636-2.106 4 4 0 0 0 .556-6.588 4 4 0 0 0-2.526-5.77A3 3 0 1 0 12 5"}],["path",{d:"M17.599 6.5a3 3 0 0 0 .399-1.375"}],["path",{d:"M6.003 5.125A3 3 0 0 0 6.401 6.5"}],["path",{d:"M3.477 10.896a4 4 0 0 1 .585-.396"}],["path",{d:"M19.938 10.5a4 4 0 0 1 .585.396"}],["path",{d:"M6 18a4 4 0 0 1-1.967-.516"}],["path",{d:"M19.967 17.484A4 4 0 0 1 18 18"}],["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"m15.7 10.4-.9.4"}],["path",{d:"m9.2 13.2-.9.4"}],["path",{d:"m13.6 15.7-.4-.9"}],["path",{d:"m10.8 9.2-.4-.9"}],["path",{d:"m15.7 13.5-.9-.4"}],["path",{d:"m9.2 10.9-.9-.4"}],["path",{d:"m10.5 15.7.4-.9"}],["path",{d:"m13.1 9.2.4-.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wn=["svg",t,[["path",{d:"M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z"}],["path",{d:"M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z"}],["path",{d:"M15 13a4.5 4.5 0 0 1-3-4 4.5 4.5 0 0 1-3 4"}],["path",{d:"M17.599 6.5a3 3 0 0 0 .399-1.375"}],["path",{d:"M6.003 5.125A3 3 0 0 0 6.401 6.5"}],["path",{d:"M3.477 10.896a4 4 0 0 1 .585-.396"}],["path",{d:"M19.938 10.5a4 4 0 0 1 .585.396"}],["path",{d:"M6 18a4 4 0 0 1-1.967-.516"}],["path",{d:"M19.967 17.484A4 4 0 0 1 18 18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hn=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M12 9v6"}],["path",{d:"M16 15v6"}],["path",{d:"M16 3v6"}],["path",{d:"M3 15h18"}],["path",{d:"M3 9h18"}],["path",{d:"M8 15v6"}],["path",{d:"M8 3v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vn=["svg",t,[["path",{d:"M12 12h.01"}],["path",{d:"M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"}],["path",{d:"M22 13a18.15 18.15 0 0 1-20 0"}],["rect",{width:"20",height:"14",x:"2",y:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cn=["svg",t,[["path",{d:"M12 11v4"}],["path",{d:"M14 13h-4"}],["path",{d:"M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"}],["path",{d:"M18 6v14"}],["path",{d:"M6 6v14"}],["rect",{width:"20",height:"14",x:"2",y:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const An=["svg",t,[["path",{d:"M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"}],["rect",{width:"20",height:"14",x:"2",y:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _n=["svg",t,[["rect",{x:"8",y:"8",width:"8",height:"8",rx:"2"}],["path",{d:"M4 10a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2"}],["path",{d:"M14 20a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sn=["svg",t,[["path",{d:"m9.06 11.9 8.07-8.06a2.85 2.85 0 1 1 4.03 4.03l-8.06 8.08"}],["path",{d:"M7.07 14.94c-1.66 0-3 1.35-3 3.02 0 1.33-2.5 1.52-2 2.02 1.08 1.1 2.49 2.02 4 2.02 2.2 0 4-1.8 4-4.04a3.01 3.01 0 0 0-3-3.02z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ln=["svg",t,[["path",{d:"M15 7.13V6a3 3 0 0 0-5.14-2.1L8 2"}],["path",{d:"M14.12 3.88 16 2"}],["path",{d:"M22 13h-4v-2a4 4 0 0 0-4-4h-1.3"}],["path",{d:"M20.97 5c0 2.1-1.6 3.8-3.5 4"}],["path",{d:"m2 2 20 20"}],["path",{d:"M7.7 7.7A4 4 0 0 0 6 11v3a6 6 0 0 0 11.13 3.13"}],["path",{d:"M12 20v-8"}],["path",{d:"M6 13H2"}],["path",{d:"M3 21c0-2.1 1.7-3.9 3.8-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bn=["svg",t,[["path",{d:"M12.765 21.522a.5.5 0 0 1-.765-.424v-8.196a.5.5 0 0 1 .765-.424l5.878 3.674a1 1 0 0 1 0 1.696z"}],["path",{d:"M14.12 3.88 16 2"}],["path",{d:"M18 11a4 4 0 0 0-4-4h-4a4 4 0 0 0-4 4v3a6.1 6.1 0 0 0 2 4.5"}],["path",{d:"M20.97 5c0 2.1-1.6 3.8-3.5 4"}],["path",{d:"M3 21c0-2.1 1.7-3.9 3.8-4"}],["path",{d:"M6 13H2"}],["path",{d:"M6.53 9C4.6 8.8 3 7.1 3 5"}],["path",{d:"m8 2 1.88 1.88"}],["path",{d:"M9 7.13v-1a3.003 3.003 0 1 1 6 0v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zn=["svg",t,[["path",{d:"m8 2 1.88 1.88"}],["path",{d:"M14.12 3.88 16 2"}],["path",{d:"M9 7.13v-1a3.003 3.003 0 1 1 6 0v1"}],["path",{d:"M12 20c-3.3 0-6-2.7-6-6v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v3c0 3.3-2.7 6-6 6"}],["path",{d:"M12 20v-9"}],["path",{d:"M6.53 9C4.6 8.8 3 7.1 3 5"}],["path",{d:"M6 13H2"}],["path",{d:"M3 21c0-2.1 1.7-3.9 3.8-4"}],["path",{d:"M20.97 5c0 2.1-1.6 3.8-3.5 4"}],["path",{d:"M22 13h-4"}],["path",{d:"M17.2 17c2.1.1 3.8 1.9 3.8 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pn=["svg",t,[["path",{d:"M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"}],["path",{d:"M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"}],["path",{d:"M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"}],["path",{d:"M10 6h4"}],["path",{d:"M10 10h4"}],["path",{d:"M10 14h4"}],["path",{d:"M10 18h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kn=["svg",t,[["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2",ry:"2"}],["path",{d:"M9 22v-4h6v4"}],["path",{d:"M8 6h.01"}],["path",{d:"M16 6h.01"}],["path",{d:"M12 6h.01"}],["path",{d:"M12 10h.01"}],["path",{d:"M12 14h.01"}],["path",{d:"M16 10h.01"}],["path",{d:"M16 14h.01"}],["path",{d:"M8 10h.01"}],["path",{d:"M8 14h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const On=["svg",t,[["path",{d:"M4 6 2 7"}],["path",{d:"M10 6h4"}],["path",{d:"m22 7-2-1"}],["rect",{width:"16",height:"16",x:"4",y:"3",rx:"2"}],["path",{d:"M4 11h16"}],["path",{d:"M8 15h.01"}],["path",{d:"M16 15h.01"}],["path",{d:"M6 19v2"}],["path",{d:"M18 21v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rn=["svg",t,[["path",{d:"M8 6v6"}],["path",{d:"M15 6v6"}],["path",{d:"M2 12h19.6"}],["path",{d:"M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.4-.1-.8-.2-1.2l-1.4-5C20.1 6.8 19.1 6 18 6H4a2 2 0 0 0-2 2v10h3"}],["circle",{cx:"7",cy:"18",r:"2"}],["path",{d:"M9 18h5"}],["circle",{cx:"16",cy:"18",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bn=["svg",t,[["path",{d:"M10 3h.01"}],["path",{d:"M14 2h.01"}],["path",{d:"m2 9 20-5"}],["path",{d:"M12 12V6.5"}],["rect",{width:"16",height:"10",x:"4",y:"12",rx:"3"}],["path",{d:"M9 12v5"}],["path",{d:"M15 12v5"}],["path",{d:"M4 17h16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tn=["svg",t,[["path",{d:"M17 21v-2a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1"}],["path",{d:"M19 15V6.5a1 1 0 0 0-7 0v11a1 1 0 0 1-7 0V9"}],["path",{d:"M21 21v-2h-4"}],["path",{d:"M3 5h4V3"}],["path",{d:"M7 5a1 1 0 0 1 1 1v1a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1V3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const En=["svg",t,[["circle",{cx:"9",cy:"7",r:"2"}],["path",{d:"M7.2 7.9 3 11v9c0 .6.4 1 1 1h16c.6 0 1-.4 1-1v-9c0-2-3-6-7-8l-3.6 2.6"}],["path",{d:"M16 13H3"}],["path",{d:"M16 17H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fn=["svg",t,[["path",{d:"M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"}],["path",{d:"M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"}],["path",{d:"M2 21h20"}],["path",{d:"M7 8v3"}],["path",{d:"M12 8v3"}],["path",{d:"M17 8v3"}],["path",{d:"M7 4h0.01"}],["path",{d:"M12 4h0.01"}],["path",{d:"M17 4h0.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zn=["svg",t,[["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2"}],["line",{x1:"8",x2:"16",y1:"6",y2:"6"}],["line",{x1:"16",x2:"16",y1:"14",y2:"18"}],["path",{d:"M16 10h.01"}],["path",{d:"M12 10h.01"}],["path",{d:"M8 10h.01"}],["path",{d:"M12 14h.01"}],["path",{d:"M8 14h.01"}],["path",{d:"M12 18h.01"}],["path",{d:"M8 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"}],["path",{d:"M3 10h18"}],["path",{d:"m16 20 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M3 10h18"}],["path",{d:"m9 16 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Un=["svg",t,[["path",{d:"M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"}],["path",{d:"M16 2v4"}],["path",{d:"M8 2v4"}],["path",{d:"M3 10h5"}],["path",{d:"M17.5 17.5 16 16.3V14"}],["circle",{cx:"16",cy:"16",r:"6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const In=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M3 10h18"}],["path",{d:"M8 14h.01"}],["path",{d:"M12 14h.01"}],["path",{d:"M16 14h.01"}],["path",{d:"M8 18h.01"}],["path",{d:"M12 18h.01"}],["path",{d:"M16 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M21 17V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11Z"}],["path",{d:"M3 10h18"}],["path",{d:"M15 22v-4a2 2 0 0 1 2-2h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $n=["svg",t,[["path",{d:"M3 10h18V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7"}],["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M21.29 14.7a2.43 2.43 0 0 0-2.65-.52c-.3.12-.57.3-.8.53l-.34.34-.35-.34a2.43 2.43 0 0 0-2.65-.53c-.3.12-.56.3-.79.53-.95.94-1 2.53.2 3.74L17.5 22l3.6-3.55c1.2-1.21 1.14-2.8.19-3.74Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M3 10h18"}],["path",{d:"M10 16h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"}],["path",{d:"M3 10h18"}],["path",{d:"M16 19h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gn=["svg",t,[["path",{d:"M4.2 4.2A2 2 0 0 0 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 1.82-1.18"}],["path",{d:"M21 15.5V6a2 2 0 0 0-2-2H9.5"}],["path",{d:"M16 2v4"}],["path",{d:"M3 10h7"}],["path",{d:"M21 10h-5.5"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M3 10h18"}],["path",{d:"M10 16h4"}],["path",{d:"M12 14v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"}],["path",{d:"M3 10h18"}],["path",{d:"M16 19h6"}],["path",{d:"M19 16v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jn=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M16 2v4"}],["path",{d:"M3 10h18"}],["path",{d:"M8 2v4"}],["path",{d:"M17 14h-6"}],["path",{d:"M13 18H7"}],["path",{d:"M7 14h.01"}],["path",{d:"M17 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yn=["svg",t,[["path",{d:"M21 12V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7.5"}],["path",{d:"M16 2v4"}],["path",{d:"M8 2v4"}],["path",{d:"M3 10h18"}],["circle",{cx:"18",cy:"18",r:"3"}],["path",{d:"m22 22-1.5-1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qn=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"}],["path",{d:"M3 10h18"}],["path",{d:"m17 22 5-5"}],["path",{d:"m17 17 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ts=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M3 10h18"}],["path",{d:"m14 14-4 4"}],["path",{d:"m10 14 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const as=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["path",{d:"M3 10h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hs=["svg",t,[["line",{x1:"2",x2:"22",y1:"2",y2:"22"}],["path",{d:"M7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16"}],["path",{d:"M9.5 4h5L17 7h3a2 2 0 0 1 2 2v7.5"}],["path",{d:"M14.121 15.121A3 3 0 1 1 9.88 10.88"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const es=["svg",t,[["path",{d:"M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"}],["circle",{cx:"12",cy:"13",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cs=["svg",t,[["path",{d:"M9 5v4"}],["rect",{width:"4",height:"6",x:"7",y:"9",rx:"1"}],["path",{d:"M9 15v2"}],["path",{d:"M17 3v2"}],["rect",{width:"4",height:"8",x:"15",y:"5",rx:"1"}],["path",{d:"M17 13v3"}],["path",{d:"M3 3v18h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ds=["svg",t,[["path",{d:"M5.7 21a2 2 0 0 1-3.5-2l8.6-14a6 6 0 0 1 10.4 6 2 2 0 1 1-3.464-2 2 2 0 1 0-3.464-2Z"}],["path",{d:"M17.75 7 15 2.1"}],["path",{d:"M10.9 4.8 13 9"}],["path",{d:"m7.9 9.7 2 4.4"}],["path",{d:"M4.9 14.7 7 18.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ps=["svg",t,[["path",{d:"m8.5 8.5-1 1a4.95 4.95 0 0 0 7 7l1-1"}],["path",{d:"M11.843 6.187A4.947 4.947 0 0 1 16.5 7.5a4.947 4.947 0 0 1 1.313 4.657"}],["path",{d:"M14 16.5V14"}],["path",{d:"M14 6.5v1.843"}],["path",{d:"M10 10v7.5"}],["path",{d:"m16 7 1-5 1.367.683A3 3 0 0 0 19.708 3H21v1.292a3 3 0 0 0 .317 1.341L22 7l-5 1"}],["path",{d:"m8 17-1 5-1.367-.683A3 3 0 0 0 4.292 21H3v-1.292a3 3 0 0 0-.317-1.341L2 17l5-1"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ns=["svg",t,[["path",{d:"m9.5 7.5-2 2a4.95 4.95 0 1 0 7 7l2-2a4.95 4.95 0 1 0-7-7Z"}],["path",{d:"M14 6.5v10"}],["path",{d:"M10 7.5v10"}],["path",{d:"m16 7 1-5 1.37.68A3 3 0 0 0 19.7 3H21v1.3c0 .46.1.92.32 1.33L22 7l-5 1"}],["path",{d:"m8 17-1 5-1.37-.68A3 3 0 0 0 4.3 21H3v-1.3a3 3 0 0 0-.32-1.33L2 17l5-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ss=["svg",t,[["path",{d:"M12 22v-4"}],["path",{d:"M7 12c-1.5 0-4.5 1.5-5 3 3.5 1.5 6 1 6 1-1.5 1.5-2 3.5-2 5 2.5 0 4.5-1.5 6-3 1.5 1.5 3.5 3 6 3 0-1.5-.5-3.5-2-5 0 0 2.5.5 6-1-.5-1.5-3.5-3-5-3 1.5-1 4-4 4-6-2.5 0-5.5 1.5-7 3 0-2.5-.5-5-2-7-1.5 2-2 4.5-2 7-1.5-1.5-4.5-3-7-3 0 2 2.5 5 4 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rs=["svg",t,[["path",{d:"M10.5 5H19a2 2 0 0 1 2 2v8.5"}],["path",{d:"M17 11h-.5"}],["path",{d:"M19 19H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2"}],["path",{d:"m2 2 20 20"}],["path",{d:"M7 11h4"}],["path",{d:"M7 15h2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G2=["svg",t,[["rect",{width:"18",height:"14",x:"3",y:"5",rx:"2",ry:"2"}],["path",{d:"M7 15h4M15 15h2M7 11h2M13 11h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const is=["svg",t,[["path",{d:"m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8"}],["path",{d:"M7 14h.01"}],["path",{d:"M17 14h.01"}],["rect",{width:"18",height:"8",x:"3",y:"10",rx:"2"}],["path",{d:"M5 18v2"}],["path",{d:"M19 18v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const os=["svg",t,[["path",{d:"M10 2h4"}],["path",{d:"m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8"}],["path",{d:"M7 14h.01"}],["path",{d:"M17 14h.01"}],["rect",{width:"18",height:"8",x:"3",y:"10",rx:"2"}],["path",{d:"M5 18v2"}],["path",{d:"M19 18v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ls=["svg",t,[["path",{d:"M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"}],["circle",{cx:"7",cy:"17",r:"2"}],["path",{d:"M9 17h6"}],["circle",{cx:"17",cy:"17",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ms=["svg",t,[["rect",{width:"4",height:"4",x:"2",y:"9"}],["rect",{width:"4",height:"10",x:"10",y:"9"}],["path",{d:"M18 19V9a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v8a2 2 0 0 0 2 2h2"}],["circle",{cx:"8",cy:"19",r:"2"}],["path",{d:"M10 19h12v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vs=["svg",t,[["path",{d:"M2.27 21.7s9.87-3.5 12.73-6.36a4.5 4.5 0 0 0-6.36-6.37C5.77 11.84 2.27 21.7 2.27 21.7zM8.64 14l-2.05-2.04M15.34 15l-2.46-2.46"}],["path",{d:"M22 9s-1.33-2-3.5-2C16.86 7 15 9 15 9s1.33 2 3.5 2S22 9 22 9z"}],["path",{d:"M15 2s-2 1.33-2 3.5S15 9 15 9s2-1.84 2-3.5C17 3.33 15 2 15 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gs=["svg",t,[["circle",{cx:"7",cy:"12",r:"3"}],["path",{d:"M10 9v6"}],["circle",{cx:"17",cy:"12",r:"3"}],["path",{d:"M14 7v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xs=["svg",t,[["path",{d:"m3 15 4-8 4 8"}],["path",{d:"M4 13h6"}],["circle",{cx:"18",cy:"12",r:"3"}],["path",{d:"M21 9v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ys=["svg",t,[["path",{d:"m3 15 4-8 4 8"}],["path",{d:"M4 13h6"}],["path",{d:"M15 11h4.5a2 2 0 0 1 0 4H15V7h4a2 2 0 0 1 0 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const us=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["circle",{cx:"8",cy:"10",r:"2"}],["path",{d:"M8 12h8"}],["circle",{cx:"16",cy:"10",r:"2"}],["path",{d:"m6 20 .7-2.9A1.4 1.4 0 0 1 8.1 16h7.8a1.4 1.4 0 0 1 1.4 1l.7 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fs=["svg",t,[["path",{d:"M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"}],["path",{d:"M2 12a9 9 0 0 1 8 8"}],["path",{d:"M2 16a5 5 0 0 1 4 4"}],["line",{x1:"2",x2:"2.01",y1:"20",y2:"20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ms=["svg",t,[["path",{d:"M22 20v-9H2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2Z"}],["path",{d:"M18 11V4H6v7"}],["path",{d:"M15 22v-4a3 3 0 0 0-3-3v0a3 3 0 0 0-3 3v4"}],["path",{d:"M22 11V9"}],["path",{d:"M2 11V9"}],["path",{d:"M6 4V2"}],["path",{d:"M18 4V2"}],["path",{d:"M10 4V2"}],["path",{d:"M14 4V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ws=["svg",t,[["path",{d:"M12 5c.67 0 1.35.09 2 .26 1.78-2 5.03-2.84 6.42-2.26 1.4.58-.42 7-.42 7 .57 1.07 1 2.24 1 3.44C21 17.9 16.97 21 12 21s-9-3-9-7.56c0-1.25.5-2.4 1-3.44 0 0-1.89-6.42-.5-7 1.39-.58 4.72.23 6.5 2.23A9.04 9.04 0 0 1 12 5Z"}],["path",{d:"M8 14v.5"}],["path",{d:"M16 14v.5"}],["path",{d:"M11.25 16.25h1.5L12 17l-.75-.75Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hs=["svg",t,[["path",{d:"M16.75 12h3.632a1 1 0 0 1 .894 1.447l-2.034 4.069a1 1 0 0 1-1.708.134l-2.124-2.97"}],["path",{d:"M17.106 9.053a1 1 0 0 1 .447 1.341l-3.106 6.211a1 1 0 0 1-1.342.447L3.61 12.3a2.92 2.92 0 0 1-1.3-3.91L3.69 5.6a2.92 2.92 0 0 1 3.92-1.3z"}],["path",{d:"M2 19h3.76a2 2 0 0 0 1.8-1.1L9 15"}],["path",{d:"M2 21v-4"}],["path",{d:"M7 9h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vs=["svg",t,[["path",{d:"M18 6 7 17l-5-5"}],["path",{d:"m22 10-7.5 7.5L13 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cs=["svg",t,[["path",{d:"M20 6 9 17l-5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const As=["svg",t,[["path",{d:"M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"}],["path",{d:"M6 17h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _s=["svg",t,[["path",{d:"M2 17a5 5 0 0 0 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"}],["path",{d:"M12 17a5 5 0 0 0 10 0c0-2.76-2.5-5-5-3-2.5-2-5 .24-5 3Z"}],["path",{d:"M7 14c3.22-2.91 4.29-8.75 5-12 1.66 2.38 4.94 9 5 12"}],["path",{d:"M22 9c-4.29 0-7.14-2.33-10-7 5.71 0 10 4.67 10 7Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ss=["svg",t,[["path",{d:"m6 9 6 6 6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ls=["svg",t,[["path",{d:"m17 18-6-6 6-6"}],["path",{d:"M7 6v12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bs=["svg",t,[["path",{d:"m7 18 6-6-6-6"}],["path",{d:"M17 6v12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zs=["svg",t,[["path",{d:"m15 18-6-6 6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ps=["svg",t,[["path",{d:"m9 18 6-6-6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ks=["svg",t,[["path",{d:"m18 15-6-6-6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Os=["svg",t,[["path",{d:"m7 20 5-5 5 5"}],["path",{d:"m7 4 5 5 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rs=["svg",t,[["path",{d:"m7 6 5 5 5-5"}],["path",{d:"m7 13 5 5 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bs=["svg",t,[["path",{d:"m9 7-5 5 5 5"}],["path",{d:"m15 7 5 5-5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ts=["svg",t,[["path",{d:"m11 17-5-5 5-5"}],["path",{d:"m18 17-5-5 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Es=["svg",t,[["path",{d:"m20 17-5-5 5-5"}],["path",{d:"m4 17 5-5-5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fs=["svg",t,[["path",{d:"m6 17 5-5-5-5"}],["path",{d:"m13 17 5-5-5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zs=["svg",t,[["path",{d:"m7 15 5 5 5-5"}],["path",{d:"m7 9 5-5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ds=["svg",t,[["path",{d:"m17 11-5-5-5 5"}],["path",{d:"m17 18-5-5-5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qs=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["circle",{cx:"12",cy:"12",r:"4"}],["line",{x1:"21.17",x2:"12",y1:"8",y2:"8"}],["line",{x1:"3.95",x2:"8.54",y1:"6.06",y2:"14"}],["line",{x1:"10.88",x2:"15.46",y1:"21.94",y2:"14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Us=["svg",t,[["path",{d:"m18 7 4 2v11a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9l4-2"}],["path",{d:"M14 22v-4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v4"}],["path",{d:"M18 22V5l-6-3-6 3v17"}],["path",{d:"M12 7v5"}],["path",{d:"M10 9h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Is=["svg",t,[["line",{x1:"2",x2:"22",y1:"2",y2:"22"}],["path",{d:"M12 12H2v4h14"}],["path",{d:"M22 12v4"}],["path",{d:"M18 12h-.5"}],["path",{d:"M7 12v4"}],["path",{d:"M18 8c0-2.5-2-2.5-2-5"}],["path",{d:"M22 8c0-2.5-2-2.5-2-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ns=["svg",t,[["path",{d:"M18 12H2v4h16"}],["path",{d:"M22 12v4"}],["path",{d:"M7 12v4"}],["path",{d:"M18 8c0-2.5-2-2.5-2-5"}],["path",{d:"M22 8c0-2.5-2-2.5-2-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K2=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["line",{x1:"12",x2:"12",y1:"8",y2:"12"}],["line",{x1:"12",x2:"12.01",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X2=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 8v8"}],["path",{d:"m8 12 4 4 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J2=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M16 12H8"}],["path",{d:"m12 8-4 4 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y2=["svg",t,[["path",{d:"M2 12a10 10 0 1 1 10 10"}],["path",{d:"m2 22 10-10"}],["path",{d:"M8 22H2v-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q2=["svg",t,[["path",{d:"M12 22a10 10 0 1 1 10-10"}],["path",{d:"M22 22 12 12"}],["path",{d:"M22 16v6h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t0=["svg",t,[["path",{d:"M2 8V2h6"}],["path",{d:"m2 2 10 10"}],["path",{d:"M12 2A10 10 0 1 1 2 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a0=["svg",t,[["path",{d:"M22 12A10 10 0 1 1 12 2"}],["path",{d:"M22 2 12 12"}],["path",{d:"M16 2h6v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M8 12h8"}],["path",{d:"m12 16 4-4-4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m16 12-4-4-4 4"}],["path",{d:"M12 16V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c0=["svg",t,[["path",{d:"M22 11.08V12a10 10 0 1 1-5.93-9.14"}],["path",{d:"m9 11 3 3L22 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m9 12 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m16 10-4 4-4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m14 16-4-4 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m10 8 4 4-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m8 14 4-4 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $s=["svg",t,[["path",{d:"M10.1 2.182a10 10 0 0 1 3.8 0"}],["path",{d:"M13.9 21.818a10 10 0 0 1-3.8 0"}],["path",{d:"M17.609 3.721a10 10 0 0 1 2.69 2.7"}],["path",{d:"M2.182 13.9a10 10 0 0 1 0-3.8"}],["path",{d:"M20.279 17.609a10 10 0 0 1-2.7 2.69"}],["path",{d:"M21.818 10.1a10 10 0 0 1 0 3.8"}],["path",{d:"M3.721 6.391a10 10 0 0 1 2.7-2.69"}],["path",{d:"M6.391 20.279a10 10 0 0 1-2.69-2.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i0=["svg",t,[["line",{x1:"8",x2:"16",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"16",y2:"16"}],["line",{x1:"12",x2:"12",y1:"8",y2:"8"}],["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ws=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"}],["path",{d:"M12 18V6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const js=["svg",t,[["path",{d:"M10.1 2.18a9.93 9.93 0 0 1 3.8 0"}],["path",{d:"M17.6 3.71a9.95 9.95 0 0 1 2.69 2.7"}],["path",{d:"M21.82 10.1a9.93 9.93 0 0 1 0 3.8"}],["path",{d:"M20.29 17.6a9.95 9.95 0 0 1-2.7 2.69"}],["path",{d:"M13.9 21.82a9.94 9.94 0 0 1-3.8 0"}],["path",{d:"M6.4 20.29a9.95 9.95 0 0 1-2.69-2.7"}],["path",{d:"M2.18 13.9a9.93 9.93 0 0 1 0-3.8"}],["path",{d:"M3.71 6.4a9.95 9.95 0 0 1 2.7-2.69"}],["circle",{cx:"12",cy:"12",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gs=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["circle",{cx:"12",cy:"12",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ks=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M17 12h.01"}],["path",{d:"M12 12h.01"}],["path",{d:"M7 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xs=["svg",t,[["path",{d:"M7 10h10"}],["path",{d:"M7 14h10"}],["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Js=["svg",t,[["path",{d:"M12 2a10 10 0 0 1 7.38 16.75"}],["path",{d:"M12 8v8"}],["path",{d:"M16 12H8"}],["path",{d:"M2.5 8.875a10 10 0 0 0-.5 3"}],["path",{d:"M2.83 16a10 10 0 0 0 2.43 3.4"}],["path",{d:"M4.636 5.235a10 10 0 0 1 .891-.857"}],["path",{d:"M8.644 21.42a10 10 0 0 0 7.631-.38"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o0=["svg",t,[["path",{d:"M15.6 2.7a10 10 0 1 0 5.7 5.7"}],["circle",{cx:"12",cy:"12",r:"2"}],["path",{d:"M13.4 10.6 19 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"}],["path",{d:"M12 17h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M8 12h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ys=["svg",t,[["path",{d:"m2 2 20 20"}],["path",{d:"M8.35 2.69A10 10 0 0 1 21.3 15.65"}],["path",{d:"M19.08 19.08A10 10 0 1 1 4.92 4.92"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m5 5 14 14"}],["path",{d:"M13 13a3 3 0 1 0 0-6H9v2"}],["path",{d:"M9 17v-2.34"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M9 17V7h4a3 3 0 0 1 0 6H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["line",{x1:"10",x2:"10",y1:"15",y2:"9"}],["line",{x1:"14",x2:"14",y1:"15",y2:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m15 9-6 6"}],["path",{d:"M9 9h.01"}],["path",{d:"M15 15h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polygon",{points:"10 8 16 12 10 16 10 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M8 12h8"}],["path",{d:"M12 8v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 12V7"}],["path",{d:"M16 9a5 5 0 1 1-8 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M22 2 2 22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qs=["svg",t,[["line",{x1:"9",x2:"15",y1:"15",y2:"9"}],["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["rect",{width:"6",height:"6",x:"9",y:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V0=["svg",t,[["path",{d:"M18 20a6 6 0 0 0-12 0"}],["circle",{cx:"12",cy:"10",r:"4"}],["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["circle",{cx:"12",cy:"10",r:"3"}],["path",{d:"M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A0=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m15 9-6 6"}],["path",{d:"m9 9 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a3=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M11 9h4a2 2 0 0 0 2-2V3"}],["circle",{cx:"9",cy:"9",r:"2"}],["path",{d:"M7 21v-4a2 2 0 0 1 2-2h4"}],["circle",{cx:"15",cy:"15",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h3=["svg",t,[["path",{d:"M21.66 17.67a1.08 1.08 0 0 1-.04 1.6A12 12 0 0 1 4.73 2.38a1.1 1.1 0 0 1 1.61-.04z"}],["path",{d:"M19.65 15.66A8 8 0 0 1 8.35 4.34"}],["path",{d:"m14 10-5.5 5.5"}],["path",{d:"M14 17.85V10H6.15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e3=["svg",t,[["path",{d:"M20.2 6 3 11l-.9-2.4c-.3-1.1.3-2.2 1.3-2.5l13.5-4c1.1-.3 2.2.3 2.5 1.3Z"}],["path",{d:"m6.2 5.3 3.1 3.9"}],["path",{d:"m12.4 3.4 3.1 4"}],["path",{d:"M3 11h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}],["path",{d:"m9 14 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v4"}],["path",{d:"M21 14H11"}],["path",{d:"m15 10-4 4 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}],["path",{d:"M12 11h4"}],["path",{d:"M12 16h4"}],["path",{d:"M8 11h.01"}],["path",{d:"M8 16h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}],["path",{d:"M9 14h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s3=["svg",t,[["path",{d:"M15 2H9a1 1 0 0 0-1 1v2c0 .6.4 1 1 1h6c.6 0 1-.4 1-1V3c0-.6-.4-1-1-1Z"}],["path",{d:"M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M16 4h2a2 2 0 0 1 2 2v2M11 14h10"}],["path",{d:"m17 10 4 4-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _0=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1"}],["path",{d:"M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.5"}],["path",{d:"M16 4h2a2 2 0 0 1 1.73 1"}],["path",{d:"M8 18h1"}],["path",{d:"M18.4 9.6a2 2 0 0 1 3 3L17 17l-4 1 1-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S0=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1"}],["path",{d:"M10.4 12.6a2 2 0 0 1 3 3L8 21l-4 1 1-4Z"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5"}],["path",{d:"M4 13.5V6a2 2 0 0 1 2-2h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}],["path",{d:"M9 14h6"}],["path",{d:"M12 17v-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}],["path",{d:"M9 12v-1h6v1"}],["path",{d:"M11 17h2"}],["path",{d:"M12 11v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}],["path",{d:"m15 11-6 6"}],["path",{d:"m9 11 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l3=["svg",t,[["rect",{width:"8",height:"4",x:"8",y:"2",rx:"1",ry:"1"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 14.5 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 8 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 9.5 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 16 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 16.5 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 16 14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 14.5 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 12 16.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 9.5 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 8 14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 7.5 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polyline",{points:"12 6 12 12 16 14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _3=["svg",t,[["circle",{cx:"12",cy:"17",r:"3"}],["path",{d:"M4.2 15.1A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.2"}],["path",{d:"m15.7 18.4-.9-.3"}],["path",{d:"m9.2 15.9-.9-.3"}],["path",{d:"m10.6 20.7.3-.9"}],["path",{d:"m13.1 14.2.3-.9"}],["path",{d:"m13.6 20.7-.4-1"}],["path",{d:"m10.8 14.3-.4-1"}],["path",{d:"m8.3 18.6 1-.4"}],["path",{d:"m14.7 15.8 1-.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L0=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M12 12v9"}],["path",{d:"m8 17 4 4 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S3=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M8 19v1"}],["path",{d:"M8 14v1"}],["path",{d:"M16 19v1"}],["path",{d:"M16 14v1"}],["path",{d:"M12 21v1"}],["path",{d:"M12 16v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L3=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M16 17H7"}],["path",{d:"M17 21H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b3=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M16 14v2"}],["path",{d:"M8 14v2"}],["path",{d:"M16 20h.01"}],["path",{d:"M8 20h.01"}],["path",{d:"M12 16v2"}],["path",{d:"M12 22h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z3=["svg",t,[["path",{d:"M6 16.326A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 .5 8.973"}],["path",{d:"m13 12-3 5h4l-3 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P3=["svg",t,[["path",{d:"M10.083 9A6.002 6.002 0 0 1 16 4a4.243 4.243 0 0 0 6 6c0 2.22-1.206 4.16-3 5.197"}],["path",{d:"M3 20a5 5 0 1 1 8.9-4H13a3 3 0 0 1 2 5.24"}],["path",{d:"M11 20v2"}],["path",{d:"M7 19v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k3=["svg",t,[["path",{d:"M13 16a3 3 0 1 1 0 6H7a5 5 0 1 1 4.9-6Z"}],["path",{d:"M10.1 9A6 6 0 0 1 16 4a4.24 4.24 0 0 0 6 6 6 6 0 0 1-3 5.197"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O3=["svg",t,[["path",{d:"m2 2 20 20"}],["path",{d:"M5.782 5.782A7 7 0 0 0 9 19h8.5a4.5 4.5 0 0 0 1.307-.193"}],["path",{d:"M21.532 16.5A4.5 4.5 0 0 0 17.5 10h-1.79A7.008 7.008 0 0 0 10 5.07"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R3=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"m9.2 22 3-7"}],["path",{d:"m9 13-3 7"}],["path",{d:"m17 13-3 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B3=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M16 14v6"}],["path",{d:"M8 14v6"}],["path",{d:"M12 16v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T3=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M8 15h.01"}],["path",{d:"M8 19h.01"}],["path",{d:"M12 17h.01"}],["path",{d:"M12 21h.01"}],["path",{d:"M16 15h.01"}],["path",{d:"M16 19h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E3=["svg",t,[["path",{d:"M12 2v2"}],["path",{d:"m4.93 4.93 1.41 1.41"}],["path",{d:"M20 12h2"}],["path",{d:"m19.07 4.93-1.41 1.41"}],["path",{d:"M15.947 12.65a4 4 0 0 0-5.925-4.128"}],["path",{d:"M3 20a5 5 0 1 1 8.9-4H13a3 3 0 0 1 2 5.24"}],["path",{d:"M11 20v2"}],["path",{d:"M7 19v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F3=["svg",t,[["path",{d:"M12 2v2"}],["path",{d:"m4.93 4.93 1.41 1.41"}],["path",{d:"M20 12h2"}],["path",{d:"m19.07 4.93-1.41 1.41"}],["path",{d:"M15.947 12.65a4 4 0 0 0-5.925-4.128"}],["path",{d:"M13 22H7a5 5 0 1 1 4.9-6H13a3 3 0 0 1 0 6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b0=["svg",t,[["path",{d:"M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"}],["path",{d:"M12 12v9"}],["path",{d:"m16 16-4-4-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z3=["svg",t,[["path",{d:"M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D3=["svg",t,[["path",{d:"M17.5 21H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"}],["path",{d:"M22 10a3 3 0 0 0-3-3h-2.207a5.502 5.502 0 0 0-10.702.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q3=["svg",t,[["path",{d:"M16.17 7.83 2 22"}],["path",{d:"M4.02 12a2.827 2.827 0 1 1 3.81-4.17A2.827 2.827 0 1 1 12 4.02a2.827 2.827 0 1 1 4.17 3.81A2.827 2.827 0 1 1 19.98 12a2.827 2.827 0 1 1-3.81 4.17A2.827 2.827 0 1 1 12 19.98a2.827 2.827 0 1 1-4.17-3.81A1 1 0 1 1 4 12"}],["path",{d:"m7.83 7.83 8.34 8.34"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U3=["svg",t,[["path",{d:"M17.28 9.05a5.5 5.5 0 1 0-10.56 0A5.5 5.5 0 1 0 12 17.66a5.5 5.5 0 1 0 5.28-8.6Z"}],["path",{d:"M12 17.66L12 22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z0=["svg",t,[["path",{d:"m18 16 4-4-4-4"}],["path",{d:"m6 8-4 4 4 4"}],["path",{d:"m14.5 4-5 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I3=["svg",t,[["polyline",{points:"16 18 22 12 16 6"}],["polyline",{points:"8 6 2 12 8 18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N3=["svg",t,[["polygon",{points:"12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"}],["line",{x1:"12",x2:"12",y1:"22",y2:"15.5"}],["polyline",{points:"22 8.5 12 15.5 2 8.5"}],["polyline",{points:"2 15.5 12 8.5 22 15.5"}],["line",{x1:"12",x2:"12",y1:"2",y2:"8.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $3=["svg",t,[["path",{d:"M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"}],["polyline",{points:"7.5 4.21 12 6.81 16.5 4.21"}],["polyline",{points:"7.5 19.79 7.5 14.6 3 12"}],["polyline",{points:"21 12 16.5 14.6 16.5 19.79"}],["polyline",{points:"3.27 6.96 12 12.01 20.73 6.96"}],["line",{x1:"12",x2:"12",y1:"22.08",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W3=["svg",t,[["path",{d:"M10 2v2"}],["path",{d:"M14 2v2"}],["path",{d:"M16 8a1 1 0 0 1 1 1v8a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V9a1 1 0 0 1 1-1h14a4 4 0 1 1 0 8h-1"}],["path",{d:"M6 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j3=["svg",t,[["path",{d:"M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"}],["path",{d:"M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"}],["path",{d:"M12 2v2"}],["path",{d:"M12 22v-2"}],["path",{d:"m17 20.66-1-1.73"}],["path",{d:"M11 10.27 7 3.34"}],["path",{d:"m20.66 17-1.73-1"}],["path",{d:"m3.34 7 1.73 1"}],["path",{d:"M14 12h8"}],["path",{d:"M2 12h2"}],["path",{d:"m20.66 7-1.73 1"}],["path",{d:"m3.34 17 1.73-1"}],["path",{d:"m17 3.34-1 1.73"}],["path",{d:"m11 13.73-4 6.93"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G3=["svg",t,[["circle",{cx:"8",cy:"8",r:"6"}],["path",{d:"M18.09 10.37A6 6 0 1 1 10.34 18"}],["path",{d:"M7 6h1v4"}],["path",{d:"m16.71 13.88.7.71-2.82 2.82"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P0=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M12 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k0=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 3v18"}],["path",{d:"M15 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K3=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7.5 3v18"}],["path",{d:"M12 3v18"}],["path",{d:"M16.5 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X3=["svg",t,[["rect",{width:"8",height:"8",x:"2",y:"2",rx:"2"}],["path",{d:"M14 2c1.1 0 2 .9 2 2v4c0 1.1-.9 2-2 2"}],["path",{d:"M20 2c1.1 0 2 .9 2 2v4c0 1.1-.9 2-2 2"}],["path",{d:"M10 18H5c-1.7 0-3-1.3-3-3v-1"}],["polyline",{points:"7 21 10 18 7 15"}],["rect",{width:"8",height:"8",x:"14",y:"14",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J3=["svg",t,[["path",{d:"M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y3=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["polygon",{points:"16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q3=["svg",t,[["path",{d:"M5.5 8.5 9 12l-3.5 3.5L2 12l3.5-3.5Z"}],["path",{d:"m12 2 3.5 3.5L12 9 8.5 5.5 12 2Z"}],["path",{d:"M18.5 8.5 22 12l-3.5 3.5L15 12l3.5-3.5Z"}],["path",{d:"m12 15 3.5 3.5L12 22l-3.5-3.5L12 15Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tr=["svg",t,[["rect",{width:"14",height:"8",x:"5",y:"2",rx:"2"}],["rect",{width:"20",height:"8",x:"2",y:"14",rx:"2"}],["path",{d:"M6 18h2"}],["path",{d:"M12 18h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ar=["svg",t,[["path",{d:"M3 20a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1Z"}],["path",{d:"M20 16a8 8 0 1 0-16 0"}],["path",{d:"M12 4v4"}],["path",{d:"M10 4h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hr=["svg",t,[["path",{d:"m20.9 18.55-8-15.98a1 1 0 0 0-1.8 0l-8 15.98"}],["ellipse",{cx:"12",cy:"19",rx:"9",ry:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const er=["svg",t,[["rect",{x:"2",y:"6",width:"20",height:"8",rx:"1"}],["path",{d:"M17 14v7"}],["path",{d:"M7 14v7"}],["path",{d:"M17 3v3"}],["path",{d:"M7 3v3"}],["path",{d:"M10 14 2.3 6.3"}],["path",{d:"m14 6 7.7 7.7"}],["path",{d:"m8 6 8 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O0=["svg",t,[["path",{d:"M16 18a4 4 0 0 0-8 0"}],["circle",{cx:"12",cy:"11",r:"3"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["line",{x1:"8",x2:"8",y1:"2",y2:"4"}],["line",{x1:"16",x2:"16",y1:"2",y2:"4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cr=["svg",t,[["path",{d:"M17 18a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2"}],["rect",{width:"18",height:"18",x:"3",y:"4",rx:"2"}],["circle",{cx:"12",cy:"10",r:"2"}],["line",{x1:"8",x2:"8",y1:"2",y2:"4"}],["line",{x1:"16",x2:"16",y1:"2",y2:"4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dr=["svg",t,[["path",{d:"M22 7.7c0-.6-.4-1.2-.8-1.5l-6.3-3.9a1.72 1.72 0 0 0-1.7 0l-10.3 6c-.5.2-.9.8-.9 1.4v6.6c0 .5.4 1.2.8 1.5l6.3 3.9a1.72 1.72 0 0 0 1.7 0l10.3-6c.5-.3.9-1 .9-1.5Z"}],["path",{d:"M10 21.9V14L2.1 9.1"}],["path",{d:"m10 14 11.9-6.9"}],["path",{d:"M14 19.8v-8.1"}],["path",{d:"M18 17.5V9.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pr=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 18a6 6 0 0 0 0-12v12z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nr=["svg",t,[["path",{d:"M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"}],["path",{d:"M8.5 8.5v.01"}],["path",{d:"M16 15.5v.01"}],["path",{d:"M12 12v.01"}],["path",{d:"M11 17v.01"}],["path",{d:"M7 14v.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sr=["svg",t,[["path",{d:"M2 12h20"}],["path",{d:"M20 12v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-8"}],["path",{d:"m4 8 16-4"}],["path",{d:"m8.86 6.78-.45-1.81a2 2 0 0 1 1.45-2.43l1.94-.48a2 2 0 0 1 2.43 1.46l.45 1.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rr=["svg",t,[["path",{d:"m12 15 2 2 4-4"}],["rect",{width:"14",height:"14",x:"8",y:"8",rx:"2",ry:"2"}],["path",{d:"M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ir=["svg",t,[["line",{x1:"12",x2:"18",y1:"15",y2:"15"}],["rect",{width:"14",height:"14",x:"8",y:"8",rx:"2",ry:"2"}],["path",{d:"M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const or=["svg",t,[["line",{x1:"15",x2:"15",y1:"12",y2:"18"}],["line",{x1:"12",x2:"18",y1:"15",y2:"15"}],["rect",{width:"14",height:"14",x:"8",y:"8",rx:"2",ry:"2"}],["path",{d:"M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lr=["svg",t,[["line",{x1:"12",x2:"18",y1:"18",y2:"12"}],["rect",{width:"14",height:"14",x:"8",y:"8",rx:"2",ry:"2"}],["path",{d:"M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mr=["svg",t,[["line",{x1:"12",x2:"18",y1:"12",y2:"18"}],["line",{x1:"12",x2:"18",y1:"18",y2:"12"}],["rect",{width:"14",height:"14",x:"8",y:"8",rx:"2",ry:"2"}],["path",{d:"M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vr=["svg",t,[["rect",{width:"14",height:"14",x:"8",y:"8",rx:"2",ry:"2"}],["path",{d:"M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gr=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M9.17 14.83a4 4 0 1 0 0-5.66"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xr=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M14.83 14.83a4 4 0 1 1 0-5.66"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yr=["svg",t,[["polyline",{points:"9 10 4 15 9 20"}],["path",{d:"M20 4v7a4 4 0 0 1-4 4H4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ur=["svg",t,[["polyline",{points:"15 10 20 15 15 20"}],["path",{d:"M4 4v7a4 4 0 0 0 4 4h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fr=["svg",t,[["polyline",{points:"14 15 9 20 4 15"}],["path",{d:"M20 4h-7a4 4 0 0 0-4 4v12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mr=["svg",t,[["polyline",{points:"14 9 9 4 4 9"}],["path",{d:"M20 20h-7a4 4 0 0 1-4-4V4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wr=["svg",t,[["polyline",{points:"10 15 15 20 20 15"}],["path",{d:"M4 4h7a4 4 0 0 1 4 4v12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hr=["svg",t,[["polyline",{points:"10 9 15 4 20 9"}],["path",{d:"M4 20h7a4 4 0 0 0 4-4V4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vr=["svg",t,[["polyline",{points:"9 14 4 9 9 4"}],["path",{d:"M20 20v-7a4 4 0 0 0-4-4H4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cr=["svg",t,[["polyline",{points:"15 14 20 9 15 4"}],["path",{d:"M4 20v-7a4 4 0 0 1 4-4h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ar=["svg",t,[["rect",{width:"16",height:"16",x:"4",y:"4",rx:"2"}],["rect",{width:"6",height:"6",x:"9",y:"9",rx:"1"}],["path",{d:"M15 2v2"}],["path",{d:"M15 20v2"}],["path",{d:"M2 15h2"}],["path",{d:"M2 9h2"}],["path",{d:"M20 15h2"}],["path",{d:"M20 9h2"}],["path",{d:"M9 2v2"}],["path",{d:"M9 20v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _r=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M10 9.3a2.8 2.8 0 0 0-3.5 1 3.1 3.1 0 0 0 0 3.4 2.7 2.7 0 0 0 3.5 1"}],["path",{d:"M17 9.3a2.8 2.8 0 0 0-3.5 1 3.1 3.1 0 0 0 0 3.4 2.7 2.7 0 0 0 3.5 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sr=["svg",t,[["rect",{width:"20",height:"14",x:"2",y:"5",rx:"2"}],["line",{x1:"2",x2:"22",y1:"10",y2:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lr=["svg",t,[["path",{d:"m4.6 13.11 5.79-3.21c1.89-1.05 4.79 1.78 3.71 3.71l-3.22 5.81C8.8 23.16.79 15.23 4.6 13.11Z"}],["path",{d:"m10.5 9.5-1-2.29C9.2 6.48 8.8 6 8 6H4.5C2.79 6 2 6.5 2 8.5a7.71 7.71 0 0 0 2 4.83"}],["path",{d:"M8 6c0-1.55.24-4-2-4-2 0-2.5 2.17-2.5 4"}],["path",{d:"m14.5 13.5 2.29 1c.73.3 1.21.7 1.21 1.5v3.5c0 1.71-.5 2.5-2.5 2.5a7.71 7.71 0 0 1-4.83-2"}],["path",{d:"M18 16c1.55 0 4-.24 4 2 0 2-2.17 2.5-4 2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const br=["svg",t,[["path",{d:"M6 2v14a2 2 0 0 0 2 2h14"}],["path",{d:"M18 22V8a2 2 0 0 0-2-2H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zr=["svg",t,[["path",{d:"M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pr=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["line",{x1:"22",x2:"18",y1:"12",y2:"12"}],["line",{x1:"6",x2:"2",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"6",y2:"2"}],["line",{x1:"12",x2:"12",y1:"22",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kr=["svg",t,[["path",{d:"M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"}],["path",{d:"M5 21h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Or=["svg",t,[["path",{d:"m21.12 6.4-6.05-4.06a2 2 0 0 0-2.17-.05L2.95 8.41a2 2 0 0 0-.95 1.7v5.82a2 2 0 0 0 .88 1.66l6.05 4.07a2 2 0 0 0 2.17.05l9.95-6.12a2 2 0 0 0 .95-1.7V8.06a2 2 0 0 0-.88-1.66Z"}],["path",{d:"M10 22v-8L2.25 9.15"}],["path",{d:"m10 14 11.77-6.87"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rr=["svg",t,[["path",{d:"m6 8 1.75 12.28a2 2 0 0 0 2 1.72h4.54a2 2 0 0 0 2-1.72L18 8"}],["path",{d:"M5 8h14"}],["path",{d:"M7 15a6.47 6.47 0 0 1 5 0 6.47 6.47 0 0 0 5 0"}],["path",{d:"m12 8 1-6h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Br=["svg",t,[["circle",{cx:"12",cy:"12",r:"8"}],["line",{x1:"3",x2:"6",y1:"3",y2:"6"}],["line",{x1:"21",x2:"18",y1:"3",y2:"6"}],["line",{x1:"3",x2:"6",y1:"21",y2:"18"}],["line",{x1:"21",x2:"18",y1:"21",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tr=["svg",t,[["ellipse",{cx:"12",cy:"5",rx:"9",ry:"3"}],["path",{d:"M3 5v14a9 3 0 0 0 18 0V5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Er=["svg",t,[["ellipse",{cx:"12",cy:"5",rx:"9",ry:"3"}],["path",{d:"M3 12a9 3 0 0 0 5 2.69"}],["path",{d:"M21 9.3V5"}],["path",{d:"M3 5v14a9 3 0 0 0 6.47 2.88"}],["path",{d:"M12 12v4h4"}],["path",{d:"M13 20a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L12 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fr=["svg",t,[["ellipse",{cx:"12",cy:"5",rx:"9",ry:"3"}],["path",{d:"M3 5V19A9 3 0 0 0 15 21.84"}],["path",{d:"M21 5V8"}],["path",{d:"M21 12L18 17H22L19 22"}],["path",{d:"M3 12A9 3 0 0 0 14.59 14.87"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zr=["svg",t,[["ellipse",{cx:"12",cy:"5",rx:"9",ry:"3"}],["path",{d:"M3 5V19A9 3 0 0 0 21 19V5"}],["path",{d:"M3 12A9 3 0 0 0 21 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dr=["svg",t,[["path",{d:"M20 5H9l-7 7 7 7h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2Z"}],["line",{x1:"18",x2:"12",y1:"9",y2:"15"}],["line",{x1:"12",x2:"18",y1:"9",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qr=["svg",t,[["circle",{cx:"12",cy:"4",r:"2"}],["path",{d:"M10.2 3.2C5.5 4 2 8.1 2 13a2 2 0 0 0 4 0v-1a2 2 0 0 1 4 0v4a2 2 0 0 0 4 0v-4a2 2 0 0 1 4 0v1a2 2 0 0 0 4 0c0-4.9-3.5-9-8.2-9.8"}],["path",{d:"M3.2 14.8a9 9 0 0 0 17.6 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ur=["svg",t,[["circle",{cx:"19",cy:"19",r:"2"}],["circle",{cx:"5",cy:"5",r:"2"}],["path",{d:"M6.48 3.66a10 10 0 0 1 13.86 13.86"}],["path",{d:"m6.41 6.41 11.18 11.18"}],["path",{d:"M3.66 6.48a10 10 0 0 0 13.86 13.86"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ir=["svg",t,[["path",{d:"M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41L13.7 2.71a2.41 2.41 0 0 0-3.41 0z"}],["path",{d:"M8 12h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R0=["svg",t,[["path",{d:"M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41L13.7 2.71a2.41 2.41 0 0 0-3.41 0Z"}],["path",{d:"M9.2 9.2h.01"}],["path",{d:"m14.5 9.5-5 5"}],["path",{d:"M14.7 14.8h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nr=["svg",t,[["path",{d:"M12 8v8"}],["path",{d:"M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41L13.7 2.71a2.41 2.41 0 0 0-3.41 0z"}],["path",{d:"M8 12h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $r=["svg",t,[["path",{d:"M2.7 10.3a2.41 2.41 0 0 0 0 3.41l7.59 7.59a2.41 2.41 0 0 0 3.41 0l7.59-7.59a2.41 2.41 0 0 0 0-3.41l-7.59-7.59a2.41 2.41 0 0 0-3.41 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wr=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M12 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jr=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M15 9h.01"}],["path",{d:"M9 15h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gr=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M16 8h.01"}],["path",{d:"M12 12h.01"}],["path",{d:"M8 16h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kr=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M16 8h.01"}],["path",{d:"M8 8h.01"}],["path",{d:"M8 16h.01"}],["path",{d:"M16 16h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xr=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M16 8h.01"}],["path",{d:"M8 8h.01"}],["path",{d:"M8 16h.01"}],["path",{d:"M16 16h.01"}],["path",{d:"M12 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jr=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M16 8h.01"}],["path",{d:"M16 12h.01"}],["path",{d:"M16 16h.01"}],["path",{d:"M8 8h.01"}],["path",{d:"M8 12h.01"}],["path",{d:"M8 16h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yr=["svg",t,[["rect",{width:"12",height:"12",x:"2",y:"10",rx:"2",ry:"2"}],["path",{d:"m17.92 14 3.5-3.5a2.24 2.24 0 0 0 0-3l-5-4.92a2.24 2.24 0 0 0-3 0L10 6"}],["path",{d:"M6 18h.01"}],["path",{d:"M10 14h.01"}],["path",{d:"M15 6h.01"}],["path",{d:"M18 9h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qr=["svg",t,[["path",{d:"M12 3v14"}],["path",{d:"M5 10h14"}],["path",{d:"M5 21h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ti=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["circle",{cx:"12",cy:"12",r:"4"}],["path",{d:"M12 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ai=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M6 12c0-1.7.7-3.2 1.8-4.2"}],["circle",{cx:"12",cy:"12",r:"2"}],["path",{d:"M18 12c0 1.7-.7 3.2-1.8 4.2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hi=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["circle",{cx:"12",cy:"12",r:"5"}],["path",{d:"M12 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ei=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["circle",{cx:"12",cy:"12",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ci=["svg",t,[["circle",{cx:"12",cy:"6",r:"1"}],["line",{x1:"5",x2:"19",y1:"12",y2:"12"}],["circle",{cx:"12",cy:"18",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const di=["svg",t,[["path",{d:"M15 2c-1.35 1.5-2.092 3-2.5 4.5M9 22c1.35-1.5 2.092-3 2.5-4.5"}],["path",{d:"M2 15c3.333-3 6.667-3 10-3m10-3c-1.5 1.35-3 2.092-4.5 2.5"}],["path",{d:"m17 6-2.5-2.5"}],["path",{d:"m14 8-1.5-1.5"}],["path",{d:"m7 18 2.5 2.5"}],["path",{d:"m3.5 14.5.5.5"}],["path",{d:"m20 9 .5.5"}],["path",{d:"m6.5 12.5 1 1"}],["path",{d:"m16.5 10.5 1 1"}],["path",{d:"m10 16 1.5 1.5"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pi=["svg",t,[["path",{d:"M2 15c6.667-6 13.333 0 20-6"}],["path",{d:"M9 22c1.798-1.998 2.518-3.995 2.807-5.993"}],["path",{d:"M15 2c-1.798 1.998-2.518 3.995-2.807 5.993"}],["path",{d:"m17 6-2.5-2.5"}],["path",{d:"m14 8-1-1"}],["path",{d:"m7 18 2.5 2.5"}],["path",{d:"m3.5 14.5.5.5"}],["path",{d:"m20 9 .5.5"}],["path",{d:"m6.5 12.5 1 1"}],["path",{d:"m16.5 10.5 1 1"}],["path",{d:"m10 16 1.5 1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ni=["svg",t,[["path",{d:"M2 8h20"}],["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"M6 16h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const si=["svg",t,[["path",{d:"M10 5.172C10 3.782 8.423 2.679 6.5 3c-2.823.47-4.113 6.006-4 7 .08.703 1.725 1.722 3.656 1 1.261-.472 1.96-1.45 2.344-2.5"}],["path",{d:"M14.267 5.172c0-1.39 1.577-2.493 3.5-2.172 2.823.47 4.113 6.006 4 7-.08.703-1.725 1.722-3.656 1-1.261-.472-1.855-1.45-2.239-2.5"}],["path",{d:"M8 14v.5"}],["path",{d:"M16 14v.5"}],["path",{d:"M11.25 16.25h1.5L12 17l-.75-.75Z"}],["path",{d:"M4.42 11.247A13.152 13.152 0 0 0 4 14.556C4 18.728 7.582 21 12 21s8-2.272 8-6.444c0-1.061-.162-2.2-.493-3.309m-9.243-6.082A8.801 8.801 0 0 1 12 5c.78 0 1.5.108 2.161.306"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ri=["svg",t,[["line",{x1:"12",x2:"12",y1:"2",y2:"22"}],["path",{d:"M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ii=["svg",t,[["path",{d:"M20.5 10a2.5 2.5 0 0 1-2.4-3H18a2.95 2.95 0 0 1-2.6-4.4 10 10 0 1 0 6.3 7.1c-.3.2-.8.3-1.2.3"}],["circle",{cx:"12",cy:"12",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const oi=["svg",t,[["path",{d:"M18 20V6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14"}],["path",{d:"M2 20h20"}],["path",{d:"M14 12v.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const li=["svg",t,[["path",{d:"M13 4h3a2 2 0 0 1 2 2v14"}],["path",{d:"M2 20h3"}],["path",{d:"M13 20h9"}],["path",{d:"M10 12v.01"}],["path",{d:"M13 4.562v16.157a1 1 0 0 1-1.242.97L5 20V5.562a2 2 0 0 1 1.515-1.94l4-1A2 2 0 0 1 13 4.561Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mi=["svg",t,[["circle",{cx:"12.1",cy:"12.1",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vi=["svg",t,[["path",{d:"M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"}],["polyline",{points:"7 10 12 15 17 10"}],["line",{x1:"12",x2:"12",y1:"15",y2:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gi=["svg",t,[["circle",{cx:"12",cy:"5",r:"2"}],["path",{d:"m3 21 8.02-14.26"}],["path",{d:"m12.99 6.74 1.93 3.44"}],["path",{d:"M19 12c-3.87 4-10.13 4-14 0"}],["path",{d:"m21 21-2.16-3.84"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xi=["svg",t,[["path",{d:"M10 11h.01"}],["path",{d:"M14 6h.01"}],["path",{d:"M18 6h.01"}],["path",{d:"M6.5 13.1h.01"}],["path",{d:"M22 5c0 9-4 12-6 12s-6-3-6-12c0-2 2-3 6-3s6 1 6 3"}],["path",{d:"M17.4 9.9c-.8.8-2 .8-2.8 0"}],["path",{d:"M10.1 7.1C9 7.2 7.7 7.7 6 8.6c-3.5 2-4.7 3.9-3.7 5.6 4.5 7.8 9.5 8.4 11.2 7.4.9-.5 1.9-2.1 1.9-4.7"}],["path",{d:"M9.1 16.5c.3-1.1 1.4-1.7 2.4-1.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yi=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"}],["path",{d:"M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"}],["path",{d:"M8.56 2.75c4.37 6 6 9.42 8 17.72"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ui=["svg",t,[["path",{d:"M14 9c0 .6-.4 1-1 1H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9c.6 0 1 .4 1 1Z"}],["path",{d:"M18 6h4"}],["path",{d:"M14 4h3a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3"}],["path",{d:"m5 10-2 8"}],["path",{d:"M12 10v3c0 .6-.4 1-1 1H8"}],["path",{d:"m7 18 2-8"}],["path",{d:"M5 22c-1.7 0-3-1.3-3-3 0-.6.4-1 1-1h7c.6 0 1 .4 1 1v2c0 .6-.4 1-1 1Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fi=["svg",t,[["path",{d:"M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mi=["svg",t,[["path",{d:"M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"}],["path",{d:"M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wi=["svg",t,[["path",{d:"m2 2 8 8"}],["path",{d:"m22 2-8 8"}],["ellipse",{cx:"12",cy:"9",rx:"10",ry:"5"}],["path",{d:"M7 13.4v7.9"}],["path",{d:"M12 14v8"}],["path",{d:"M17 13.4v7.9"}],["path",{d:"M2 9v8a10 5 0 0 0 20 0V9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hi=["svg",t,[["path",{d:"M15.4 15.63a7.875 6 135 1 1 6.23-6.23 4.5 3.43 135 0 0-6.23 6.23"}],["path",{d:"m8.29 12.71-2.6 2.6a2.5 2.5 0 1 0-1.65 4.65A2.5 2.5 0 1 0 8.7 18.3l2.59-2.59"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vi=["svg",t,[["path",{d:"M14.4 14.4 9.6 9.6"}],["path",{d:"M18.657 21.485a2 2 0 1 1-2.829-2.828l-1.767 1.768a2 2 0 1 1-2.829-2.829l6.364-6.364a2 2 0 1 1 2.829 2.829l-1.768 1.767a2 2 0 1 1 2.828 2.829z"}],["path",{d:"m21.5 21.5-1.4-1.4"}],["path",{d:"M3.9 3.9 2.5 2.5"}],["path",{d:"M6.404 12.768a2 2 0 1 1-2.829-2.829l1.768-1.767a2 2 0 1 1-2.828-2.829l2.828-2.828a2 2 0 1 1 2.829 2.828l1.767-1.768a2 2 0 1 1 2.829 2.829z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ci=["svg",t,[["path",{d:"M6 18.5a3.5 3.5 0 1 0 7 0c0-1.57.92-2.52 2.04-3.46"}],["path",{d:"M6 8.5c0-.75.13-1.47.36-2.14"}],["path",{d:"M8.8 3.15A6.5 6.5 0 0 1 19 8.5c0 1.63-.44 2.81-1.09 3.76"}],["path",{d:"M12.5 6A2.5 2.5 0 0 1 15 8.5M10 13a2 2 0 0 0 1.82-1.18"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ai=["svg",t,[["path",{d:"M6 8.5a6.5 6.5 0 1 1 13 0c0 6-6 6-6 10a3.5 3.5 0 1 1-7 0"}],["path",{d:"M15 8.5a2.5 2.5 0 0 0-5 0v1a2 2 0 1 1 0 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _i=["svg",t,[["path",{d:"M7 3.34V5a3 3 0 0 0 3 3"}],["path",{d:"M11 21.95V18a2 2 0 0 0-2-2 2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05"}],["path",{d:"M21.54 15H17a2 2 0 0 0-2 2v4.54"}],["path",{d:"M12 2a10 10 0 1 0 9.54 13"}],["path",{d:"M20 6V4a2 2 0 1 0-4 0v2"}],["rect",{width:"8",height:"5",x:"14",y:"6",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B0=["svg",t,[["path",{d:"M21.54 15H17a2 2 0 0 0-2 2v4.54"}],["path",{d:"M7 3.34V5a3 3 0 0 0 3 3v0a2 2 0 0 1 2 2v0c0 1.1.9 2 2 2v0a2 2 0 0 0 2-2v0c0-1.1.9-2 2-2h3.17"}],["path",{d:"M11 21.95V18a2 2 0 0 0-2-2v0a2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05"}],["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Si=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 2a7 7 0 1 0 10 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Li=["svg",t,[["circle",{cx:"11.5",cy:"12.5",r:"3.5"}],["path",{d:"M3 8c0-3.5 2.5-6 6.5-6 5 0 4.83 3 7.5 5s5 2 5 6c0 4.5-2.5 6.5-7 6.5-2.5 0-2.5 2.5-6 2.5s-7-2-7-5.5c0-3 1.5-3 1.5-5C3.5 10 3 9 3 8Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bi=["svg",t,[["path",{d:"M6.399 6.399C5.362 8.157 4.65 10.189 4.5 12c-.37 4.43 1.27 9.95 7.5 10 3.256-.026 5.259-1.547 6.375-3.625"}],["path",{d:"M19.532 13.875A14.07 14.07 0 0 0 19.5 12c-.36-4.34-3.95-9.96-7.5-10-1.04.012-2.082.502-3.046 1.297"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zi=["svg",t,[["path",{d:"M12 22c6.23-.05 7.87-5.57 7.5-10-.36-4.34-3.95-9.96-7.5-10-3.55.04-7.14 5.66-7.5 10-.37 4.43 1.27 9.95 7.5 10z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T0=["svg",t,[["circle",{cx:"12",cy:"12",r:"1"}],["circle",{cx:"12",cy:"5",r:"1"}],["circle",{cx:"12",cy:"19",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E0=["svg",t,[["circle",{cx:"12",cy:"12",r:"1"}],["circle",{cx:"19",cy:"12",r:"1"}],["circle",{cx:"5",cy:"12",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pi=["svg",t,[["line",{x1:"5",x2:"19",y1:"9",y2:"9"}],["line",{x1:"5",x2:"19",y1:"15",y2:"15"}],["line",{x1:"19",x2:"5",y1:"5",y2:"19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ki=["svg",t,[["line",{x1:"5",x2:"19",y1:"9",y2:"9"}],["line",{x1:"5",x2:"19",y1:"15",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Oi=["svg",t,[["path",{d:"m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"}],["path",{d:"M22 21H7"}],["path",{d:"m5 11 9 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ri=["svg",t,[["path",{d:"M4 10h12"}],["path",{d:"M4 14h9"}],["path",{d:"M19 6a7.7 7.7 0 0 0-5.2-2A7.9 7.9 0 0 0 6 12c0 4.4 3.5 8 7.8 8 2 0 3.8-.8 5.2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bi=["svg",t,[["path",{d:"m21 21-6-6m6 6v-4.8m0 4.8h-4.8"}],["path",{d:"M3 16.2V21m0 0h4.8M3 21l6-6"}],["path",{d:"M21 7.8V3m0 0h-4.8M21 3l-6 6"}],["path",{d:"M3 7.8V3m0 0h4.8M3 3l6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ti=["svg",t,[["path",{d:"M15 3h6v6"}],["path",{d:"M10 14 21 3"}],["path",{d:"M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ei=["svg",t,[["path",{d:"M9.88 9.88a3 3 0 1 0 4.24 4.24"}],["path",{d:"M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"}],["path",{d:"M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fi=["svg",t,[["path",{d:"M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"}],["circle",{cx:"12",cy:"12",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zi=["svg",t,[["path",{d:"M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Di=["svg",t,[["path",{d:"M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"M17 18h1"}],["path",{d:"M12 18h1"}],["path",{d:"M7 18h1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qi=["svg",t,[["path",{d:"M10.827 16.379a6.082 6.082 0 0 1-8.618-7.002l5.412 1.45a6.082 6.082 0 0 1 7.002-8.618l-1.45 5.412a6.082 6.082 0 0 1 8.618 7.002l-5.412-1.45a6.082 6.082 0 0 1-7.002 8.618l1.45-5.412Z"}],["path",{d:"M12 12v.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ui=["svg",t,[["polygon",{points:"13 19 22 12 13 5 13 19"}],["polygon",{points:"2 19 11 12 2 5 2 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ii=["svg",t,[["path",{d:"M12.67 19a2 2 0 0 0 1.416-.588l6.154-6.172a6 6 0 0 0-8.49-8.49L5.586 9.914A2 2 0 0 0 5 11.328V18a1 1 0 0 0 1 1z"}],["path",{d:"M16 8 2 22"}],["path",{d:"M17.5 15H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ni=["svg",t,[["path",{d:"M4 3 2 5v15c0 .6.4 1 1 1h2c.6 0 1-.4 1-1V5Z"}],["path",{d:"M6 8h4"}],["path",{d:"M6 18h4"}],["path",{d:"m12 3-2 2v15c0 .6.4 1 1 1h2c.6 0 1-.4 1-1V5Z"}],["path",{d:"M14 8h4"}],["path",{d:"M14 18h4"}],["path",{d:"m20 3-2 2v15c0 .6.4 1 1 1h2c.6 0 1-.4 1-1V5Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $i=["svg",t,[["circle",{cx:"12",cy:"12",r:"2"}],["path",{d:"M12 2v4"}],["path",{d:"m6.8 15-3.5 2"}],["path",{d:"m20.7 7-3.5 2"}],["path",{d:"M6.8 9 3.3 7"}],["path",{d:"m20.7 17-3.5-2"}],["path",{d:"m9 22 3-8 3 8"}],["path",{d:"M8 22h8"}],["path",{d:"M18 18.7a9 9 0 1 0-12 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wi=["svg",t,[["path",{d:"M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"}],["path",{d:"M12 2h3.5a3.5 3.5 0 1 1 0 7H12V2z"}],["path",{d:"M12 12.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 1 1-7 0z"}],["path",{d:"M5 19.5A3.5 3.5 0 0 1 8.5 16H12v3.5a3.5 3.5 0 1 1-7 0z"}],["path",{d:"M5 12.5A3.5 3.5 0 0 1 8.5 9H12v7H8.5A3.5 3.5 0 0 1 5 12.5z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ji=["svg",t,[["path",{d:"M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v18"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"10",cy:"20",r:"2"}],["path",{d:"M10 7V6"}],["path",{d:"M10 12v-1"}],["path",{d:"M10 18v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gi=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v2"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"3",cy:"17",r:"1"}],["path",{d:"M2 17v-3a4 4 0 0 1 8 0v3"}],["circle",{cx:"9",cy:"17",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ki=["svg",t,[["path",{d:"M17.5 22h.5a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M2 19a2 2 0 1 1 4 0v1a2 2 0 1 1-4 0v-4a6 6 0 0 1 12 0v4a2 2 0 1 1-4 0v-1a2 2 0 1 1 4 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F0=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m8 18 4-4"}],["path",{d:"M8 10v8h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xi=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["circle",{cx:"12",cy:"10",r:"3"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m14 12.5 1 5.5-3-1-3 1 1-5.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ji=["svg",t,[["path",{d:"M12 22h6a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M5 17a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"}],["path",{d:"M7 16.5 8 22l-3-1-3 1 1-5.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yi=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M8 18v-1"}],["path",{d:"M12 18v-6"}],["path",{d:"M16 18v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qi=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M8 18v-2"}],["path",{d:"M12 18v-4"}],["path",{d:"M16 18v-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t6=["svg",t,[["path",{d:"M14.5 22H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M3 13.1a2 2 0 0 0-1 1.76v3.24a2 2 0 0 0 .97 1.78L6 21.7a2 2 0 0 0 2.03.01L11 19.9a2 2 0 0 0 1-1.76V14.9a2 2 0 0 0-.97-1.78L8 11.3a2 2 0 0 0-2.03-.01Z"}],["path",{d:"M7 17v5"}],["path",{d:"M11.7 14.2 7 17l-4.7-2.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m3 15 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m9 15 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e6=["svg",t,[["path",{d:"M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"8",cy:"16",r:"6"}],["path",{d:"M9.5 17.5 8 16.25V14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m5 12-3 3 3 3"}],["path",{d:"m9 18 3-3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d6=["svg",t,[["path",{d:"M10 12.5 8 15l2 2.5"}],["path",{d:"m14 12.5 2 2.5-2 2.5"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z0=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v2"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"6",cy:"14",r:"3"}],["path",{d:"M6 10v1"}],["path",{d:"M6 17v1"}],["path",{d:"M10 14H9"}],["path",{d:"M3 14H2"}],["path",{d:"m9 11-.88.88"}],["path",{d:"M3.88 16.12 3 17"}],["path",{d:"m9 17-.88-.88"}],["path",{d:"M3.88 11.88 3 11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M9 10h6"}],["path",{d:"M12 13V7"}],["path",{d:"M9 17h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["rect",{width:"4",height:"6",x:"2",y:"12",rx:"2"}],["path",{d:"M10 12h2v6"}],["path",{d:"M10 18h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M12 18v-6"}],["path",{d:"m9 15 3 3 3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v2"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M10.29 10.7a2.43 2.43 0 0 0-2.66-.52c-.29.12-.56.3-.78.53l-.35.34-.35-.34a2.43 2.43 0 0 0-2.65-.53c-.3.12-.56.3-.79.53-.95.94-1 2.53.2 3.74L6.5 18l3.6-3.55c1.2-1.21 1.14-2.8.19-3.74Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"10",cy:"12",r:"2"}],["path",{d:"m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M2 15h10"}],["path",{d:"m9 18 3-3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M4 12a1 1 0 0 0-1 1v1a1 1 0 0 1-1 1 1 1 0 0 1 1 1v1a1 1 0 0 0 1 1"}],["path",{d:"M8 18a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1 1 1 0 0 1-1-1v-1a1 1 0 0 0-1-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M10 12a1 1 0 0 0-1 1v1a1 1 0 0 1-1 1 1 1 0 0 1 1 1v1a1 1 0 0 0 1 1"}],["path",{d:"M14 18a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1 1 1 0 0 1-1-1v-1a1 1 0 0 0-1-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v6"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"4",cy:"16",r:"2"}],["path",{d:"m10 10-4.5 4.5"}],["path",{d:"m9 11 1 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["circle",{cx:"10",cy:"16",r:"2"}],["path",{d:"m16 10-4.5 4.5"}],["path",{d:"m15 11 1 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m16 13-3.5 3.5-2-2L8 17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v1"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["rect",{width:"8",height:"5",x:"2",y:"13",rx:"1"}],["path",{d:"M8 13v-2a2 2 0 1 0-4 0v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["rect",{width:"8",height:"6",x:"8",y:"12",rx:"1"}],["path",{d:"M10 12v-2a2 2 0 1 1 4 0v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M3 15h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M9 15h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w6=["svg",t,[["circle",{cx:"14",cy:"16",r:"2"}],["circle",{cx:"6",cy:"18",r:"2"}],["path",{d:"M4 12.4V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2h-7.5"}],["path",{d:"M8 18v-7.7L16 9v7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H6=["svg",t,[["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M4 7V4a2 2 0 0 1 2-2 2 2 0 0 0-2 2"}],["path",{d:"M4.063 20.999a2 2 0 0 0 2 1L18 22a2 2 0 0 0 2-2V7l-5-5H6"}],["path",{d:"m5 11-3 3"}],["path",{d:"m5 17-3-3h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D0=["svg",t,[["path",{d:"m18 5-3-3H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2"}],["path",{d:"M8 18h1"}],["path",{d:"M18.4 9.6a2 2 0 1 1 3 3L17 17l-4 1 1-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q0=["svg",t,[["path",{d:"M12 22h6a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v10"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M10.4 12.6a2 2 0 1 1 3 3L8 21l-4 1 1-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V6=["svg",t,[["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M16 22h2a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3.5"}],["path",{d:"M4.017 11.512a6 6 0 1 0 8.466 8.475"}],["path",{d:"M8 16v-6a6 6 0 0 1 6 6z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M3 15h6"}],["path",{d:"M6 12v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M9 15h6"}],["path",{d:"M12 18v-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _6=["svg",t,[["path",{d:"M12 17h.01"}],["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"}],["path",{d:"M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S6=["svg",t,[["path",{d:"M20 10V7l-5-5H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M16 14a2 2 0 0 0-2 2"}],["path",{d:"M20 14a2 2 0 0 1 2 2"}],["path",{d:"M20 22a2 2 0 0 0 2-2"}],["path",{d:"M16 22a2 2 0 0 1-2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["circle",{cx:"11.5",cy:"14.5",r:"2.5"}],["path",{d:"M13.3 16.3 15 18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b6=["svg",t,[["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3"}],["path",{d:"m9 18-1.5-1.5"}],["circle",{cx:"5",cy:"14",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M8 12h8"}],["path",{d:"M10 11v2"}],["path",{d:"M8 17h8"}],["path",{d:"M14 16v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M8 13h2"}],["path",{d:"M14 13h2"}],["path",{d:"M8 17h2"}],["path",{d:"M14 17h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k6=["svg",t,[["path",{d:"M21 7h-3a2 2 0 0 1-2-2V2"}],["path",{d:"M21 6v6.5c0 .8-.7 1.5-1.5 1.5h-7c-.8 0-1.5-.7-1.5-1.5v-9c0-.8.7-1.5 1.5-1.5H17Z"}],["path",{d:"M7 8v8.8c0 .3.2.6.4.8.2.2.5.4.8.4H15"}],["path",{d:"M3 12v8.8c0 .3.2.6.4.8.2.2.5.4.8.4H11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O6=["svg",t,[["path",{d:"m10 18 3-3-3-3"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M4 11V4a2 2 0 0 1 2-2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m8 16 2-2-2-2"}],["path",{d:"M12 18h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M10 9H8"}],["path",{d:"M16 13H8"}],["path",{d:"M16 17H8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M2 13v-1h6v1"}],["path",{d:"M5 12v6"}],["path",{d:"M4 18h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M9 13v-1h6v1"}],["path",{d:"M12 12v6"}],["path",{d:"M11 18h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M12 12v6"}],["path",{d:"m15 15-3-3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["rect",{width:"8",height:"6",x:"2",y:"12",rx:"1"}],["path",{d:"m10 15.5 4 2.5v-6l-4 2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m10 11 5 3-5 3v-6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M8 15h.01"}],["path",{d:"M11.5 13.5a2.5 2.5 0 0 1 0 3"}],["path",{d:"M15 12a5 5 0 0 1 0 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U6=["svg",t,[["path",{d:"M11 11a5 5 0 0 1 0 6"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"M4.268 21A2 2 0 0 0 6 22h12a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3"}],["path",{d:"m7 10-3 2H2v4h2l3 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M12 9v4"}],["path",{d:"M12 17h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N6=["svg",t,[["path",{d:"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m8 12.5-5 5"}],["path",{d:"m3 12.5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}],["path",{d:"m14.5 12.5-5 5"}],["path",{d:"m9.5 12.5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W6=["svg",t,[["path",{d:"M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"}],["path",{d:"M14 2v4a2 2 0 0 0 2 2h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j6=["svg",t,[["path",{d:"M20 7h-3a2 2 0 0 1-2-2V2"}],["path",{d:"M9 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h7l4 4v10a2 2 0 0 1-2 2Z"}],["path",{d:"M3 7.6v12.8A1.6 1.6 0 0 0 4.6 22h9.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G6=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7 3v18"}],["path",{d:"M3 7.5h4"}],["path",{d:"M3 12h18"}],["path",{d:"M3 16.5h4"}],["path",{d:"M17 3v18"}],["path",{d:"M17 7.5h4"}],["path",{d:"M17 16.5h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K6=["svg",t,[["path",{d:"M13.013 3H2l8 9.46V19l4 2v-8.54l.9-1.055"}],["path",{d:"m22 3-5 5"}],["path",{d:"m17 3 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X6=["svg",t,[["polygon",{points:"22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J6=["svg",t,[["path",{d:"M12 10a2 2 0 0 0-2 2c0 1.02-.1 2.51-.26 4"}],["path",{d:"M14 13.12c0 2.38 0 6.38-1 8.88"}],["path",{d:"M17.29 21.02c.12-.6.43-2.3.5-3.02"}],["path",{d:"M2 12a10 10 0 0 1 18-6"}],["path",{d:"M2 16h.01"}],["path",{d:"M21.8 16c.2-2 .131-5.354 0-6"}],["path",{d:"M5 19.5C5.5 18 6 15 6 12a6 6 0 0 1 .34-2"}],["path",{d:"M8.65 22c.21-.66.45-1.32.57-2"}],["path",{d:"M9 6.8a6 6 0 0 1 9 5.2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y6=["svg",t,[["path",{d:"M15 6.5V3a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3.5"}],["path",{d:"M9 18h8"}],["path",{d:"M18 3h-3"}],["path",{d:"M11 3a6 6 0 0 0-6 6v11"}],["path",{d:"M5 13h4"}],["path",{d:"M17 10a4 4 0 0 0-8 0v10a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q6=["svg",t,[["path",{d:"M18 12.47v.03m0-.5v.47m-.475 5.056A6.744 6.744 0 0 1 15 18c-3.56 0-7.56-2.53-8.5-6 .348-1.28 1.114-2.433 2.121-3.38m3.444-2.088A8.802 8.802 0 0 1 15 6c3.56 0 6.06 2.54 7 6-.309 1.14-.786 2.177-1.413 3.058"}],["path",{d:"M7 10.67C7 8 5.58 5.97 2.73 5.5c-1 1.5-1 5 .23 6.5-1.24 1.5-1.24 5-.23 6.5C5.58 18.03 7 16 7 13.33m7.48-4.372A9.77 9.77 0 0 1 16 6.07m0 11.86a9.77 9.77 0 0 1-1.728-3.618"}],["path",{d:"m16.01 17.93-.23 1.4A2 2 0 0 1 13.8 21H9.5a5.96 5.96 0 0 0 1.49-3.98M8.53 3h5.27a2 2 0 0 1 1.98 1.67l.23 1.4M2 2l20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const to=["svg",t,[["path",{d:"M2 16s9-15 20-4C11 23 2 8 2 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ao=["svg",t,[["path",{d:"M6.5 12c.94-3.46 4.94-6 8.5-6 3.56 0 6.06 2.54 7 6-.94 3.47-3.44 6-7 6s-7.56-2.53-8.5-6Z"}],["path",{d:"M18 12v.5"}],["path",{d:"M16 17.93a9.77 9.77 0 0 1 0-11.86"}],["path",{d:"M7 10.67C7 8 5.58 5.97 2.73 5.5c-1 1.5-1 5 .23 6.5-1.24 1.5-1.24 5-.23 6.5C5.58 18.03 7 16 7 13.33"}],["path",{d:"M10.46 7.26C10.2 5.88 9.17 4.24 8 3h5.8a2 2 0 0 1 1.98 1.67l.23 1.4"}],["path",{d:"m16.01 17.93-.23 1.4A2 2 0 0 1 13.8 21H9.5a5.96 5.96 0 0 0 1.49-3.98"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ho=["svg",t,[["path",{d:"M8 2c3 0 5 2 8 2s4-1 4-1v11"}],["path",{d:"M4 22V4"}],["path",{d:"M4 15s1-1 4-1 5 2 8 2"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const eo=["svg",t,[["path",{d:"M17 22V2L7 7l10 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const co=["svg",t,[["path",{d:"M7 22V2l10 5-10 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const po=["svg",t,[["path",{d:"M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"}],["line",{x1:"4",x2:"4",y1:"22",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const no=["svg",t,[["path",{d:"M12 2c1 3 2.5 3.5 3.5 4.5A5 5 0 0 1 17 10a5 5 0 1 1-10 0c0-.3 0-.6.1-.9a2 2 0 1 0 3.3-2C8 4.5 11 2 12 2Z"}],["path",{d:"m5 22 14-4"}],["path",{d:"m5 18 14 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const so=["svg",t,[["path",{d:"M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ro=["svg",t,[["path",{d:"M16 16v4a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V10c0-2-2-2-2-4"}],["path",{d:"M7 2h11v4c0 2-2 2-2 4v1"}],["line",{x1:"11",x2:"18",y1:"6",y2:"6"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const io=["svg",t,[["path",{d:"M18 6c0 2-2 2-2 4v10a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V10c0-2-2-2-2-4V2h12z"}],["line",{x1:"6",x2:"18",y1:"6",y2:"6"}],["line",{x1:"12",x2:"12",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const oo=["svg",t,[["path",{d:"M10 10 4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-1.272-2.542"}],["path",{d:"M10 2v2.343"}],["path",{d:"M14 2v6.343"}],["path",{d:"M8.5 2h7"}],["path",{d:"M7 16h9"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lo=["svg",t,[["path",{d:"M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"}],["path",{d:"M8.5 2h7"}],["path",{d:"M7 16h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mo=["svg",t,[["path",{d:"M10 2v7.31"}],["path",{d:"M14 9.3V1.99"}],["path",{d:"M8.5 2h7"}],["path",{d:"M14 9.3a6.5 6.5 0 1 1-4 0"}],["path",{d:"M5.52 16h12.96"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vo=["svg",t,[["path",{d:"m3 7 5 5-5 5V7"}],["path",{d:"m21 7-5 5 5 5V7"}],["path",{d:"M12 20v2"}],["path",{d:"M12 14v2"}],["path",{d:"M12 8v2"}],["path",{d:"M12 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const go=["svg",t,[["path",{d:"M8 3H5a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h3"}],["path",{d:"M16 3h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-3"}],["path",{d:"M12 20v2"}],["path",{d:"M12 14v2"}],["path",{d:"M12 8v2"}],["path",{d:"M12 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xo=["svg",t,[["path",{d:"m17 3-5 5-5-5h10"}],["path",{d:"m17 21-5-5-5 5h10"}],["path",{d:"M4 12H2"}],["path",{d:"M10 12H8"}],["path",{d:"M16 12h-2"}],["path",{d:"M22 12h-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yo=["svg",t,[["path",{d:"M21 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3"}],["path",{d:"M21 16v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3"}],["path",{d:"M4 12H2"}],["path",{d:"M10 12H8"}],["path",{d:"M16 12h-2"}],["path",{d:"M22 12h-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uo=["svg",t,[["path",{d:"M12 5a3 3 0 1 1 3 3m-3-3a3 3 0 1 0-3 3m3-3v1M9 8a3 3 0 1 0 3 3M9 8h1m5 0a3 3 0 1 1-3 3m3-3h-1m-2 3v-1"}],["circle",{cx:"12",cy:"8",r:"2"}],["path",{d:"M12 10v12"}],["path",{d:"M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"}],["path",{d:"M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fo=["svg",t,[["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"M12 16.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 1 1 12 7.5a4.5 4.5 0 1 1 4.5 4.5 4.5 4.5 0 1 1-4.5 4.5"}],["path",{d:"M12 7.5V9"}],["path",{d:"M7.5 12H9"}],["path",{d:"M16.5 12H15"}],["path",{d:"M12 16.5V15"}],["path",{d:"m8 8 1.88 1.88"}],["path",{d:"M14.12 9.88 16 8"}],["path",{d:"m8 16 1.88-1.88"}],["path",{d:"M14.12 14.12 16 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mo=["svg",t,[["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wo=["svg",t,[["path",{d:"M2 12h6"}],["path",{d:"M22 12h-6"}],["path",{d:"M12 2v2"}],["path",{d:"M12 8v2"}],["path",{d:"M12 14v2"}],["path",{d:"M12 20v2"}],["path",{d:"m19 9-3 3 3 3"}],["path",{d:"m5 15 3-3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ho=["svg",t,[["path",{d:"M12 22v-6"}],["path",{d:"M12 8V2"}],["path",{d:"M4 12H2"}],["path",{d:"M10 12H8"}],["path",{d:"M16 12h-2"}],["path",{d:"M22 12h-2"}],["path",{d:"m15 19-3-3-3 3"}],["path",{d:"m15 5-3 3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vo=["svg",t,[["circle",{cx:"15",cy:"19",r:"2"}],["path",{d:"M20.9 19.8A2 2 0 0 0 22 18V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h5.1"}],["path",{d:"M15 11v-1"}],["path",{d:"M15 17v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Co=["svg",t,[["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"m9 13 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ao=["svg",t,[["circle",{cx:"16",cy:"16",r:"6"}],["path",{d:"M7 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2"}],["path",{d:"M16 14v2l1 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _o=["svg",t,[["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"M2 10h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U0=["svg",t,[["circle",{cx:"18",cy:"18",r:"3"}],["path",{d:"M10.3 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v3.3"}],["path",{d:"m21.7 19.4-.9-.3"}],["path",{d:"m15.2 16.9-.9-.3"}],["path",{d:"m16.6 21.7.3-.9"}],["path",{d:"m19.1 15.2.3-.9"}],["path",{d:"m19.6 21.7-.4-1"}],["path",{d:"m16.8 15.3-.4-1"}],["path",{d:"m14.3 19.6 1-.4"}],["path",{d:"m20.7 16.8 1-.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const So=["svg",t,[["path",{d:"M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"}],["circle",{cx:"12",cy:"13",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lo=["svg",t,[["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"M12 10v6"}],["path",{d:"m15 13-3 3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bo=["svg",t,[["path",{d:"M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"}],["circle",{cx:"13",cy:"12",r:"2"}],["path",{d:"M18 19c-2.8 0-5-2.2-5-5v8"}],["circle",{cx:"20",cy:"19",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zo=["svg",t,[["circle",{cx:"12",cy:"13",r:"2"}],["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"M14 13h3"}],["path",{d:"M7 13h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Po=["svg",t,[["path",{d:"M11 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v1.5"}],["path",{d:"M13.9 17.45c-1.2-1.2-1.14-2.8-.2-3.73a2.43 2.43 0 0 1 3.44 0l.36.34.34-.34a2.43 2.43 0 0 1 3.45-.01v0c.95.95 1 2.53-.2 3.74L17.5 21Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ko=["svg",t,[["path",{d:"M2 9V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-1"}],["path",{d:"M2 13h10"}],["path",{d:"m9 16 3-3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Oo=["svg",t,[["path",{d:"M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"}],["path",{d:"M8 10v4"}],["path",{d:"M12 10v2"}],["path",{d:"M16 10v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ro=["svg",t,[["circle",{cx:"16",cy:"20",r:"2"}],["path",{d:"M10 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v2"}],["path",{d:"m22 14-4.5 4.5"}],["path",{d:"m21 15 1 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bo=["svg",t,[["rect",{width:"8",height:"5",x:"14",y:"17",rx:"1"}],["path",{d:"M10 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v2.5"}],["path",{d:"M20 17v-2a2 2 0 1 0-4 0v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const To=["svg",t,[["path",{d:"M9 13h6"}],["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Eo=["svg",t,[["path",{d:"m6 14 1.45-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.55 6a2 2 0 0 1-1.94 1.5H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 0 1 1.66.9l.82 1.2a2 2 0 0 0 1.66.9H18a2 2 0 0 1 2 2v2"}],["circle",{cx:"14",cy:"15",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fo=["svg",t,[["path",{d:"m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zo=["svg",t,[["path",{d:"M2 7.5V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-1.5"}],["path",{d:"M2 13h10"}],["path",{d:"m5 10-3 3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I0=["svg",t,[["path",{d:"M8.4 10.6a2 2 0 0 1 3 3L6 19l-4 1 1-4Z"}],["path",{d:"M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Do=["svg",t,[["path",{d:"M12 10v6"}],["path",{d:"M9 13h6"}],["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qo=["svg",t,[["path",{d:"M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"}],["circle",{cx:"12",cy:"13",r:"2"}],["path",{d:"M12 15v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uo=["svg",t,[["circle",{cx:"11.5",cy:"12.5",r:"2.5"}],["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"M13.3 14.3 15 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Io=["svg",t,[["circle",{cx:"17",cy:"17",r:"3"}],["path",{d:"M10.7 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v4.1"}],["path",{d:"m21 21-1.5-1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const No=["svg",t,[["path",{d:"M2 9V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7"}],["path",{d:"m8 16 3-3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $o=["svg",t,[["path",{d:"M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v.5"}],["path",{d:"M12 10v4h4"}],["path",{d:"m12 14 1.535-1.605a5 5 0 0 1 8 1.5"}],["path",{d:"M22 22v-4h-4"}],["path",{d:"m22 18-1.535 1.605a5 5 0 0 1-8-1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wo=["svg",t,[["path",{d:"M20 10a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-2.5a1 1 0 0 1-.8-.4l-.9-1.2A1 1 0 0 0 15 3h-2a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1Z"}],["path",{d:"M20 21a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-2.9a1 1 0 0 1-.88-.55l-.42-.85a1 1 0 0 0-.92-.6H13a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1Z"}],["path",{d:"M3 5a2 2 0 0 0 2 2h3"}],["path",{d:"M3 3v13a2 2 0 0 0 2 2h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jo=["svg",t,[["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"M12 10v6"}],["path",{d:"m9 13 3-3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Go=["svg",t,[["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}],["path",{d:"m9.5 10.5 5 5"}],["path",{d:"m14.5 10.5-5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ko=["svg",t,[["path",{d:"M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xo=["svg",t,[["path",{d:"M20 17a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3.9a2 2 0 0 1-1.69-.9l-.81-1.2a2 2 0 0 0-1.67-.9H8a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2Z"}],["path",{d:"M2 8v11a2 2 0 0 0 2 2h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jo=["svg",t,[["path",{d:"M4 16v-2.38C4 11.5 2.97 10.5 3 8c.03-2.72 1.49-6 4.5-6C9.37 2 10 3.8 10 5.5c0 3.11-2 5.66-2 8.68V16a2 2 0 1 1-4 0Z"}],["path",{d:"M20 20v-2.38c0-2.12 1.03-3.12 1-5.62-.03-2.72-1.49-6-4.5-6C14.63 6 14 7.8 14 9.5c0 3.11 2 5.66 2 8.68V20a2 2 0 1 0 4 0Z"}],["path",{d:"M16 17h4"}],["path",{d:"M4 13h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yo=["svg",t,[["path",{d:"M12 12H5a2 2 0 0 0-2 2v5"}],["circle",{cx:"13",cy:"19",r:"2"}],["circle",{cx:"5",cy:"19",r:"2"}],["path",{d:"M8 19h3m5-17v17h6M6 12V7c0-1.1.9-2 2-2h3l5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qo=["svg",t,[["polyline",{points:"15 17 20 12 15 7"}],["path",{d:"M4 18v-2a4 4 0 0 1 4-4h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t8=["svg",t,[["line",{x1:"22",x2:"2",y1:"6",y2:"6"}],["line",{x1:"22",x2:"2",y1:"18",y2:"18"}],["line",{x1:"6",x2:"6",y1:"2",y2:"22"}],["line",{x1:"18",x2:"18",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a8=["svg",t,[["path",{d:"M5 16V9h14V2H5l14 14h-7m-7 0 7 7v-7m-7 0h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h8=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M16 16s-1.5-2-4-2-4 2-4 2"}],["line",{x1:"9",x2:"9.01",y1:"9",y2:"9"}],["line",{x1:"15",x2:"15.01",y1:"9",y2:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e8=["svg",t,[["line",{x1:"3",x2:"15",y1:"22",y2:"22"}],["line",{x1:"4",x2:"14",y1:"9",y2:"9"}],["path",{d:"M14 22V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v18"}],["path",{d:"M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V9.83a2 2 0 0 0-.59-1.42L18 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c8=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["rect",{width:"10",height:"8",x:"7",y:"8",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d8=["svg",t,[["path",{d:"M2 7v10"}],["path",{d:"M6 5v14"}],["rect",{width:"12",height:"18",x:"10",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p8=["svg",t,[["path",{d:"M2 3v18"}],["rect",{width:"12",height:"18",x:"6",y:"3",rx:"2"}],["path",{d:"M22 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n8=["svg",t,[["rect",{width:"18",height:"14",x:"3",y:"3",rx:"2"}],["path",{d:"M4 21h1"}],["path",{d:"M9 21h1"}],["path",{d:"M14 21h1"}],["path",{d:"M19 21h1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s8=["svg",t,[["path",{d:"M7 2h10"}],["path",{d:"M5 6h14"}],["rect",{width:"18",height:"12",x:"3",y:"10",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r8=["svg",t,[["path",{d:"M3 2h18"}],["rect",{width:"18",height:"12",x:"3",y:"6",rx:"2"}],["path",{d:"M3 22h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i8=["svg",t,[["line",{x1:"6",x2:"10",y1:"11",y2:"11"}],["line",{x1:"8",x2:"8",y1:"9",y2:"13"}],["line",{x1:"15",x2:"15.01",y1:"12",y2:"12"}],["line",{x1:"18",x2:"18.01",y1:"10",y2:"10"}],["path",{d:"M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o8=["svg",t,[["line",{x1:"6",x2:"10",y1:"12",y2:"12"}],["line",{x1:"8",x2:"8",y1:"10",y2:"14"}],["line",{x1:"15",x2:"15.01",y1:"13",y2:"13"}],["line",{x1:"18",x2:"18.01",y1:"11",y2:"11"}],["rect",{width:"20",height:"12",x:"2",y:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l8=["svg",t,[["path",{d:"M8 6h10"}],["path",{d:"M6 12h9"}],["path",{d:"M11 18h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M8=["svg",t,[["path",{d:"m12 14 4-4"}],["path",{d:"M3.34 19a10 10 0 1 1 17.32 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v8=["svg",t,[["path",{d:"m14.5 12.5-8 8a2.119 2.119 0 1 1-3-3l8-8"}],["path",{d:"m16 16 6-6"}],["path",{d:"m8 8 6-6"}],["path",{d:"m9 7 8 8"}],["path",{d:"m21 11-8-8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g8=["svg",t,[["path",{d:"M6 3h12l4 6-10 13L2 9Z"}],["path",{d:"M11 3 8 9l4 13 4-13-3-6"}],["path",{d:"M2 9h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x8=["svg",t,[["path",{d:"M9 10h.01"}],["path",{d:"M15 10h.01"}],["path",{d:"M12 2a8 8 0 0 0-8 8v12l3-3 2.5 2.5L12 19l2.5 2.5L17 19l3 3V10a8 8 0 0 0-8-8z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y8=["svg",t,[["rect",{x:"3",y:"8",width:"18",height:"4",rx:"1"}],["path",{d:"M12 8v13"}],["path",{d:"M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"}],["path",{d:"M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u8=["svg",t,[["path",{d:"M6 3v12"}],["path",{d:"M18 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"}],["path",{d:"M6 21a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"}],["path",{d:"M15 6a9 9 0 0 0-9 9"}],["path",{d:"M18 15v6"}],["path",{d:"M21 18h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f8=["svg",t,[["line",{x1:"6",x2:"6",y1:"3",y2:"15"}],["circle",{cx:"18",cy:"6",r:"3"}],["circle",{cx:"6",cy:"18",r:"3"}],["path",{d:"M18 9a9 9 0 0 1-9 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N0=["svg",t,[["circle",{cx:"12",cy:"12",r:"3"}],["line",{x1:"3",x2:"9",y1:"12",y2:"12"}],["line",{x1:"15",x2:"21",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m8=["svg",t,[["path",{d:"M12 3v6"}],["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"M12 15v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w8=["svg",t,[["circle",{cx:"5",cy:"6",r:"3"}],["path",{d:"M12 6h5a2 2 0 0 1 2 2v7"}],["path",{d:"m15 9-3-3 3-3"}],["circle",{cx:"19",cy:"18",r:"3"}],["path",{d:"M12 18H7a2 2 0 0 1-2-2V9"}],["path",{d:"m9 15 3 3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H8=["svg",t,[["circle",{cx:"18",cy:"18",r:"3"}],["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M13 6h3a2 2 0 0 1 2 2v7"}],["path",{d:"M11 18H8a2 2 0 0 1-2-2V9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V8=["svg",t,[["circle",{cx:"12",cy:"18",r:"3"}],["circle",{cx:"6",cy:"6",r:"3"}],["circle",{cx:"18",cy:"6",r:"3"}],["path",{d:"M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9"}],["path",{d:"M12 12v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C8=["svg",t,[["circle",{cx:"5",cy:"6",r:"3"}],["path",{d:"M5 9v6"}],["circle",{cx:"5",cy:"18",r:"3"}],["path",{d:"M12 3v18"}],["circle",{cx:"19",cy:"6",r:"3"}],["path",{d:"M16 15.7A9 9 0 0 0 19 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A8=["svg",t,[["circle",{cx:"18",cy:"18",r:"3"}],["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M6 21V9a9 9 0 0 0 9 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _8=["svg",t,[["circle",{cx:"5",cy:"6",r:"3"}],["path",{d:"M5 9v12"}],["circle",{cx:"19",cy:"18",r:"3"}],["path",{d:"m15 9-3-3 3-3"}],["path",{d:"M12 6h5a2 2 0 0 1 2 2v7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S8=["svg",t,[["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M6 9v12"}],["path",{d:"m21 3-6 6"}],["path",{d:"m21 9-6-6"}],["path",{d:"M18 11.5V15"}],["circle",{cx:"18",cy:"18",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L8=["svg",t,[["circle",{cx:"5",cy:"6",r:"3"}],["path",{d:"M5 9v12"}],["path",{d:"m15 9-3-3 3-3"}],["path",{d:"M12 6h5a2 2 0 0 1 2 2v3"}],["path",{d:"M19 15v6"}],["path",{d:"M22 18h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b8=["svg",t,[["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M6 9v12"}],["path",{d:"M13 6h3a2 2 0 0 1 2 2v3"}],["path",{d:"M18 15v6"}],["path",{d:"M21 18h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z8=["svg",t,[["circle",{cx:"18",cy:"18",r:"3"}],["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M18 6V5"}],["path",{d:"M18 11v-1"}],["line",{x1:"6",x2:"6",y1:"9",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P8=["svg",t,[["circle",{cx:"18",cy:"18",r:"3"}],["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M13 6h3a2 2 0 0 1 2 2v7"}],["line",{x1:"6",x2:"6",y1:"9",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k8=["svg",t,[["path",{d:"M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"}],["path",{d:"M9 18c-4.51 2-5-2-7-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O8=["svg",t,[["path",{d:"m22 13.29-3.33-10a.42.42 0 0 0-.14-.18.38.38 0 0 0-.22-.11.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18l-2.26 6.67H8.32L6.1 3.26a.42.42 0 0 0-.1-.18.38.38 0 0 0-.26-.08.39.39 0 0 0-.23.07.42.42 0 0 0-.14.18L2 13.29a.74.74 0 0 0 .27.83L12 21l9.69-6.88a.71.71 0 0 0 .31-.83Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R8=["svg",t,[["path",{d:"M15.2 22H8.8a2 2 0 0 1-2-1.79L5 3h14l-1.81 17.21A2 2 0 0 1 15.2 22Z"}],["path",{d:"M6 12a5 5 0 0 1 6 0 5 5 0 0 0 6 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B8=["svg",t,[["circle",{cx:"6",cy:"15",r:"4"}],["circle",{cx:"18",cy:"15",r:"4"}],["path",{d:"M14 15a2 2 0 0 0-2-2 2 2 0 0 0-2 2"}],["path",{d:"M2.5 13 5 7c.7-1.3 1.4-2 3-2"}],["path",{d:"M21.5 13 19 7c-.7-1.3-1.5-2-3-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T8=["svg",t,[["path",{d:"M15.686 15A14.5 14.5 0 0 1 12 22a14.5 14.5 0 0 1 0-20 10 10 0 1 0 9.542 13"}],["path",{d:"M2 12h8.5"}],["path",{d:"M20 6V4a2 2 0 1 0-4 0v2"}],["rect",{width:"8",height:"5",x:"14",y:"6",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E8=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"}],["path",{d:"M2 12h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F8=["svg",t,[["path",{d:"M12 13V2l8 4-8 4"}],["path",{d:"M20.561 10.222a9 9 0 1 1-12.55-5.29"}],["path",{d:"M8.002 9.997a5 5 0 1 0 8.9 2.02"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z8=["svg",t,[["path",{d:"M18 11.5V9a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v1.4"}],["path",{d:"M14 10V8a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"}],["path",{d:"M10 9.9V9a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v5"}],["path",{d:"M6 14v0a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"}],["path",{d:"M18 11v0a2 2 0 1 1 4 0v3a8 8 0 0 1-8 8h-4a8 8 0 0 1-8-8 2 2 0 1 1 4 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D8=["svg",t,[["path",{d:"M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"}],["path",{d:"M22 10v6"}],["path",{d:"M6 12.5V16a6 3 0 0 0 12 0v-3.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q8=["svg",t,[["path",{d:"M22 5V2l-5.89 5.89"}],["circle",{cx:"16.6",cy:"15.89",r:"3"}],["circle",{cx:"8.11",cy:"7.4",r:"3"}],["circle",{cx:"12.35",cy:"11.65",r:"3"}],["circle",{cx:"13.91",cy:"5.85",r:"3"}],["circle",{cx:"18.15",cy:"10.09",r:"3"}],["circle",{cx:"6.56",cy:"13.2",r:"3"}],["circle",{cx:"10.8",cy:"17.44",r:"3"}],["circle",{cx:"5",cy:"19",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U8=["svg",t,[["path",{d:"M12 3v17a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1H3"}],["path",{d:"m16 19 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I8=["svg",t,[["path",{d:"M12 3v17a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6a1 1 0 0 1-1 1H3"}],["path",{d:"m16 16 5 5"}],["path",{d:"m16 21 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $0=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 12h18"}],["path",{d:"M12 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O1=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9h18"}],["path",{d:"M3 15h18"}],["path",{d:"M9 3v18"}],["path",{d:"M15 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N8=["svg",t,[["circle",{cx:"12",cy:"9",r:"1"}],["circle",{cx:"19",cy:"9",r:"1"}],["circle",{cx:"5",cy:"9",r:"1"}],["circle",{cx:"12",cy:"15",r:"1"}],["circle",{cx:"19",cy:"15",r:"1"}],["circle",{cx:"5",cy:"15",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $8=["svg",t,[["circle",{cx:"9",cy:"12",r:"1"}],["circle",{cx:"9",cy:"5",r:"1"}],["circle",{cx:"9",cy:"19",r:"1"}],["circle",{cx:"15",cy:"12",r:"1"}],["circle",{cx:"15",cy:"5",r:"1"}],["circle",{cx:"15",cy:"19",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W8=["svg",t,[["circle",{cx:"12",cy:"5",r:"1"}],["circle",{cx:"19",cy:"5",r:"1"}],["circle",{cx:"5",cy:"5",r:"1"}],["circle",{cx:"12",cy:"12",r:"1"}],["circle",{cx:"19",cy:"12",r:"1"}],["circle",{cx:"5",cy:"12",r:"1"}],["circle",{cx:"12",cy:"19",r:"1"}],["circle",{cx:"19",cy:"19",r:"1"}],["circle",{cx:"5",cy:"19",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j8=["svg",t,[["path",{d:"M3 7V5c0-1.1.9-2 2-2h2"}],["path",{d:"M17 3h2c1.1 0 2 .9 2 2v2"}],["path",{d:"M21 17v2c0 1.1-.9 2-2 2h-2"}],["path",{d:"M7 21H5c-1.1 0-2-.9-2-2v-2"}],["rect",{width:"7",height:"5",x:"7",y:"7",rx:"1"}],["rect",{width:"7",height:"5",x:"10",y:"12",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G8=["svg",t,[["path",{d:"m20 7 1.7-1.7a1 1 0 0 0 0-1.4l-1.6-1.6a1 1 0 0 0-1.4 0L17 4v3Z"}],["path",{d:"m17 7-5.1 5.1"}],["circle",{cx:"11.5",cy:"12.5",r:".5",fill:"currentColor"}],["path",{d:"M6 12a2 2 0 0 0 1.8-1.2l.4-.9C8.7 8.8 9.8 8 11 8c2.8 0 5 2.2 5 5 0 1.2-.8 2.3-1.9 2.8l-.9.4A2 2 0 0 0 12 18a4 4 0 0 1-4 4c-3.3 0-6-2.7-6-6a4 4 0 0 1 4-4"}],["path",{d:"m6 16 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K8=["svg",t,[["path",{d:"M13.144 21.144A7.274 10.445 45 1 0 2.856 10.856"}],["path",{d:"M13.144 21.144A7.274 4.365 45 0 0 2.856 10.856a7.274 4.365 45 0 0 10.288 10.288"}],["path",{d:"M16.565 10.435 18.6 8.4a2.501 2.501 0 1 0 1.65-4.65 2.5 2.5 0 1 0-4.66 1.66l-2.024 2.025"}],["path",{d:"m8.5 16.5-1-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X8=["svg",t,[["path",{d:"m15 12-8.373 8.373a1 1 0 1 1-3-3L12 9"}],["path",{d:"m18 15 4-4"}],["path",{d:"m21.5 11.5-1.914-1.914A2 2 0 0 1 19 8.172V7l-2.26-2.26a6 6 0 0 0-4.202-1.756L9 2.96l.92.82A6.18 6.18 0 0 1 12 8.4V10l2 2h1.172a2 2 0 0 1 1.414.586L18.5 14.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J8=["svg",t,[["path",{d:"M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"}],["path",{d:"m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"}],["path",{d:"m2 16 6 6"}],["circle",{cx:"16",cy:"9",r:"2.9"}],["circle",{cx:"6",cy:"5",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y8=["svg",t,[["path",{d:"M11 14h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 16"}],["path",{d:"m7 20 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"}],["path",{d:"m2 15 6 6"}],["path",{d:"M19.5 8.5c.7-.7 1.5-1.6 1.5-2.7A2.73 2.73 0 0 0 16 4a2.78 2.78 0 0 0-5 1.8c0 1.2.8 2 1.5 2.8L16 12Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W0=["svg",t,[["path",{d:"M11 12h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 14"}],["path",{d:"m7 18 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"}],["path",{d:"m2 13 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q8=["svg",t,[["path",{d:"M18 12.5V10a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v1.4"}],["path",{d:"M14 11V9a2 2 0 1 0-4 0v2"}],["path",{d:"M10 10.5V5a2 2 0 1 0-4 0v9"}],["path",{d:"m7 15-1.76-1.76a2 2 0 0 0-2.83 2.82l3.6 3.6C7.5 21.14 9.2 22 12 22h2a8 8 0 0 0 8-8V7a2 2 0 1 0-4 0v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t7=["svg",t,[["path",{d:"M12 3V2"}],["path",{d:"M5 10a7.1 7.1 0 0 1 14 0"}],["path",{d:"M4 10h16"}],["path",{d:"M2 14h12a2 2 0 1 1 0 4h-2"}],["path",{d:"m15.4 17.4 3.2-2.8a2 2 0 0 1 2.8 2.9l-3.6 3.3c-.7.8-1.7 1.2-2.8 1.2h-4c-1.1 0-2.1-.4-2.8-1.2L5 18"}],["path",{d:"M5 14v7H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a7=["svg",t,[["path",{d:"M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"}],["path",{d:"M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"}],["path",{d:"M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"}],["path",{d:"M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h7=["svg",t,[["path",{d:"m11 17 2 2a1 1 0 1 0 3-3"}],["path",{d:"m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"}],["path",{d:"m21 3 1 11h-2"}],["path",{d:"M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"}],["path",{d:"M3 4h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e7=["svg",t,[["path",{d:"M12 2v8"}],["path",{d:"m16 6-4 4-4-4"}],["rect",{width:"20",height:"8",x:"2",y:"14",rx:"2"}],["path",{d:"M6 18h.01"}],["path",{d:"M10 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c7=["svg",t,[["path",{d:"m16 6-4-4-4 4"}],["path",{d:"M12 2v8"}],["rect",{width:"20",height:"8",x:"2",y:"14",rx:"2"}],["path",{d:"M6 18h.01"}],["path",{d:"M10 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d7=["svg",t,[["line",{x1:"22",x2:"2",y1:"12",y2:"12"}],["path",{d:"M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"}],["line",{x1:"6",x2:"6.01",y1:"16",y2:"16"}],["line",{x1:"10",x2:"10.01",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p7=["svg",t,[["path",{d:"M2 18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v2z"}],["path",{d:"M10 10V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5"}],["path",{d:"M4 15v-3a6 6 0 0 1 6-6h0"}],["path",{d:"M14 6h0a6 6 0 0 1 6 6v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n7=["svg",t,[["line",{x1:"4",x2:"20",y1:"9",y2:"9"}],["line",{x1:"4",x2:"20",y1:"15",y2:"15"}],["line",{x1:"10",x2:"8",y1:"3",y2:"21"}],["line",{x1:"16",x2:"14",y1:"3",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s7=["svg",t,[["path",{d:"m5.2 6.2 1.4 1.4"}],["path",{d:"M2 13h2"}],["path",{d:"M20 13h2"}],["path",{d:"m17.4 7.6 1.4-1.4"}],["path",{d:"M22 17H2"}],["path",{d:"M22 21H2"}],["path",{d:"M16 13a4 4 0 0 0-8 0"}],["path",{d:"M12 5V2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r7=["svg",t,[["path",{d:"M22 9a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h1l2 2h12l2-2h1a1 1 0 0 0 1-1Z"}],["path",{d:"M7.5 12h9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i7=["svg",t,[["path",{d:"M4 12h8"}],["path",{d:"M4 18V6"}],["path",{d:"M12 18V6"}],["path",{d:"m17 12 3-2v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o7=["svg",t,[["path",{d:"M4 12h8"}],["path",{d:"M4 18V6"}],["path",{d:"M12 18V6"}],["path",{d:"M21 18h-4c0-4 4-3 4-6 0-1.5-2-2.5-4-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l7=["svg",t,[["path",{d:"M4 12h8"}],["path",{d:"M4 18V6"}],["path",{d:"M12 18V6"}],["path",{d:"M17.5 10.5c1.7-1 3.5 0 3.5 1.5a2 2 0 0 1-2 2"}],["path",{d:"M17 17.5c2 1.5 4 .3 4-1.5a2 2 0 0 0-2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M7=["svg",t,[["path",{d:"M4 12h8"}],["path",{d:"M4 18V6"}],["path",{d:"M12 18V6"}],["path",{d:"M17 10v4h4"}],["path",{d:"M21 10v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v7=["svg",t,[["path",{d:"M4 12h8"}],["path",{d:"M4 18V6"}],["path",{d:"M12 18V6"}],["path",{d:"M17 13v-3h4"}],["path",{d:"M17 17.7c.4.2.8.3 1.3.3 1.5 0 2.7-1.1 2.7-2.5S19.8 13 18.3 13H17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g7=["svg",t,[["path",{d:"M4 12h8"}],["path",{d:"M4 18V6"}],["path",{d:"M12 18V6"}],["circle",{cx:"19",cy:"16",r:"2"}],["path",{d:"M20 10c-2 2-3 3.5-3 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x7=["svg",t,[["path",{d:"M6 12h12"}],["path",{d:"M6 20V4"}],["path",{d:"M18 20V4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y7=["svg",t,[["path",{d:"M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u7=["svg",t,[["path",{d:"M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"}],["path",{d:"M21 16v2a4 4 0 0 1-4 4h-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f7=["svg",t,[["path",{d:"M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"}],["path",{d:"m12 13-1-1 2-2-3-3 2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m7=["svg",t,[["path",{d:"M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"}],["path",{d:"M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08v0c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66"}],["path",{d:"m18 15-2-2"}],["path",{d:"m15 18-2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w7=["svg",t,[["line",{x1:"2",y1:"2",x2:"22",y2:"22"}],["path",{d:"M16.5 16.5 12 21l-7-7c-1.5-1.45-3-3.2-3-5.5a5.5 5.5 0 0 1 2.14-4.35"}],["path",{d:"M8.76 3.1c1.15.22 2.13.78 3.24 1.9 1.5-1.5 2.74-2 4.5-2A5.5 5.5 0 0 1 22 8.5c0 2.12-1.3 3.78-2.67 5.17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H7=["svg",t,[["path",{d:"M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"}],["path",{d:"M3.22 12H9.5l.5-1 2 4.5 2-7 1.5 3.5h5.27"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V7=["svg",t,[["path",{d:"M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C7=["svg",t,[["path",{d:"M11 8c2-3-2-3 0-6"}],["path",{d:"M15.5 8c2-3-2-3 0-6"}],["path",{d:"M6 10h.01"}],["path",{d:"M6 14h.01"}],["path",{d:"M10 16v-4"}],["path",{d:"M14 16v-4"}],["path",{d:"M18 16v-4"}],["path",{d:"M20 6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3"}],["path",{d:"M5 20v2"}],["path",{d:"M19 20v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A7=["svg",t,[["path",{d:"M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _7=["svg",t,[["path",{d:"m9 11-6 6v3h9l3-3"}],["path",{d:"m22 12-4.6 4.6a2 2 0 0 1-2.8 0l-5.2-5.2a2 2 0 0 1 0-2.8L14 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S7=["svg",t,[["path",{d:"M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"}],["path",{d:"M3 3v5h5"}],["path",{d:"M12 7v5l4 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L7=["svg",t,[["path",{d:"m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"}],["polyline",{points:"9 22 9 12 15 12 15 22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b7=["svg",t,[["path",{d:"M10.82 16.12c1.69.6 3.91.79 5.18.85.28.01.53-.09.7-.27"}],["path",{d:"M11.14 20.57c.52.24 2.44 1.12 4.08 1.37.46.06.86-.25.9-.71.12-1.52-.3-3.43-.5-4.28"}],["path",{d:"M16.13 21.05c1.65.63 3.68.84 4.87.91a.9.9 0 0 0 .7-.26"}],["path",{d:"M17.99 5.52a20.83 20.83 0 0 1 3.15 4.5.8.8 0 0 1-.68 1.13c-1.17.1-2.5.02-3.9-.25"}],["path",{d:"M20.57 11.14c.24.52 1.12 2.44 1.37 4.08.04.3-.08.59-.31.75"}],["path",{d:"M4.93 4.93a10 10 0 0 0-.67 13.4c.35.43.96.4 1.17-.12.69-1.71 1.07-5.07 1.07-6.71 1.34.45 3.1.9 4.88.62a.85.85 0 0 0 .48-.24"}],["path",{d:"M5.52 17.99c1.05.95 2.91 2.42 4.5 3.15a.8.8 0 0 0 1.13-.68c.2-2.34-.33-5.3-1.57-8.28"}],["path",{d:"M8.35 2.68a10 10 0 0 1 9.98 1.58c.43.35.4.96-.12 1.17-1.5.6-4.3.98-6.07 1.05"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z7=["svg",t,[["path",{d:"M10.82 16.12c1.69.6 3.91.79 5.18.85.55.03 1-.42.97-.97-.06-1.27-.26-3.5-.85-5.18"}],["path",{d:"M11.5 6.5c1.64 0 5-.38 6.71-1.07.52-.2.55-.82.12-1.17A10 10 0 0 0 4.26 18.33c.35.43.96.4 1.17-.12.69-1.71 1.07-5.07 1.07-6.71 1.34.45 3.1.9 4.88.62a.88.88 0 0 0 .73-.74c.3-2.14-.15-3.5-.61-4.88"}],["path",{d:"M15.62 16.95c.2.85.62 2.76.5 4.28a.77.77 0 0 1-.9.7 16.64 16.64 0 0 1-4.08-1.36"}],["path",{d:"M16.13 21.05c1.65.63 3.68.84 4.87.91a.9.9 0 0 0 .96-.96 17.68 17.68 0 0 0-.9-4.87"}],["path",{d:"M16.94 15.62c.86.2 2.77.62 4.29.5a.77.77 0 0 0 .7-.9 16.64 16.64 0 0 0-1.36-4.08"}],["path",{d:"M17.99 5.52a20.82 20.82 0 0 1 3.15 4.5.8.8 0 0 1-.68 1.13c-2.33.2-5.3-.32-8.27-1.57"}],["path",{d:"M4.93 4.93 3 3a.7.7 0 0 1 0-1"}],["path",{d:"M9.58 12.18c1.24 2.98 1.77 5.95 1.57 8.28a.8.8 0 0 1-1.13.68 20.82 20.82 0 0 1-4.5-3.15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P7=["svg",t,[["path",{d:"M12 6v4"}],["path",{d:"M14 14h-4"}],["path",{d:"M14 18h-4"}],["path",{d:"M14 8h-4"}],["path",{d:"M18 12h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h2"}],["path",{d:"M18 22V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k7=["svg",t,[["path",{d:"M10 22v-6.57"}],["path",{d:"M12 11h.01"}],["path",{d:"M12 7h.01"}],["path",{d:"M14 15.43V22"}],["path",{d:"M15 16a5 5 0 0 0-6 0"}],["path",{d:"M16 11h.01"}],["path",{d:"M16 7h.01"}],["path",{d:"M8 11h.01"}],["path",{d:"M8 7h.01"}],["rect",{x:"4",y:"2",width:"16",height:"20",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O7=["svg",t,[["path",{d:"M5 22h14"}],["path",{d:"M5 2h14"}],["path",{d:"M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"}],["path",{d:"M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j0=["svg",t,[["path",{d:"M12 17c5 0 8-2.69 8-6H4c0 3.31 3 6 8 6m-4 4h8m-4-3v3M5.14 11a3.5 3.5 0 1 1 6.71 0"}],["path",{d:"M12.14 11a3.5 3.5 0 1 1 6.71 0"}],["path",{d:"M15.5 6.5a3.5 3.5 0 1 0-7 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G0=["svg",t,[["path",{d:"m7 11 4.08 10.35a1 1 0 0 0 1.84 0L17 11"}],["path",{d:"M17 7A5 5 0 0 0 7 7"}],["path",{d:"M17 7a2 2 0 0 1 0 4H7a2 2 0 0 1 0-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R7=["svg",t,[["path",{d:"M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"}],["path",{d:"m14 19 3 3v-5.5"}],["path",{d:"m17 22 3-3"}],["circle",{cx:"9",cy:"9",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B7=["svg",t,[["path",{d:"M21 9v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"}],["line",{x1:"16",x2:"22",y1:"5",y2:"5"}],["circle",{cx:"9",cy:"9",r:"2"}],["path",{d:"m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T7=["svg",t,[["line",{x1:"2",x2:"22",y1:"2",y2:"22"}],["path",{d:"M10.41 10.41a2 2 0 1 1-2.83-2.83"}],["line",{x1:"13.5",x2:"6",y1:"13.5",y2:"21"}],["line",{x1:"18",x2:"21",y1:"12",y2:"15"}],["path",{d:"M3.59 3.59A1.99 1.99 0 0 0 3 5v14a2 2 0 0 0 2 2h14c.55 0 1.052-.22 1.41-.59"}],["path",{d:"M21 15V5a2 2 0 0 0-2-2H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E7=["svg",t,[["path",{d:"m11 16-5 5"}],["path",{d:"M11 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6.5"}],["path",{d:"M15.765 22a.5.5 0 0 1-.765-.424V13.38a.5.5 0 0 1 .765-.424l5.878 3.674a1 1 0 0 1 0 1.696z"}],["circle",{cx:"9",cy:"9",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F7=["svg",t,[["path",{d:"M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"}],["line",{x1:"16",x2:"22",y1:"5",y2:"5"}],["line",{x1:"19",x2:"19",y1:"2",y2:"8"}],["circle",{cx:"9",cy:"9",r:"2"}],["path",{d:"m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z7=["svg",t,[["path",{d:"M10.3 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10l-3.1-3.1a2 2 0 0 0-2.814.014L6 21"}],["path",{d:"m14 19.5 3-3 3 3"}],["path",{d:"M17 22v-5.5"}],["circle",{cx:"9",cy:"9",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D7=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["circle",{cx:"9",cy:"9",r:"2"}],["path",{d:"m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q7=["svg",t,[["path",{d:"M18 22H4a2 2 0 0 1-2-2V6"}],["path",{d:"m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18"}],["circle",{cx:"12",cy:"8",r:"2"}],["rect",{width:"16",height:"16",x:"6",y:"2",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U7=["svg",t,[["path",{d:"M12 3v12"}],["path",{d:"m8 11 4 4 4-4"}],["path",{d:"M8 5H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I7=["svg",t,[["polyline",{points:"22 12 16 12 14 15 10 15 8 12 2 12"}],["path",{d:"M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K0=["svg",t,[["polyline",{points:"7 8 3 12 7 16"}],["line",{x1:"21",x2:"11",y1:"12",y2:"12"}],["line",{x1:"21",x2:"11",y1:"6",y2:"6"}],["line",{x1:"21",x2:"11",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X0=["svg",t,[["polyline",{points:"3 8 7 12 3 16"}],["line",{x1:"21",x2:"11",y1:"12",y2:"12"}],["line",{x1:"21",x2:"11",y1:"6",y2:"6"}],["line",{x1:"21",x2:"11",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N7=["svg",t,[["path",{d:"M6 3h12"}],["path",{d:"M6 8h12"}],["path",{d:"m6 13 8.5 8"}],["path",{d:"M6 13h3"}],["path",{d:"M9 13c6.667 0 6.667-10 0-10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $7=["svg",t,[["path",{d:"M12 12c-2-2.67-4-4-6-4a4 4 0 1 0 0 8c2 0 4-1.33 6-4Zm0 0c2 2.67 4 4 6 4a4 4 0 0 0 0-8c-2 0-4 1.33-6 4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W7=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 16v-4"}],["path",{d:"M12 8h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j7=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7 7h.01"}],["path",{d:"M17 7h.01"}],["path",{d:"M7 17h.01"}],["path",{d:"M17 17h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G7=["svg",t,[["rect",{width:"20",height:"20",x:"2",y:"2",rx:"5",ry:"5"}],["path",{d:"M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"}],["line",{x1:"17.5",x2:"17.51",y1:"6.5",y2:"6.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K7=["svg",t,[["line",{x1:"19",x2:"10",y1:"4",y2:"4"}],["line",{x1:"14",x2:"5",y1:"20",y2:"20"}],["line",{x1:"15",x2:"9",y1:"4",y2:"20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X7=["svg",t,[["path",{d:"M20 10c0-4.4-3.6-8-8-8s-8 3.6-8 8 3.6 8 8 8h8"}],["polyline",{points:"16 14 20 18 16 22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J7=["svg",t,[["path",{d:"M4 10c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8H4"}],["polyline",{points:"8 22 4 18 8 14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y7=["svg",t,[["path",{d:"M12 9.5V21m0-11.5L6 3m6 6.5L18 3"}],["path",{d:"M6 15h12"}],["path",{d:"M6 11h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q7=["svg",t,[["path",{d:"M21 17a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2Z"}],["path",{d:"M6 15v-2"}],["path",{d:"M12 15V9"}],["circle",{cx:"12",cy:"6",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tl=["svg",t,[["path",{d:"M6 5v11"}],["path",{d:"M12 5v6"}],["path",{d:"M18 5v14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const al=["svg",t,[["path",{d:"M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"}],["circle",{cx:"16.5",cy:"7.5",r:".5",fill:"currentColor"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hl=["svg",t,[["path",{d:"M12.4 2.7c.9-.9 2.5-.9 3.4 0l5.5 5.5c.9.9.9 2.5 0 3.4l-3.7 3.7c-.9.9-2.5.9-3.4 0L8.7 9.8c-.9-.9-.9-2.5 0-3.4Z"}],["path",{d:"m14 7 3 3"}],["path",{d:"M9.4 10.6 2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const el=["svg",t,[["circle",{cx:"7.5",cy:"15.5",r:"5.5"}],["path",{d:"m21 2-9.6 9.6"}],["path",{d:"m15.5 7.5 3 3L22 7l-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cl=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"M6 8h4"}],["path",{d:"M14 8h.01"}],["path",{d:"M18 8h.01"}],["path",{d:"M2 12h20"}],["path",{d:"M6 12v4"}],["path",{d:"M10 12v4"}],["path",{d:"M14 12v4"}],["path",{d:"M18 12v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dl=["svg",t,[["path",{d:"M 20 4 A2 2 0 0 1 22 6"}],["path",{d:"M 22 6 L 22 16.41"}],["path",{d:"M 7 16 L 16 16"}],["path",{d:"M 9.69 4 L 20 4"}],["path",{d:"M14 8h.01"}],["path",{d:"M18 8h.01"}],["path",{d:"m2 2 20 20"}],["path",{d:"M20 20H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2"}],["path",{d:"M6 8h.01"}],["path",{d:"M8 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pl=["svg",t,[["path",{d:"M10 8h.01"}],["path",{d:"M12 12h.01"}],["path",{d:"M14 8h.01"}],["path",{d:"M16 12h.01"}],["path",{d:"M18 8h.01"}],["path",{d:"M6 8h.01"}],["path",{d:"M7 16h10"}],["path",{d:"M8 12h.01"}],["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nl=["svg",t,[["path",{d:"M12 2v5"}],["path",{d:"M6 7h12l4 9H2l4-9Z"}],["path",{d:"M9.17 16a3 3 0 1 0 5.66 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sl=["svg",t,[["path",{d:"m14 5-3 3 2 7 8-8-7-2Z"}],["path",{d:"m14 5-3 3-3-3 3-3 3 3Z"}],["path",{d:"M9.5 6.5 4 12l3 6"}],["path",{d:"M3 22v-2c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2H3Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rl=["svg",t,[["path",{d:"M9 2h6l3 7H6l3-7Z"}],["path",{d:"M12 9v13"}],["path",{d:"M9 22h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const il=["svg",t,[["path",{d:"M11 13h6l3 7H8l3-7Z"}],["path",{d:"M14 13V8a2 2 0 0 0-2-2H8"}],["path",{d:"M4 9h2a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H4v6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ol=["svg",t,[["path",{d:"M11 4h6l3 7H8l3-7Z"}],["path",{d:"M14 11v5a2 2 0 0 1-2 2H8"}],["path",{d:"M4 15h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H4v-6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ll=["svg",t,[["path",{d:"M8 2h8l4 10H4L8 2Z"}],["path",{d:"M12 12v6"}],["path",{d:"M8 22v-2c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2H8Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ml=["svg",t,[["path",{d:"m12 8 6-3-6-3v10"}],["path",{d:"m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12"}],["path",{d:"m6.49 12.85 11.02 6.3"}],["path",{d:"M17.51 12.85 6.5 19.15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vl=["svg",t,[["line",{x1:"3",x2:"21",y1:"22",y2:"22"}],["line",{x1:"6",x2:"6",y1:"18",y2:"11"}],["line",{x1:"10",x2:"10",y1:"18",y2:"11"}],["line",{x1:"14",x2:"14",y1:"18",y2:"11"}],["line",{x1:"18",x2:"18",y1:"18",y2:"11"}],["polygon",{points:"12 2 20 7 4 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gl=["svg",t,[["path",{d:"m5 8 6 6"}],["path",{d:"m4 14 6-6 2-3"}],["path",{d:"M2 5h12"}],["path",{d:"M7 2h1"}],["path",{d:"m22 22-5-10-5 10"}],["path",{d:"M14 18h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J0=["svg",t,[["rect",{width:"18",height:"12",x:"3",y:"4",rx:"2",ry:"2"}],["line",{x1:"2",x2:"22",y1:"20",y2:"20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xl=["svg",t,[["path",{d:"M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yl=["svg",t,[["path",{d:"M7 22a5 5 0 0 1-2-4"}],["path",{d:"M7 16.93c.96.43 1.96.74 2.99.91"}],["path",{d:"M3.34 14A6.8 6.8 0 0 1 2 10c0-4.42 4.48-8 10-8s10 3.58 10 8a7.19 7.19 0 0 1-.33 2"}],["path",{d:"M5 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"}],["path",{d:"M14.33 22h-.09a.35.35 0 0 1-.24-.32v-10a.34.34 0 0 1 .33-.34c.08 0 .15.03.21.08l7.34 6a.33.33 0 0 1-.21.59h-4.49l-2.57 3.85a.35.35 0 0 1-.28.14v0z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ul=["svg",t,[["path",{d:"M7 22a5 5 0 0 1-2-4"}],["path",{d:"M3.3 14A6.8 6.8 0 0 1 2 10c0-4.4 4.5-8 10-8s10 3.6 10 8-4.5 8-10 8a12 12 0 0 1-5-1"}],["path",{d:"M5 18a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fl=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M18 13a6 6 0 0 1-6 5 6 6 0 0 1-6-5h12Z"}],["line",{x1:"9",x2:"9.01",y1:"9",y2:"9"}],["line",{x1:"15",x2:"15.01",y1:"9",y2:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ml=["svg",t,[["path",{d:"m16.02 12 5.48 3.13a1 1 0 0 1 0 1.74L13 21.74a2 2 0 0 1-2 0l-8.5-4.87a1 1 0 0 1 0-1.74L7.98 12"}],["path",{d:"M13 13.74a2 2 0 0 1-2 0L2.5 8.87a1 1 0 0 1 0-1.74L11 2.26a2 2 0 0 1 2 0l8.5 4.87a1 1 0 0 1 0 1.74Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wl=["svg",t,[["path",{d:"m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"}],["path",{d:"m6.08 9.5-3.5 1.6a1 1 0 0 0 0 1.81l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9a1 1 0 0 0 0-1.83l-3.5-1.59"}],["path",{d:"m6.08 14.5-3.5 1.6a1 1 0 0 0 0 1.81l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9a1 1 0 0 0 0-1.83l-3.5-1.59"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hl=["svg",t,[["path",{d:"m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"}],["path",{d:"m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"}],["path",{d:"m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vl=["svg",t,[["rect",{width:"7",height:"9",x:"3",y:"3",rx:"1"}],["rect",{width:"7",height:"5",x:"14",y:"3",rx:"1"}],["rect",{width:"7",height:"9",x:"14",y:"12",rx:"1"}],["rect",{width:"7",height:"5",x:"3",y:"16",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cl=["svg",t,[["rect",{width:"7",height:"7",x:"3",y:"3",rx:"1"}],["rect",{width:"7",height:"7",x:"14",y:"3",rx:"1"}],["rect",{width:"7",height:"7",x:"14",y:"14",rx:"1"}],["rect",{width:"7",height:"7",x:"3",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Al=["svg",t,[["rect",{width:"7",height:"7",x:"3",y:"3",rx:"1"}],["rect",{width:"7",height:"7",x:"3",y:"14",rx:"1"}],["path",{d:"M14 4h7"}],["path",{d:"M14 9h7"}],["path",{d:"M14 15h7"}],["path",{d:"M14 20h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _l=["svg",t,[["rect",{width:"7",height:"18",x:"3",y:"3",rx:"1"}],["rect",{width:"7",height:"7",x:"14",y:"3",rx:"1"}],["rect",{width:"7",height:"7",x:"14",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sl=["svg",t,[["rect",{width:"18",height:"7",x:"3",y:"3",rx:"1"}],["rect",{width:"7",height:"7",x:"3",y:"14",rx:"1"}],["rect",{width:"7",height:"7",x:"14",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ll=["svg",t,[["rect",{width:"18",height:"7",x:"3",y:"3",rx:"1"}],["rect",{width:"9",height:"7",x:"3",y:"14",rx:"1"}],["rect",{width:"5",height:"7",x:"16",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bl=["svg",t,[["path",{d:"M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"}],["path",{d:"M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zl=["svg",t,[["path",{d:"M2 22c1.25-.987 2.27-1.975 3.9-2.2a5.56 5.56 0 0 1 3.8 1.5 4 4 0 0 0 6.187-2.353 3.5 3.5 0 0 0 3.69-5.116A3.5 3.5 0 0 0 20.95 8 3.5 3.5 0 1 0 16 3.05a3.5 3.5 0 0 0-5.831 1.373 3.5 3.5 0 0 0-5.116 3.69 4 4 0 0 0-2.348 6.155C3.499 15.42 4.409 16.712 4.2 18.1 3.926 19.743 3.014 20.732 2 22"}],["path",{d:"M2 22 17 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pl=["svg",t,[["rect",{width:"8",height:"18",x:"3",y:"3",rx:"1"}],["path",{d:"M7 3v18"}],["path",{d:"M20.4 18.9c.2.5-.1 1.1-.6 1.3l-1.9.7c-.5.2-1.1-.1-1.3-.6L11.1 5.1c-.2-.5.1-1.1.6-1.3l1.9-.7c.5-.2 1.1.1 1.3.6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kl=["svg",t,[["path",{d:"m16 6 4 14"}],["path",{d:"M12 6v14"}],["path",{d:"M8 8v12"}],["path",{d:"M4 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ol=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"m4.93 4.93 4.24 4.24"}],["path",{d:"m14.83 9.17 4.24-4.24"}],["path",{d:"m14.83 14.83 4.24 4.24"}],["path",{d:"m9.17 14.83-4.24 4.24"}],["circle",{cx:"12",cy:"12",r:"4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rl=["svg",t,[["path",{d:"M8 20V8c0-2.2 1.8-4 4-4 1.5 0 2.8.8 3.5 2"}],["path",{d:"M6 12h4"}],["path",{d:"M14 12h2v8"}],["path",{d:"M6 20h4"}],["path",{d:"M14 20h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bl=["svg",t,[["path",{d:"M16.8 11.2c.8-.9 1.2-2 1.2-3.2a6 6 0 0 0-9.3-5"}],["path",{d:"m2 2 20 20"}],["path",{d:"M6.3 6.3a4.67 4.67 0 0 0 1.2 5.2c.7.7 1.3 1.5 1.5 2.5"}],["path",{d:"M9 18h6"}],["path",{d:"M10 22h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tl=["svg",t,[["path",{d:"M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"}],["path",{d:"M9 18h6"}],["path",{d:"M10 22h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const El=["svg",t,[["path",{d:"M3 3v18h18"}],["path",{d:"m19 9-5 5-4-4-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fl=["svg",t,[["path",{d:"M9 17H7A5 5 0 0 1 7 7"}],["path",{d:"M15 7h2a5 5 0 0 1 4 8"}],["line",{x1:"8",x2:"12",y1:"12",y2:"12"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zl=["svg",t,[["path",{d:"M9 17H7A5 5 0 0 1 7 7h2"}],["path",{d:"M15 7h2a5 5 0 1 1 0 10h-2"}],["line",{x1:"8",x2:"16",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dl=["svg",t,[["path",{d:"M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"}],["path",{d:"M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ql=["svg",t,[["path",{d:"M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"}],["rect",{width:"4",height:"12",x:"2",y:"9"}],["circle",{cx:"4",cy:"4",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ul=["svg",t,[["path",{d:"m3 17 2 2 4-4"}],["path",{d:"m3 7 2 2 4-4"}],["path",{d:"M13 6h8"}],["path",{d:"M13 12h8"}],["path",{d:"M13 18h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Il=["svg",t,[["path",{d:"m3 10 2.5-2.5L3 5"}],["path",{d:"m3 19 2.5-2.5L3 14"}],["path",{d:"M10 6h11"}],["path",{d:"M10 12h11"}],["path",{d:"M10 18h11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nl=["svg",t,[["path",{d:"M16 12H3"}],["path",{d:"M16 6H3"}],["path",{d:"M10 18H3"}],["path",{d:"M21 6v10a2 2 0 0 1-2 2h-5"}],["path",{d:"m16 16-2 2 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $l=["svg",t,[["path",{d:"M3 6h18"}],["path",{d:"M7 12h10"}],["path",{d:"M10 18h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wl=["svg",t,[["path",{d:"M11 12H3"}],["path",{d:"M16 6H3"}],["path",{d:"M16 18H3"}],["path",{d:"M21 12h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jl=["svg",t,[["path",{d:"M21 15V6"}],["path",{d:"M18.5 18a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"}],["path",{d:"M12 12H3"}],["path",{d:"M16 6H3"}],["path",{d:"M12 18H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gl=["svg",t,[["line",{x1:"10",x2:"21",y1:"6",y2:"6"}],["line",{x1:"10",x2:"21",y1:"12",y2:"12"}],["line",{x1:"10",x2:"21",y1:"18",y2:"18"}],["path",{d:"M4 6h1v4"}],["path",{d:"M4 10h2"}],["path",{d:"M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kl=["svg",t,[["path",{d:"M11 12H3"}],["path",{d:"M16 6H3"}],["path",{d:"M16 18H3"}],["path",{d:"M18 9v6"}],["path",{d:"M21 12h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xl=["svg",t,[["path",{d:"M21 6H3"}],["path",{d:"M7 12H3"}],["path",{d:"M7 18H3"}],["path",{d:"M12 18a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L11 14"}],["path",{d:"M11 10v4h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jl=["svg",t,[["path",{d:"M16 12H3"}],["path",{d:"M16 18H3"}],["path",{d:"M10 6H3"}],["path",{d:"M21 18V8a2 2 0 0 0-2-2h-5"}],["path",{d:"m16 8-2-2 2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yl=["svg",t,[["rect",{x:"3",y:"5",width:"6",height:"6",rx:"1"}],["path",{d:"m3 17 2 2 4-4"}],["path",{d:"M13 6h8"}],["path",{d:"M13 12h8"}],["path",{d:"M13 18h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ql=["svg",t,[["path",{d:"M21 12h-8"}],["path",{d:"M21 6H8"}],["path",{d:"M21 18h-8"}],["path",{d:"M3 6v4c0 1.1.9 2 2 2h3"}],["path",{d:"M3 10v6c0 1.1.9 2 2 2h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tM=["svg",t,[["path",{d:"M12 12H3"}],["path",{d:"M16 6H3"}],["path",{d:"M12 18H3"}],["path",{d:"m16 12 5 3-5 3v-6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const aM=["svg",t,[["path",{d:"M11 12H3"}],["path",{d:"M16 6H3"}],["path",{d:"M16 18H3"}],["path",{d:"m19 10-4 4"}],["path",{d:"m15 10 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hM=["svg",t,[["line",{x1:"8",x2:"21",y1:"6",y2:"6"}],["line",{x1:"8",x2:"21",y1:"12",y2:"12"}],["line",{x1:"8",x2:"21",y1:"18",y2:"18"}],["line",{x1:"3",x2:"3.01",y1:"6",y2:"6"}],["line",{x1:"3",x2:"3.01",y1:"12",y2:"12"}],["line",{x1:"3",x2:"3.01",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y0=["svg",t,[["path",{d:"M21 12a9 9 0 1 1-6.219-8.56"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const eM=["svg",t,[["path",{d:"M2 12c0-2.8 2.2-5 5-5s5 2.2 5 5 2.2 5 5 5 5-2.2 5-5"}],["path",{d:"M7 20.7a1 1 0 1 1 5-8.7 1 1 0 1 0 5-8.6"}],["path",{d:"M7 3.3a1 1 0 1 1 5 8.6 1 1 0 1 0 5 8.6"}],["circle",{cx:"12",cy:"12",r:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cM=["svg",t,[["path",{d:"M12 2v4"}],["path",{d:"m16.2 7.8 2.9-2.9"}],["path",{d:"M18 12h4"}],["path",{d:"m16.2 16.2 2.9 2.9"}],["path",{d:"M12 18v4"}],["path",{d:"m4.9 19.1 2.9-2.9"}],["path",{d:"M2 12h4"}],["path",{d:"m4.9 4.9 2.9 2.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dM=["svg",t,[["line",{x1:"2",x2:"5",y1:"12",y2:"12"}],["line",{x1:"19",x2:"22",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"2",y2:"5"}],["line",{x1:"12",x2:"12",y1:"19",y2:"22"}],["circle",{cx:"12",cy:"12",r:"7"}],["circle",{cx:"12",cy:"12",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pM=["svg",t,[["line",{x1:"2",x2:"5",y1:"12",y2:"12"}],["line",{x1:"19",x2:"22",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"2",y2:"5"}],["line",{x1:"12",x2:"12",y1:"19",y2:"22"}],["path",{d:"M7.11 7.11C5.83 8.39 5 10.1 5 12c0 3.87 3.13 7 7 7 1.9 0 3.61-.83 4.89-2.11"}],["path",{d:"M18.71 13.96c.19-.63.29-1.29.29-1.96 0-3.87-3.13-7-7-7-.67 0-1.33.1-1.96.29"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nM=["svg",t,[["line",{x1:"2",x2:"5",y1:"12",y2:"12"}],["line",{x1:"19",x2:"22",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"2",y2:"5"}],["line",{x1:"12",x2:"12",y1:"19",y2:"22"}],["circle",{cx:"12",cy:"12",r:"7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q0=["svg",t,[["circle",{cx:"12",cy:"16",r:"1"}],["rect",{width:"18",height:"12",x:"3",y:"10",rx:"2"}],["path",{d:"M7 10V7a5 5 0 0 1 9.33-2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sM=["svg",t,[["circle",{cx:"12",cy:"16",r:"1"}],["rect",{x:"3",y:"10",width:"18",height:"12",rx:"2"}],["path",{d:"M7 10V7a5 5 0 0 1 10 0v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tt=["svg",t,[["rect",{width:"18",height:"11",x:"3",y:"11",rx:"2",ry:"2"}],["path",{d:"M7 11V7a5 5 0 0 1 9.9-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rM=["svg",t,[["rect",{width:"18",height:"11",x:"3",y:"11",rx:"2",ry:"2"}],["path",{d:"M7 11V7a5 5 0 0 1 10 0v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const iM=["svg",t,[["path",{d:"M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"}],["polyline",{points:"10 17 15 12 10 7"}],["line",{x1:"15",x2:"3",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const oM=["svg",t,[["path",{d:"M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"}],["polyline",{points:"16 17 21 12 16 7"}],["line",{x1:"21",x2:"9",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lM=["svg",t,[["circle",{cx:"11",cy:"11",r:"8"}],["path",{d:"m21 21-4.3-4.3"}],["path",{d:"M11 11a2 2 0 0 0 4 0 4 4 0 0 0-8 0 6 6 0 0 0 12 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const MM=["svg",t,[["path",{d:"M6 20h0a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h0"}],["path",{d:"M8 18V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v14"}],["path",{d:"M10 20h4"}],["circle",{cx:"16",cy:"20",r:"2"}],["circle",{cx:"8",cy:"20",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vM=["svg",t,[["path",{d:"m6 15-4-4 6.75-6.77a7.79 7.79 0 0 1 11 11L13 22l-4-4 6.39-6.36a2.14 2.14 0 0 0-3-3L6 15"}],["path",{d:"m5 8 4 4"}],["path",{d:"m12 15 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gM=["svg",t,[["path",{d:"M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"m16 19 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xM=["svg",t,[["path",{d:"M22 15V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"M16 19h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yM=["svg",t,[["path",{d:"M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z"}],["path",{d:"m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uM=["svg",t,[["path",{d:"M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"M19 16v6"}],["path",{d:"M16 19h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fM=["svg",t,[["path",{d:"M22 10.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12.5"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"M18 15.28c.2-.4.5-.8.9-1a2.1 2.1 0 0 1 2.6.4c.3.4.5.8.5 1.3 0 1.3-2 2-2 2"}],["path",{d:"M20 22v.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mM=["svg",t,[["path",{d:"M22 12.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h7.5"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"M18 21a3 3 0 1 0 0-6 3 3 0 0 0 0 6v0Z"}],["circle",{cx:"18",cy:"18",r:"3"}],["path",{d:"m22 22-1.5-1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wM=["svg",t,[["path",{d:"M22 10.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12.5"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"M20 14v4"}],["path",{d:"M20 22v.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const HM=["svg",t,[["path",{d:"M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h9"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}],["path",{d:"m17 17 4 4"}],["path",{d:"m21 17-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const VM=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const CM=["svg",t,[["path",{d:"M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5C2 7 4 5 6.5 5H18c2.2 0 4 1.8 4 4v8Z"}],["polyline",{points:"15,9 18,9 18,11"}],["path",{d:"M6.5 5C9 5 11 7 11 9.5V17a2 2 0 0 1-2 2v0"}],["line",{x1:"6",x2:"7",y1:"10",y2:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const AM=["svg",t,[["rect",{width:"16",height:"13",x:"6",y:"4",rx:"2"}],["path",{d:"m22 7-7.1 3.78c-.57.3-1.23.3-1.8 0L6 7"}],["path",{d:"M2 8v11c0 1.1.9 2 2 2h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _M=["svg",t,[["path",{d:"M5.43 5.43A8.06 8.06 0 0 0 4 10c0 6 8 12 8 12a29.94 29.94 0 0 0 5-5"}],["path",{d:"M19.18 13.52A8.66 8.66 0 0 0 20 10a8 8 0 0 0-8-8 7.88 7.88 0 0 0-3.52.82"}],["path",{d:"M9.13 9.13A2.78 2.78 0 0 0 9 10a3 3 0 0 0 3 3 2.78 2.78 0 0 0 .87-.13"}],["path",{d:"M14.9 9.25a3 3 0 0 0-2.15-2.16"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const SM=["svg",t,[["path",{d:"M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"}],["circle",{cx:"12",cy:"10",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const LM=["svg",t,[["path",{d:"M18 8c0 4.5-6 9-6 9s-6-4.5-6-9a6 6 0 0 1 12 0"}],["circle",{cx:"12",cy:"8",r:"2"}],["path",{d:"M8.835 14H5a1 1 0 0 0-.9.7l-2 6c-.1.1-.1.2-.1.3 0 .6.4 1 1 1h18c.6 0 1-.4 1-1 0-.1 0-.2-.1-.3l-2-6a1 1 0 0 0-.9-.7h-3.835"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bM=["svg",t,[["path",{d:"M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"}],["path",{d:"M15 5.764v15"}],["path",{d:"M9 3.236v15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ZM=["svg",t,[["path",{d:"M8 22h8"}],["path",{d:"M12 11v11"}],["path",{d:"m19 3-7 8-7-8Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const PM=["svg",t,[["polyline",{points:"15 3 21 3 21 9"}],["polyline",{points:"9 21 3 21 3 15"}],["line",{x1:"21",x2:"14",y1:"3",y2:"10"}],["line",{x1:"3",x2:"10",y1:"21",y2:"14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kM=["svg",t,[["path",{d:"M8 3H5a2 2 0 0 0-2 2v3"}],["path",{d:"M21 8V5a2 2 0 0 0-2-2h-3"}],["path",{d:"M3 16v3a2 2 0 0 0 2 2h3"}],["path",{d:"M16 21h3a2 2 0 0 0 2-2v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const OM=["svg",t,[["path",{d:"M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15"}],["path",{d:"M11 12 5.12 2.2"}],["path",{d:"m13 12 5.88-9.8"}],["path",{d:"M8 7h8"}],["circle",{cx:"12",cy:"17",r:"5"}],["path",{d:"M12 18v-2h-.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const RM=["svg",t,[["path",{d:"M9.26 9.26 3 11v3l14.14 3.14"}],["path",{d:"M21 15.34V6l-7.31 2.03"}],["path",{d:"M11.6 16.8a3 3 0 1 1-5.8-1.6"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const BM=["svg",t,[["path",{d:"m3 11 18-5v12L3 14v-3z"}],["path",{d:"M11.6 16.8a3 3 0 1 1-5.8-1.6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const TM=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["line",{x1:"8",x2:"16",y1:"15",y2:"15"}],["line",{x1:"9",x2:"9.01",y1:"9",y2:"9"}],["line",{x1:"15",x2:"15.01",y1:"9",y2:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const EM=["svg",t,[["path",{d:"M6 19v-3"}],["path",{d:"M10 19v-3"}],["path",{d:"M14 19v-3"}],["path",{d:"M18 19v-3"}],["path",{d:"M8 11V9"}],["path",{d:"M16 11V9"}],["path",{d:"M12 11V9"}],["path",{d:"M2 15h20"}],["path",{d:"M2 7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1.1a2 2 0 0 0 0 3.837V17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5.1a2 2 0 0 0 0-3.837Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const FM=["svg",t,[["line",{x1:"4",x2:"20",y1:"12",y2:"12"}],["line",{x1:"4",x2:"20",y1:"6",y2:"6"}],["line",{x1:"4",x2:"20",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zM=["svg",t,[["path",{d:"m8 6 4-4 4 4"}],["path",{d:"M12 2v10.3a4 4 0 0 1-1.172 2.872L4 22"}],["path",{d:"m20 22-5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const DM=["svg",t,[["path",{d:"M10 9.5 8 12l2 2.5"}],["path",{d:"m14 9.5 2 2.5-2 2.5"}],["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qM=["svg",t,[["path",{d:"M13.5 3.1c-.5 0-1-.1-1.5-.1s-1 .1-1.5.1"}],["path",{d:"M19.3 6.8a10.45 10.45 0 0 0-2.1-2.1"}],["path",{d:"M20.9 13.5c.1-.5.1-1 .1-1.5s-.1-1-.1-1.5"}],["path",{d:"M17.2 19.3a10.45 10.45 0 0 0 2.1-2.1"}],["path",{d:"M10.5 20.9c.5.1 1 .1 1.5.1s1-.1 1.5-.1"}],["path",{d:"M3.5 17.5 2 22l4.5-1.5"}],["path",{d:"M3.1 10.5c0 .5-.1 1-.1 1.5s.1 1 .1 1.5"}],["path",{d:"M6.8 4.7a10.45 10.45 0 0 0-2.1 2.1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const UM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"M15.8 9.2a2.5 2.5 0 0 0-3.5 0l-.3.4-.35-.3a2.42 2.42 0 1 0-3.2 3.6l3.6 3.5 3.6-3.5c1.2-1.2 1.1-2.7.2-3.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const IM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"M8 12h.01"}],["path",{d:"M12 12h.01"}],["path",{d:"M16 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const NM=["svg",t,[["path",{d:"M20.5 14.9A9 9 0 0 0 9.1 3.5"}],["path",{d:"m2 2 20 20"}],["path",{d:"M5.6 5.6C3 8.3 2.2 12.5 4 16l-2 6 6-2c3.4 1.8 7.6 1.1 10.3-1.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $M=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"M8 12h8"}],["path",{d:"M12 8v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const WM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"}],["path",{d:"M12 17h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"m10 15-3-3 3-3"}],["path",{d:"M7 12h7a2 2 0 0 1 2 2v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const GM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"M12 8v4"}],["path",{d:"M12 16h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const KM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}],["path",{d:"m15 9-6 6"}],["path",{d:"m9 9 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const XM=["svg",t,[["path",{d:"M7.9 20A9 9 0 1 0 4 16.1L2 22Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const JM=["svg",t,[["path",{d:"M10 7.5 8 10l2 2.5"}],["path",{d:"m14 7.5 2 2.5-2 2.5"}],["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const YM=["svg",t,[["path",{d:"M3 6V5c0-1.1.9-2 2-2h2"}],["path",{d:"M11 3h3"}],["path",{d:"M18 3h1c1.1 0 2 .9 2 2"}],["path",{d:"M21 9v2"}],["path",{d:"M21 15c0 1.1-.9 2-2 2h-1"}],["path",{d:"M14 17h-3"}],["path",{d:"m7 17-4 4v-5"}],["path",{d:"M3 12v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const QM=["svg",t,[["path",{d:"m5 19-2 2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2"}],["path",{d:"M9 10h6"}],["path",{d:"M12 7v6"}],["path",{d:"M9 17h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tv=["svg",t,[["path",{d:"M11.7 3H5a2 2 0 0 0-2 2v16l4-4h12a2 2 0 0 0 2-2v-2.7"}],["circle",{cx:"18",cy:"6",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const av=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"M14.8 7.5a1.84 1.84 0 0 0-2.6 0l-.2.3-.3-.3a1.84 1.84 0 1 0-2.4 2.8L12 13l2.7-2.7c.9-.9.8-2.1.1-2.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"M8 10h.01"}],["path",{d:"M12 10h.01"}],["path",{d:"M16 10h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ev=["svg",t,[["path",{d:"M21 15V5a2 2 0 0 0-2-2H9"}],["path",{d:"m2 2 20 20"}],["path",{d:"M3.6 3.6c-.4.3-.6.8-.6 1.4v16l4-4h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"M12 7v6"}],["path",{d:"M9 10h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"M8 12a2 2 0 0 0 2-2V8H8"}],["path",{d:"M14 12a2 2 0 0 0 2-2V8h-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"m10 7-3 3 3 3"}],["path",{d:"M17 13v-1a2 2 0 0 0-2-2H7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nv=["svg",t,[["path",{d:"M21 12v3a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h7"}],["path",{d:"M16 3h5v5"}],["path",{d:"m16 8 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"M13 8H7"}],["path",{d:"M17 12H7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"M12 7v2"}],["path",{d:"M12 13h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const iv=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}],["path",{d:"m14.5 7.5-5 5"}],["path",{d:"m9.5 7.5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ov=["svg",t,[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lv=["svg",t,[["path",{d:"M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2z"}],["path",{d:"M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mv=["svg",t,[["line",{x1:"2",x2:"22",y1:"2",y2:"22"}],["path",{d:"M18.89 13.23A7.12 7.12 0 0 0 19 12v-2"}],["path",{d:"M5 10v2a7 7 0 0 0 12 5"}],["path",{d:"M15 9.34V5a3 3 0 0 0-5.68-1.33"}],["path",{d:"M9 9v3a3 3 0 0 0 5.12 2.12"}],["line",{x1:"12",x2:"12",y1:"19",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const at=["svg",t,[["path",{d:"m12 8-9.04 9.06a2.82 2.82 0 1 0 3.98 3.98L16 12"}],["circle",{cx:"17",cy:"7",r:"5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vv=["svg",t,[["path",{d:"M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"}],["path",{d:"M19 10v2a7 7 0 0 1-14 0v-2"}],["line",{x1:"12",x2:"12",y1:"19",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gv=["svg",t,[["path",{d:"M6 18h8"}],["path",{d:"M3 22h18"}],["path",{d:"M14 22a7 7 0 1 0 0-14h-1"}],["path",{d:"M9 14h2"}],["path",{d:"M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"}],["path",{d:"M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xv=["svg",t,[["rect",{width:"20",height:"15",x:"2",y:"4",rx:"2"}],["rect",{width:"8",height:"7",x:"6",y:"8",rx:"1"}],["path",{d:"M18 8v7"}],["path",{d:"M6 19v2"}],["path",{d:"M18 19v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yv=["svg",t,[["path",{d:"M18 6H5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h13l4-3.5L18 6Z"}],["path",{d:"M12 13v8"}],["path",{d:"M12 3v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uv=["svg",t,[["path",{d:"M8 2h8"}],["path",{d:"M9 2v1.343M15 2v2.789a4 4 0 0 0 .672 2.219l.656.984a4 4 0 0 1 .672 2.22v1.131M7.8 7.8l-.128.192A4 4 0 0 0 7 10.212V20a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-3"}],["path",{d:"M7 15a6.47 6.47 0 0 1 5 0 6.472 6.472 0 0 0 3.435.435"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fv=["svg",t,[["path",{d:"M8 2h8"}],["path",{d:"M9 2v2.789a4 4 0 0 1-.672 2.219l-.656.984A4 4 0 0 0 7 10.212V20a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-9.789a4 4 0 0 0-.672-2.219l-.656-.984A4 4 0 0 1 15 4.788V2"}],["path",{d:"M7 15a6.472 6.472 0 0 1 5 0 6.47 6.47 0 0 0 5 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mv=["svg",t,[["polyline",{points:"4 14 10 14 10 20"}],["polyline",{points:"20 10 14 10 14 4"}],["line",{x1:"14",x2:"21",y1:"10",y2:"3"}],["line",{x1:"3",x2:"10",y1:"21",y2:"14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wv=["svg",t,[["path",{d:"M8 3v3a2 2 0 0 1-2 2H3"}],["path",{d:"M21 8h-3a2 2 0 0 1-2-2V3"}],["path",{d:"M3 16h3a2 2 0 0 1 2 2v3"}],["path",{d:"M16 21v-3a2 2 0 0 1 2-2h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hv=["svg",t,[["path",{d:"M5 12h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vv=["svg",t,[["path",{d:"m9 10 2 2 4-4"}],["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cv=["svg",t,[["circle",{cx:"19",cy:"6",r:"3"}],["path",{d:"M22 12v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Av=["svg",t,[["path",{d:"M12 13V7"}],["path",{d:"m15 10-3 3-3-3"}],["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _v=["svg",t,[["path",{d:"M17 17H4a2 2 0 0 1-2-2V5c0-1.5 1-2 1-2"}],["path",{d:"M22 15V5a2 2 0 0 0-2-2H9"}],["path",{d:"M8 21h8"}],["path",{d:"M12 17v4"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sv=["svg",t,[["path",{d:"M10 13V7"}],["path",{d:"M14 13V7"}],["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lv=["svg",t,[["path",{d:"M10 7.75a.75.75 0 0 1 1.142-.638l3.664 2.249a.75.75 0 0 1 0 1.278l-3.664 2.25a.75.75 0 0 1-1.142-.64z"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}],["rect",{x:"2",y:"3",width:"20",height:"14",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bv=["svg",t,[["path",{d:"M18 8V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8"}],["path",{d:"M10 19v-3.96 3.15"}],["path",{d:"M7 19h5"}],["rect",{width:"6",height:"10",x:"16",y:"12",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zv=["svg",t,[["path",{d:"M5.5 20H8"}],["path",{d:"M17 9h.01"}],["rect",{width:"10",height:"16",x:"12",y:"4",rx:"2"}],["path",{d:"M8 6H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h4"}],["circle",{cx:"17",cy:"15",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pv=["svg",t,[["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}],["rect",{x:"2",y:"3",width:"20",height:"14",rx:"2"}],["rect",{x:"9",y:"7",width:"6",height:"6",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kv=["svg",t,[["path",{d:"m9 10 3-3 3 3"}],["path",{d:"M12 13V7"}],["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ov=["svg",t,[["path",{d:"m14.5 12.5-5-5"}],["path",{d:"m9.5 12.5 5-5"}],["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["path",{d:"M12 17v4"}],["path",{d:"M8 21h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rv=["svg",t,[["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["line",{x1:"8",x2:"16",y1:"21",y2:"21"}],["line",{x1:"12",x2:"12",y1:"17",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bv=["svg",t,[["path",{d:"M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9"}],["path",{d:"M20 3v4"}],["path",{d:"M22 5h-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tv=["svg",t,[["path",{d:"M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ev=["svg",t,[["path",{d:"m8 3 4 8 5-5 5 15H2L8 3z"}],["path",{d:"M4.14 15.08c2.62-1.57 5.24-1.43 7.86.42 2.74 1.94 5.49 2 8.23.19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fv=["svg",t,[["path",{d:"m8 3 4 8 5-5 5 15H2L8 3z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zv=["svg",t,[["path",{d:"M12 6v.343"}],["path",{d:"M18.218 18.218A7 7 0 0 1 5 15V9a7 7 0 0 1 .782-3.218"}],["path",{d:"M19 13.343V9A7 7 0 0 0 8.56 2.902"}],["path",{d:"M22 22 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dv=["svg",t,[["path",{d:"m4 4 7.07 17 2.51-7.39L21 11.07z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qv=["svg",t,[["path",{d:"m2 2 4 11 2-5 5-2Z"}],["circle",{cx:"16",cy:"16",r:"6"}],["path",{d:"m11.8 11.8 8.4 8.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uv=["svg",t,[["path",{d:"m9 9 5 12 1.8-5.2L21 14Z"}],["path",{d:"M7.2 2.2 8 5.1"}],["path",{d:"m5.1 8-2.9-.8"}],["path",{d:"M14 4.1 12 6"}],["path",{d:"m6 12-1.9 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Iv=["svg",t,[["path",{d:"m3 3 7.07 16.97 2.51-7.39 7.39-2.51L3 3z"}],["path",{d:"m13 13 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nv=["svg",t,[["rect",{x:"5",y:"2",width:"14",height:"20",rx:"7"}],["path",{d:"M12 6v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ht=["svg",t,[["path",{d:"M5 3v16h16"}],["path",{d:"m5 19 6-6"}],["path",{d:"m2 6 3-3 3 3"}],["path",{d:"m18 16 3 3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $v=["svg",t,[["polyline",{points:"5 11 5 5 11 5"}],["polyline",{points:"19 13 19 19 13 19"}],["line",{x1:"5",x2:"19",y1:"5",y2:"19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wv=["svg",t,[["polyline",{points:"13 5 19 5 19 11"}],["polyline",{points:"11 19 5 19 5 13"}],["line",{x1:"19",x2:"5",y1:"5",y2:"19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jv=["svg",t,[["path",{d:"M11 19H5V13"}],["path",{d:"M19 5L5 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gv=["svg",t,[["path",{d:"M19 13V19H13"}],["path",{d:"M5 5L19 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kv=["svg",t,[["path",{d:"M8 18L12 22L16 18"}],["path",{d:"M12 2V22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xv=["svg",t,[["polyline",{points:"18 8 22 12 18 16"}],["polyline",{points:"6 8 2 12 6 16"}],["line",{x1:"2",x2:"22",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jv=["svg",t,[["path",{d:"M6 8L2 12L6 16"}],["path",{d:"M2 12H22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yv=["svg",t,[["path",{d:"M18 8L22 12L18 16"}],["path",{d:"M2 12H22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qv=["svg",t,[["path",{d:"M5 11V5H11"}],["path",{d:"M5 5L19 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const t9=["svg",t,[["path",{d:"M13 5H19V11"}],["path",{d:"M19 5L5 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const a9=["svg",t,[["path",{d:"M8 6L12 2L16 6"}],["path",{d:"M12 2V22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const h9=["svg",t,[["polyline",{points:"8 18 12 22 16 18"}],["polyline",{points:"8 6 12 2 16 6"}],["line",{x1:"12",x2:"12",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const e9=["svg",t,[["polyline",{points:"5 9 2 12 5 15"}],["polyline",{points:"9 5 12 2 15 5"}],["polyline",{points:"15 19 12 22 9 19"}],["polyline",{points:"19 9 22 12 19 15"}],["line",{x1:"2",x2:"22",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const c9=["svg",t,[["circle",{cx:"8",cy:"18",r:"4"}],["path",{d:"M12 18V2l7 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const d9=["svg",t,[["circle",{cx:"12",cy:"18",r:"4"}],["path",{d:"M16 18V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p9=["svg",t,[["path",{d:"M9 18V5l12-2v13"}],["path",{d:"m9 9 12-2"}],["circle",{cx:"6",cy:"18",r:"3"}],["circle",{cx:"18",cy:"16",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const n9=["svg",t,[["path",{d:"M9 18V5l12-2v13"}],["circle",{cx:"6",cy:"18",r:"3"}],["circle",{cx:"18",cy:"16",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const s9=["svg",t,[["path",{d:"M9.31 9.31 5 21l7-4 7 4-1.17-3.17"}],["path",{d:"M14.53 8.88 12 2l-1.17 3.17"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r9=["svg",t,[["polygon",{points:"12 2 19 21 12 17 5 21 12 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const i9=["svg",t,[["path",{d:"M8.43 8.43 3 11l8 2 2 8 2.57-5.43"}],["path",{d:"M17.39 11.73 22 2l-9.73 4.61"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const o9=["svg",t,[["polygon",{points:"3 11 22 2 13 21 11 13 3 11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l9=["svg",t,[["rect",{x:"16",y:"16",width:"6",height:"6",rx:"1"}],["rect",{x:"2",y:"16",width:"6",height:"6",rx:"1"}],["rect",{x:"9",y:"2",width:"6",height:"6",rx:"1"}],["path",{d:"M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"}],["path",{d:"M12 12V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const M9=["svg",t,[["path",{d:"M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"}],["path",{d:"M18 14h-8"}],["path",{d:"M15 18h-5"}],["path",{d:"M10 6h8v4h-8V6Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v9=["svg",t,[["path",{d:"M6 8.32a7.43 7.43 0 0 1 0 7.36"}],["path",{d:"M9.46 6.21a11.76 11.76 0 0 1 0 11.58"}],["path",{d:"M12.91 4.1a15.91 15.91 0 0 1 .01 15.8"}],["path",{d:"M16.37 2a20.16 20.16 0 0 1 0 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g9=["svg",t,[["path",{d:"M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4"}],["path",{d:"M2 6h4"}],["path",{d:"M2 10h4"}],["path",{d:"M2 14h4"}],["path",{d:"M2 18h4"}],["path",{d:"M18.4 2.6a2.17 2.17 0 0 1 3 3L16 11l-4 1 1-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const x9=["svg",t,[["path",{d:"M2 6h4"}],["path",{d:"M2 10h4"}],["path",{d:"M2 14h4"}],["path",{d:"M2 18h4"}],["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2"}],["path",{d:"M15 2v20"}],["path",{d:"M15 7h5"}],["path",{d:"M15 12h5"}],["path",{d:"M15 17h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y9=["svg",t,[["path",{d:"M2 6h4"}],["path",{d:"M2 10h4"}],["path",{d:"M2 14h4"}],["path",{d:"M2 18h4"}],["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2"}],["path",{d:"M9.5 8h5"}],["path",{d:"M9.5 12H16"}],["path",{d:"M9.5 16H14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const u9=["svg",t,[["path",{d:"M2 6h4"}],["path",{d:"M2 10h4"}],["path",{d:"M2 14h4"}],["path",{d:"M2 18h4"}],["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2"}],["path",{d:"M16 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f9=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M12 2v4"}],["path",{d:"M16 2v4"}],["path",{d:"M16 4h2a2 2 0 0 1 2 2v2"}],["path",{d:"M20 12v2"}],["path",{d:"M20 18v2a2 2 0 0 1-2 2h-1"}],["path",{d:"M13 22h-2"}],["path",{d:"M7 22H6a2 2 0 0 1-2-2v-2"}],["path",{d:"M4 14v-2"}],["path",{d:"M4 8V6a2 2 0 0 1 2-2h2"}],["path",{d:"M8 10h6"}],["path",{d:"M8 14h8"}],["path",{d:"M8 18h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m9=["svg",t,[["path",{d:"M8 2v4"}],["path",{d:"M12 2v4"}],["path",{d:"M16 2v4"}],["rect",{width:"16",height:"18",x:"4",y:"4",rx:"2"}],["path",{d:"M8 10h6"}],["path",{d:"M8 14h8"}],["path",{d:"M8 18h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w9=["svg",t,[["path",{d:"M12 4V2"}],["path",{d:"M5 10v4a7.004 7.004 0 0 0 5.277 6.787c.412.104.802.292 1.102.592L12 22l.621-.621c.3-.3.69-.488 1.102-.592a7.01 7.01 0 0 0 4.125-2.939"}],["path",{d:"M19 10v3.343"}],["path",{d:"M12 12c-1.349-.573-1.905-1.005-2.5-2-.546.902-1.048 1.353-2.5 2-1.018-.644-1.46-1.08-2-2-1.028.71-1.69.918-3 1 1.081-1.048 1.757-2.03 2-3 .194-.776.84-1.551 1.79-2.21m11.654 5.997c.887-.457 1.28-.891 1.556-1.787 1.032.916 1.683 1.157 3 1-1.297-1.036-1.758-2.03-2-3-.5-2-4-4-8-4-.74 0-1.461.068-2.15.192"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const H9=["svg",t,[["path",{d:"M12 4V2"}],["path",{d:"M5 10v4a7.004 7.004 0 0 0 5.277 6.787c.412.104.802.292 1.102.592L12 22l.621-.621c.3-.3.69-.488 1.102-.592A7.003 7.003 0 0 0 19 14v-4"}],["path",{d:"M12 4C8 4 4.5 6 4 8c-.243.97-.919 1.952-2 3 1.31-.082 1.972-.29 3-1 .54.92.982 1.356 2 2 1.452-.647 1.954-1.098 2.5-2 .595.995 1.151 1.427 2.5 2 1.31-.621 1.862-1.058 2.5-2 .629.977 1.162 1.423 2.5 2 1.209-.548 1.68-.967 2-2 1.032.916 1.683 1.157 3 1-1.297-1.036-1.758-2.03-2-3-.5-2-4-4-8-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const et=["svg",t,[["polygon",{points:"7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"}],["line",{x1:"12",x2:"12",y1:"8",y2:"12"}],["line",{x1:"12",x2:"12.01",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ct=["svg",t,[["path",{d:"M10 15V9"}],["path",{d:"M14 15V9"}],["path",{d:"M7.714 2h8.572L22 7.714v8.572L16.286 22H7.714L2 16.286V7.714z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dt=["svg",t,[["polygon",{points:"7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"}],["path",{d:"m15 9-6 6"}],["path",{d:"m9 9 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const V9=["svg",t,[["polygon",{points:"7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C9=["svg",t,[["path",{d:"M3 3h6l6 18h6"}],["path",{d:"M14 3h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A9=["svg",t,[["circle",{cx:"12",cy:"12",r:"3"}],["circle",{cx:"19",cy:"5",r:"2"}],["circle",{cx:"5",cy:"19",r:"2"}],["path",{d:"M10.4 21.9a10 10 0 0 0 9.941-15.416"}],["path",{d:"M13.5 2.1a10 10 0 0 0-9.841 15.416"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _9=["svg",t,[["path",{d:"M12 12V4a1 1 0 0 1 1-1h6.297a1 1 0 0 1 .651 1.759l-4.696 4.025"}],["path",{d:"m12 21-7.414-7.414A2 2 0 0 1 4 12.172V6.415a1.002 1.002 0 0 1 1.707-.707L20 20.009"}],["path",{d:"m12.214 3.381 8.414 14.966a1 1 0 0 1-.167 1.199l-1.168 1.163a1 1 0 0 1-.706.291H6.351a1 1 0 0 1-.625-.219L3.25 18.8a1 1 0 0 1 .631-1.781l4.165.027"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S9=["svg",t,[["path",{d:"M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"}],["path",{d:"m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"}],["path",{d:"M12 3v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L9=["svg",t,[["path",{d:"m16 16 2 2 4-4"}],["path",{d:"M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"}],["path",{d:"m7.5 4.27 9 5.15"}],["polyline",{points:"3.29 7 12 12 20.71 7"}],["line",{x1:"12",x2:"12",y1:"22",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const b9=["svg",t,[["path",{d:"M16 16h6"}],["path",{d:"M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"}],["path",{d:"m7.5 4.27 9 5.15"}],["polyline",{points:"3.29 7 12 12 20.71 7"}],["line",{x1:"12",x2:"12",y1:"22",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Z9=["svg",t,[["path",{d:"M12 22v-9"}],["path",{d:"M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"}],["path",{d:"M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"}],["path",{d:"M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const P9=["svg",t,[["path",{d:"M16 16h6"}],["path",{d:"M19 13v6"}],["path",{d:"M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"}],["path",{d:"m7.5 4.27 9 5.15"}],["polyline",{points:"3.29 7 12 12 20.71 7"}],["line",{x1:"12",x2:"12",y1:"22",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k9=["svg",t,[["path",{d:"M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"}],["path",{d:"m7.5 4.27 9 5.15"}],["polyline",{points:"3.29 7 12 12 20.71 7"}],["line",{x1:"12",x2:"12",y1:"22",y2:"12"}],["circle",{cx:"18.5",cy:"15.5",r:"2.5"}],["path",{d:"M20.27 17.27 22 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O9=["svg",t,[["path",{d:"M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"}],["path",{d:"m7.5 4.27 9 5.15"}],["polyline",{points:"3.29 7 12 12 20.71 7"}],["line",{x1:"12",x2:"12",y1:"22",y2:"12"}],["path",{d:"m17 13 5 5m-5 0 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R9=["svg",t,[["path",{d:"m7.5 4.27 9 5.15"}],["path",{d:"M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"}],["path",{d:"m3.3 7 8.7 5 8.7-5"}],["path",{d:"M12 22V12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const B9=["svg",t,[["path",{d:"m19 11-8-8-8.6 8.6a2 2 0 0 0 0 2.8l5.2 5.2c.8.8 2 .8 2.8 0L19 11Z"}],["path",{d:"m5 2 5 5"}],["path",{d:"M2 13h15"}],["path",{d:"M22 20a2 2 0 1 1-4 0c0-1.6 1.7-2.4 2-4 .3 1.6 2 2.4 2 4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const T9=["svg",t,[["rect",{width:"16",height:"6",x:"2",y:"2",rx:"2"}],["path",{d:"M10 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"}],["rect",{width:"4",height:"6",x:"8",y:"16",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E9=["svg",t,[["path",{d:"M14 19.9V16h3a2 2 0 0 0 2-2v-2H5v2c0 1.1.9 2 2 2h3v3.9a2 2 0 1 0 4 0Z"}],["path",{d:"M6 12V2h12v10"}],["path",{d:"M14 2v4"}],["path",{d:"M10 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F9=["svg",t,[["path",{d:"M18.37 2.63 14 7l-1.59-1.59a2 2 0 0 0-2.82 0L8 7l9 9 1.59-1.59a2 2 0 0 0 0-2.82L17 10l4.37-4.37a2.12 2.12 0 1 0-3-3Z"}],["path",{d:"M9 8c-2 3-4 3.5-7 4l8 10c2-1 6-5 6-7"}],["path",{d:"M14.5 17.5 4.5 15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z9=["svg",t,[["circle",{cx:"13.5",cy:"6.5",r:".5",fill:"currentColor"}],["circle",{cx:"17.5",cy:"10.5",r:".5",fill:"currentColor"}],["circle",{cx:"8.5",cy:"7.5",r:".5",fill:"currentColor"}],["circle",{cx:"6.5",cy:"12.5",r:".5",fill:"currentColor"}],["path",{d:"M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const D9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 15h18"}],["path",{d:"m15 8-3 3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M14 15h1"}],["path",{d:"M19 15h2"}],["path",{d:"M3 15h2"}],["path",{d:"M9 15h1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 15h18"}],["path",{d:"m9 10 3-3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 15h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 3v18"}],["path",{d:"m16 15-3-3 3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const st=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 14v1"}],["path",{d:"M9 19v2"}],["path",{d:"M9 3v2"}],["path",{d:"M9 9v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 3v18"}],["path",{d:"m14 9 3 3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const it=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M15 3v18"}],["path",{d:"m8 9 3 3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ot=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M15 14v1"}],["path",{d:"M15 19v2"}],["path",{d:"M15 3v2"}],["path",{d:"M15 9v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M15 3v18"}],["path",{d:"m10 15-3-3 3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M15 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const W9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9h18"}],["path",{d:"m9 16 3-3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M14 9h1"}],["path",{d:"M19 9h2"}],["path",{d:"M3 9h2"}],["path",{d:"M9 9h1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9h18"}],["path",{d:"m15 14-3 3-3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 3v18"}],["path",{d:"M9 15h12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const X9=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 15h12"}],["path",{d:"M15 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9h18"}],["path",{d:"M9 21V9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J9=["svg",t,[["path",{d:"m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Y9=["svg",t,[["path",{d:"M8 21s-4-3-4-9 4-9 4-9"}],["path",{d:"M16 3s4 3 4 9-4 9-4 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q9=["svg",t,[["path",{d:"M9 9a3 3 0 1 1 6 0"}],["path",{d:"M12 12v3"}],["path",{d:"M11 15h2"}],["path",{d:"M19 9a7 7 0 1 0-13.6 2.3C6.4 14.4 8 19 8 19h8s1.6-4.6 2.6-7.7c.3-.8.4-1.5.4-2.3"}],["path",{d:"M12 19v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tg=["svg",t,[["path",{d:"M5.8 11.3 2 22l10.7-3.79"}],["path",{d:"M4 3h.01"}],["path",{d:"M22 8h.01"}],["path",{d:"M15 2h.01"}],["path",{d:"M22 20h.01"}],["path",{d:"m22 2-2.24.75a2.9 2.9 0 0 0-1.96 3.12v0c.1.86-.57 1.63-1.45 1.63h-.38c-.86 0-1.6.6-1.76 1.44L14 10"}],["path",{d:"m22 13-.82-.33c-.86-.34-1.82.2-1.98 1.11v0c-.11.7-.72 1.22-1.43 1.22H17"}],["path",{d:"m11 2 .33.82c.34.86-.2 1.82-1.11 1.98v0C9.52 4.9 9 5.52 9 6.23V7"}],["path",{d:"M11 13c1.93 1.93 2.83 4.17 2 5-.83.83-3.07-.07-5-2-1.93-1.93-2.83-4.17-2-5 .83-.83 3.07.07 5 2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ag=["svg",t,[["rect",{x:"14",y:"4",width:"4",height:"16",rx:"1"}],["rect",{x:"6",y:"4",width:"4",height:"16",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hg=["svg",t,[["circle",{cx:"11",cy:"4",r:"2"}],["circle",{cx:"18",cy:"8",r:"2"}],["circle",{cx:"20",cy:"16",r:"2"}],["path",{d:"M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const eg=["svg",t,[["rect",{width:"14",height:"20",x:"5",y:"2",rx:"2"}],["path",{d:"M15 14h.01"}],["path",{d:"M9 6h6"}],["path",{d:"M9 10h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vt=["svg",t,[["path",{d:"M12 20h9"}],["path",{d:"M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cg=["svg",t,[["path",{d:"M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"}],["path",{d:"m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"}],["path",{d:"m2.3 2.3 7.286 7.286"}],["circle",{cx:"11",cy:"11",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gt=["svg",t,[["path",{d:"M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dg=["svg",t,[["path",{d:"M12 20h9"}],["path",{d:"M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"}],["path",{d:"m15 5 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pg=["svg",t,[["path",{d:"m15 5 4 4"}],["path",{d:"M13 7 8.7 2.7a2.41 2.41 0 0 0-3.4 0L2.7 5.3a2.41 2.41 0 0 0 0 3.4L7 13"}],["path",{d:"m8 6 2-2"}],["path",{d:"m2 22 5.5-1.5L21.17 6.83a2.82 2.82 0 0 0-4-4L3.5 16.5Z"}],["path",{d:"m18 16 2-2"}],["path",{d:"m17 11 4.3 4.3c.94.94.94 2.46 0 3.4l-2.6 2.6c-.94.94-2.46.94-3.4 0L11 17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ng=["svg",t,[["path",{d:"M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"}],["path",{d:"m15 5 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sg=["svg",t,[["path",{d:"M3.5 8.7c-.7.5-1 1.4-.7 2.2l2.8 8.7c.3.8 1 1.4 1.9 1.4h9.1c.9 0 1.6-.6 1.9-1.4l2.8-8.7c.3-.8 0-1.7-.7-2.2l-7.4-5.3a2.1 2.1 0 0 0-2.4 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rg=["svg",t,[["line",{x1:"19",x2:"5",y1:"5",y2:"19"}],["circle",{cx:"6.5",cy:"6.5",r:"2.5"}],["circle",{cx:"17.5",cy:"17.5",r:"2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ig=["svg",t,[["circle",{cx:"12",cy:"5",r:"1"}],["path",{d:"m9 20 3-6 3 6"}],["path",{d:"m6 8 6 2 6-2"}],["path",{d:"M12 10v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const og=["svg",t,[["path",{d:"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"}],["path",{d:"M14.05 2a9 9 0 0 1 8 7.94"}],["path",{d:"M14.05 6A5 5 0 0 1 18 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lg=["svg",t,[["polyline",{points:"18 2 22 6 18 10"}],["line",{x1:"14",x2:"22",y1:"6",y2:"6"}],["path",{d:"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mg=["svg",t,[["polyline",{points:"16 2 16 8 22 8"}],["line",{x1:"22",x2:"16",y1:"2",y2:"8"}],["path",{d:"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vg=["svg",t,[["line",{x1:"22",x2:"16",y1:"2",y2:"8"}],["line",{x1:"16",x2:"22",y1:"2",y2:"8"}],["path",{d:"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gg=["svg",t,[["path",{d:"M10.68 13.31a16 16 0 0 0 3.41 2.6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.42 19.42 0 0 1-3.33-2.67m-2.67-3.34a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91"}],["line",{x1:"22",x2:"2",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xg=["svg",t,[["polyline",{points:"22 8 22 2 16 2"}],["line",{x1:"16",x2:"22",y1:"8",y2:"2"}],["path",{d:"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yg=["svg",t,[["path",{d:"M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ug=["svg",t,[["line",{x1:"9",x2:"9",y1:"4",y2:"20"}],["path",{d:"M4 7c0-1.7 1.3-3 3-3h13"}],["path",{d:"M18 20c-1.7 0-3-1.3-3-3V4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fg=["svg",t,[["path",{d:"M18.5 8c-1.4 0-2.6-.8-3.2-2A6.87 6.87 0 0 0 2 9v11a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-8.5C22 9.6 20.4 8 18.5 8"}],["path",{d:"M2 14h20"}],["path",{d:"M6 14v4"}],["path",{d:"M10 14v4"}],["path",{d:"M14 14v4"}],["path",{d:"M18 14v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mg=["svg",t,[["path",{d:"M14.531 12.469 6.619 20.38a1 1 0 1 1-3-3l7.912-7.912"}],["path",{d:"M15.686 4.314A12.5 12.5 0 0 0 5.461 2.958 1 1 0 0 0 5.58 4.71a22 22 0 0 1 6.318 3.393"}],["path",{d:"M17.7 3.7a1 1 0 0 0-1.4 0l-4.6 4.6a1 1 0 0 0 0 1.4l2.6 2.6a1 1 0 0 0 1.4 0l4.6-4.6a1 1 0 0 0 0-1.4z"}],["path",{d:"M19.686 8.314a12.501 12.501 0 0 1 1.356 10.225 1 1 0 0 1-1.751-.119 22 22 0 0 0-3.393-6.319"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wg=["svg",t,[["path",{d:"M21 9V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h4"}],["rect",{width:"10",height:"7",x:"12",y:"13",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hg=["svg",t,[["path",{d:"M8 4.5v5H3m-1-6 6 6m13 0v-3c0-1.16-.84-2-2-2h-7m-9 9v2c0 1.05.95 2 2 2h3"}],["rect",{width:"10",height:"7",x:"12",y:"13.5",ry:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vg=["svg",t,[["path",{d:"M21.21 15.89A10 10 0 1 1 8 2.83"}],["path",{d:"M22 12A10 10 0 0 0 12 2v10z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cg=["svg",t,[["path",{d:"M19 5c-1.5 0-2.8 1.4-3 2-3.5-1.5-11-.3-11 5 0 1.8 0 3 2 4.5V20h4v-2h3v2h4v-4c1-.5 1.7-1 2-2h2v-4h-2c0-1-.5-1.5-1-2h0V5z"}],["path",{d:"M2 9v1c0 1.1.9 2 2 2h1"}],["path",{d:"M16 11h0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ag=["svg",t,[["path",{d:"M14 3v11"}],["path",{d:"M14 9h-3a3 3 0 0 1 0-6h9"}],["path",{d:"M18 3v11"}],["path",{d:"M22 18H2l4-4"}],["path",{d:"m6 22-4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _g=["svg",t,[["path",{d:"M10 3v11"}],["path",{d:"M10 9H7a1 1 0 0 1 0-6h8"}],["path",{d:"M14 3v11"}],["path",{d:"m18 14 4 4H2"}],["path",{d:"m22 18-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sg=["svg",t,[["path",{d:"M13 4v16"}],["path",{d:"M17 4v16"}],["path",{d:"M19 4H9.5a4.5 4.5 0 0 0 0 9H13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lg=["svg",t,[["path",{d:"m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"}],["path",{d:"m8.5 8.5 7 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bg=["svg",t,[["line",{x1:"2",x2:"22",y1:"2",y2:"22"}],["line",{x1:"12",x2:"12",y1:"17",y2:"22"}],["path",{d:"M9 9v1.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24V17h12"}],["path",{d:"M15 9.34V6h1a2 2 0 0 0 0-4H7.89"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zg=["svg",t,[["line",{x1:"12",x2:"12",y1:"17",y2:"22"}],["path",{d:"M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pg=["svg",t,[["path",{d:"m2 22 1-1h3l9-9"}],["path",{d:"M3 21v-3l9-9"}],["path",{d:"m15 6 3.4-3.4a2.1 2.1 0 1 1 3 3L18 9l.4.4a2.1 2.1 0 1 1-3 3l-3.8-3.8a2.1 2.1 0 1 1 3-3l.4.4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kg=["svg",t,[["path",{d:"M15 11h.01"}],["path",{d:"M11 15h.01"}],["path",{d:"M16 16h.01"}],["path",{d:"m2 16 20 6-6-20A20 20 0 0 0 2 16"}],["path",{d:"M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Og=["svg",t,[["path",{d:"M2 22h20"}],["path",{d:"M3.77 10.77 2 9l2-4.5 1.1.55c.55.28.9.84.9 1.45s.35 1.17.9 1.45L8 8.5l3-6 1.05.53a2 2 0 0 1 1.09 1.52l.72 5.4a2 2 0 0 0 1.09 1.52l4.4 2.2c.42.22.78.55 1.01.96l.6 1.03c.49.88-.06 1.98-1.06 2.1l-1.18.15c-.47.06-.95-.02-1.37-.24L4.29 11.15a2 2 0 0 1-.52-.38Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rg=["svg",t,[["path",{d:"M2 22h20"}],["path",{d:"M6.36 17.4 4 17l-2-4 1.1-.55a2 2 0 0 1 1.8 0l.17.1a2 2 0 0 0 1.8 0L8 12 5 6l.9-.45a2 2 0 0 1 2.09.2l4.02 3a2 2 0 0 0 2.1.2l4.19-2.06a2.41 2.41 0 0 1 1.73-.17L21 7a1.4 1.4 0 0 1 .87 1.99l-.38.76c-.23.46-.6.84-1.07 1.08L7.58 17.2a2 2 0 0 1-1.22.18Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bg=["svg",t,[["path",{d:"M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tg=["svg",t,[["polygon",{points:"6 3 20 12 6 21 6 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Eg=["svg",t,[["path",{d:"M9 2v6"}],["path",{d:"M15 2v6"}],["path",{d:"M12 17v5"}],["path",{d:"M5 8h14"}],["path",{d:"M6 11V8h12v3a6 6 0 1 1-12 0v0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fg=["svg",t,[["path",{d:"m13 2-2 2.5h3L12 7"}],["path",{d:"M10 14v-3"}],["path",{d:"M14 14v-3"}],["path",{d:"M11 19c-1.7 0-3-1.3-3-3v-2h8v2c0 1.7-1.3 3-3 3Z"}],["path",{d:"M12 22v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zg=["svg",t,[["path",{d:"M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z"}],["path",{d:"m2 22 3-3"}],["path",{d:"M7.5 13.5 10 11"}],["path",{d:"M10.5 16.5 13 14"}],["path",{d:"m18 3-4 4h6l-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dg=["svg",t,[["path",{d:"M12 22v-5"}],["path",{d:"M9 8V2"}],["path",{d:"M15 8V2"}],["path",{d:"M18 8v5a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4V8Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qg=["svg",t,[["path",{d:"M5 12h14"}],["path",{d:"M12 5v14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ug=["svg",t,[["path",{d:"M3 2v1c0 1 2 1 2 2S3 6 3 7s2 1 2 2-2 1-2 2 2 1 2 2"}],["path",{d:"M18 6h.01"}],["path",{d:"M6 18h.01"}],["path",{d:"M20.83 8.83a4 4 0 0 0-5.66-5.66l-12 12a4 4 0 1 0 5.66 5.66Z"}],["path",{d:"M18 11.66V22a4 4 0 0 0 4-4V6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ig=["svg",t,[["path",{d:"M4 3h16a2 2 0 0 1 2 2v6a10 10 0 0 1-10 10A10 10 0 0 1 2 11V5a2 2 0 0 1 2-2z"}],["polyline",{points:"8 10 12 14 16 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ng=["svg",t,[["path",{d:"M16.85 18.58a9 9 0 1 0-9.7 0"}],["path",{d:"M8 14a5 5 0 1 1 8 0"}],["circle",{cx:"12",cy:"11",r:"1"}],["path",{d:"M13 17a1 1 0 1 0-2 0l.5 4.5a.5.5 0 1 0 1 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $g=["svg",t,[["path",{d:"M10 4.5V4a2 2 0 0 0-2.41-1.957"}],["path",{d:"M13.9 8.4a2 2 0 0 0-1.26-1.295"}],["path",{d:"M21.7 16.2A8 8 0 0 0 22 14v-3a2 2 0 1 0-4 0v-1a2 2 0 0 0-3.63-1.158"}],["path",{d:"m7 15-1.8-1.8a2 2 0 0 0-2.79 2.86L6 19.7a7.74 7.74 0 0 0 6 2.3h2a8 8 0 0 0 5.657-2.343"}],["path",{d:"M6 6v8"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wg=["svg",t,[["path",{d:"M22 14a8 8 0 0 1-8 8"}],["path",{d:"M18 11v-1a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"}],["path",{d:"M14 10V9a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v1"}],["path",{d:"M10 9.5V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v10"}],["path",{d:"M18 11a2 2 0 1 1 4 0v3a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jg=["svg",t,[["path",{d:"M18 8a2 2 0 0 0 0-4 2 2 0 0 0-4 0 2 2 0 0 0-4 0 2 2 0 0 0-4 0 2 2 0 0 0 0 4"}],["path",{d:"M10 22 9 8"}],["path",{d:"m14 22 1-14"}],["path",{d:"M20 8c.5 0 .9.4.8 1l-2.6 12c-.1.5-.7 1-1.2 1H7c-.6 0-1.1-.4-1.2-1L3.2 9c-.1-.6.3-1 .8-1Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gg=["svg",t,[["path",{d:"M18.6 14.4c.8-.8.8-2 0-2.8l-8.1-8.1a4.95 4.95 0 1 0-7.1 7.1l8.1 8.1c.9.7 2.1.7 2.9-.1Z"}],["path",{d:"m22 22-5.5-5.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kg=["svg",t,[["path",{d:"M18 7c0-5.333-8-5.333-8 0"}],["path",{d:"M10 7v14"}],["path",{d:"M6 21h12"}],["path",{d:"M6 13h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xg=["svg",t,[["path",{d:"M18.36 6.64A9 9 0 0 1 20.77 15"}],["path",{d:"M6.16 6.16a9 9 0 1 0 12.68 12.68"}],["path",{d:"M12 2v4"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jg=["svg",t,[["path",{d:"M12 2v10"}],["path",{d:"M18.4 6.6a9 9 0 1 1-12.77.04"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yg=["svg",t,[["path",{d:"M2 3h20"}],["path",{d:"M21 3v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V3"}],["path",{d:"m7 21 5-5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qg=["svg",t,[["path",{d:"M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"}],["path",{d:"M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"}],["rect",{x:"6",y:"14",width:"12",height:"8",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tx=["svg",t,[["path",{d:"M5 7 3 5"}],["path",{d:"M9 6V3"}],["path",{d:"m13 7 2-2"}],["circle",{cx:"9",cy:"13",r:"3"}],["path",{d:"M11.83 12H20a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h2.17"}],["path",{d:"M16 16h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ax=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"M12 9v11"}],["path",{d:"M2 9h13a2 2 0 0 1 2 2v9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hx=["svg",t,[["path",{d:"M19.439 7.85c-.049.322.059.648.289.878l1.568 1.568c.47.47.706 1.087.706 1.704s-.235 1.233-.706 1.704l-1.611 1.611a.98.98 0 0 1-.837.276c-.47-.07-.802-.48-.968-.925a2.501 2.501 0 1 0-3.214 3.214c.446.166.855.497.925.968a.979.979 0 0 1-.276.837l-1.61 1.61a2.404 2.404 0 0 1-1.705.707 2.402 2.402 0 0 1-1.704-.706l-1.568-1.568a1.026 1.026 0 0 0-.877-.29c-.493.074-.84.504-1.02.968a2.5 2.5 0 1 1-3.237-3.237c.464-.18.894-.527.967-1.02a1.026 1.026 0 0 0-.289-.877l-1.568-1.568A2.402 2.402 0 0 1 1.998 12c0-.617.236-1.234.706-1.704L4.23 8.77c.24-.24.581-.353.917-.303.515.077.877.528 1.073 1.01a2.5 2.5 0 1 0 3.259-3.259c-.482-.196-.933-.558-1.01-1.073-.05-.336.062-.676.303-.917l1.525-1.525A2.402 2.402 0 0 1 12 1.998c.617 0 1.234.236 1.704.706l1.568 1.568c.23.23.556.338.877.29.493-.074.84-.504 1.02-.968a2.5 2.5 0 1 1 3.237 3.237c-.464.18-.894.527-.967 1.02Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ex=["svg",t,[["path",{d:"M2.5 16.88a1 1 0 0 1-.32-1.43l9-13.02a1 1 0 0 1 1.64 0l9 13.01a1 1 0 0 1-.32 1.44l-8.51 4.86a2 2 0 0 1-1.98 0Z"}],["path",{d:"M12 2v20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cx=["svg",t,[["rect",{width:"5",height:"5",x:"3",y:"3",rx:"1"}],["rect",{width:"5",height:"5",x:"16",y:"3",rx:"1"}],["rect",{width:"5",height:"5",x:"3",y:"16",rx:"1"}],["path",{d:"M21 16h-3a2 2 0 0 0-2 2v3"}],["path",{d:"M21 21v.01"}],["path",{d:"M12 7v3a2 2 0 0 1-2 2H7"}],["path",{d:"M3 12h.01"}],["path",{d:"M12 3h.01"}],["path",{d:"M12 16v.01"}],["path",{d:"M16 12h1"}],["path",{d:"M21 12v.01"}],["path",{d:"M12 21v-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dx=["svg",t,[["path",{d:"M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"}],["path",{d:"M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const px=["svg",t,[["path",{d:"M13 16a3 3 0 0 1 2.24 5"}],["path",{d:"M18 12h.01"}],["path",{d:"M18 21h-8a4 4 0 0 1-4-4 7 7 0 0 1 7-7h.2L9.6 6.4a1 1 0 1 1 2.8-2.8L15.8 7h.2c3.3 0 6 2.7 6 6v1a2 2 0 0 1-2 2h-1a3 3 0 0 0-3 3"}],["path",{d:"M20 8.54V4a2 2 0 1 0-4 0v3"}],["path",{d:"M7.612 12.524a3 3 0 1 0-1.6 4.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nx=["svg",t,[["path",{d:"M19.07 4.93A10 10 0 0 0 6.99 3.34"}],["path",{d:"M4 6h.01"}],["path",{d:"M2.29 9.62A10 10 0 1 0 21.31 8.35"}],["path",{d:"M16.24 7.76A6 6 0 1 0 8.23 16.67"}],["path",{d:"M12 18h.01"}],["path",{d:"M17.99 11.66A6 6 0 0 1 15.77 16.67"}],["circle",{cx:"12",cy:"12",r:"2"}],["path",{d:"m13.41 10.59 5.66-5.66"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sx=["svg",t,[["path",{d:"M12 12h0.01"}],["path",{d:"M7.5 4.2c-.3-.5-.9-.7-1.3-.4C3.9 5.5 2.3 8.1 2 11c-.1.5.4 1 1 1h5c0-1.5.8-2.8 2-3.4-1.1-1.9-2-3.5-2.5-4.4z"}],["path",{d:"M21 12c.6 0 1-.4 1-1-.3-2.9-1.8-5.5-4.1-7.1-.4-.3-1.1-.2-1.3.3-.6.9-1.5 2.5-2.6 4.3 1.2.7 2 2 2 3.5h5z"}],["path",{d:"M7.5 19.8c-.3.5-.1 1.1.4 1.3 2.6 1.2 5.6 1.2 8.2 0 .5-.2.7-.8.4-1.3-.5-.9-1.4-2.5-2.5-4.3-1.2.7-2.8.7-4 0-1.1 1.8-2 3.4-2.5 4.3z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rx=["svg",t,[["path",{d:"M3 12h4l3 9 4-17h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ix=["svg",t,[["path",{d:"M5 16v2"}],["path",{d:"M19 16v2"}],["rect",{width:"20",height:"8",x:"2",y:"8",rx:"2"}],["path",{d:"M18 12h0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ox=["svg",t,[["path",{d:"M4.9 16.1C1 12.2 1 5.8 4.9 1.9"}],["path",{d:"M7.8 4.7a6.14 6.14 0 0 0-.8 7.5"}],["circle",{cx:"12",cy:"9",r:"2"}],["path",{d:"M16.2 4.8c2 2 2.26 5.11.8 7.47"}],["path",{d:"M19.1 1.9a9.96 9.96 0 0 1 0 14.1"}],["path",{d:"M9.5 18h5"}],["path",{d:"m8 22 4-11 4 11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lx=["svg",t,[["path",{d:"M4.9 19.1C1 15.2 1 8.8 4.9 4.9"}],["path",{d:"M7.8 16.2c-2.3-2.3-2.3-6.1 0-8.5"}],["circle",{cx:"12",cy:"12",r:"2"}],["path",{d:"M16.2 7.8c2.3 2.3 2.3 6.1 0 8.5"}],["path",{d:"M19.1 4.9C23 8.8 23 15.1 19.1 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mx=["svg",t,[["path",{d:"M20.34 17.52a10 10 0 1 0-2.82 2.82"}],["circle",{cx:"19",cy:"19",r:"2"}],["path",{d:"m13.41 13.41 4.18 4.18"}],["circle",{cx:"12",cy:"12",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vx=["svg",t,[["path",{d:"M5 15h14"}],["path",{d:"M5 9h14"}],["path",{d:"m14 20-5-5 6-6-5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gx=["svg",t,[["path",{d:"M22 17a10 10 0 0 0-20 0"}],["path",{d:"M6 17a6 6 0 0 1 12 0"}],["path",{d:"M10 17a2 2 0 0 1 4 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xx=["svg",t,[["path",{d:"M17 5c0-1.7-1.3-3-3-3s-3 1.3-3 3c0 .8.3 1.5.8 2H11c-3.9 0-7 3.1-7 7v0c0 2.2 1.8 4 4 4"}],["path",{d:"M16.8 3.9c.3-.3.6-.5 1-.7 1.5-.6 3.3.1 3.9 1.6.6 1.5-.1 3.3-1.6 3.9l1.6 2.8c.2.3.2.7.2 1-.2.8-.9 1.2-1.7 1.1 0 0-1.6-.3-2.7-.6H17c-1.7 0-3 1.3-3 3"}],["path",{d:"M13.2 18a3 3 0 0 0-2.2-5"}],["path",{d:"M13 22H4a2 2 0 0 1 0-4h12"}],["path",{d:"M16 9h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yx=["svg",t,[["rect",{width:"12",height:"20",x:"6",y:"2",rx:"2"}],["rect",{width:"20",height:"12",x:"2",y:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ux=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M12 6.5v11"}],["path",{d:"M15 9.4a4 4 0 1 0 0 5.2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fx=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M8 12h5"}],["path",{d:"M16 9.5a4 4 0 1 0 0 5.2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mx=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M8 7h8"}],["path",{d:"M12 17.5 8 15h1a4 4 0 0 0 0-8"}],["path",{d:"M8 11h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wx=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"m12 10 3-3"}],["path",{d:"m9 7 3 3v7.5"}],["path",{d:"M9 11h6"}],["path",{d:"M9 15h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hx=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M8 13h5"}],["path",{d:"M10 17V9.5a2.5 2.5 0 0 1 5 0"}],["path",{d:"M8 17h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vx=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M8 15h5"}],["path",{d:"M8 11h5a2 2 0 1 0 0-4h-3v10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cx=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M10 17V7h5"}],["path",{d:"M10 11h4"}],["path",{d:"M8 15h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ax=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M14 8H8"}],["path",{d:"M16 12H8"}],["path",{d:"M13 16H8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _x=["svg",t,[["path",{d:"M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"}],["path",{d:"M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"}],["path",{d:"M12 17.5v-11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xt=["svg",t,[["rect",{width:"20",height:"12",x:"2",y:"6",rx:"2"}],["path",{d:"M12 12h.01"}],["path",{d:"M17 12h.01"}],["path",{d:"M7 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sx=["svg",t,[["rect",{width:"20",height:"12",x:"2",y:"6",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lx=["svg",t,[["rect",{width:"12",height:"20",x:"6",y:"2",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bx=["svg",t,[["path",{d:"M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"}],["path",{d:"M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"}],["path",{d:"m14 16-3 3 3 3"}],["path",{d:"M8.293 13.596 7.196 9.5 3.1 10.598"}],["path",{d:"m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843"}],["path",{d:"m13.378 9.633 4.096 1.098 1.097-4.096"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zx=["svg",t,[["path",{d:"m15 14 5-5-5-5"}],["path",{d:"M20 9H9.5A5.5 5.5 0 0 0 4 14.5v0A5.5 5.5 0 0 0 9.5 20H13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Px=["svg",t,[["circle",{cx:"12",cy:"17",r:"1"}],["path",{d:"M21 7v6h-6"}],["path",{d:"M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kx=["svg",t,[["path",{d:"M21 7v6h-6"}],["path",{d:"M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ox=["svg",t,[["path",{d:"M3 2v6h6"}],["path",{d:"M21 12A9 9 0 0 0 6 5.3L3 8"}],["path",{d:"M21 22v-6h-6"}],["path",{d:"M3 12a9 9 0 0 0 15 6.7l3-2.7"}],["circle",{cx:"12",cy:"12",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rx=["svg",t,[["path",{d:"M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"}],["path",{d:"M3 3v5h5"}],["path",{d:"M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"}],["path",{d:"M16 16h5v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bx=["svg",t,[["path",{d:"M21 8L18.74 5.74A9.75 9.75 0 0 0 12 3C11 3 10.03 3.16 9.13 3.47"}],["path",{d:"M8 16H3v5"}],["path",{d:"M3 12C3 9.51 4 7.26 5.64 5.64"}],["path",{d:"m3 16 2.26 2.26A9.75 9.75 0 0 0 12 21c2.49 0 4.74-1 6.36-2.64"}],["path",{d:"M21 12c0 1-.16 1.97-.47 2.87"}],["path",{d:"M21 3v5h-5"}],["path",{d:"M22 22 2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tx=["svg",t,[["path",{d:"M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"}],["path",{d:"M21 3v5h-5"}],["path",{d:"M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"}],["path",{d:"M8 16H3v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ex=["svg",t,[["path",{d:"M5 6a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6Z"}],["path",{d:"M5 10h14"}],["path",{d:"M15 7v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fx=["svg",t,[["path",{d:"M17 3v10"}],["path",{d:"m12.67 5.5 8.66 5"}],["path",{d:"m12.67 10.5 8.66-5"}],["path",{d:"M9 17a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zx=["svg",t,[["path",{d:"M4 7V4h16v3"}],["path",{d:"M5 20h6"}],["path",{d:"M13 4 8 20"}],["path",{d:"m15 15 5 5"}],["path",{d:"m20 15-5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dx=["svg",t,[["path",{d:"m17 2 4 4-4 4"}],["path",{d:"M3 11v-1a4 4 0 0 1 4-4h14"}],["path",{d:"m7 22-4-4 4-4"}],["path",{d:"M21 13v1a4 4 0 0 1-4 4H3"}],["path",{d:"M11 10h1v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qx=["svg",t,[["path",{d:"m2 9 3-3 3 3"}],["path",{d:"M13 18H7a2 2 0 0 1-2-2V6"}],["path",{d:"m22 15-3 3-3-3"}],["path",{d:"M11 6h6a2 2 0 0 1 2 2v10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ux=["svg",t,[["path",{d:"m17 2 4 4-4 4"}],["path",{d:"M3 11v-1a4 4 0 0 1 4-4h14"}],["path",{d:"m7 22-4-4 4-4"}],["path",{d:"M21 13v1a4 4 0 0 1-4 4H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ix=["svg",t,[["path",{d:"M14 4c0-1.1.9-2 2-2"}],["path",{d:"M20 2c1.1 0 2 .9 2 2"}],["path",{d:"M22 8c0 1.1-.9 2-2 2"}],["path",{d:"M16 10c-1.1 0-2-.9-2-2"}],["path",{d:"m3 7 3 3 3-3"}],["path",{d:"M6 10V5c0-1.7 1.3-3 3-3h1"}],["rect",{width:"8",height:"8",x:"2",y:"14",rx:"2"}],["path",{d:"M14 14c1.1 0 2 .9 2 2v4c0 1.1-.9 2-2 2"}],["path",{d:"M20 14c1.1 0 2 .9 2 2v4c0 1.1-.9 2-2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nx=["svg",t,[["path",{d:"M14 4c0-1.1.9-2 2-2"}],["path",{d:"M20 2c1.1 0 2 .9 2 2"}],["path",{d:"M22 8c0 1.1-.9 2-2 2"}],["path",{d:"M16 10c-1.1 0-2-.9-2-2"}],["path",{d:"m3 7 3 3 3-3"}],["path",{d:"M6 10V5c0-1.7 1.3-3 3-3h1"}],["rect",{width:"8",height:"8",x:"2",y:"14",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $x=["svg",t,[["polyline",{points:"7 17 2 12 7 7"}],["polyline",{points:"12 17 7 12 12 7"}],["path",{d:"M22 18v-2a4 4 0 0 0-4-4H7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wx=["svg",t,[["polyline",{points:"9 17 4 12 9 7"}],["path",{d:"M20 18v-2a4 4 0 0 0-4-4H4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jx=["svg",t,[["polygon",{points:"11 19 2 12 11 5 11 19"}],["polygon",{points:"22 19 13 12 22 5 22 19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gx=["svg",t,[["path",{d:"M17.75 9.01c-.52 2.08-1.83 3.64-3.18 5.49l-2.6 3.54-2.97 4-3.5-2.54 3.85-4.97c-1.86-2.61-2.8-3.77-3.16-5.44"}],["path",{d:"M17.75 9.01A7 7 0 0 0 6.2 9.1C6.06 8.5 6 7.82 6 7c0-3.5 2.83-5 5.98-5C15.24 2 18 3.5 18 7c0 .73-.09 1.4-.25 2.01Z"}],["path",{d:"m9.35 14.53 2.64-3.31"}],["path",{d:"m11.97 18.04 2.99 4 3.54-2.54-3.93-5"}],["path",{d:"M14 8c0 1-1 2-2.01 3.22C11 10 10 9 10 8a2 2 0 1 1 4 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kx=["svg",t,[["path",{d:"M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"}],["path",{d:"m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"}],["path",{d:"M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"}],["path",{d:"M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xx=["svg",t,[["polyline",{points:"3.5 2 6.5 12.5 18 12.5"}],["line",{x1:"9.5",x2:"5.5",y1:"12.5",y2:"20"}],["line",{x1:"15",x2:"18.5",y1:"12.5",y2:"20"}],["path",{d:"M2.75 18a13 13 0 0 0 18.5 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jx=["svg",t,[["path",{d:"M6 19V5"}],["path",{d:"M10 19V6.8"}],["path",{d:"M14 19v-7.8"}],["path",{d:"M18 5v4"}],["path",{d:"M18 19v-6"}],["path",{d:"M22 19V9"}],["path",{d:"M2 19V9a4 4 0 0 1 4-4c2 0 4 1.33 6 4s4 4 6 4a4 4 0 1 0-3-6.65"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yt=["svg",t,[["path",{d:"M16.466 7.5C15.643 4.237 13.952 2 12 2 9.239 2 7 6.477 7 12s2.239 10 5 10c.342 0 .677-.069 1-.2"}],["path",{d:"m15.194 13.707 3.814 1.86-1.86 3.814"}],["path",{d:"M19 15.57c-1.804.885-4.274 1.43-7 1.43-5.523 0-10-2.239-10-5s4.477-5 10-5c4.838 0 8.873 1.718 9.8 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yx=["svg",t,[["path",{d:"M20 9V7a2 2 0 0 0-2-2h-6"}],["path",{d:"m15 2-3 3 3 3"}],["path",{d:"M20 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qx=["svg",t,[["path",{d:"M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"}],["path",{d:"M3 3v5h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ty=["svg",t,[["path",{d:"M12 5H6a2 2 0 0 0-2 2v3"}],["path",{d:"m9 8 3-3-3-3"}],["path",{d:"M4 14v4a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ay=["svg",t,[["path",{d:"M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"}],["path",{d:"M21 3v5h-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hy=["svg",t,[["circle",{cx:"6",cy:"19",r:"3"}],["path",{d:"M9 19h8.5c.4 0 .9-.1 1.3-.2"}],["path",{d:"M5.2 5.2A3.5 3.53 0 0 0 6.5 12H12"}],["path",{d:"m2 2 20 20"}],["path",{d:"M21 15.3a3.5 3.5 0 0 0-3.3-3.3"}],["path",{d:"M15 5h-4.3"}],["circle",{cx:"18",cy:"5",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ey=["svg",t,[["circle",{cx:"6",cy:"19",r:"3"}],["path",{d:"M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"}],["circle",{cx:"18",cy:"5",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cy=["svg",t,[["rect",{width:"20",height:"8",x:"2",y:"14",rx:"2"}],["path",{d:"M6.01 18H6"}],["path",{d:"M10.01 18H10"}],["path",{d:"M15 10v4"}],["path",{d:"M17.84 7.17a4 4 0 0 0-5.66 0"}],["path",{d:"M20.66 4.34a8 8 0 0 0-11.31 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ut=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 12h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ft=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M21 9H3"}],["path",{d:"M21 15H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dy=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M21 7.5H3"}],["path",{d:"M21 12H3"}],["path",{d:"M21 16.5H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const py=["svg",t,[["path",{d:"M4 11a9 9 0 0 1 9 9"}],["path",{d:"M4 4a16 16 0 0 1 16 16"}],["circle",{cx:"5",cy:"19",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ny=["svg",t,[["path",{d:"M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"}],["path",{d:"m14.5 12.5 2-2"}],["path",{d:"m11.5 9.5 2-2"}],["path",{d:"m8.5 6.5 2-2"}],["path",{d:"m17.5 15.5 2-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sy=["svg",t,[["path",{d:"M6 11h8a4 4 0 0 0 0-8H9v18"}],["path",{d:"M6 15h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ry=["svg",t,[["path",{d:"M22 18H2a4 4 0 0 0 4 4h12a4 4 0 0 0 4-4Z"}],["path",{d:"M21 14 10 2 3 14h18Z"}],["path",{d:"M10 2v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const iy=["svg",t,[["path",{d:"M7 21h10"}],["path",{d:"M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"}],["path",{d:"M11.38 12a2.4 2.4 0 0 1-.4-4.77 2.4 2.4 0 0 1 3.2-2.77 2.4 2.4 0 0 1 3.47-.63 2.4 2.4 0 0 1 3.37 3.37 2.4 2.4 0 0 1-1.1 3.7 2.51 2.51 0 0 1 .03 1.1"}],["path",{d:"m13 12 4-4"}],["path",{d:"M10.9 7.25A3.99 3.99 0 0 0 4 10c0 .73.2 1.41.54 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const oy=["svg",t,[["path",{d:"M3 11v3a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-3"}],["path",{d:"M12 19H4a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-3.83"}],["path",{d:"m3 11 7.77-6.04a2 2 0 0 1 2.46 0L21 11H3Z"}],["path",{d:"M12.97 19.77 7 15h12.5l-3.75 4.5a2 2 0 0 1-2.78.27Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ly=["svg",t,[["path",{d:"M4 10a7.31 7.31 0 0 0 10 10Z"}],["path",{d:"m9 15 3-3"}],["path",{d:"M17 13a6 6 0 0 0-6-6"}],["path",{d:"M21 13A10 10 0 0 0 11 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const My=["svg",t,[["path",{d:"M13 7 9 3 5 7l4 4"}],["path",{d:"m17 11 4 4-4 4-4-4"}],["path",{d:"m8 12 4 4 6-6-4-4Z"}],["path",{d:"m16 8 3-3"}],["path",{d:"M9 21a6 6 0 0 0-6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vy=["svg",t,[["path",{d:"M10 2v3a1 1 0 0 0 1 1h5"}],["path",{d:"M18 18v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6"}],["path",{d:"M18 22H4a2 2 0 0 1-2-2V6"}],["path",{d:"M8 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9.172a2 2 0 0 1 1.414.586l2.828 2.828A2 2 0 0 1 22 6.828V16a2 2 0 0 1-2.01 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gy=["svg",t,[["path",{d:"M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"}],["path",{d:"M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"}],["path",{d:"M7 3v4a1 1 0 0 0 1 1h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mt=["svg",t,[["circle",{cx:"19",cy:"19",r:"2"}],["circle",{cx:"5",cy:"5",r:"2"}],["path",{d:"M5 7v12h12"}],["path",{d:"m5 19 6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xy=["svg",t,[["path",{d:"m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"}],["path",{d:"m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"}],["path",{d:"M7 21h10"}],["path",{d:"M12 3v18"}],["path",{d:"M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yy=["svg",t,[["path",{d:"M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"}],["path",{d:"M14 15H9v-5"}],["path",{d:"M16 3h5v5"}],["path",{d:"M21 3 9 15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uy=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["path",{d:"M8 7v10"}],["path",{d:"M12 7v10"}],["path",{d:"M17 7v10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fy=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["circle",{cx:"12",cy:"12",r:"1"}],["path",{d:"M5 12s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const my=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["path",{d:"M8 14s1.5 2 4 2 4-2 4-2"}],["path",{d:"M9 9h.01"}],["path",{d:"M15 9h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wy=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["path",{d:"M7 12h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hy=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"m16 16-1.9-1.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vy=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}],["path",{d:"M7 8h8"}],["path",{d:"M7 12h10"}],["path",{d:"M7 16h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cy=["svg",t,[["path",{d:"M3 7V5a2 2 0 0 1 2-2h2"}],["path",{d:"M17 3h2a2 2 0 0 1 2 2v2"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2h-2"}],["path",{d:"M7 21H5a2 2 0 0 1-2-2v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ay=["svg",t,[["circle",{cx:"7.5",cy:"7.5",r:".5",fill:"currentColor"}],["circle",{cx:"18.5",cy:"5.5",r:".5",fill:"currentColor"}],["circle",{cx:"11.5",cy:"11.5",r:".5",fill:"currentColor"}],["circle",{cx:"7.5",cy:"16.5",r:".5",fill:"currentColor"}],["circle",{cx:"17.5",cy:"14.5",r:".5",fill:"currentColor"}],["path",{d:"M3 3v18h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _y=["svg",t,[["path",{d:"M14 22v-4a2 2 0 1 0-4 0v4"}],["path",{d:"m18 10 4 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8l4-2"}],["path",{d:"M18 5v17"}],["path",{d:"m4 6 8-4 8 4"}],["path",{d:"M6 5v17"}],["circle",{cx:"12",cy:"9",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sy=["svg",t,[["path",{d:"M5.42 9.42 8 12"}],["circle",{cx:"4",cy:"8",r:"2"}],["path",{d:"m14 6-8.58 8.58"}],["circle",{cx:"4",cy:"16",r:"2"}],["path",{d:"M10.8 14.8 14 18"}],["path",{d:"M16 12h-2"}],["path",{d:"M22 12h-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ly=["svg",t,[["circle",{cx:"6",cy:"6",r:"3"}],["path",{d:"M8.12 8.12 12 12"}],["path",{d:"M20 4 8.12 15.88"}],["circle",{cx:"6",cy:"18",r:"3"}],["path",{d:"M14.8 14.8 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const by=["svg",t,[["path",{d:"M13 3H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-3"}],["path",{d:"M8 21h8"}],["path",{d:"M12 17v4"}],["path",{d:"m22 3-5 5"}],["path",{d:"m17 3 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zy=["svg",t,[["path",{d:"M13 3H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-3"}],["path",{d:"M8 21h8"}],["path",{d:"M12 17v4"}],["path",{d:"m17 8 5-5"}],["path",{d:"M17 3h5v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Py=["svg",t,[["path",{d:"M15 12h-5"}],["path",{d:"M15 8h-5"}],["path",{d:"M19 17V5a2 2 0 0 0-2-2H4"}],["path",{d:"M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ky=["svg",t,[["path",{d:"M19 17V5a2 2 0 0 0-2-2H4"}],["path",{d:"M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Oy=["svg",t,[["path",{d:"m8 11 2 2 4-4"}],["circle",{cx:"11",cy:"11",r:"8"}],["path",{d:"m21 21-4.3-4.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ry=["svg",t,[["path",{d:"m13 13.5 2-2.5-2-2.5"}],["path",{d:"m21 21-4.3-4.3"}],["path",{d:"M9 8.5 7 11l2 2.5"}],["circle",{cx:"11",cy:"11",r:"8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const By=["svg",t,[["path",{d:"m13.5 8.5-5 5"}],["circle",{cx:"11",cy:"11",r:"8"}],["path",{d:"m21 21-4.3-4.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ty=["svg",t,[["path",{d:"m13.5 8.5-5 5"}],["path",{d:"m8.5 8.5 5 5"}],["circle",{cx:"11",cy:"11",r:"8"}],["path",{d:"m21 21-4.3-4.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ey=["svg",t,[["circle",{cx:"11",cy:"11",r:"8"}],["path",{d:"m21 21-4.3-4.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wt=["svg",t,[["path",{d:"m3 3 3 9-3 9 19-9Z"}],["path",{d:"M6 12h16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fy=["svg",t,[["rect",{x:"14",y:"14",width:"8",height:"8",rx:"2"}],["rect",{x:"2",y:"2",width:"8",height:"8",rx:"2"}],["path",{d:"M7 14v1a2 2 0 0 0 2 2h1"}],["path",{d:"M14 7h1a2 2 0 0 1 2 2v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zy=["svg",t,[["path",{d:"m22 2-7 20-4-9-9-4Z"}],["path",{d:"M22 2 11 13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dy=["svg",t,[["line",{x1:"3",x2:"21",y1:"12",y2:"12"}],["polyline",{points:"8 8 12 4 16 8"}],["polyline",{points:"16 16 12 20 8 16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qy=["svg",t,[["line",{x1:"12",x2:"12",y1:"3",y2:"21"}],["polyline",{points:"8 8 4 12 8 16"}],["polyline",{points:"16 16 20 12 16 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uy=["svg",t,[["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"M4.5 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-.5"}],["path",{d:"M4.5 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-.5"}],["path",{d:"M6 6h.01"}],["path",{d:"M6 18h.01"}],["path",{d:"m15.7 13.4-.9-.3"}],["path",{d:"m9.2 10.9-.9-.3"}],["path",{d:"m10.6 15.7.3-.9"}],["path",{d:"m13.6 15.7-.4-1"}],["path",{d:"m10.8 9.3-.4-1"}],["path",{d:"m8.3 13.6 1-.4"}],["path",{d:"m14.7 10.8 1-.4"}],["path",{d:"m13.4 8.3-.3.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Iy=["svg",t,[["path",{d:"M6 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2"}],["path",{d:"M6 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2"}],["path",{d:"M6 6h.01"}],["path",{d:"M6 18h.01"}],["path",{d:"m13 6-4 6h6l-4 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ny=["svg",t,[["path",{d:"M7 2h13a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-5"}],["path",{d:"M10 10 2.5 2.5C2 2 2 2.5 2 5v3a2 2 0 0 0 2 2h6z"}],["path",{d:"M22 17v-1a2 2 0 0 0-2-2h-1"}],["path",{d:"M4 14a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16.5l1-.5.5.5-8-8H4z"}],["path",{d:"M6 18h.01"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $y=["svg",t,[["rect",{width:"20",height:"8",x:"2",y:"2",rx:"2",ry:"2"}],["rect",{width:"20",height:"8",x:"2",y:"14",rx:"2",ry:"2"}],["line",{x1:"6",x2:"6.01",y1:"6",y2:"6"}],["line",{x1:"6",x2:"6.01",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wy=["svg",t,[["path",{d:"M20 7h-9"}],["path",{d:"M14 17H5"}],["circle",{cx:"17",cy:"17",r:"3"}],["circle",{cx:"7",cy:"7",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jy=["svg",t,[["path",{d:"M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"}],["circle",{cx:"12",cy:"12",r:"3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gy=["svg",t,[["path",{d:"M8.3 10a.7.7 0 0 1-.626-1.079L11.4 3a.7.7 0 0 1 1.198-.043L16.3 8.9a.7.7 0 0 1-.572 1.1Z"}],["rect",{x:"3",y:"14",width:"7",height:"7",rx:"1"}],["circle",{cx:"17.5",cy:"17.5",r:"3.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ky=["svg",t,[["circle",{cx:"18",cy:"5",r:"3"}],["circle",{cx:"6",cy:"12",r:"3"}],["circle",{cx:"18",cy:"19",r:"3"}],["line",{x1:"8.59",x2:"15.42",y1:"13.51",y2:"17.49"}],["line",{x1:"15.41",x2:"8.59",y1:"6.51",y2:"10.49"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xy=["svg",t,[["path",{d:"M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"}],["polyline",{points:"16 6 12 2 8 6"}],["line",{x1:"12",x2:"12",y1:"2",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jy=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["line",{x1:"3",x2:"21",y1:"9",y2:"9"}],["line",{x1:"3",x2:"21",y1:"15",y2:"15"}],["line",{x1:"9",x2:"9",y1:"9",y2:"21"}],["line",{x1:"15",x2:"15",y1:"9",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yy=["svg",t,[["path",{d:"M14 11a2 2 0 1 1-4 0 4 4 0 0 1 8 0 6 6 0 0 1-12 0 8 8 0 0 1 16 0 10 10 0 1 1-20 0 11.93 11.93 0 0 1 2.42-7.22 2 2 0 1 1 3.16 2.44"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qy=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"M12 8v4"}],["path",{d:"M12 16h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tu=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"m4.243 5.21 14.39 12.472"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const au=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"m9 12 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hu=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"M8 12h.01"}],["path",{d:"M12 12h.01"}],["path",{d:"M16 12h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const eu=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"M12 22V2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cu=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"M9 12h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const du=["svg",t,[["path",{d:"m2 2 20 20"}],["path",{d:"M5 5a1 1 0 0 0-1 1v7c0 5 3.5 7.5 7.67 8.94a1 1 0 0 0 .67.01c2.35-.82 4.48-1.97 5.9-3.71"}],["path",{d:"M9.309 3.652A12.252 12.252 0 0 0 11.24 2.28a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1v7a9.784 9.784 0 0 1-.08 1.264"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pu=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"M9 12h6"}],["path",{d:"M12 9v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nu=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"}],["path",{d:"M12 17h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ht=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}],["path",{d:"m14.5 9.5-5 5"}],["path",{d:"m9.5 9.5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const su=["svg",t,[["path",{d:"M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ru=["svg",t,[["circle",{cx:"12",cy:"12",r:"8"}],["path",{d:"M12 2v7.5"}],["path",{d:"m19 5-5.23 5.23"}],["path",{d:"M22 12h-7.5"}],["path",{d:"m19 19-5.23-5.23"}],["path",{d:"M12 14.5V22"}],["path",{d:"M10.23 13.77 5 19"}],["path",{d:"M9.5 12H2"}],["path",{d:"M10.23 10.23 5 5"}],["circle",{cx:"12",cy:"12",r:"2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const iu=["svg",t,[["path",{d:"M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"}],["path",{d:"M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"}],["path",{d:"M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"}],["path",{d:"M12 10v4"}],["path",{d:"M12 2v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ou=["svg",t,[["path",{d:"M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lu=["svg",t,[["path",{d:"M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"}],["path",{d:"M3 6h18"}],["path",{d:"M16 10a4 4 0 0 1-8 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mu=["svg",t,[["path",{d:"m15 11-1 9"}],["path",{d:"m19 11-4-7"}],["path",{d:"M2 11h20"}],["path",{d:"m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"}],["path",{d:"M4.5 15.5h15"}],["path",{d:"m5 11 4-7"}],["path",{d:"m9 11 1 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vu=["svg",t,[["circle",{cx:"8",cy:"21",r:"1"}],["circle",{cx:"19",cy:"21",r:"1"}],["path",{d:"M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gu=["svg",t,[["path",{d:"M2 22v-5l5-5 5 5-5 5z"}],["path",{d:"M9.5 14.5 16 8"}],["path",{d:"m17 2 5 5-.5.5a3.53 3.53 0 0 1-5 0s0 0 0 0a3.53 3.53 0 0 1 0-5L17 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xu=["svg",t,[["path",{d:"m4 4 2.5 2.5"}],["path",{d:"M13.5 6.5a4.95 4.95 0 0 0-7 7"}],["path",{d:"M15 5 5 15"}],["path",{d:"M14 17v.01"}],["path",{d:"M10 16v.01"}],["path",{d:"M13 13v.01"}],["path",{d:"M16 10v.01"}],["path",{d:"M11 20v.01"}],["path",{d:"M17 14v.01"}],["path",{d:"M20 11v.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yu=["svg",t,[["path",{d:"m15 15 6 6m-6-6v4.8m0-4.8h4.8"}],["path",{d:"M9 19.8V15m0 0H4.2M9 15l-6 6"}],["path",{d:"M15 4.2V9m0 0h4.8M15 9l6-6"}],["path",{d:"M9 4.2V9m0 0H4.2M9 9 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uu=["svg",t,[["path",{d:"M12 22v-7l-2-2"}],["path",{d:"M17 8v.8A6 6 0 0 1 13.8 20v0H10v0A6.5 6.5 0 0 1 7 8h0a5 5 0 0 1 10 0Z"}],["path",{d:"m14 14-2 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fu=["svg",t,[["path",{d:"M2 18h1.4c1.3 0 2.5-.6 3.3-1.7l6.1-8.6c.7-1.1 2-1.7 3.3-1.7H22"}],["path",{d:"m18 2 4 4-4 4"}],["path",{d:"M2 6h1.9c1.5 0 2.9.9 3.6 2.2"}],["path",{d:"M22 18h-5.9c-1.3 0-2.6-.7-3.3-1.8l-.5-.8"}],["path",{d:"m18 14 4 4-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mu=["svg",t,[["path",{d:"M18 7V4H6l6 8-6 8h12v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wu=["svg",t,[["path",{d:"M2 20h.01"}],["path",{d:"M7 20v-4"}],["path",{d:"M12 20v-8"}],["path",{d:"M17 20V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hu=["svg",t,[["path",{d:"M2 20h.01"}],["path",{d:"M7 20v-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vu=["svg",t,[["path",{d:"M2 20h.01"}],["path",{d:"M7 20v-4"}],["path",{d:"M12 20v-8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cu=["svg",t,[["path",{d:"M2 20h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Au=["svg",t,[["path",{d:"M2 20h.01"}],["path",{d:"M7 20v-4"}],["path",{d:"M12 20v-8"}],["path",{d:"M17 20V8"}],["path",{d:"M22 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _u=["svg",t,[["path",{d:"M10 9H4L2 7l2-2h6"}],["path",{d:"M14 5h6l2 2-2 2h-6"}],["path",{d:"M10 22V4a2 2 0 1 1 4 0v18"}],["path",{d:"M8 22h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Su=["svg",t,[["path",{d:"M12 3v3"}],["path",{d:"M18.5 13h-13L2 9.5 5.5 6h13L22 9.5Z"}],["path",{d:"M12 13v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lu=["svg",t,[["path",{d:"M7 18v-6a5 5 0 1 1 10 0v6"}],["path",{d:"M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2z"}],["path",{d:"M21 12h1"}],["path",{d:"M18.5 4.5 18 5"}],["path",{d:"M2 12h1"}],["path",{d:"M12 2v1"}],["path",{d:"m4.929 4.929.707.707"}],["path",{d:"M12 12v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bu=["svg",t,[["polygon",{points:"19 20 9 12 19 4 19 20"}],["line",{x1:"5",x2:"5",y1:"19",y2:"5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zu=["svg",t,[["polygon",{points:"5 4 15 12 5 20 5 4"}],["line",{x1:"19",x2:"19",y1:"5",y2:"19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pu=["svg",t,[["circle",{cx:"9",cy:"12",r:"1"}],["circle",{cx:"15",cy:"12",r:"1"}],["path",{d:"M8 20v2h8v-2"}],["path",{d:"m12.5 17-.5-1-.5 1h1z"}],["path",{d:"M16 20a2 2 0 0 0 1.56-3.25 8 8 0 1 0-11.12 0A2 2 0 0 0 8 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ku=["svg",t,[["rect",{width:"3",height:"8",x:"13",y:"2",rx:"1.5"}],["path",{d:"M19 8.5V10h1.5A1.5 1.5 0 1 0 19 8.5"}],["rect",{width:"3",height:"8",x:"8",y:"14",rx:"1.5"}],["path",{d:"M5 15.5V14H3.5A1.5 1.5 0 1 0 5 15.5"}],["rect",{width:"8",height:"3",x:"14",y:"13",rx:"1.5"}],["path",{d:"M15.5 19H14v1.5a1.5 1.5 0 1 0 1.5-1.5"}],["rect",{width:"8",height:"3",x:"2",y:"8",rx:"1.5"}],["path",{d:"M8.5 5H10V3.5A1.5 1.5 0 1 0 8.5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ou=["svg",t,[["path",{d:"M22 2 2 22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ru=["svg",t,[["path",{d:"m8 14-6 6h9v-3"}],["path",{d:"M18.37 3.63 8 14l3 3L21.37 6.63a2.12 2.12 0 1 0-3-3Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bu=["svg",t,[["line",{x1:"21",x2:"14",y1:"4",y2:"4"}],["line",{x1:"10",x2:"3",y1:"4",y2:"4"}],["line",{x1:"21",x2:"12",y1:"12",y2:"12"}],["line",{x1:"8",x2:"3",y1:"12",y2:"12"}],["line",{x1:"21",x2:"16",y1:"20",y2:"20"}],["line",{x1:"12",x2:"3",y1:"20",y2:"20"}],["line",{x1:"14",x2:"14",y1:"2",y2:"6"}],["line",{x1:"8",x2:"8",y1:"10",y2:"14"}],["line",{x1:"16",x2:"16",y1:"18",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vt=["svg",t,[["line",{x1:"4",x2:"4",y1:"21",y2:"14"}],["line",{x1:"4",x2:"4",y1:"10",y2:"3"}],["line",{x1:"12",x2:"12",y1:"21",y2:"12"}],["line",{x1:"12",x2:"12",y1:"8",y2:"3"}],["line",{x1:"20",x2:"20",y1:"21",y2:"16"}],["line",{x1:"20",x2:"20",y1:"12",y2:"3"}],["line",{x1:"2",x2:"6",y1:"14",y2:"14"}],["line",{x1:"10",x2:"14",y1:"8",y2:"8"}],["line",{x1:"18",x2:"22",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tu=["svg",t,[["rect",{width:"14",height:"20",x:"5",y:"2",rx:"2",ry:"2"}],["path",{d:"M12.667 8 10 12h4l-2.667 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Eu=["svg",t,[["rect",{width:"7",height:"12",x:"2",y:"6",rx:"1"}],["path",{d:"M13 8.32a7.43 7.43 0 0 1 0 7.36"}],["path",{d:"M16.46 6.21a11.76 11.76 0 0 1 0 11.58"}],["path",{d:"M19.91 4.1a15.91 15.91 0 0 1 .01 15.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fu=["svg",t,[["rect",{width:"14",height:"20",x:"5",y:"2",rx:"2",ry:"2"}],["path",{d:"M12 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zu=["svg",t,[["path",{d:"M22 11v1a10 10 0 1 1-9-10"}],["path",{d:"M8 14s1.5 2 4 2 4-2 4-2"}],["line",{x1:"9",x2:"9.01",y1:"9",y2:"9"}],["line",{x1:"15",x2:"15.01",y1:"9",y2:"9"}],["path",{d:"M16 5h6"}],["path",{d:"M19 2v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Du=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M8 14s1.5 2 4 2 4-2 4-2"}],["line",{x1:"9",x2:"9.01",y1:"9",y2:"9"}],["line",{x1:"15",x2:"15.01",y1:"9",y2:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qu=["svg",t,[["path",{d:"M2 13a6 6 0 1 0 12 0 4 4 0 1 0-8 0 2 2 0 0 0 4 0"}],["circle",{cx:"10",cy:"13",r:"8"}],["path",{d:"M2 21h12c4.4 0 8-3.6 8-8V7a2 2 0 1 0-4 0v6"}],["path",{d:"M18 3 19.1 5.2"}],["path",{d:"M22 3 20.9 5.2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uu=["svg",t,[["line",{x1:"2",x2:"22",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"2",y2:"22"}],["path",{d:"m20 16-4-4 4-4"}],["path",{d:"m4 8 4 4-4 4"}],["path",{d:"m16 4-4 4-4-4"}],["path",{d:"m8 20 4-4 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Iu=["svg",t,[["path",{d:"M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3"}],["path",{d:"M2 11v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v2H6v-2a2 2 0 0 0-4 0Z"}],["path",{d:"M4 18v2"}],["path",{d:"M20 18v2"}],["path",{d:"M12 4v9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nu=["svg",t,[["path",{d:"M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"}],["path",{d:"M7 21h10"}],["path",{d:"M19.5 12 22 6"}],["path",{d:"M16.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.73 1.62"}],["path",{d:"M11.25 3c.27.1.8.53.74 1.36-.05.83-.93 1.2-.98 2.02-.06.78.33 1.24.72 1.62"}],["path",{d:"M6.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.74 1.62"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $u=["svg",t,[["path",{d:"M22 17v1c0 .5-.5 1-1 1H3c-.5 0-1-.5-1-1v-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wu=["svg",t,[["path",{d:"M5 9c-1.5 1.5-3 3.2-3 5.5A5.5 5.5 0 0 0 7.5 20c1.8 0 3-.5 4.5-2 1.5 1.5 2.7 2 4.5 2a5.5 5.5 0 0 0 5.5-5.5c0-2.3-1.5-4-3-5.5l-7-7-7 7Z"}],["path",{d:"M12 18v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ju=["svg",t,[["path",{d:"M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ct=["svg",t,[["path",{d:"M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"}],["path",{d:"M20 3v4"}],["path",{d:"M22 5h-4"}],["path",{d:"M4 17v2"}],["path",{d:"M5 18H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gu=["svg",t,[["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2"}],["path",{d:"M12 6h.01"}],["circle",{cx:"12",cy:"14",r:"4"}],["path",{d:"M12 14h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ku=["svg",t,[["path",{d:"M8.8 20v-4.1l1.9.2a2.3 2.3 0 0 0 2.164-2.1V8.3A5.37 5.37 0 0 0 2 8.25c0 2.8.656 3.054 1 4.55a5.77 5.77 0 0 1 .029 2.758L2 20"}],["path",{d:"M19.8 17.8a7.5 7.5 0 0 0 .003-10.603"}],["path",{d:"M17 15a3.5 3.5 0 0 0-.025-4.975"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xu=["svg",t,[["path",{d:"m6 16 6-12 6 12"}],["path",{d:"M8 12h8"}],["path",{d:"M4 21c1.1 0 1.1-1 2.3-1s1.1 1 2.3 1c1.1 0 1.1-1 2.3-1 1.1 0 1.1 1 2.3 1 1.1 0 1.1-1 2.3-1 1.1 0 1.1 1 2.3 1 1.1 0 1.1-1 2.3-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ju=["svg",t,[["path",{d:"m6 16 6-12 6 12"}],["path",{d:"M8 12h8"}],["path",{d:"m16 20 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yu=["svg",t,[["circle",{cx:"19",cy:"5",r:"2"}],["circle",{cx:"5",cy:"19",r:"2"}],["path",{d:"M5 17A12 12 0 0 1 17 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qu=["svg",t,[["path",{d:"M16 3h5v5"}],["path",{d:"M8 3H3v5"}],["path",{d:"M12 22v-8.3a4 4 0 0 0-1.172-2.872L3 3"}],["path",{d:"m15 9 6-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tf=["svg",t,[["path",{d:"M3 3h.01"}],["path",{d:"M7 5h.01"}],["path",{d:"M11 7h.01"}],["path",{d:"M3 7h.01"}],["path",{d:"M7 9h.01"}],["path",{d:"M3 11h.01"}],["rect",{width:"4",height:"4",x:"15",y:"5"}],["path",{d:"m19 9 2 2v10c0 .6-.4 1-1 1h-6c-.6 0-1-.4-1-1V11l2-2"}],["path",{d:"m13 14 8-2"}],["path",{d:"m13 19 8-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const af=["svg",t,[["path",{d:"M7 20h10"}],["path",{d:"M10 20c5.5-2.5.8-6.4 3-10"}],["path",{d:"M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"}],["path",{d:"M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const At=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M17 12h-2l-2 5-2-10-2 5H7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _t=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m16 8-8 8"}],["path",{d:"M16 16H8V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const St=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m8 8 8 8"}],["path",{d:"M16 8v8H8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M12 8v8"}],["path",{d:"m8 12 4 4 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m12 8-4 4 4 4"}],["path",{d:"M16 12H8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zt=["svg",t,[["path",{d:"M13 21h6a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"}],["path",{d:"m3 21 9-9"}],["path",{d:"M9 21H3v-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pt=["svg",t,[["path",{d:"M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"}],["path",{d:"m21 21-9-9"}],["path",{d:"M21 15v6h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kt=["svg",t,[["path",{d:"M13 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6"}],["path",{d:"m3 3 9 9"}],["path",{d:"M3 9V3h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ot=["svg",t,[["path",{d:"M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6"}],["path",{d:"m21 3-9 9"}],["path",{d:"M15 3h6v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 12h8"}],["path",{d:"m12 16 4-4-4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 16V8h8"}],["path",{d:"M16 16 8 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 8h8v8"}],["path",{d:"m8 16 8-8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Et=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m16 12-4-4-4 4"}],["path",{d:"M12 16V8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ft=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M12 8v8"}],["path",{d:"m8.5 14 7-4"}],["path",{d:"m8.5 10 7 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zt=["svg",t,[["path",{d:"M4 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2"}],["path",{d:"M10 22H8"}],["path",{d:"M16 22h-2"}],["circle",{cx:"8",cy:"8",r:"2"}],["path",{d:"M9.414 9.414 12 12"}],["path",{d:"M14.8 14.8 18 18"}],["circle",{cx:"8",cy:"16",r:"2"}],["path",{d:"m18 6-8.586 8.586"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dt=["svg",t,[["path",{d:"m9 11 3 3L22 4"}],["path",{d:"M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m9 12 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ut=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m16 10-4 4-4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const It=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m14 16-4-4 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m10 8 4 4-4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $t=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m8 14 4-4 4 4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wt=["svg",t,[["path",{d:"M10 9.5 8 12l2 2.5"}],["path",{d:"m14 9.5 2 2.5-2 2.5"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hf=["svg",t,[["path",{d:"M10 9.5 8 12l2 2.5"}],["path",{d:"M14 21h1"}],["path",{d:"m14 9.5 2 2.5-2 2.5"}],["path",{d:"M5 21a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2"}],["path",{d:"M9 21h1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ef=["svg",t,[["path",{d:"M5 21a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2"}],["path",{d:"M9 21h1"}],["path",{d:"M14 21h1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jt=["svg",t,[["path",{d:"M8 7v7"}],["path",{d:"M12 7v4"}],["path",{d:"M16 7v9"}],["path",{d:"M5 3a2 2 0 0 0-2 2"}],["path",{d:"M9 3h1"}],["path",{d:"M14 3h1"}],["path",{d:"M19 3a2 2 0 0 1 2 2"}],["path",{d:"M21 9v1"}],["path",{d:"M21 14v1"}],["path",{d:"M21 19a2 2 0 0 1-2 2"}],["path",{d:"M14 21h1"}],["path",{d:"M9 21h1"}],["path",{d:"M5 21a2 2 0 0 1-2-2"}],["path",{d:"M3 14v1"}],["path",{d:"M3 9v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gt=["svg",t,[["path",{d:"M5 3a2 2 0 0 0-2 2"}],["path",{d:"M19 3a2 2 0 0 1 2 2"}],["path",{d:"m12 12 4 10 1.7-4.3L22 16Z"}],["path",{d:"M5 21a2 2 0 0 1-2-2"}],["path",{d:"M9 3h1"}],["path",{d:"M9 21h2"}],["path",{d:"M14 3h1"}],["path",{d:"M3 9v1"}],["path",{d:"M21 9v2"}],["path",{d:"M3 14v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["line",{x1:"8",x2:"16",y1:"12",y2:"12"}],["line",{x1:"12",x2:"12",y1:"16",y2:"16"}],["line",{x1:"12",x2:"12",y1:"8",y2:"8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["circle",{cx:"12",cy:"12",r:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7 10h10"}],["path",{d:"M7 14h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"M9 17c2 0 2.8-1 2.8-2.8V10c0-2 1-3.3 3.2-3"}],["path",{d:"M9 11.2h5.7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qt=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 8h7"}],["path",{d:"M8 12h6"}],["path",{d:"M11 16h5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ta=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 7v7"}],["path",{d:"M12 7v4"}],["path",{d:"M16 7v9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const aa=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7 7v10"}],["path",{d:"M11 7v10"}],["path",{d:"m15 7 2 10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ha=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 16V8l4 4 4-4v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ea=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7 8h10"}],["path",{d:"M7 12h10"}],["path",{d:"M7 16h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ca=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 12h8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const da=["svg",t,[["path",{d:"M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"}],["path",{d:"m12 12 4 10 1.7-4.3L22 16Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pa=["svg",t,[["path",{d:"M3.6 3.6A2 2 0 0 1 5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-.59 1.41"}],["path",{d:"M3 8.7V19a2 2 0 0 0 2 2h10.3"}],["path",{d:"m2 2 20 20"}],["path",{d:"M13 13a3 3 0 1 0 0-6H9v2"}],["path",{d:"M9 17v-2.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const na=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M9 17V7h4a3 3 0 0 1 0 6H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g1=["svg",t,[["path",{d:"M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"}],["path",{d:"M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sa=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m15 9-6 6"}],["path",{d:"M9 9h.01"}],["path",{d:"M15 15h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ra=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M7 7h10"}],["path",{d:"M10 7v10"}],["path",{d:"M16 17a2 2 0 0 1-2-2V7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ia=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M12 12H9.5a2.5 2.5 0 0 1 0-5H17"}],["path",{d:"M12 7v10"}],["path",{d:"M16 7v10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const oa=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"m9 8 6 4-6 4Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const la=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M8 12h8"}],["path",{d:"M12 8v8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ma=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M12 7v5"}],["path",{d:"M8 9a5.14 5.14 0 0 0 4 8 4.95 4.95 0 0 0 4-8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cf=["svg",t,[["path",{d:"M7 12h2l2 5 2-10h4"}],["rect",{x:"3",y:"3",width:"18",height:"18",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const va=["svg",t,[["rect",{width:"20",height:"20",x:"2",y:"2",rx:"2"}],["circle",{cx:"8",cy:"8",r:"2"}],["path",{d:"M9.414 9.414 12 12"}],["path",{d:"M14.8 14.8 18 18"}],["circle",{cx:"8",cy:"16",r:"2"}],["path",{d:"m18 6-8.586 8.586"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ga=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M16 8.9V7H8l4 5-4 5h8v-1.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xa=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["line",{x1:"9",x2:"15",y1:"15",y2:"9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ya=["svg",t,[["path",{d:"M8 19H5c-1 0-2-1-2-2V7c0-1 1-2 2-2h3"}],["path",{d:"M16 5h3c1 0 2 1 2 2v10c0 1-1 2-2 2h-3"}],["line",{x1:"12",x2:"12",y1:"4",y2:"20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ua=["svg",t,[["path",{d:"M5 8V5c0-1 1-2 2-2h10c1 0 2 1 2 2v3"}],["path",{d:"M19 16v3c0 1-1 2-2 2H7c-1 0-2-1-2-2v-3"}],["line",{x1:"4",x2:"20",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const df=["svg",t,[["path",{d:"M4 10c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2"}],["path",{d:"M10 16c-1.1 0-2-.9-2-2v-4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2"}],["rect",{width:"8",height:"8",x:"14",y:"14",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fa=["svg",t,[["path",{d:"m7 11 2-2-2-2"}],["path",{d:"M11 13h4"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ma=["svg",t,[["path",{d:"M18 21a6 6 0 0 0-12 0"}],["circle",{cx:"12",cy:"11",r:"4"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wa=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["circle",{cx:"12",cy:"10",r:"3"}],["path",{d:"M7 21v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ha=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["path",{d:"m15 9-6 6"}],["path",{d:"m9 9 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pf=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nf=["svg",t,[["path",{d:"M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9-9-1.8-9-9 1.8-9 9-9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sf=["svg",t,[["path",{d:"M15.236 22a3 3 0 0 0-2.2-5"}],["path",{d:"M16 20a3 3 0 0 1 3-3h1a2 2 0 0 0 2-2v-2a4 4 0 0 0-4-4V4"}],["path",{d:"M18 13h.01"}],["path",{d:"M18 6a4 4 0 0 0-4 4 7 7 0 0 0-7 7c0-5 4-5 4-10.5a4.5 4.5 0 1 0-9 0 2.5 2.5 0 0 0 5 0C7 10 3 11 3 17c0 2.8 2.2 5 5 5h10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rf=["svg",t,[["path",{d:"M5 22h14"}],["path",{d:"M19.27 13.73A2.5 2.5 0 0 0 17.5 13h-11A2.5 2.5 0 0 0 4 15.5V17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-1.5c0-.66-.26-1.3-.73-1.77Z"}],["path",{d:"M14 13V8.5C14 7 15 7 15 5a3 3 0 0 0-3-3c-1.66 0-3 1-3 3s1 2 1 3.5V13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const of=["svg",t,[["path",{d:"M12 17.8 5.8 21 7 14.1 2 9.3l7-1L12 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lf=["svg",t,[["path",{d:"M8.34 8.34 2 9.27l5 4.87L5.82 21 12 17.77 18.18 21l-.59-3.43"}],["path",{d:"M18.42 12.76 22 9.27l-6.91-1L12 2l-1.44 2.91"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mf=["svg",t,[["polygon",{points:"12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vf=["svg",t,[["line",{x1:"18",x2:"18",y1:"20",y2:"4"}],["polygon",{points:"14,20 4,12 14,4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gf=["svg",t,[["line",{x1:"6",x2:"6",y1:"4",y2:"20"}],["polygon",{points:"10,4 20,12 10,20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xf=["svg",t,[["path",{d:"M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"}],["path",{d:"M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"}],["circle",{cx:"20",cy:"10",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yf=["svg",t,[["path",{d:"M15.5 3H5a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2V8.5L15.5 3Z"}],["path",{d:"M14 3v4a2 2 0 0 0 2 2h4"}],["path",{d:"M8 13h0"}],["path",{d:"M16 13h0"}],["path",{d:"M10 16s.8 1 2 1c1.3 0 2-1 2-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uf=["svg",t,[["path",{d:"M16 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8Z"}],["path",{d:"M15 3v4a2 2 0 0 0 2 2h4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ff=["svg",t,[["path",{d:"m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"}],["path",{d:"M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"}],["path",{d:"M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"}],["path",{d:"M2 7h20"}],["path",{d:"M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mf=["svg",t,[["rect",{width:"20",height:"6",x:"2",y:"4",rx:"2"}],["rect",{width:"20",height:"6",x:"2",y:"14",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wf=["svg",t,[["rect",{width:"6",height:"20",x:"4",y:"2",rx:"2"}],["rect",{width:"6",height:"20",x:"14",y:"2",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hf=["svg",t,[["path",{d:"M16 4H9a3 3 0 0 0-2.83 4"}],["path",{d:"M14 12a4 4 0 0 1 0 8H6"}],["line",{x1:"4",x2:"20",y1:"12",y2:"12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vf=["svg",t,[["path",{d:"m4 5 8 8"}],["path",{d:"m12 5-8 8"}],["path",{d:"M20 19h-4c0-1.5.44-2 1.5-2.5S20 15.33 20 14c0-.47-.17-.93-.48-1.29a2.11 2.11 0 0 0-2.62-.44c-.42.24-.74.62-.9 1.07"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cf=["svg",t,[["circle",{cx:"12",cy:"12",r:"4"}],["path",{d:"M12 4h.01"}],["path",{d:"M20 12h.01"}],["path",{d:"M12 20h.01"}],["path",{d:"M4 12h.01"}],["path",{d:"M17.657 6.343h.01"}],["path",{d:"M17.657 17.657h.01"}],["path",{d:"M6.343 17.657h.01"}],["path",{d:"M6.343 6.343h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Af=["svg",t,[["circle",{cx:"12",cy:"12",r:"4"}],["path",{d:"M12 3v1"}],["path",{d:"M12 20v1"}],["path",{d:"M3 12h1"}],["path",{d:"M20 12h1"}],["path",{d:"m18.364 5.636-.707.707"}],["path",{d:"m6.343 17.657-.707.707"}],["path",{d:"m5.636 5.636.707.707"}],["path",{d:"m17.657 17.657.707.707"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _f=["svg",t,[["path",{d:"M12 8a2.83 2.83 0 0 0 4 4 4 4 0 1 1-4-4"}],["path",{d:"M12 2v2"}],["path",{d:"M12 20v2"}],["path",{d:"m4.9 4.9 1.4 1.4"}],["path",{d:"m17.7 17.7 1.4 1.4"}],["path",{d:"M2 12h2"}],["path",{d:"M20 12h2"}],["path",{d:"m6.3 17.7-1.4 1.4"}],["path",{d:"m19.1 4.9-1.4 1.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sf=["svg",t,[["path",{d:"M10 9a3 3 0 1 0 0 6"}],["path",{d:"M2 12h1"}],["path",{d:"M14 21V3"}],["path",{d:"M10 4V3"}],["path",{d:"M10 21v-1"}],["path",{d:"m3.64 18.36.7-.7"}],["path",{d:"m4.34 6.34-.7-.7"}],["path",{d:"M14 12h8"}],["path",{d:"m17 4-3 3"}],["path",{d:"m14 17 3 3"}],["path",{d:"m21 15-3-3 3-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lf=["svg",t,[["circle",{cx:"12",cy:"12",r:"4"}],["path",{d:"M12 2v2"}],["path",{d:"M12 20v2"}],["path",{d:"m4.93 4.93 1.41 1.41"}],["path",{d:"m17.66 17.66 1.41 1.41"}],["path",{d:"M2 12h2"}],["path",{d:"M20 12h2"}],["path",{d:"m6.34 17.66-1.41 1.41"}],["path",{d:"m19.07 4.93-1.41 1.41"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bf=["svg",t,[["path",{d:"M12 2v8"}],["path",{d:"m4.93 10.93 1.41 1.41"}],["path",{d:"M2 18h2"}],["path",{d:"M20 18h2"}],["path",{d:"m19.07 10.93-1.41 1.41"}],["path",{d:"M22 22H2"}],["path",{d:"m8 6 4-4 4 4"}],["path",{d:"M16 18a4 4 0 0 0-8 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zf=["svg",t,[["path",{d:"M12 10V2"}],["path",{d:"m4.93 10.93 1.41 1.41"}],["path",{d:"M2 18h2"}],["path",{d:"M20 18h2"}],["path",{d:"m19.07 10.93-1.41 1.41"}],["path",{d:"M22 22H2"}],["path",{d:"m16 6-4 4-4-4"}],["path",{d:"M16 18a4 4 0 0 0-8 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pf=["svg",t,[["path",{d:"m4 19 8-8"}],["path",{d:"m12 19-8-8"}],["path",{d:"M20 12h-4c0-1.5.442-2 1.5-2.5S20 8.334 20 7.002c0-.472-.17-.93-.484-1.29a2.105 2.105 0 0 0-2.617-.436c-.42.239-.738.614-.899 1.06"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kf=["svg",t,[["path",{d:"M11 17a4 4 0 0 1-8 0V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2Z"}],["path",{d:"M16.7 13H19a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H7"}],["path",{d:"M 7 17h0.01"}],["path",{d:"m11 8 2.3-2.3a2.4 2.4 0 0 1 3.404.004L18.6 7.6a2.4 2.4 0 0 1 .026 3.434L9.9 19.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Of=["svg",t,[["path",{d:"M10 21V3h8"}],["path",{d:"M6 16h9"}],["path",{d:"M10 9.5h7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rf=["svg",t,[["path",{d:"M11 19H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h5"}],["path",{d:"M13 5h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-5"}],["circle",{cx:"12",cy:"12",r:"3"}],["path",{d:"m18 22-3-3 3-3"}],["path",{d:"m6 2 3 3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bf=["svg",t,[["polyline",{points:"14.5 17.5 3 6 3 3 6 3 17.5 14.5"}],["line",{x1:"13",x2:"19",y1:"19",y2:"13"}],["line",{x1:"16",x2:"20",y1:"16",y2:"20"}],["line",{x1:"19",x2:"21",y1:"21",y2:"19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tf=["svg",t,[["polyline",{points:"14.5 17.5 3 6 3 3 6 3 17.5 14.5"}],["line",{x1:"13",x2:"19",y1:"19",y2:"13"}],["line",{x1:"16",x2:"20",y1:"16",y2:"20"}],["line",{x1:"19",x2:"21",y1:"21",y2:"19"}],["polyline",{points:"14.5 6.5 18 3 21 3 21 6 17.5 9.5"}],["line",{x1:"5",x2:"9",y1:"14",y2:"18"}],["line",{x1:"7",x2:"4",y1:"17",y2:"20"}],["line",{x1:"3",x2:"5",y1:"19",y2:"21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ef=["svg",t,[["path",{d:"m18 2 4 4"}],["path",{d:"m17 7 3-3"}],["path",{d:"M19 9 8.7 19.3c-1 1-2.5 1-3.4 0l-.6-.6c-1-1-1-2.5 0-3.4L15 5"}],["path",{d:"m9 11 4 4"}],["path",{d:"m5 19-3 3"}],["path",{d:"m14 4 6 6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ff=["svg",t,[["path",{d:"M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zf=["svg",t,[["path",{d:"M12 21v-6"}],["path",{d:"M12 9V3"}],["path",{d:"M3 15h18"}],["path",{d:"M3 9h18"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Df=["svg",t,[["path",{d:"M12 15V9"}],["path",{d:"M3 15h18"}],["path",{d:"M3 9h18"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qf=["svg",t,[["path",{d:"M14 14v2"}],["path",{d:"M14 20v2"}],["path",{d:"M14 2v2"}],["path",{d:"M14 8v2"}],["path",{d:"M2 15h8"}],["path",{d:"M2 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2"}],["path",{d:"M2 9h8"}],["path",{d:"M22 15h-4"}],["path",{d:"M22 3h-2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h2"}],["path",{d:"M22 9h-4"}],["path",{d:"M5 3v18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uf=["svg",t,[["path",{d:"M15 3v18"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M21 9H3"}],["path",{d:"M21 15H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const If=["svg",t,[["path",{d:"M14 10h2"}],["path",{d:"M15 22v-8"}],["path",{d:"M15 2v4"}],["path",{d:"M2 10h2"}],["path",{d:"M20 10h2"}],["path",{d:"M3 19h18"}],["path",{d:"M3 22v-6a2 2 135 0 1 2-2h14a2 2 45 0 1 2 2v6"}],["path",{d:"M3 2v2a2 2 45 0 0 2 2h14a2 2 135 0 0 2-2V2"}],["path",{d:"M8 10h2"}],["path",{d:"M9 22v-8"}],["path",{d:"M9 2v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nf=["svg",t,[["path",{d:"M12 3v18"}],["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9h18"}],["path",{d:"M3 15h18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $f=["svg",t,[["rect",{width:"10",height:"14",x:"3",y:"8",rx:"2"}],["path",{d:"M5 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-2.4"}],["path",{d:"M8 18h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wf=["svg",t,[["rect",{width:"16",height:"20",x:"4",y:"2",rx:"2",ry:"2"}],["line",{x1:"12",x2:"12.01",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jf=["svg",t,[["circle",{cx:"7",cy:"7",r:"5"}],["circle",{cx:"17",cy:"17",r:"5"}],["path",{d:"M12 17h10"}],["path",{d:"m3.46 10.54 7.08-7.08"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gf=["svg",t,[["path",{d:"M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"}],["circle",{cx:"7.5",cy:"7.5",r:".5",fill:"currentColor"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kf=["svg",t,[["path",{d:"m15 5 6.3 6.3a2.4 2.4 0 0 1 0 3.4L17 19"}],["path",{d:"M9.586 5.586A2 2 0 0 0 8.172 5H3a1 1 0 0 0-1 1v5.172a2 2 0 0 0 .586 1.414L8.29 18.29a2.426 2.426 0 0 0 3.42 0l3.58-3.58a2.426 2.426 0 0 0 0-3.42z"}],["circle",{cx:"6.5",cy:"9.5",r:".5",fill:"currentColor"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xf=["svg",t,[["path",{d:"M4 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jf=["svg",t,[["path",{d:"M4 4v16"}],["path",{d:"M9 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yf=["svg",t,[["path",{d:"M4 4v16"}],["path",{d:"M9 4v16"}],["path",{d:"M14 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qf=["svg",t,[["path",{d:"M4 4v16"}],["path",{d:"M9 4v16"}],["path",{d:"M14 4v16"}],["path",{d:"M19 4v16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tm=["svg",t,[["path",{d:"M4 4v16"}],["path",{d:"M9 4v16"}],["path",{d:"M14 4v16"}],["path",{d:"M19 4v16"}],["path",{d:"M22 6 2 18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const am=["svg",t,[["circle",{cx:"17",cy:"4",r:"2"}],["path",{d:"M15.59 5.41 5.41 15.59"}],["circle",{cx:"4",cy:"17",r:"2"}],["path",{d:"M12 22s-4-9-1.5-11.5S22 12 22 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hm=["svg",t,[["circle",{cx:"12",cy:"12",r:"10"}],["circle",{cx:"12",cy:"12",r:"6"}],["circle",{cx:"12",cy:"12",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const em=["svg",t,[["path",{d:"m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44"}],["path",{d:"m13.56 11.747 4.332-.924"}],["path",{d:"m16 21-3.105-6.21"}],["path",{d:"M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z"}],["path",{d:"m6.158 8.633 1.114 4.456"}],["path",{d:"m8 21 3.105-6.21"}],["circle",{cx:"12",cy:"13",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cm=["svg",t,[["circle",{cx:"4",cy:"4",r:"2"}],["path",{d:"m14 5 3-3 3 3"}],["path",{d:"m14 10 3-3 3 3"}],["path",{d:"M17 14V2"}],["path",{d:"M17 14H7l-5 8h20Z"}],["path",{d:"M8 14v8"}],["path",{d:"m9 14 5 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dm=["svg",t,[["path",{d:"M3.5 21 14 3"}],["path",{d:"M20.5 21 10 3"}],["path",{d:"M15.5 21 12 15l-3.5 6"}],["path",{d:"M2 21h20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pm=["svg",t,[["polyline",{points:"4 17 10 11 4 5"}],["line",{x1:"12",x2:"20",y1:"19",y2:"19"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Va=["svg",t,[["path",{d:"M21 7 6.82 21.18a2.83 2.83 0 0 1-3.99-.01v0a2.83 2.83 0 0 1 0-4L17 3"}],["path",{d:"m16 2 6 6"}],["path",{d:"M12 16H4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nm=["svg",t,[["path",{d:"M14.5 2v17.5c0 1.4-1.1 2.5-2.5 2.5h0c-1.4 0-2.5-1.1-2.5-2.5V2"}],["path",{d:"M8.5 2h7"}],["path",{d:"M14.5 16h-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sm=["svg",t,[["path",{d:"M9 2v17.5A2.5 2.5 0 0 1 6.5 22v0A2.5 2.5 0 0 1 4 19.5V2"}],["path",{d:"M20 2v17.5a2.5 2.5 0 0 1-2.5 2.5v0a2.5 2.5 0 0 1-2.5-2.5V2"}],["path",{d:"M3 2h7"}],["path",{d:"M14 2h7"}],["path",{d:"M9 16H4"}],["path",{d:"M20 16h-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rm=["svg",t,[["path",{d:"M5 4h1a3 3 0 0 1 3 3 3 3 0 0 1 3-3h1"}],["path",{d:"M13 20h-1a3 3 0 0 1-3-3 3 3 0 0 1-3 3H5"}],["path",{d:"M5 16H4a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h1"}],["path",{d:"M13 8h7a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-7"}],["path",{d:"M9 7v10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const im=["svg",t,[["path",{d:"M17 22h-1a4 4 0 0 1-4-4V6a4 4 0 0 1 4-4h1"}],["path",{d:"M7 22h1a4 4 0 0 0 4-4v-1"}],["path",{d:"M7 2h1a4 4 0 0 1 4 4v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const om=["svg",t,[["path",{d:"M17 6H3"}],["path",{d:"M21 12H8"}],["path",{d:"M21 18H8"}],["path",{d:"M3 12v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lm=["svg",t,[["path",{d:"M21 6H3"}],["path",{d:"M10 12H3"}],["path",{d:"M10 18H3"}],["circle",{cx:"17",cy:"15",r:"3"}],["path",{d:"m21 19-1.9-1.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ca=["svg",t,[["path",{d:"M5 3a2 2 0 0 0-2 2"}],["path",{d:"M19 3a2 2 0 0 1 2 2"}],["path",{d:"M21 19a2 2 0 0 1-2 2"}],["path",{d:"M5 21a2 2 0 0 1-2-2"}],["path",{d:"M9 3h1"}],["path",{d:"M9 21h1"}],["path",{d:"M14 3h1"}],["path",{d:"M14 21h1"}],["path",{d:"M3 9v1"}],["path",{d:"M21 9v1"}],["path",{d:"M3 14v1"}],["path",{d:"M21 14v1"}],["line",{x1:"7",x2:"15",y1:"8",y2:"8"}],["line",{x1:"7",x2:"17",y1:"12",y2:"12"}],["line",{x1:"7",x2:"13",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mm=["svg",t,[["path",{d:"M17 6.1H3"}],["path",{d:"M21 12.1H3"}],["path",{d:"M15.1 18H3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vm=["svg",t,[["path",{d:"M2 10s3-3 3-8"}],["path",{d:"M22 10s-3-3-3-8"}],["path",{d:"M10 2c0 4.4-3.6 8-8 8"}],["path",{d:"M14 2c0 4.4 3.6 8 8 8"}],["path",{d:"M2 10s2 2 2 5"}],["path",{d:"M22 10s-2 2-2 5"}],["path",{d:"M8 15h8"}],["path",{d:"M2 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"}],["path",{d:"M14 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gm=["svg",t,[["path",{d:"M2 12h10"}],["path",{d:"M9 4v16"}],["path",{d:"m3 9 3 3-3 3"}],["path",{d:"M12 6 9 9 6 6"}],["path",{d:"m6 18 3-3 1.5 1.5"}],["path",{d:"M20 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xm=["svg",t,[["path",{d:"M12 9a4 4 0 0 0-2 7.5"}],["path",{d:"M12 3v2"}],["path",{d:"m6.6 18.4-1.4 1.4"}],["path",{d:"M20 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"}],["path",{d:"M4 13H2"}],["path",{d:"M6.34 7.34 4.93 5.93"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ym=["svg",t,[["path",{d:"M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const um=["svg",t,[["path",{d:"M17 14V2"}],["path",{d:"M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fm=["svg",t,[["path",{d:"M7 10v12"}],["path",{d:"M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mm=["svg",t,[["path",{d:"M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"m9 12 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wm=["svg",t,[["path",{d:"M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"M9 12h6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hm=["svg",t,[["path",{d:"M2 9a3 3 0 1 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 1 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"M9 9h.01"}],["path",{d:"m15 9-6 6"}],["path",{d:"M15 15h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vm=["svg",t,[["path",{d:"M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"M9 12h6"}],["path",{d:"M12 9v6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cm=["svg",t,[["path",{d:"M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"m9.5 14.5 5-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Am=["svg",t,[["path",{d:"M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"m9.5 14.5 5-5"}],["path",{d:"m9.5 9.5 5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _m=["svg",t,[["path",{d:"M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"}],["path",{d:"M13 5v2"}],["path",{d:"M13 17v2"}],["path",{d:"M13 11v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sm=["svg",t,[["path",{d:"M10 2h4"}],["path",{d:"M4.6 11a8 8 0 0 0 1.7 8.7 8 8 0 0 0 8.7 1.7"}],["path",{d:"M7.4 7.4a8 8 0 0 1 10.3 1 8 8 0 0 1 .9 10.2"}],["path",{d:"m2 2 20 20"}],["path",{d:"M12 12v-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lm=["svg",t,[["path",{d:"M10 2h4"}],["path",{d:"M12 14v-4"}],["path",{d:"M4 13a8 8 0 0 1 8-7 8 8 0 1 1-5.3 14L4 17.6"}],["path",{d:"M9 17H4v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bm=["svg",t,[["line",{x1:"10",x2:"14",y1:"2",y2:"2"}],["line",{x1:"12",x2:"15",y1:"14",y2:"11"}],["circle",{cx:"12",cy:"14",r:"8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zm=["svg",t,[["rect",{width:"20",height:"12",x:"2",y:"6",rx:"6",ry:"6"}],["circle",{cx:"8",cy:"12",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pm=["svg",t,[["rect",{width:"20",height:"12",x:"2",y:"6",rx:"6",ry:"6"}],["circle",{cx:"16",cy:"12",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const km=["svg",t,[["path",{d:"M21 4H3"}],["path",{d:"M18 8H6"}],["path",{d:"M19 12H9"}],["path",{d:"M16 16h-6"}],["path",{d:"M11 20H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Om=["svg",t,[["ellipse",{cx:"12",cy:"11",rx:"3",ry:"2"}],["ellipse",{cx:"12",cy:"12.5",rx:"10",ry:"8.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rm=["svg",t,[["path",{d:"M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16"}],["path",{d:"M2 14h12"}],["path",{d:"M22 14h-2"}],["path",{d:"M12 20v-6"}],["path",{d:"m2 2 20 20"}],["path",{d:"M22 16V6a2 2 0 0 0-2-2H10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bm=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"M2 14h20"}],["path",{d:"M12 20v-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tm=["svg",t,[["path",{d:"M18.2 12.27 20 6H4l1.8 6.27a1 1 0 0 0 .95.73h10.5a1 1 0 0 0 .96-.73Z"}],["path",{d:"M8 13v9"}],["path",{d:"M16 22v-9"}],["path",{d:"m9 6 1 7"}],["path",{d:"m15 6-1 7"}],["path",{d:"M12 6V2"}],["path",{d:"M13 2h-2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Em=["svg",t,[["rect",{width:"18",height:"12",x:"3",y:"8",rx:"1"}],["path",{d:"M10 8V5c0-.6-.4-1-1-1H6a1 1 0 0 0-1 1v3"}],["path",{d:"M19 8V5c0-.6-.4-1-1-1h-3a1 1 0 0 0-1 1v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fm=["svg",t,[["path",{d:"m10 11 11 .9c.6 0 .9.5.8 1.1l-.8 5h-1"}],["path",{d:"M16 18h-5"}],["path",{d:"M18 5a1 1 0 0 0-1 1v5.573"}],["path",{d:"M3 4h9l1 7.246"}],["path",{d:"M4 11V4"}],["path",{d:"M7 15h.01"}],["path",{d:"M8 10.1V4"}],["circle",{cx:"18",cy:"18",r:"2"}],["circle",{cx:"7",cy:"15",r:"5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zm=["svg",t,[["path",{d:"M9.3 6.2a4.55 4.55 0 0 0 5.4 0"}],["path",{d:"M7.9 10.7c.9.8 2.4 1.3 4.1 1.3s3.2-.5 4.1-1.3"}],["path",{d:"M13.9 3.5a1.93 1.93 0 0 0-3.8-.1l-3 10c-.1.2-.1.4-.1.6 0 1.7 2.2 3 5 3s5-1.3 5-3c0-.2 0-.4-.1-.5Z"}],["path",{d:"m7.5 12.2-4.7 2.7c-.5.3-.8.7-.8 1.1s.3.8.8 1.1l7.6 4.5c.9.5 2.1.5 3 0l7.6-4.5c.7-.3 1-.7 1-1.1s-.3-.8-.8-1.1l-4.7-2.8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dm=["svg",t,[["path",{d:"M2 22V12a10 10 0 1 1 20 0v10"}],["path",{d:"M15 6.8v1.4a3 2.8 0 1 1-6 0V6.8"}],["path",{d:"M10 15h.01"}],["path",{d:"M14 15h.01"}],["path",{d:"M10 19a4 4 0 0 1-4-4v-3a6 6 0 1 1 12 0v3a4 4 0 0 1-4 4Z"}],["path",{d:"m9 19-2 3"}],["path",{d:"m15 19 2 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qm=["svg",t,[["path",{d:"M8 3.1V7a4 4 0 0 0 8 0V3.1"}],["path",{d:"m9 15-1-1"}],["path",{d:"m15 15 1-1"}],["path",{d:"M9 19c-2.8 0-5-2.2-5-5v-4a8 8 0 0 1 16 0v4c0 2.8-2.2 5-5 5Z"}],["path",{d:"m8 19-2 3"}],["path",{d:"m16 19 2 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Um=["svg",t,[["path",{d:"M2 17 17 2"}],["path",{d:"m2 14 8 8"}],["path",{d:"m5 11 8 8"}],["path",{d:"m8 8 8 8"}],["path",{d:"m11 5 8 8"}],["path",{d:"m14 2 8 8"}],["path",{d:"M7 22 22 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Aa=["svg",t,[["rect",{width:"16",height:"16",x:"4",y:"3",rx:"2"}],["path",{d:"M4 11h16"}],["path",{d:"M12 3v8"}],["path",{d:"m8 19-2 3"}],["path",{d:"m18 22-2-3"}],["path",{d:"M8 15h.01"}],["path",{d:"M16 15h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Im=["svg",t,[["path",{d:"M3 6h18"}],["path",{d:"M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"}],["path",{d:"M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"}],["line",{x1:"10",x2:"10",y1:"11",y2:"17"}],["line",{x1:"14",x2:"14",y1:"11",y2:"17"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nm=["svg",t,[["path",{d:"M3 6h18"}],["path",{d:"M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"}],["path",{d:"M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $m=["svg",t,[["path",{d:"M8 19a4 4 0 0 1-2.24-7.32A3.5 3.5 0 0 1 9 6.03V6a3 3 0 1 1 6 0v.04a3.5 3.5 0 0 1 3.24 5.65A4 4 0 0 1 16 19Z"}],["path",{d:"M12 19v3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _a=["svg",t,[["path",{d:"M13 8c0-2.76-2.46-5-5.5-5S2 5.24 2 8h2l1-1 1 1h4"}],["path",{d:"M13 7.14A5.82 5.82 0 0 1 16.5 6c3.04 0 5.5 2.24 5.5 5h-3l-1-1-1 1h-3"}],["path",{d:"M5.89 9.71c-2.15 2.15-2.3 5.47-.35 7.43l4.24-4.25.7-.7.71-.71 2.12-2.12c-1.95-1.96-5.27-1.8-7.42.35"}],["path",{d:"M11 15.5c.5 2.5-.17 4.5-1 6.5h4c2-5.5-.5-12-1-14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Wm=["svg",t,[["path",{d:"m17 14 3 3.3a1 1 0 0 1-.7 1.7H4.7a1 1 0 0 1-.7-1.7L7 14h-.3a1 1 0 0 1-.7-1.7L9 9h-.2A1 1 0 0 1 8 7.3L12 3l4 4.3a1 1 0 0 1-.8 1.7H15l3 3.3a1 1 0 0 1-.7 1.7H17Z"}],["path",{d:"M12 22v-3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jm=["svg",t,[["path",{d:"M10 10v.2A3 3 0 0 1 8.9 16v0H5v0h0a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"}],["path",{d:"M7 16v6"}],["path",{d:"M13 19v3"}],["path",{d:"M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gm=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2"}],["rect",{width:"3",height:"9",x:"7",y:"7"}],["rect",{width:"3",height:"5",x:"14",y:"7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Km=["svg",t,[["polyline",{points:"22 17 13.5 8.5 8.5 13.5 2 7"}],["polyline",{points:"16 17 22 17 22 11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xm=["svg",t,[["polyline",{points:"22 7 13.5 15.5 8.5 10.5 2 17"}],["polyline",{points:"16 7 22 7 22 13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sa=["svg",t,[["path",{d:"m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"}],["path",{d:"M12 9v4"}],["path",{d:"M12 17h.01"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jm=["svg",t,[["path",{d:"M22 18a2 2 0 0 1-2 2H3c-1.1 0-1.3-.6-.4-1.3L20.4 4.3c.9-.7 1.6-.4 1.6.7Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ym=["svg",t,[["path",{d:"M13.73 4a2 2 0 0 0-3.46 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qm=["svg",t,[["path",{d:"M6 9H4.5a2.5 2.5 0 0 1 0-5H6"}],["path",{d:"M18 9h1.5a2.5 2.5 0 0 0 0-5H18"}],["path",{d:"M4 22h16"}],["path",{d:"M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"}],["path",{d:"M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"}],["path",{d:"M18 2H6v7a6 6 0 0 0 12 0V2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tw=["svg",t,[["path",{d:"M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"}],["path",{d:"M15 18H9"}],["path",{d:"M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"}],["circle",{cx:"17",cy:"18",r:"2"}],["circle",{cx:"7",cy:"18",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const aw=["svg",t,[["path",{d:"m12 10 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a8 8 0 1 0-16 0v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3l2-4h4Z"}],["path",{d:"M4.82 7.9 8 10"}],["path",{d:"M15.18 7.9 12 10"}],["path",{d:"M16.93 10H20a2 2 0 0 1 0 4H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hw=["svg",t,[["path",{d:"M7 21h10"}],["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ew=["svg",t,[["rect",{width:"20",height:"15",x:"2",y:"7",rx:"2",ry:"2"}],["polyline",{points:"17 2 12 7 7 2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cw=["svg",t,[["path",{d:"M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dw=["svg",t,[["path",{d:"M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pw=["svg",t,[["polyline",{points:"4 7 4 4 20 4 20 7"}],["line",{x1:"9",x2:"15",y1:"20",y2:"20"}],["line",{x1:"12",x2:"12",y1:"4",y2:"20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nw=["svg",t,[["path",{d:"M12 2v1"}],["path",{d:"M15.5 21a1.85 1.85 0 0 1-3.5-1v-8H2a10 10 0 0 1 3.428-6.575"}],["path",{d:"M17.5 12H22A10 10 0 0 0 9.004 3.455"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sw=["svg",t,[["path",{d:"M22 12a10.06 10.06 1 0 0-20 0Z"}],["path",{d:"M12 12v8a2 2 0 0 0 4 0"}],["path",{d:"M12 2v1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rw=["svg",t,[["path",{d:"M6 4v6a6 6 0 0 0 12 0V4"}],["line",{x1:"4",x2:"20",y1:"20",y2:"20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const iw=["svg",t,[["path",{d:"M9 14 4 9l5-5"}],["path",{d:"M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ow=["svg",t,[["circle",{cx:"12",cy:"17",r:"1"}],["path",{d:"M3 7v6h6"}],["path",{d:"M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lw=["svg",t,[["path",{d:"M3 7v6h6"}],["path",{d:"M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Mw=["svg",t,[["path",{d:"M16 12h6"}],["path",{d:"M8 12H2"}],["path",{d:"M12 2v2"}],["path",{d:"M12 8v2"}],["path",{d:"M12 14v2"}],["path",{d:"M12 20v2"}],["path",{d:"m19 15 3-3-3-3"}],["path",{d:"m5 9-3 3 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vw=["svg",t,[["path",{d:"M12 22v-6"}],["path",{d:"M12 8V2"}],["path",{d:"M4 12H2"}],["path",{d:"M10 12H8"}],["path",{d:"M16 12h-2"}],["path",{d:"M22 12h-2"}],["path",{d:"m15 19-3 3-3-3"}],["path",{d:"m15 5-3-3-3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gw=["svg",t,[["rect",{width:"8",height:"6",x:"5",y:"4",rx:"1"}],["rect",{width:"8",height:"6",x:"11",y:"14",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const La=["svg",t,[["circle",{cx:"12",cy:"10",r:"1"}],["path",{d:"M22 20V8h-4l-6-4-6 4H2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2"}],["path",{d:"M6 17v.01"}],["path",{d:"M6 13v.01"}],["path",{d:"M18 17v.01"}],["path",{d:"M18 13v.01"}],["path",{d:"M14 22v-5a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xw=["svg",t,[["path",{d:"M15 7h2a5 5 0 0 1 0 10h-2m-6 0H7A5 5 0 0 1 7 7h2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yw=["svg",t,[["path",{d:"m18.84 12.25 1.72-1.71h-.02a5.004 5.004 0 0 0-.12-7.07 5.006 5.006 0 0 0-6.95 0l-1.72 1.71"}],["path",{d:"m5.17 11.75-1.71 1.71a5.004 5.004 0 0 0 .12 7.07 5.006 5.006 0 0 0 6.95 0l1.71-1.71"}],["line",{x1:"8",x2:"8",y1:"2",y2:"5"}],["line",{x1:"2",x2:"5",y1:"8",y2:"8"}],["line",{x1:"16",x2:"16",y1:"19",y2:"22"}],["line",{x1:"19",x2:"22",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uw=["svg",t,[["path",{d:"m19 5 3-3"}],["path",{d:"m2 22 3-3"}],["path",{d:"M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z"}],["path",{d:"M7.5 13.5 10 11"}],["path",{d:"M10.5 16.5 13 14"}],["path",{d:"m12 6 6 6 2.3-2.3a2.4 2.4 0 0 0 0-3.4l-2.6-2.6a2.4 2.4 0 0 0-3.4 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fw=["svg",t,[["path",{d:"M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"}],["polyline",{points:"17 8 12 3 7 8"}],["line",{x1:"12",x2:"12",y1:"3",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mw=["svg",t,[["circle",{cx:"10",cy:"7",r:"1"}],["circle",{cx:"4",cy:"20",r:"1"}],["path",{d:"M4.7 19.3 19 5"}],["path",{d:"m21 3-3 1 2 2Z"}],["path",{d:"M9.26 7.68 5 12l2 5"}],["path",{d:"m10 14 5 2 3.5-3.5"}],["path",{d:"m18 12 1-1 1 1-1 1Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ww=["svg",t,[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"}],["circle",{cx:"9",cy:"7",r:"4"}],["polyline",{points:"16 11 18 13 22 9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Hw=["svg",t,[["circle",{cx:"18",cy:"15",r:"3"}],["circle",{cx:"9",cy:"7",r:"4"}],["path",{d:"M10 15H6a4 4 0 0 0-4 4v2"}],["path",{d:"m21.7 16.4-.9-.3"}],["path",{d:"m15.2 13.9-.9-.3"}],["path",{d:"m16.6 18.7.3-.9"}],["path",{d:"m19.1 12.2.3-.9"}],["path",{d:"m19.6 18.7-.4-1"}],["path",{d:"m16.8 12.3-.4-1"}],["path",{d:"m14.3 16.6 1-.4"}],["path",{d:"m20.7 13.8 1-.4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Vw=["svg",t,[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"}],["circle",{cx:"9",cy:"7",r:"4"}],["line",{x1:"22",x2:"16",y1:"11",y2:"11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Cw=["svg",t,[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"}],["circle",{cx:"9",cy:"7",r:"4"}],["line",{x1:"19",x2:"19",y1:"8",y2:"14"}],["line",{x1:"22",x2:"16",y1:"11",y2:"11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ba=["svg",t,[["path",{d:"M2 21a8 8 0 0 1 13.292-6"}],["circle",{cx:"10",cy:"8",r:"5"}],["path",{d:"m16 19 2 2 4-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Za=["svg",t,[["path",{d:"M2 21a8 8 0 0 1 10.434-7.62"}],["circle",{cx:"10",cy:"8",r:"5"}],["circle",{cx:"18",cy:"18",r:"3"}],["path",{d:"m19.5 14.3-.4.9"}],["path",{d:"m16.9 20.8-.4.9"}],["path",{d:"m21.7 19.5-.9-.4"}],["path",{d:"m15.2 16.9-.9-.4"}],["path",{d:"m21.7 16.5-.9.4"}],["path",{d:"m15.2 19.1-.9.4"}],["path",{d:"m19.5 21.7-.4-.9"}],["path",{d:"m16.9 15.2-.4-.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pa=["svg",t,[["path",{d:"M2 21a8 8 0 0 1 13.292-6"}],["circle",{cx:"10",cy:"8",r:"5"}],["path",{d:"M22 19h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ka=["svg",t,[["path",{d:"M2 21a8 8 0 0 1 13.292-6"}],["circle",{cx:"10",cy:"8",r:"5"}],["path",{d:"M19 16v6"}],["path",{d:"M22 19h-6"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Aw=["svg",t,[["circle",{cx:"10",cy:"8",r:"5"}],["path",{d:"M2 21a8 8 0 0 1 10.434-7.62"}],["circle",{cx:"18",cy:"18",r:"3"}],["path",{d:"m22 22-1.9-1.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Oa=["svg",t,[["path",{d:"M2 21a8 8 0 0 1 11.873-7"}],["circle",{cx:"10",cy:"8",r:"5"}],["path",{d:"m17 17 5 5"}],["path",{d:"m22 17-5 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ra=["svg",t,[["circle",{cx:"12",cy:"8",r:"5"}],["path",{d:"M20 21a8 8 0 0 0-16 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _w=["svg",t,[["circle",{cx:"10",cy:"7",r:"4"}],["path",{d:"M10.3 15H7a4 4 0 0 0-4 4v2"}],["circle",{cx:"17",cy:"17",r:"3"}],["path",{d:"m21 21-1.9-1.9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Sw=["svg",t,[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"}],["circle",{cx:"9",cy:"7",r:"4"}],["line",{x1:"17",x2:"22",y1:"8",y2:"13"}],["line",{x1:"22",x2:"17",y1:"8",y2:"13"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Lw=["svg",t,[["path",{d:"M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"}],["circle",{cx:"12",cy:"7",r:"4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ba=["svg",t,[["path",{d:"M18 21a8 8 0 0 0-16 0"}],["circle",{cx:"10",cy:"8",r:"5"}],["path",{d:"M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const bw=["svg",t,[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"}],["circle",{cx:"9",cy:"7",r:"4"}],["path",{d:"M22 21v-2a4 4 0 0 0-3-3.87"}],["path",{d:"M16 3.13a4 4 0 0 1 0 7.75"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Zw=["svg",t,[["path",{d:"m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"}],["path",{d:"M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"}],["path",{d:"m2.1 21.8 6.4-6.3"}],["path",{d:"m19 5-7 7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Pw=["svg",t,[["path",{d:"M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"}],["path",{d:"M7 2v20"}],["path",{d:"M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const kw=["svg",t,[["path",{d:"M12 2v20"}],["path",{d:"M2 5h20"}],["path",{d:"M3 3v2"}],["path",{d:"M7 3v2"}],["path",{d:"M17 3v2"}],["path",{d:"M21 3v2"}],["path",{d:"m19 5-7 7-7-7"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ow=["svg",t,[["path",{d:"M8 21s-4-3-4-9 4-9 4-9"}],["path",{d:"M16 3s4 3 4 9-4 9-4 9"}],["line",{x1:"15",x2:"9",y1:"9",y2:"15"}],["line",{x1:"9",x2:"15",y1:"9",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Rw=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["circle",{cx:"7.5",cy:"7.5",r:".5",fill:"currentColor"}],["path",{d:"m7.9 7.9 2.7 2.7"}],["circle",{cx:"16.5",cy:"7.5",r:".5",fill:"currentColor"}],["path",{d:"m13.4 10.6 2.7-2.7"}],["circle",{cx:"7.5",cy:"16.5",r:".5",fill:"currentColor"}],["path",{d:"m7.9 16.1 2.7-2.7"}],["circle",{cx:"16.5",cy:"16.5",r:".5",fill:"currentColor"}],["path",{d:"m13.4 13.4 2.7 2.7"}],["circle",{cx:"12",cy:"12",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Bw=["svg",t,[["path",{d:"M2 2a26.6 26.6 0 0 1 10 20c.9-6.82 1.5-9.5 4-14"}],["path",{d:"M16 8c4 0 6-2 6-6-4 0-6 2-6 6"}],["path",{d:"M17.41 3.6a10 10 0 1 0 3 3"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Tw=["svg",t,[["path",{d:"M2 12a5 5 0 0 0 5 5 8 8 0 0 1 5 2 8 8 0 0 1 5-2 5 5 0 0 0 5-5V7h-5a8 8 0 0 0-5 2 8 8 0 0 0-5-2H2Z"}],["path",{d:"M6 11c1.5 0 3 .5 3 2-2 0-3 0-3-2Z"}],["path",{d:"M18 11c-1.5 0-3 .5-3 2 2 0 3 0 3-2Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ew=["svg",t,[["path",{d:"m2 8 2 2-2 2 2 2-2 2"}],["path",{d:"m22 8-2 2 2 2-2 2 2 2"}],["path",{d:"M8 8v10c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2"}],["path",{d:"M16 10.34V6c0-.55-.45-1-1-1h-4.34"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Fw=["svg",t,[["path",{d:"m2 8 2 2-2 2 2 2-2 2"}],["path",{d:"m22 8-2 2 2 2-2 2 2 2"}],["rect",{width:"8",height:"14",x:"8",y:"5",rx:"1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const zw=["svg",t,[["path",{d:"M10.66 6H14a2 2 0 0 1 2 2v2.5l5.248-3.062A.5.5 0 0 1 22 7.87v8.196"}],["path",{d:"M16 16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Dw=["svg",t,[["path",{d:"m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"}],["rect",{x:"2",y:"6",width:"14",height:"12",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const qw=["svg",t,[["rect",{width:"20",height:"16",x:"2",y:"4",rx:"2"}],["path",{d:"M2 8h20"}],["circle",{cx:"8",cy:"14",r:"2"}],["path",{d:"M8 12h8"}],["circle",{cx:"16",cy:"14",r:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Uw=["svg",t,[["path",{d:"M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z"}],["path",{d:"M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"}],["path",{d:"M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2"}],["path",{d:"M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Iw=["svg",t,[["circle",{cx:"6",cy:"12",r:"4"}],["circle",{cx:"18",cy:"12",r:"4"}],["line",{x1:"6",x2:"18",y1:"16",y2:"16"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Nw=["svg",t,[["polygon",{points:"11 5 6 9 2 9 2 15 6 15 11 19 11 5"}],["path",{d:"M15.54 8.46a5 5 0 0 1 0 7.07"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $w=["svg",t,[["polygon",{points:"11 5 6 9 2 9 2 15 6 15 11 19 11 5"}],["path",{d:"M15.54 8.46a5 5 0 0 1 0 7.07"}],["path",{d:"M19.07 4.93a10 10 0 0 1 0 14.14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ww=["svg",t,[["polygon",{points:"11 5 6 9 2 9 2 15 6 15 11 19 11 5"}],["line",{x1:"22",x2:"16",y1:"9",y2:"15"}],["line",{x1:"16",x2:"22",y1:"9",y2:"15"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const jw=["svg",t,[["polygon",{points:"11 5 6 9 2 9 2 15 6 15 11 19 11 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Gw=["svg",t,[["path",{d:"m9 12 2 2 4-4"}],["path",{d:"M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z"}],["path",{d:"M22 19H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Kw=["svg",t,[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2"}],["path",{d:"M3 9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"}],["path",{d:"M3 11h3c.8 0 1.6.3 2.1.9l1.1.9c1.6 1.6 4.1 1.6 5.7 0l1.1-.9c.5-.5 1.3-.9 2.1-.9H21"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ta=["svg",t,[["path",{d:"M17 14h.01"}],["path",{d:"M7 7h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Xw=["svg",t,[["path",{d:"M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"}],["path",{d:"M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Jw=["svg",t,[["circle",{cx:"8",cy:"9",r:"2"}],["path",{d:"m9 17 6.1-6.1a2 2 0 0 1 2.81.01L22 15V5a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2"}],["path",{d:"M8 21h8"}],["path",{d:"M12 17v4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Ea=["svg",t,[["path",{d:"m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72"}],["path",{d:"m14 7 3 3"}],["path",{d:"M5 6v4"}],["path",{d:"M19 14v4"}],["path",{d:"M10 2v2"}],["path",{d:"M7 8H3"}],["path",{d:"M21 16h-4"}],["path",{d:"M11 3H9"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Yw=["svg",t,[["path",{d:"M15 4V2"}],["path",{d:"M15 16v-2"}],["path",{d:"M8 9h2"}],["path",{d:"M20 9h2"}],["path",{d:"M17.8 11.8 19 13"}],["path",{d:"M15 9h0"}],["path",{d:"M17.8 6.2 19 5"}],["path",{d:"m3 21 9-9"}],["path",{d:"M12.2 6.2 11 5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Qw=["svg",t,[["path",{d:"M22 8.35V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.35A2 2 0 0 1 3.26 6.5l8-3.2a2 2 0 0 1 1.48 0l8 3.2A2 2 0 0 1 22 8.35Z"}],["path",{d:"M6 18h12"}],["path",{d:"M6 14h12"}],["rect",{width:"12",height:"12",x:"6",y:"10"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const tH=["svg",t,[["path",{d:"M3 6h3"}],["path",{d:"M17 6h.01"}],["rect",{width:"18",height:"20",x:"3",y:"2",rx:"2"}],["circle",{cx:"12",cy:"13",r:"5"}],["path",{d:"M12 18a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 1 0-5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const aH=["svg",t,[["circle",{cx:"12",cy:"12",r:"6"}],["polyline",{points:"12 10 12 12 13 13"}],["path",{d:"m16.13 7.66-.81-4.05a2 2 0 0 0-2-1.61h-2.68a2 2 0 0 0-2 1.61l-.78 4.05"}],["path",{d:"m7.88 16.36.8 4a2 2 0 0 0 2 1.61h2.72a2 2 0 0 0 2-1.61l.81-4.05"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const hH=["svg",t,[["path",{d:"M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"}],["path",{d:"M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"}],["path",{d:"M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const eH=["svg",t,[["circle",{cx:"12",cy:"4.5",r:"2.5"}],["path",{d:"m10.2 6.3-3.9 3.9"}],["circle",{cx:"4.5",cy:"12",r:"2.5"}],["path",{d:"M7 12h10"}],["circle",{cx:"19.5",cy:"12",r:"2.5"}],["path",{d:"m13.8 17.7 3.9-3.9"}],["circle",{cx:"12",cy:"19.5",r:"2.5"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const cH=["svg",t,[["circle",{cx:"12",cy:"10",r:"8"}],["circle",{cx:"12",cy:"10",r:"3"}],["path",{d:"M7 22h10"}],["path",{d:"M12 22v-4"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const dH=["svg",t,[["path",{d:"M17 17h-5c-1.09-.02-1.94.92-2.5 1.9A3 3 0 1 1 2.57 15"}],["path",{d:"M9 3.4a4 4 0 0 1 6.52.66"}],["path",{d:"m6 17 3.1-5.8a2.5 2.5 0 0 0 .057-2.05"}],["path",{d:"M20.3 20.3a4 4 0 0 1-2.3.7"}],["path",{d:"M18.6 13a4 4 0 0 1 3.357 3.414"}],["path",{d:"m12 6 .6 1"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const pH=["svg",t,[["path",{d:"M18 16.98h-5.99c-1.1 0-1.95.94-2.48 1.9A4 4 0 0 1 2 17c.01-.7.2-1.4.57-2"}],["path",{d:"m6 17 3.13-5.78c.53-.97.1-2.18-.5-3.1a4 4 0 1 1 6.89-4.06"}],["path",{d:"m12 6 3.13 5.73C15.66 12.7 16.9 13 18 13a4 4 0 0 1 0 8"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const nH=["svg",t,[["circle",{cx:"12",cy:"5",r:"3"}],["path",{d:"M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const sH=["svg",t,[["path",{d:"m2 22 10-10"}],["path",{d:"m16 8-1.17 1.17"}],["path",{d:"M3.47 12.53 5 11l1.53 1.53a3.5 3.5 0 0 1 0 4.94L5 19l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"}],["path",{d:"m8 8-.53.53a3.5 3.5 0 0 0 0 4.94L9 15l1.53-1.53c.55-.55.88-1.25.98-1.97"}],["path",{d:"M10.91 5.26c.15-.26.34-.51.56-.73L13 3l1.53 1.53a3.5 3.5 0 0 1 .28 4.62"}],["path",{d:"M20 2h2v2a4 4 0 0 1-4 4h-2V6a4 4 0 0 1 4-4Z"}],["path",{d:"M11.47 17.47 13 19l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L5 19l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"}],["path",{d:"m16 16-.53.53a3.5 3.5 0 0 1-4.94 0L9 15l1.53-1.53a3.49 3.49 0 0 1 1.97-.98"}],["path",{d:"M18.74 13.09c.26-.15.51-.34.73-.56L21 11l-1.53-1.53a3.5 3.5 0 0 0-4.62-.28"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const rH=["svg",t,[["path",{d:"M2 22 16 8"}],["path",{d:"M3.47 12.53 5 11l1.53 1.53a3.5 3.5 0 0 1 0 4.94L5 19l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"}],["path",{d:"M7.47 8.53 9 7l1.53 1.53a3.5 3.5 0 0 1 0 4.94L9 15l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"}],["path",{d:"M11.47 4.53 13 3l1.53 1.53a3.5 3.5 0 0 1 0 4.94L13 11l-1.53-1.53a3.5 3.5 0 0 1 0-4.94Z"}],["path",{d:"M20 2h2v2a4 4 0 0 1-4 4h-2V6a4 4 0 0 1 4-4Z"}],["path",{d:"M11.47 17.47 13 19l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L5 19l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"}],["path",{d:"M15.47 13.47 17 15l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L9 15l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"}],["path",{d:"M19.47 9.47 21 11l-1.53 1.53a3.5 3.5 0 0 1-4.94 0L13 11l1.53-1.53a3.5 3.5 0 0 1 4.94 0Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const iH=["svg",t,[["circle",{cx:"7",cy:"12",r:"3"}],["path",{d:"M10 9v6"}],["circle",{cx:"17",cy:"12",r:"3"}],["path",{d:"M14 7v8"}],["path",{d:"M22 17v1c0 .5-.5 1-1 1H3c-.5 0-1-.5-1-1v-1"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const oH=["svg",t,[["path",{d:"M12 20h.01"}],["path",{d:"M8.5 16.429a5 5 0 0 1 7 0"}],["path",{d:"M5 12.859a10 10 0 0 1 5.17-2.69"}],["path",{d:"M19 12.859a10 10 0 0 0-2.007-1.523"}],["path",{d:"M2 8.82a15 15 0 0 1 4.177-2.643"}],["path",{d:"M22 8.82a15 15 0 0 0-11.288-3.764"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const lH=["svg",t,[["path",{d:"M12 20h.01"}],["path",{d:"M2 8.82a15 15 0 0 1 20 0"}],["path",{d:"M5 12.859a10 10 0 0 1 14 0"}],["path",{d:"M8.5 16.429a5 5 0 0 1 7 0"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const MH=["svg",t,[["path",{d:"M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"}],["path",{d:"M9.6 4.6A2 2 0 1 1 11 8H2"}],["path",{d:"M12.6 19.4A2 2 0 1 0 14 16H2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const vH=["svg",t,[["path",{d:"M8 22h8"}],["path",{d:"M7 10h3m7 0h-1.343"}],["path",{d:"M12 15v7"}],["path",{d:"M7.307 7.307A12.33 12.33 0 0 0 7 10a5 5 0 0 0 7.391 4.391M8.638 2.981C8.75 2.668 8.872 2.34 9 2h6c1.5 4 2 6 2 8 0 .407-.05.809-.145 1.198"}],["line",{x1:"2",x2:"22",y1:"2",y2:"22"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const gH=["svg",t,[["path",{d:"M8 22h8"}],["path",{d:"M7 10h10"}],["path",{d:"M12 15v7"}],["path",{d:"M12 15a5 5 0 0 0 5-5c0-2-.5-4-2-8H9c-1.5 4-2 6-2 8a5 5 0 0 0 5 5Z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const xH=["svg",t,[["rect",{width:"8",height:"8",x:"3",y:"3",rx:"2"}],["path",{d:"M7 11v4a2 2 0 0 0 2 2h4"}],["rect",{width:"8",height:"8",x:"13",y:"13",rx:"2"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const yH=["svg",t,[["path",{d:"m19 12-1.5 3"}],["path",{d:"M19.63 18.81 22 20"}],["path",{d:"M6.47 8.23a1.68 1.68 0 0 1 2.44 1.93l-.64 2.08a6.76 6.76 0 0 0 10.16 7.67l.42-.27a1 1 0 1 0-2.73-4.21l-.42.27a1.76 1.76 0 0 1-2.63-1.99l.64-2.08A6.66 6.66 0 0 0 3.94 3.9l-.7.4a1 1 0 1 0 2.55 4.34z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const uH=["svg",t,[["line",{x1:"3",x2:"21",y1:"6",y2:"6"}],["path",{d:"M3 12h15a3 3 0 1 1 0 6h-4"}],["polyline",{points:"16 16 14 18 16 20"}],["line",{x1:"3",x2:"10",y1:"18",y2:"18"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const fH=["svg",t,[["path",{d:"M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const mH=["svg",t,[["path",{d:"M18 6 6 18"}],["path",{d:"m6 6 12 12"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const wH=["svg",t,[["path",{d:"M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"}],["path",{d:"m10 15 5-3-5-3z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const HH=["svg",t,[["path",{d:"M10.513 4.856 13.12 2.17a.5.5 0 0 1 .86.46l-1.377 4.317"}],["path",{d:"M15.656 10H20a1 1 0 0 1 .78 1.63l-1.72 1.773"}],["path",{d:"M16.273 16.273 10.88 21.83a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14H4a1 1 0 0 1-.78-1.63l4.507-4.643"}],["path",{d:"m2 2 20 20"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const VH=["svg",t,[["path",{d:"M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const CH=["svg",t,[["circle",{cx:"11",cy:"11",r:"8"}],["line",{x1:"21",x2:"16.65",y1:"21",y2:"16.65"}],["line",{x1:"11",x2:"11",y1:"8",y2:"14"}],["line",{x1:"8",x2:"14",y1:"11",y2:"11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const AH=["svg",t,[["circle",{cx:"11",cy:"11",r:"8"}],["line",{x1:"21",x2:"16.65",y1:"21",y2:"16.65"}],["line",{x1:"8",x2:"14",y1:"11",y2:"11"}]]];/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const _H=Object.freeze(Object.defineProperty({__proto__:null,AArrowDown:Lc,AArrowUp:bc,ALargeSmall:Zc,Accessibility:Pc,Activity:kc,ActivitySquare:At,AirVent:Oc,Airplay:Rc,AlarmCheck:O2,AlarmClock:Tc,AlarmClockCheck:O2,AlarmClockMinus:R2,AlarmClockOff:Bc,AlarmClockPlus:B2,AlarmMinus:R2,AlarmPlus:B2,AlarmSmoke:Ec,Album:Fc,AlertCircle:K2,AlertOctagon:et,AlertTriangle:Sa,AlignCenter:qc,AlignCenterHorizontal:zc,AlignCenterVertical:Dc,AlignEndHorizontal:Uc,AlignEndVertical:Ic,AlignHorizontalDistributeCenter:Nc,AlignHorizontalDistributeEnd:$c,AlignHorizontalDistributeStart:Wc,AlignHorizontalJustifyCenter:jc,AlignHorizontalJustifyEnd:Gc,AlignHorizontalJustifyStart:Kc,AlignHorizontalSpaceAround:Xc,AlignHorizontalSpaceBetween:Jc,AlignJustify:Yc,AlignLeft:Qc,AlignRight:td,AlignStartHorizontal:ad,AlignStartVertical:hd,AlignVerticalDistributeCenter:ed,AlignVerticalDistributeEnd:cd,AlignVerticalDistributeStart:dd,AlignVerticalJustifyCenter:pd,AlignVerticalJustifyEnd:nd,AlignVerticalJustifyStart:sd,AlignVerticalSpaceAround:rd,AlignVerticalSpaceBetween:id,Ambulance:od,Ampersand:ld,Ampersands:Md,Anchor:vd,Angry:gd,Annoyed:xd,Antenna:yd,Anvil:ud,Aperture:fd,AppWindow:wd,AppWindowMac:md,Apple:Hd,Archive:Ad,ArchiveRestore:Vd,ArchiveX:Cd,AreaChart:_d,Armchair:Sd,ArrowBigDown:bd,ArrowBigDownDash:Ld,ArrowBigLeft:Pd,ArrowBigLeftDash:Zd,ArrowBigRight:Od,ArrowBigRightDash:kd,ArrowBigUp:Bd,ArrowBigUpDash:Rd,ArrowDown:$d,ArrowDown01:Td,ArrowDown10:Ed,ArrowDownAZ:T2,ArrowDownAz:T2,ArrowDownCircle:X2,ArrowDownFromLine:Fd,ArrowDownLeft:zd,ArrowDownLeftFromCircle:Y2,ArrowDownLeftFromSquare:Zt,ArrowDownLeftSquare:_t,ArrowDownNarrowWide:Dd,ArrowDownRight:qd,ArrowDownRightFromCircle:Q2,ArrowDownRightFromSquare:Pt,ArrowDownRightSquare:St,ArrowDownSquare:Lt,ArrowDownToDot:Ud,ArrowDownToLine:Id,ArrowDownUp:Nd,ArrowDownWideNarrow:E2,ArrowDownZA:F2,ArrowDownZa:F2,ArrowLeft:Kd,ArrowLeftCircle:J2,ArrowLeftFromLine:Wd,ArrowLeftRight:jd,ArrowLeftSquare:bt,ArrowLeftToLine:Gd,ArrowRight:Qd,ArrowRightCircle:h0,ArrowRightFromLine:Xd,ArrowRightLeft:Jd,ArrowRightSquare:Rt,ArrowRightToLine:Yd,ArrowUp:r5,ArrowUp01:t5,ArrowUp10:a5,ArrowUpAZ:z2,ArrowUpAz:z2,ArrowUpCircle:e0,ArrowUpDown:h5,ArrowUpFromDot:e5,ArrowUpFromLine:c5,ArrowUpLeft:d5,ArrowUpLeftFromCircle:t0,ArrowUpLeftFromSquare:kt,ArrowUpLeftSquare:Bt,ArrowUpNarrowWide:D2,ArrowUpRight:p5,ArrowUpRightFromCircle:a0,ArrowUpRightFromSquare:Ot,ArrowUpRightSquare:Tt,ArrowUpSquare:Et,ArrowUpToLine:n5,ArrowUpWideNarrow:s5,ArrowUpZA:q2,ArrowUpZa:q2,ArrowsUpFromLine:i5,Asterisk:o5,AsteriskSquare:Ft,AtSign:l5,Atom:M5,AudioLines:v5,AudioWaveform:g5,Award:x5,Axe:y5,Axis3D:U2,Axis3d:U2,Baby:u5,Backpack:f5,Badge:B5,BadgeAlert:m5,BadgeCent:w5,BadgeCheck:I2,BadgeDollarSign:H5,BadgeEuro:V5,BadgeHelp:C5,BadgeIndianRupee:A5,BadgeInfo:_5,BadgeJapaneseYen:S5,BadgeMinus:L5,BadgePercent:b5,BadgePlus:Z5,BadgePoundSterling:P5,BadgeRussianRuble:k5,BadgeSwissFranc:O5,BadgeX:R5,BaggageClaim:T5,Ban:E5,Banana:F5,Banknote:z5,BarChart:W5,BarChart2:D5,BarChart3:q5,BarChart4:U5,BarChartBig:I5,BarChartHorizontal:$5,BarChartHorizontalBig:N5,Barcode:j5,Baseline:G5,Bath:K5,Battery:ap,BatteryCharging:X5,BatteryFull:J5,BatteryLow:Y5,BatteryMedium:Q5,BatteryWarning:tp,Beaker:hp,Bean:cp,BeanOff:ep,Bed:np,BedDouble:dp,BedSingle:pp,Beef:sp,Beer:ip,BeerOff:rp,Bell:yp,BellDot:op,BellElectric:lp,BellMinus:Mp,BellOff:vp,BellPlus:gp,BellRing:xp,BetweenHorizonalEnd:N2,BetweenHorizonalStart:$2,BetweenHorizontalEnd:N2,BetweenHorizontalStart:$2,BetweenVerticalEnd:up,BetweenVerticalStart:fp,Bike:mp,Binary:wp,Biohazard:Hp,Bird:Vp,Bitcoin:Cp,Blend:Ap,Blinds:_p,Blocks:Sp,Bluetooth:Pp,BluetoothConnected:Lp,BluetoothOff:bp,BluetoothSearching:Zp,Bold:kp,Bolt:Op,Bomb:Rp,Bone:Bp,Book:cn,BookA:Tp,BookAudio:Ep,BookCheck:Fp,BookCopy:zp,BookDashed:W2,BookDown:Dp,BookHeadphones:qp,BookHeart:Up,BookImage:Ip,BookKey:Np,BookLock:$p,BookMarked:Wp,BookMinus:jp,BookOpen:Xp,BookOpenCheck:Gp,BookOpenText:Kp,BookPlus:Jp,BookTemplate:W2,BookText:Yp,BookType:Qp,BookUp:an,BookUp2:tn,BookUser:hn,BookX:en,Bookmark:rn,BookmarkCheck:dn,BookmarkMinus:pn,BookmarkPlus:nn,BookmarkX:sn,BoomBox:on,Bot:vn,BotMessageSquare:ln,BotOff:Mn,Box:xn,BoxSelect:gn,Boxes:yn,Braces:j2,Brackets:un,Brain:wn,BrainCircuit:fn,BrainCog:mn,BrickWall:Hn,Briefcase:An,BriefcaseBusiness:Vn,BriefcaseMedical:Cn,BringToFront:_n,Brush:Sn,Bug:Zn,BugOff:Ln,BugPlay:bn,Building:kn,Building2:Pn,Bus:Rn,BusFront:On,Cable:Tn,CableCar:Bn,Cake:Fn,CakeSlice:En,Calculator:zn,Calendar:as,CalendarCheck:qn,CalendarCheck2:Dn,CalendarClock:Un,CalendarDays:In,CalendarFold:Nn,CalendarHeart:$n,CalendarMinus:jn,CalendarMinus2:Wn,CalendarOff:Gn,CalendarPlus:Xn,CalendarPlus2:Kn,CalendarRange:Jn,CalendarSearch:Yn,CalendarX:ts,CalendarX2:Qn,Camera:es,CameraOff:hs,CandlestickChart:cs,Candy:ns,CandyCane:ds,CandyOff:ps,Cannabis:ss,Captions:G2,CaptionsOff:rs,Car:ls,CarFront:is,CarTaxiFront:os,Caravan:Ms,Carrot:vs,CaseLower:gs,CaseSensitive:xs,CaseUpper:ys,CassetteTape:us,Cast:fs,Castle:ms,Cat:ws,Cctv:Hs,Check:Cs,CheckCheck:Vs,CheckCircle:c0,CheckCircle2:d0,CheckSquare:Dt,CheckSquare2:qt,ChefHat:As,Cherry:_s,ChevronDown:Ss,ChevronDownCircle:p0,ChevronDownSquare:Ut,ChevronFirst:Ls,ChevronLast:bs,ChevronLeft:Zs,ChevronLeftCircle:n0,ChevronLeftSquare:It,ChevronRight:Ps,ChevronRightCircle:s0,ChevronRightSquare:Nt,ChevronUp:ks,ChevronUpCircle:r0,ChevronUpSquare:$t,ChevronsDown:Rs,ChevronsDownUp:Os,ChevronsLeft:Ts,ChevronsLeftRight:Bs,ChevronsRight:Fs,ChevronsRightLeft:Es,ChevronsUp:Ds,ChevronsUpDown:zs,Chrome:qs,Church:Us,Cigarette:Ns,CigaretteOff:Is,Circle:t3,CircleAlert:K2,CircleArrowDown:X2,CircleArrowLeft:J2,CircleArrowOutDownLeft:Y2,CircleArrowOutDownRight:Q2,CircleArrowOutUpLeft:t0,CircleArrowOutUpRight:a0,CircleArrowRight:h0,CircleArrowUp:e0,CircleCheck:d0,CircleCheckBig:c0,CircleChevronDown:p0,CircleChevronLeft:n0,CircleChevronRight:s0,CircleChevronUp:r0,CircleDashed:$s,CircleDivide:i0,CircleDollarSign:Ws,CircleDot:Gs,CircleDotDashed:js,CircleEllipsis:Ks,CircleEqual:Xs,CircleFadingPlus:Js,CircleGauge:o0,CircleHelp:l0,CircleMinus:M0,CircleOff:Ys,CircleParking:g0,CircleParkingOff:v0,CirclePause:x0,CirclePercent:y0,CirclePlay:u0,CirclePlus:f0,CirclePower:m0,CircleSlash:Qs,CircleSlash2:w0,CircleSlashed:w0,CircleStop:H0,CircleUser:C0,CircleUserRound:V0,CircleX:A0,CircuitBoard:a3,Citrus:h3,Clapperboard:e3,Clipboard:l3,ClipboardCheck:c3,ClipboardCopy:d3,ClipboardEdit:S0,ClipboardList:p3,ClipboardMinus:n3,ClipboardPaste:s3,ClipboardPen:S0,ClipboardPenLine:_0,ClipboardPlus:r3,ClipboardSignature:_0,ClipboardType:i3,ClipboardX:o3,Clock:A3,Clock1:M3,Clock10:v3,Clock11:g3,Clock12:x3,Clock2:y3,Clock3:u3,Clock4:f3,Clock5:m3,Clock6:w3,Clock7:H3,Clock8:V3,Clock9:C3,Cloud:z3,CloudCog:_3,CloudDownload:L0,CloudDrizzle:S3,CloudFog:L3,CloudHail:b3,CloudLightning:Z3,CloudMoon:k3,CloudMoonRain:P3,CloudOff:O3,CloudRain:B3,CloudRainWind:R3,CloudSnow:T3,CloudSun:F3,CloudSunRain:E3,CloudUpload:b0,Cloudy:D3,Clover:q3,Club:U3,Code:I3,Code2:Z0,CodeSquare:Wt,CodeXml:Z0,Codepen:N3,Codesandbox:$3,Coffee:W3,Cog:j3,Coins:G3,Columns:P0,Columns2:P0,Columns3:k0,Columns4:K3,Combine:X3,Command:J3,Compass:Y3,Component:Q3,Computer:tr,ConciergeBell:ar,Cone:hr,Construction:er,Contact:cr,Contact2:O0,ContactRound:O0,Container:dr,Contrast:pr,Cookie:nr,CookingPot:sr,Copy:vr,CopyCheck:rr,CopyMinus:ir,CopyPlus:or,CopySlash:lr,CopyX:Mr,Copyleft:gr,Copyright:xr,CornerDownLeft:yr,CornerDownRight:ur,CornerLeftDown:fr,CornerLeftUp:mr,CornerRightDown:wr,CornerRightUp:Hr,CornerUpLeft:Vr,CornerUpRight:Cr,Cpu:Ar,CreativeCommons:_r,CreditCard:Sr,Croissant:Lr,Crop:br,Cross:Zr,Crosshair:Pr,Crown:kr,Cuboid:Or,CupSoda:Rr,CurlyBraces:j2,Currency:Br,Cylinder:Tr,Database:zr,DatabaseBackup:Er,DatabaseZap:Fr,Delete:Dr,Dessert:qr,Diameter:Ur,Diamond:$r,DiamondMinus:Ir,DiamondPercent:R0,DiamondPlus:Nr,Dice1:Wr,Dice2:jr,Dice3:Gr,Dice4:Kr,Dice5:Xr,Dice6:Jr,Dices:Yr,Diff:Qr,Disc:ei,Disc2:ti,Disc3:ai,DiscAlbum:hi,Divide:ci,DivideCircle:i0,DivideSquare:Kt,Dna:pi,DnaOff:di,Dock:ni,Dog:si,DollarSign:ri,Donut:ii,DoorClosed:oi,DoorOpen:li,Dot:Mi,DotSquare:Xt,Download:vi,DownloadCloud:L0,DraftingCompass:gi,Drama:xi,Dribbble:yi,Drill:ui,Droplet:fi,Droplets:mi,Drum:wi,Drumstick:Hi,Dumbbell:Vi,Ear:Ai,EarOff:Ci,Earth:B0,EarthLock:_i,Eclipse:Si,Edit:g1,Edit2:gt,Edit3:vt,Egg:Zi,EggFried:Li,EggOff:bi,Ellipsis:E0,EllipsisVertical:T0,Equal:ki,EqualNot:Pi,EqualSquare:Jt,Eraser:Oi,Euro:Ri,Expand:Bi,ExternalLink:Ti,Eye:Fi,EyeOff:Ei,Facebook:zi,Factory:Di,Fan:qi,FastForward:Ui,Feather:Ii,Fence:Ni,FerrisWheel:$i,Figma:Wi,File:W6,FileArchive:ji,FileAudio:Ki,FileAudio2:Gi,FileAxis3D:F0,FileAxis3d:F0,FileBadge:Ji,FileBadge2:Xi,FileBarChart:Qi,FileBarChart2:Yi,FileBox:t6,FileCheck:h6,FileCheck2:a6,FileClock:e6,FileCode:d6,FileCode2:c6,FileCog:z0,FileCog2:z0,FileDiff:p6,FileDigit:n6,FileDown:s6,FileEdit:q0,FileHeart:r6,FileImage:i6,FileInput:o6,FileJson:M6,FileJson2:l6,FileKey:g6,FileKey2:v6,FileLineChart:x6,FileLock:u6,FileLock2:y6,FileMinus:m6,FileMinus2:f6,FileMusic:w6,FileOutput:H6,FilePen:q0,FilePenLine:D0,FilePieChart:V6,FilePlus:A6,FilePlus2:C6,FileQuestion:_6,FileScan:S6,FileSearch:b6,FileSearch2:L6,FileSignature:D0,FileSliders:Z6,FileSpreadsheet:P6,FileStack:k6,FileSymlink:O6,FileTerminal:R6,FileText:B6,FileType:E6,FileType2:T6,FileUp:F6,FileVideo:D6,FileVideo2:z6,FileVolume:U6,FileVolume2:q6,FileWarning:I6,FileX:$6,FileX2:N6,Files:j6,Film:G6,Filter:X6,FilterX:K6,Fingerprint:J6,FireExtinguisher:Y6,Fish:ao,FishOff:Q6,FishSymbol:to,Flag:po,FlagOff:ho,FlagTriangleLeft:eo,FlagTriangleRight:co,Flame:so,FlameKindling:no,Flashlight:io,FlashlightOff:ro,FlaskConical:lo,FlaskConicalOff:oo,FlaskRound:Mo,FlipHorizontal:go,FlipHorizontal2:vo,FlipVertical:yo,FlipVertical2:xo,Flower:fo,Flower2:uo,Focus:mo,FoldHorizontal:wo,FoldVertical:Ho,Folder:Ko,FolderArchive:Vo,FolderCheck:Co,FolderClock:Ao,FolderClosed:_o,FolderCog:U0,FolderCog2:U0,FolderDot:So,FolderDown:Lo,FolderEdit:I0,FolderGit:Zo,FolderGit2:bo,FolderHeart:Po,FolderInput:ko,FolderKanban:Oo,FolderKey:Ro,FolderLock:Bo,FolderMinus:To,FolderOpen:Fo,FolderOpenDot:Eo,FolderOutput:zo,FolderPen:I0,FolderPlus:Do,FolderRoot:qo,FolderSearch:Io,FolderSearch2:Uo,FolderSymlink:No,FolderSync:$o,FolderTree:Wo,FolderUp:jo,FolderX:Go,Folders:Xo,Footprints:Jo,Forklift:Yo,FormInput:xt,Forward:Qo,Frame:t8,Framer:a8,Frown:h8,Fuel:e8,Fullscreen:c8,FunctionSquare:Yt,GalleryHorizontal:p8,GalleryHorizontalEnd:d8,GalleryThumbnails:n8,GalleryVertical:r8,GalleryVerticalEnd:s8,Gamepad:o8,Gamepad2:i8,GanttChart:l8,GanttChartSquare:Qt,Gauge:M8,GaugeCircle:o0,Gavel:v8,Gem:g8,Ghost:x8,Gift:y8,GitBranch:f8,GitBranchPlus:u8,GitCommit:N0,GitCommitHorizontal:N0,GitCommitVertical:m8,GitCompare:H8,GitCompareArrows:w8,GitFork:V8,GitGraph:C8,GitMerge:A8,GitPullRequest:P8,GitPullRequestArrow:_8,GitPullRequestClosed:S8,GitPullRequestCreate:b8,GitPullRequestCreateArrow:L8,GitPullRequestDraft:Z8,Github:k8,Gitlab:O8,GlassWater:R8,Glasses:B8,Globe:E8,Globe2:B0,GlobeLock:T8,Goal:F8,Grab:z8,GraduationCap:D8,Grape:q8,Grid:O1,Grid2X2:$0,Grid2x2:$0,Grid2x2Check:U8,Grid2x2X:I8,Grid3X3:O1,Grid3x3:O1,Grip:W8,GripHorizontal:N8,GripVertical:$8,Group:j8,Guitar:G8,Ham:K8,Hammer:X8,Hand:a7,HandCoins:J8,HandHeart:Y8,HandHelping:W0,HandMetal:Q8,HandPlatter:t7,Handshake:h7,HardDrive:d7,HardDriveDownload:e7,HardDriveUpload:c7,HardHat:p7,Hash:n7,Haze:s7,HdmiPort:r7,Heading:x7,Heading1:i7,Heading2:o7,Heading3:l7,Heading4:M7,Heading5:v7,Heading6:g7,Headphones:y7,Headset:u7,Heart:V7,HeartCrack:f7,HeartHandshake:m7,HeartOff:w7,HeartPulse:H7,Heater:C7,HelpCircle:l0,HelpingHand:W0,Hexagon:A7,Highlighter:_7,History:S7,Home:L7,Hop:Z7,HopOff:b7,Hospital:P7,Hotel:k7,Hourglass:O7,IceCream:G0,IceCream2:j0,IceCreamBowl:j0,IceCreamCone:G0,Image:D7,ImageDown:R7,ImageMinus:B7,ImageOff:T7,ImagePlay:E7,ImagePlus:F7,ImageUp:z7,Images:q7,Import:U7,Inbox:I7,Indent:X0,IndentDecrease:K0,IndentIncrease:X0,IndianRupee:N7,Infinity:$7,Info:W7,Inspect:da,InspectionPanel:j7,Instagram:G7,Italic:K7,IterationCcw:X7,IterationCw:J7,JapaneseYen:Y7,Joystick:Q7,Kanban:tl,KanbanSquare:ta,KanbanSquareDashed:jt,Key:el,KeyRound:al,KeySquare:hl,Keyboard:pl,KeyboardMusic:cl,KeyboardOff:dl,Lamp:ll,LampCeiling:nl,LampDesk:sl,LampFloor:rl,LampWallDown:il,LampWallUp:ol,LandPlot:Ml,Landmark:vl,Languages:gl,Laptop:xl,Laptop2:J0,LaptopMinimal:J0,Lasso:ul,LassoSelect:yl,Laugh:fl,Layers:Hl,Layers2:ml,Layers3:wl,Layout:Mt,LayoutDashboard:Vl,LayoutGrid:Cl,LayoutList:Al,LayoutPanelLeft:_l,LayoutPanelTop:Sl,LayoutTemplate:Ll,Leaf:bl,LeafyGreen:Zl,Library:kl,LibraryBig:Pl,LibrarySquare:aa,LifeBuoy:Ol,Ligature:Rl,Lightbulb:Tl,LightbulbOff:Bl,LineChart:El,Link:Dl,Link2:zl,Link2Off:Fl,Linkedin:ql,List:hM,ListChecks:Ul,ListCollapse:Il,ListEnd:Nl,ListFilter:$l,ListMinus:Wl,ListMusic:jl,ListOrdered:Gl,ListPlus:Kl,ListRestart:Xl,ListStart:Jl,ListTodo:Yl,ListTree:Ql,ListVideo:tM,ListX:aM,Loader:cM,Loader2:Y0,LoaderCircle:Y0,LoaderPinwheel:eM,Locate:nM,LocateFixed:dM,LocateOff:pM,Lock:rM,LockKeyhole:sM,LockKeyholeOpen:Q0,LockOpen:tt,LogIn:iM,LogOut:oM,Lollipop:lM,Luggage:MM,MSquare:ha,Magnet:vM,Mail:VM,MailCheck:gM,MailMinus:xM,MailOpen:yM,MailPlus:uM,MailQuestion:fM,MailSearch:mM,MailWarning:wM,MailX:HM,Mailbox:CM,Mails:AM,Map:bM,MapPin:SM,MapPinOff:_M,MapPinned:LM,Martini:ZM,Maximize:kM,Maximize2:PM,Medal:OM,Megaphone:BM,MegaphoneOff:RM,Meh:TM,MemoryStick:EM,Menu:FM,MenuSquare:ea,Merge:zM,MessageCircle:XM,MessageCircleCode:DM,MessageCircleDashed:qM,MessageCircleHeart:UM,MessageCircleMore:IM,MessageCircleOff:NM,MessageCirclePlus:$M,MessageCircleQuestion:WM,MessageCircleReply:jM,MessageCircleWarning:GM,MessageCircleX:KM,MessageSquare:ov,MessageSquareCode:JM,MessageSquareDashed:YM,MessageSquareDiff:QM,MessageSquareDot:tv,MessageSquareHeart:av,MessageSquareMore:hv,MessageSquareOff:ev,MessageSquarePlus:cv,MessageSquareQuote:dv,MessageSquareReply:pv,MessageSquareShare:nv,MessageSquareText:sv,MessageSquareWarning:rv,MessageSquareX:iv,MessagesSquare:lv,Mic:vv,Mic2:at,MicOff:Mv,MicVocal:at,Microscope:gv,Microwave:xv,Milestone:yv,Milk:fv,MilkOff:uv,Minimize:wv,Minimize2:mv,Minus:Hv,MinusCircle:M0,MinusSquare:ca,Monitor:Rv,MonitorCheck:Vv,MonitorDot:Cv,MonitorDown:Av,MonitorOff:_v,MonitorPause:Sv,MonitorPlay:Lv,MonitorSmartphone:bv,MonitorSpeaker:Zv,MonitorStop:Pv,MonitorUp:kv,MonitorX:Ov,Moon:Tv,MoonStar:Bv,MoreHorizontal:E0,MoreVertical:T0,Mountain:Fv,MountainSnow:Ev,Mouse:Nv,MouseOff:zv,MousePointer:Iv,MousePointer2:Dv,MousePointerBan:qv,MousePointerClick:Uv,MousePointerSquareDashed:Gt,Move:e9,Move3D:ht,Move3d:ht,MoveDiagonal:Wv,MoveDiagonal2:$v,MoveDown:Kv,MoveDownLeft:jv,MoveDownRight:Gv,MoveHorizontal:Xv,MoveLeft:Jv,MoveRight:Yv,MoveUp:a9,MoveUpLeft:Qv,MoveUpRight:t9,MoveVertical:h9,Music:n9,Music2:c9,Music3:d9,Music4:p9,Navigation:o9,Navigation2:r9,Navigation2Off:s9,NavigationOff:i9,Network:l9,Newspaper:M9,Nfc:v9,Notebook:u9,NotebookPen:g9,NotebookTabs:x9,NotebookText:y9,NotepadText:m9,NotepadTextDashed:f9,Nut:H9,NutOff:w9,Octagon:V9,OctagonAlert:et,OctagonPause:ct,OctagonX:dt,Option:C9,Orbit:A9,Origami:_9,Outdent:K0,Package:R9,Package2:S9,PackageCheck:L9,PackageMinus:b9,PackageOpen:Z9,PackagePlus:P9,PackageSearch:k9,PackageX:O9,PaintBucket:B9,PaintRoller:T9,Paintbrush:F9,Paintbrush2:E9,Palette:z9,Palmtree:_a,PanelBottom:U9,PanelBottomClose:D9,PanelBottomDashed:pt,PanelBottomInactive:pt,PanelBottomOpen:q9,PanelLeft:it,PanelLeftClose:nt,PanelLeftDashed:st,PanelLeftInactive:st,PanelLeftOpen:rt,PanelRight:$9,PanelRightClose:I9,PanelRightDashed:ot,PanelRightInactive:ot,PanelRightOpen:N9,PanelTop:G9,PanelTopClose:W9,PanelTopDashed:lt,PanelTopInactive:lt,PanelTopOpen:j9,PanelsLeftBottom:K9,PanelsLeftRight:k0,PanelsRightBottom:X9,PanelsTopBottom:ft,PanelsTopLeft:Mt,Paperclip:J9,Parentheses:Y9,ParkingCircle:g0,ParkingCircleOff:v0,ParkingMeter:Q9,ParkingSquare:na,ParkingSquareOff:pa,PartyPopper:tg,Pause:ag,PauseCircle:x0,PauseOctagon:ct,PawPrint:hg,PcCase:eg,Pen:gt,PenBox:g1,PenLine:vt,PenSquare:g1,PenTool:cg,Pencil:ng,PencilLine:dg,PencilRuler:pg,Pentagon:sg,Percent:rg,PercentCircle:y0,PercentDiamond:R0,PercentSquare:sa,PersonStanding:ig,Phone:yg,PhoneCall:og,PhoneForwarded:lg,PhoneIncoming:Mg,PhoneMissed:vg,PhoneOff:gg,PhoneOutgoing:xg,Pi:ug,PiSquare:ra,Piano:fg,Pickaxe:mg,PictureInPicture:Hg,PictureInPicture2:wg,PieChart:Vg,PiggyBank:Cg,Pilcrow:Sg,PilcrowLeft:Ag,PilcrowRight:_g,PilcrowSquare:ia,Pill:Lg,Pin:Zg,PinOff:bg,Pipette:Pg,Pizza:kg,Plane:Bg,PlaneLanding:Og,PlaneTakeoff:Rg,Play:Tg,PlayCircle:u0,PlaySquare:oa,Plug:Dg,Plug2:Eg,PlugZap:zg,PlugZap2:Fg,Plus:qg,PlusCircle:f0,PlusSquare:la,Pocket:Ig,PocketKnife:Ug,Podcast:Ng,Pointer:Wg,PointerOff:$g,Popcorn:jg,Popsicle:Gg,PoundSterling:Kg,Power:Jg,PowerCircle:m0,PowerOff:Xg,PowerSquare:Ma,Presentation:Yg,Printer:Qg,Projector:tx,Proportions:ax,Puzzle:hx,Pyramid:ex,QrCode:cx,Quote:dx,Rabbit:px,Radar:nx,Radiation:sx,Radical:rx,Radio:lx,RadioReceiver:ix,RadioTower:ox,Radius:Mx,RailSymbol:vx,Rainbow:gx,Rat:xx,Ratio:yx,Receipt:_x,ReceiptCent:ux,ReceiptEuro:fx,ReceiptIndianRupee:mx,ReceiptJapaneseYen:wx,ReceiptPoundSterling:Hx,ReceiptRussianRuble:Vx,ReceiptSwissFranc:Cx,ReceiptText:Ax,RectangleEllipsis:xt,RectangleHorizontal:Sx,RectangleVertical:Lx,Recycle:bx,Redo:kx,Redo2:Zx,RedoDot:Px,RefreshCcw:Rx,RefreshCcwDot:Ox,RefreshCw:Tx,RefreshCwOff:Bx,Refrigerator:Ex,Regex:Fx,RemoveFormatting:zx,Repeat:Ux,Repeat1:Dx,Repeat2:qx,Replace:Nx,ReplaceAll:Ix,Reply:Wx,ReplyAll:$x,Rewind:jx,Ribbon:Gx,Rocket:Kx,RockingChair:Xx,RollerCoaster:Jx,Rotate3D:yt,Rotate3d:yt,RotateCcw:Qx,RotateCcwSquare:Yx,RotateCw:ay,RotateCwSquare:ty,Route:ey,RouteOff:hy,Router:cy,Rows:ut,Rows2:ut,Rows3:ft,Rows4:dy,Rss:py,Ruler:ny,RussianRuble:sy,Sailboat:ry,Salad:iy,Sandwich:oy,Satellite:My,SatelliteDish:ly,Save:gy,SaveAll:vy,Scale:xy,Scale3D:mt,Scale3d:mt,Scaling:yy,Scan:Cy,ScanBarcode:uy,ScanEye:fy,ScanFace:my,ScanLine:wy,ScanSearch:Hy,ScanText:Vy,ScatterChart:Ay,School:_y,School2:La,Scissors:Ly,ScissorsLineDashed:Sy,ScissorsSquare:va,ScissorsSquareDashedBottom:zt,ScreenShare:Zy,ScreenShareOff:by,Scroll:ky,ScrollText:Py,Search:Ey,SearchCheck:Oy,SearchCode:Ry,SearchSlash:By,SearchX:Ty,Send:zy,SendHorizonal:wt,SendHorizontal:wt,SendToBack:Fy,SeparatorHorizontal:Dy,SeparatorVertical:qy,Server:$y,ServerCog:Uy,ServerCrash:Iy,ServerOff:Ny,Settings:jy,Settings2:Wy,Shapes:Gy,Share:Xy,Share2:Ky,Sheet:Jy,Shell:Yy,Shield:su,ShieldAlert:Qy,ShieldBan:tu,ShieldCheck:au,ShieldClose:Ht,ShieldEllipsis:hu,ShieldHalf:eu,ShieldMinus:cu,ShieldOff:du,ShieldPlus:pu,ShieldQuestion:nu,ShieldX:Ht,Ship:iu,ShipWheel:ru,Shirt:ou,ShoppingBag:lu,ShoppingBasket:Mu,ShoppingCart:vu,Shovel:gu,ShowerHead:xu,Shrink:yu,Shrub:uu,Shuffle:fu,Sidebar:it,SidebarClose:nt,SidebarOpen:rt,Sigma:mu,SigmaSquare:ga,Signal:Au,SignalHigh:wu,SignalLow:Hu,SignalMedium:Vu,SignalZero:Cu,Signpost:Su,SignpostBig:_u,Siren:Lu,SkipBack:bu,SkipForward:Zu,Skull:Pu,Slack:ku,Slash:Ou,SlashSquare:xa,Slice:Ru,Sliders:Vt,SlidersHorizontal:Bu,SlidersVertical:Vt,Smartphone:Fu,SmartphoneCharging:Tu,SmartphoneNfc:Eu,Smile:Du,SmilePlus:zu,Snail:qu,Snowflake:Uu,Sofa:Iu,SortAsc:D2,SortDesc:E2,Soup:Nu,Space:$u,Spade:Wu,Sparkle:ju,Sparkles:Ct,Speaker:Gu,Speech:Ku,SpellCheck:Ju,SpellCheck2:Xu,Spline:Yu,Split:Qu,SplitSquareHorizontal:ya,SplitSquareVertical:ua,SprayCan:tf,Sprout:af,Square:pf,SquareActivity:At,SquareArrowDown:Lt,SquareArrowDownLeft:_t,SquareArrowDownRight:St,SquareArrowLeft:bt,SquareArrowOutDownLeft:Zt,SquareArrowOutDownRight:Pt,SquareArrowOutUpLeft:kt,SquareArrowOutUpRight:Ot,SquareArrowRight:Rt,SquareArrowUp:Et,SquareArrowUpLeft:Bt,SquareArrowUpRight:Tt,SquareAsterisk:Ft,SquareBottomDashedScissors:zt,SquareCheck:qt,SquareCheckBig:Dt,SquareChevronDown:Ut,SquareChevronLeft:It,SquareChevronRight:Nt,SquareChevronUp:$t,SquareCode:Wt,SquareDashedBottom:ef,SquareDashedBottomCode:hf,SquareDashedKanban:jt,SquareDashedMousePointer:Gt,SquareDivide:Kt,SquareDot:Xt,SquareEqual:Jt,SquareFunction:Yt,SquareGanttChart:Qt,SquareKanban:ta,SquareLibrary:aa,SquareM:ha,SquareMenu:ea,SquareMinus:ca,SquareMousePointer:da,SquareParking:na,SquareParkingOff:pa,SquarePen:g1,SquarePercent:sa,SquarePi:ra,SquarePilcrow:ia,SquarePlay:oa,SquarePlus:la,SquarePower:Ma,SquareRadical:cf,SquareScissors:va,SquareSigma:ga,SquareSlash:xa,SquareSplitHorizontal:ya,SquareSplitVertical:ua,SquareStack:df,SquareTerminal:fa,SquareUser:wa,SquareUserRound:ma,SquareX:Ha,Squircle:nf,Squirrel:sf,Stamp:rf,Star:Mf,StarHalf:of,StarOff:lf,Stars:Ct,StepBack:vf,StepForward:gf,Stethoscope:xf,Sticker:yf,StickyNote:uf,StopCircle:H0,Store:ff,StretchHorizontal:mf,StretchVertical:wf,Strikethrough:Hf,Subscript:Vf,Subtitles:G2,Sun:Lf,SunDim:Cf,SunMedium:Af,SunMoon:_f,SunSnow:Sf,Sunrise:bf,Sunset:Zf,Superscript:Pf,SwatchBook:kf,SwissFranc:Of,SwitchCamera:Rf,Sword:Bf,Swords:Tf,Syringe:Ef,Table:Nf,Table2:Ff,TableCellsMerge:zf,TableCellsSplit:Df,TableColumnsSplit:qf,TableProperties:Uf,TableRowsSplit:If,Tablet:Wf,TabletSmartphone:$f,Tablets:jf,Tag:Gf,Tags:Kf,Tally1:Xf,Tally2:Jf,Tally3:Yf,Tally4:Qf,Tally5:tm,Tangent:am,Target:hm,Telescope:em,Tent:dm,TentTree:cm,Terminal:pm,TerminalSquare:fa,TestTube:nm,TestTube2:Va,TestTubeDiagonal:Va,TestTubes:sm,Text:Mm,TextCursor:im,TextCursorInput:rm,TextQuote:om,TextSearch:lm,TextSelect:Ca,TextSelection:Ca,Theater:vm,Thermometer:ym,ThermometerSnowflake:gm,ThermometerSun:xm,ThumbsDown:um,ThumbsUp:fm,Ticket:_m,TicketCheck:mm,TicketMinus:wm,TicketPercent:Hm,TicketPlus:Vm,TicketSlash:Cm,TicketX:Am,Timer:bm,TimerOff:Sm,TimerReset:Lm,ToggleLeft:Zm,ToggleRight:Pm,Tornado:km,Torus:Om,Touchpad:Bm,TouchpadOff:Rm,TowerControl:Tm,ToyBrick:Em,Tractor:Fm,TrafficCone:zm,Train:Aa,TrainFront:qm,TrainFrontTunnel:Dm,TrainTrack:Um,TramFront:Aa,Trash:Nm,Trash2:Im,TreeDeciduous:$m,TreePalm:_a,TreePine:Wm,Trees:jm,Trello:Gm,TrendingDown:Km,TrendingUp:Xm,Triangle:Ym,TriangleAlert:Sa,TriangleRight:Jm,Trophy:Qm,Truck:tw,Turtle:aw,Tv:ew,Tv2:hw,Twitch:cw,Twitter:dw,Type:pw,Umbrella:sw,UmbrellaOff:nw,Underline:rw,Undo:lw,Undo2:iw,UndoDot:ow,UnfoldHorizontal:Mw,UnfoldVertical:vw,Ungroup:gw,University:La,Unlink:yw,Unlink2:xw,Unlock:tt,UnlockKeyhole:Q0,Unplug:uw,Upload:fw,UploadCloud:b0,Usb:mw,User:Lw,User2:Ra,UserCheck:ww,UserCheck2:ba,UserCircle:C0,UserCircle2:V0,UserCog:Hw,UserCog2:Za,UserMinus:Vw,UserMinus2:Pa,UserPlus:Cw,UserPlus2:ka,UserRound:Ra,UserRoundCheck:ba,UserRoundCog:Za,UserRoundMinus:Pa,UserRoundPlus:ka,UserRoundSearch:Aw,UserRoundX:Oa,UserSearch:_w,UserSquare:wa,UserSquare2:ma,UserX:Sw,UserX2:Oa,Users:bw,Users2:Ba,UsersRound:Ba,Utensils:Pw,UtensilsCrossed:Zw,UtilityPole:kw,Variable:Ow,Vault:Rw,Vegan:Bw,VenetianMask:Tw,Verified:I2,Vibrate:Fw,VibrateOff:Ew,Video:Dw,VideoOff:zw,Videotape:qw,View:Uw,Voicemail:Iw,Volume:jw,Volume1:Nw,Volume2:$w,VolumeX:Ww,Vote:Gw,Wallet:Xw,Wallet2:Ta,WalletCards:Kw,WalletMinimal:Ta,Wallpaper:Jw,Wand:Yw,Wand2:Ea,WandSparkles:Ea,Warehouse:Qw,WashingMachine:tH,Watch:aH,Waves:hH,Waypoints:eH,Webcam:cH,Webhook:pH,WebhookOff:dH,Weight:nH,Wheat:rH,WheatOff:sH,WholeWord:iH,Wifi:lH,WifiOff:oH,Wind:MH,Wine:gH,WineOff:vH,Workflow:xH,Worm:yH,WrapText:uH,Wrench:fH,X:mH,XCircle:A0,XOctagon:dt,XSquare:Ha,Youtube:wH,Zap:VH,ZapOff:HH,ZoomIn:CH,ZoomOut:AH},Symbol.toStringTag,{value:"Module"}));/**
 * @license lucide v0.378.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const SH=({icons:a={},nameAttr:h="data-lucide",attrs:e={}}={})=>{if(!Object.values(a).length)throw new Error(`Please provide an icons object.
If you want to use all the icons you can import it like:
 \`import { createIcons, icons } from 'lucide';
lucide.createIcons({icons});\``);if(typeof document>"u")throw new Error("`createIcons()` only works in a browser environment.");const c=document.querySelectorAll(`[${h}]`);if(Array.from(c).forEach(d=>k2(d,{nameAttr:h,icons:a,attrs:e})),h==="data-lucide"){const d=document.querySelectorAll("[icon-name]");d.length>0&&(console.warn("[Lucide] Some icons were found with the now deprecated icon-name attribute. These will still be replaced for backwards compatibility, but will no longer be supported in v1.0 and you should switch to data-lucide"),Array.from(d).forEach(p=>k2(p,{nameAttr:"icon-name",icons:a,attrs:e})))}};V.plugin(Hc);window.Alpine=V;window.axios=za;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";const Fa=document.head.querySelector('meta[name="csrf-token"]');Fa&&(window.axios.defaults.headers.common["X-CSRF-TOKEN"]=Fa.content);function L1(){try{SH({icons:_H})}catch{}}window.renderIcons=L1;V.store("sidebar",{open:localStorage.getItem("sidebarOpen")!=="false",mobileOpen:!1,toggle(){this.open=!this.open,localStorage.setItem("sidebarOpen",this.open)},toggleMobile(){this.mobileOpen=!this.mobileOpen},closeMobile(){this.mobileOpen=!1}});V.store("toast",{items:[],add(a,h="success",e=4e3){const c=Date.now()+Math.random();this.items.push({id:c,message:a,type:h}),setTimeout(()=>this.remove(c),e)},remove(a){this.items=this.items.filter(h=>h.id!==a)}});V.data("dropdown",(a={})=>({open:!1,floating:a.floating||!1,toggle(){this.open?this.close():this.show()},show(){this.open=!0,this.floating&&this.$nextTick(()=>this.place())},close(){this.open=!1},place(){const h=this.$refs.trigger,e=this.$refs.menu;if(!h||!e)return;e.style.position="fixed",e.style.margin="0",e.style.right="auto";const c=h.getBoundingClientRect();let d=c.right-e.offsetWidth,p=c.bottom+4;p+e.offsetHeight>window.innerHeight-8&&(p=Math.max(8,c.top-e.offsetHeight-4)),d<8&&(d=8),e.style.left=d+"px",e.style.top=p+"px"}}));V.data("confirmDelete",()=>({show:!1,url:"",name:"",loading:!1,open(a,h=""){this.url=a,this.name=h,this.show=!0},close(){this.show=!1,this.url="",this.name="",this.loading=!1},async confirm(){var a,h;if(this.url){this.loading=!0;try{await za.delete(this.url),V.store("toast").add("Успешно удалено","success"),setTimeout(()=>window.location.reload(),500)}catch(e){V.store("toast").add(((h=(a=e==null?void 0:e.response)==null?void 0:a.data)==null?void 0:h.message)||"Ошибка при удалении","error"),this.loading=!1,this.close()}}}}));V.data("commandPalette",()=>({open:!1,q:"",active:0,items:window.__navItems||[],get results(){const a=this.q.trim().toLowerCase();return a?this.items.filter(h=>(h.label+" "+(h.group||"")).toLowerCase().includes(a)):this.items},toggle(){this.open=!this.open,this.open&&(this.q="",this.active=0,this.$nextTick(()=>{this.$refs.input&&this.$refs.input.focus(),L1()}))},close(){this.open=!1},move(a){const h=this.results.length;h&&(this.active=(this.active+a+h)%h)},go(){const a=this.results[this.active];a&&(window.location.href=a.url)}}));document.addEventListener("alpine:initialized",L1);document.addEventListener("DOMContentLoaded",L1);document.addEventListener("keydown",a=>{if(!(a.ctrlKey||a.metaKey))return;const h=a.key.toLowerCase();h==="k"?(a.preventDefault(),window.dispatchEvent(new CustomEvent("command-palette-toggle"))):h==="b"&&(a.preventDefault(),V.store("sidebar").toggle())});V.start();
