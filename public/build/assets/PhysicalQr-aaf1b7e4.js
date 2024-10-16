import{O as v,r as n,m as T,B as q,j as e}from"./app-6efd6b9b.js";import{e as N}from"./qr-scanner.min-a8df683f.js";const w=()=>{var x;const[g]=v(),c=g.get("tickets"),[r,S]=n.useState((c==null?void 0:c.split(","))??[]),j=(x=c==null?void 0:c.split(","))==null?void 0:x.length,a=n.useRef(null),[s,l]=n.useState(null),[u,d]=n.useState(!1),[h,k]=n.useState(0),[p,f]=n.useState(!1);n.useEffect(()=>{if(a.current&&!s){const t=new N(a.current,i=>{p||b(i)},{highlightScanRegion:!0,highlightCodeOutline:!0});l(t)}return()=>{s&&(s.stop(),s.destroy(),l(null))}},[a,s,p]);const y=()=>{s?(d(!0),s.start()):console.error("Scanner is not initialized yet")},b=async t=>{const i=r[r.length-1];if(!(!(t!=null&&t.data)||!i)){d(!1),f(!0),s&&s.stop();try{await T.post("https://events.essenciacompany.com/api/tickets/update-code",{ticket:i,code:t==null?void 0:t.data}),S(o=>{const m=[...o];return m.pop(),m}),k(o=>o+1)}catch{q.error("Error scanning ticket")}finally{f(!1)}}};return e.jsxs("section",{className:"scanner-page",style:{display:"flex",flexDirection:"column"},children:[e.jsxs("h3",{children:[h," / ",j," tickets scanned"]}),u?"":r!=null&&r.length?e.jsxs("div",{className:"qr-box flex-column",onClick:y,children:[e.jsx("img",{className:"qr-image",src:"/assets/qr-code.png",alt:"QR Code"}),e.jsxs("h3",{children:["Tap to start scanning",h>0?" next":""]})]}):e.jsx("a",{href:"/pos/tickets",className:"qr-box flex-column",children:e.jsxs("h3",{style:{textTransform:"capitalize",textAlign:"center"},children:["All tickets are done scanning",e.jsx("br",{}),e.jsx("br",{}),"Go back to tickets"]})}),e.jsx("div",{id:"viewfinder",className:"qr-box",style:u?{}:{display:"none"},children:e.jsx("video",{ref:a,children:"Your browser does not support video playback."})})]})};export{w as default};