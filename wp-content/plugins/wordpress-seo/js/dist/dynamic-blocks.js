(()=>{"use strict";var e={n:t=>{var r=t&&t.__esModule?()=>t.default:()=>t;return e.d(r,{a:r}),r},d:(t,r)=>{for(var s in r)e.o(r,s)&&!e.o(t,s)&&Object.defineProperty(t,s,{enumerable:!0,get:r[s]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.React,r=window.wp.blockEditor,s=window.wp.blocks,o=window.wp.serverSideRender;var a=e.n(o);const n=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"version":"22.8","name":"yoast-seo/breadcrumbs","title":"Yoast Breadcrumbs","description":"Adds the Yoast SEO breadcrumbs to your template or content.","category":"yoast-internal-linking-blocks","icon":"admin-links","keywords":["SEO","breadcrumbs","internal linking","site structure"],"textdomain":"wordpress-seo","attributes":{"className":{"type":"string"}},"example":{"attributes":{}}}');(0,s.registerBlockType)(n,{edit:e=>{const s=(0,r.useBlockProps)();return(0,t.createElement)("div",{...s},(0,t.createElement)(a(),{block:"yoast-seo/breadcrumbs",attributes:e.attributes}))},save:()=>null})})();