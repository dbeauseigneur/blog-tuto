import{B as b}from"./basedecoder.c2fc4d47.js";const B=9,E=256,p=257,k=12;function x(c,o,r){const i=o%8,n=Math.floor(o/8),h=8-i,g=o+r-(n+1)*8;let l=8*(n+2)-(o+r);const w=(n+2)*8-o;if(l=Math.max(0,l),n>=c.length)return console.warn("ran off the end of the buffer before finding EOI_CODE (end on input code)"),p;let u=c[n]&2**(8-i)-1;u<<=r-h;let s=u;if(n+1<c.length){let f=c[n+1]>>>l;f<<=Math.max(0,r-w),s+=f}if(g>8&&n+2<c.length){const f=(n+3)*8-(o+r),t=c[n+2]>>>f;s+=t}return s}function D(c,o){for(let r=o.length-1;r>=0;r--)c.push(o[r]);return c}function A(c){const o=new Uint16Array(4093),r=new Uint8Array(4093);for(let e=0;e<=257;e++)o[e]=4096,r[e]=e;let i=258,n=B,h=0;function g(){i=258,n=B}function l(e){const a=x(e,h,n);return h+=n,a}function w(e,a){return r[i]=a,o[i]=e,i++,i-1}function u(e){const a=[];for(let y=e;y!==4096;y=o[y])a.push(r[y]);return a}const s=[];g();const f=new Uint8Array(c);let t=l(f),d;for(;t!==p;){if(t===E){for(g(),t=l(f);t===E;)t=l(f);if(t===p)break;if(t>E)throw new Error(`corrupted code at scanline ${t}`);{const e=u(t);D(s,e),d=t}}else if(t<i){const e=u(t);D(s,e),w(d,e[e.length-1]),d=t}else{const e=u(d);if(!e)throw new Error(`Bogus entry. Not in dictionary, ${d} / ${i}, position: ${h}`);D(s,e),s.push(e[e.length-1]),w(d,e[e.length-1]),d=t}i+1>=2**n&&(n===k?d=void 0:n++),t=l(f)}return new Uint8Array(s)}class m extends b{decodeBlock(o){return A(o).buffer}}export{m as default};
