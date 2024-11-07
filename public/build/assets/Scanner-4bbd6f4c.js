import{r as o,j as e,m as q,R as T,B as D}from"./app-155c5dff.js";import{e as X}from"./qr-scanner.min-96a1cdc4.js";import{a as G,P as ee,I as se,B as z,F as ne}from"./PhoneNumberInput-b9f84f4d.js";import"./index-69538333.js";function ae({item:s}){const r=o.useMemo(()=>((s==null?void 0:s.newQty)??0)-((s==null?void 0:s.qty)??0),[s==null?void 0:s.newQty,s==null?void 0:s.qty]);return e.jsx(e.Fragment,{children:e.jsxs("tr",{className:"table-info",children:[e.jsx("td",{children:(s==null?void 0:s.display_name)??(s==null?void 0:s.name)}),e.jsxs("td",{children:[s==null?void 0:s.price," €"]}),e.jsx("td",{children:r}),e.jsxs("td",{children:[(s==null?void 0:s.price)*r," €"]})]})})}function le({items:s=[],cartTotal:r=0,discount:l=0}){const p=o.useMemo(()=>r-l,[r,l]);return e.jsxs("div",{className:"h-100 d-flex flex-column justify-content-start",children:[e.jsx("h5",{className:"modal-title text-start mb-2",id:"paymentModalLabel",children:"Cart Information"}),e.jsx("div",{className:"cart-info-items-container",children:e.jsx("div",{className:"card",children:e.jsxs("table",{className:"table mb-0 rounded",children:[e.jsx("thead",{children:e.jsxs("tr",{children:[e.jsx("th",{children:"Item"}),e.jsx("th",{children:"Price"}),e.jsx("th",{children:"Quantity"}),e.jsx("th",{children:"Total"})]})}),e.jsx("tbody",{children:s==null?void 0:s.map((u,n)=>u.newQty?e.jsx(ae,{item:u},n):"")})]})})}),e.jsx("div",{className:"card mt-auto",children:e.jsx("table",{className:"table mb-0",children:e.jsxs("tbody",{children:[e.jsxs("tr",{children:[e.jsx("td",{children:"Subtotal"}),e.jsxs("td",{children:[r," €"]})]}),e.jsxs("tr",{children:[e.jsx("td",{children:"Discount"}),e.jsxs("td",{children:[l," €"]})]}),e.jsxs("tr",{children:[e.jsx("td",{children:"Total"}),e.jsxs("td",{children:[p," €"]})]})]})})})]})}const te=({open:s,onClose:r,ticket:l,handleSubmit:p,withdraw:u,setWithdraw:n})=>{const[m,b]=o.useState(!0),[y,C]=o.useState(!1);o.useState(!1),o.useState(!1);const P=()=>{C(t=>!t)},k=()=>{b(t=>!t)},Q=o.useMemo(()=>{var j;var t=0;return(j=l==null?void 0:l.extras)==null||j.map(h=>{(h==null?void 0:h.newQty)>0&&(t+=((h==null?void 0:h.newQty)-h.qty)*h.price)}),t},[l==null?void 0:l.extras]),[d,x]=o.useState({name:"",email:"",phone:"",vatNumber:"",discount:0,paymentMethod:"Cash",sendToMail:y,sendToPhone:m,withdraw:u}),{data:S}=G(["withdraw_checked"],"https://events.essenciacompany.com/api/withdraw_checked");o.useEffect(()=>{n(S==null?void 0:S.checked)},[S]),o.useEffect(()=>{var t;(t=l==null?void 0:l.order_id)!=null&&t.billing&&x({name:l.order_id.billing.name||"",email:l.order_id.billing.email||"",phone:l.order_id.billing.phone||"",vatNumber:l.order_id.billing.vatNumber||"",discount:0,paymentMethod:"Cash"})},[l]);const N=t=>{const{name:j,value:h}=t.target;x(w=>({...w,[j]:h}))},[F,_]=o.useState(!1);o.useEffect(()=>{const t=document.getElementById("scannerPaymentModal");s?(t.classList.add("show","fade-in"),t.style.display="block"):(t.classList.remove("fade-in"),t.classList.add("fade-out"),setTimeout(()=>{t.style.display="none",t.classList.remove("show","fade-out")},300))},[s]);const I=()=>r(),v=async()=>{var h;_(!0);const t={biling:d,tickets:[],extras:(h=l==null?void 0:l.extras)==null?void 0:h.map(w=>{if(w.newQty>0)return{...w,quantity:w.newQty-w.qty}}),discount:d.discount,paymentMethod:d.paymentMethod,subTotal:Q,total:Q};(await q.post("https://events.essenciacompany.com/api/create-order",t,{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}})).status==200&&(p(),x({name:"",email:"",phone:"",vatNumber:"",discount:0,paymentMethod:"Cash"}),C(!1),b(!1),I()),_(!1)};return e.jsxs(e.Fragment,{children:[s&&e.jsx("div",{className:"payment-modal-backdrop payment-modal-fade-in"}),e.jsx("div",{className:`modal payment-modal ${s?"payment-modal-fade-in":"payment-modal-fade-out"}`,id:"scannerPaymentModal",tabIndex:"-1","aria-labelledby":"paymentModalLabel","aria-hidden":!s,onClick:I,children:e.jsx("div",{className:"modal-dialog modal-center modal-lg",onClick:t=>t.stopPropagation(),children:e.jsxs("div",{className:"modal-content p-0",children:[e.jsxs("div",{className:"modal-header",children:[e.jsx("h5",{className:"modal-title text-center",id:"paymentModalLabel",children:"Place Order"}),e.jsx("button",{type:"button",className:"btn-close","aria-label":"Close",onClick:I})]}),e.jsxs("div",{className:"modal-body row",children:[e.jsxs("div",{className:"col-md-6",children:[e.jsx("h5",{className:"modal-title text-start mb-2",id:"paymentModalLabel",children:"Payment Information"}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsx("label",{htmlFor:"nameInput",children:"Name"}),e.jsx("input",{id:"nameInput",name:"name",className:"form-control",value:d.name,onChange:N,placeholder:"Enter name"})]}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsxs("label",{htmlFor:"emailInput",children:["Email"," "]}),e.jsx("input",{id:"emailInput",className:"form-control",name:"email",value:d.email,onChange:N,placeholder:"Enter email"})]}),e.jsx(ee,{value:d.phone,onChange:t=>x(j=>({...j,phone:"+"+t}))}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsx("label",{htmlFor:"vatInput",children:"VAT Number (optional)"}),e.jsx("input",{id:"vatInput",className:"form-control",name:"vatNumber",value:d.vatNumber,onChange:N,placeholder:"Enter VAT number"})]}),e.jsxs("div",{className:"form-group row mb-4",children:[e.jsxs("div",{className:"col-md-4",children:[e.jsx("label",{htmlFor:"discountInput",children:"Payment Method"}),e.jsxs("select",{class:"form-select","aria-label":"Default select example",onChange:t=>x(j=>({...j,paymentMethod:t.target.value})),children:[e.jsx("option",{value:"Cash",selected:!0,children:"Cash"}),e.jsx("option",{value:"Card",children:"Card"})]})]}),e.jsxs("div",{className:"col-md-8",children:[e.jsx("label",{htmlFor:"discountInput",children:"Discount"}),e.jsx("input",{id:"discountInput",type:"number",className:"form-control",name:"discount",value:d.discount>0?d.discount:"",onChange:N,placeholder:"Enter discount"})]})]}),e.jsxs("div",{className:"form-check",children:[e.jsx("input",{className:"form-check-input",type:"checkbox",value:"",id:"flexCheckDefault",checked:u,onChange:()=>n(!u)}),e.jsx("label",{className:"form-check-label",for:"flexCheckDefault",children:"Withdraw"})]}),e.jsxs("div",{class:"form-check",children:[e.jsx("input",{class:"form-check-input",type:"checkbox",value:m,checked:m,onChange:k,id:"sendToPhoneCheck"}),e.jsx("label",{class:"form-check-label",htmlFor:"sendToPhoneCheck",children:"Send to phone"})]}),e.jsxs("div",{class:"form-check",children:[e.jsx("input",{class:"form-check-input",type:"checkbox",value:y,checked:y,onChange:P,id:"sendToMailCheck"}),e.jsx("label",{class:"form-check-label",htmlFor:"sendToMailCheck",children:"Send to mail"})]})]}),e.jsx("div",{className:"col-md-6",children:e.jsx(le,{items:l==null?void 0:l.extras,cartTotal:Q,discount:d.discount})})]}),e.jsxs("div",{className:"modal-footer",children:[e.jsx("button",{type:"button",className:"btn btn-secondary",onClick:I,children:"Close"}),e.jsx("button",{type:"button",className:"btn btn-primary",onClick:v,disabled:!d.name||(d.vatNumber?!(d.email||d.phone):!1)||F,children:F?"Processing...":"Proceed"})]})]})})})]})},oe=({extra:s,index:r,handleExtraChange:l})=>{const[p,u]=o.useState(0),n=parseInt((s==null?void 0:s.newQty)??0)||parseInt((s==null?void 0:s.qty)??0),m=parseFloat((s==null?void 0:s.price)??0).toFixed(2),b=C=>{const P=parseInt(C.target.value)||0;u(P)},y=()=>{p>0&&p<=s.qty-s.used&&(l(s,p),u(0))};return e.jsx("div",{className:"card",children:e.jsxs("div",{className:"card-body text-start",children:[e.jsxs("div",{className:"d-flex justify-content-between align-items-center",children:[e.jsxs("p",{className:"h6",children:[(s==null?void 0:s.display_name)??(s==null?void 0:s.name)," X ",n-(s==null?void 0:s.used),s!=null&&s.newQty?e.jsxs("sup",{className:"text-secondary fs-6",children:["+ ",(s==null?void 0:s.newQty)-(s==null?void 0:s.qty)]}):""]}),e.jsxs("h6",{children:["€"," ",(m*parseInt(s!=null&&s.newQty?(s==null?void 0:s.newQty)-(s==null?void 0:s.qty):0)).toFixed(2)]})]}),e.jsxs("div",{className:"mt-3",children:[e.jsxs("label",{htmlFor:"",children:["Withdraw (Available: ",(s==null?void 0:s.qty)-(s==null?void 0:s.used),")"]}),e.jsxs("div",{className:"form-inline d-flex gap-2",children:[e.jsx("input",{type:"number",min:1,max:(s==null?void 0:s.qty)-(s==null?void 0:s.used),value:p,onChange:b,className:"form-control"}),e.jsx("button",{className:"btn btn-sm btn-dark",onClick:y,children:e.jsx("i",{className:"fa fa-check"})})]})]})]})},r)},he=()=>{var U,V;const s=T.useRef(null),[r,l]=o.useState(null),[p,u]=o.useState(!1),[n,m]=o.useState(null),[b,y]=o.useState(""),[C,P]=o.useState(!1),[k,Q]=o.useState(!1),[d,x]=o.useState(!1);o.useEffect(()=>{if(s.current&&!r){const a=new X(s.current,c=>{N(c)},{highlightScanRegion:!0,highlightCodeOutline:!0});l(a)}return()=>{r&&(r.stop(),r.destroy(),l(null))}},[s.current,r]);const S=()=>{r?(u(!0),P(!0),r.start()):console.error("Scanner is not initialized yet")},N=async a=>{if(a!=null&&a.data)try{const c=await q.post("https://events.essenciacompany.com/api/tickets/get",{ticket:a==null?void 0:a.data});m(c.data)}catch(c){D("Error scanning ticket",c)}},F=a=>{a.key==="Enter"&&_()},_=async()=>{if(b){Q(!1),u(!1);try{const a=await q.post("https://events.essenciacompany.com/api/tickets/get",{ticket:b});m(a.data),y("")}catch(a){D("Error scanning ticket",a)}finally{setIsProcessing(!1)}}},I=(a,c)=>{const f=parseInt(a==null?void 0:a.used)??0;if(c=parseInt(c),c>a.qty-(a==null?void 0:a.used))return;a={...a,used:c+f};var M=n.extras.map(W=>W.id===a.id?a:W);let i=n;i.extras=M,m(i),console.log(n),L()},{data:v,isError:t,isLoading:j,isSuccess:h,refetch:w}=G(["scanner-extras",n],`https://events.essenciacompany.com/api/event-extras/${n==null?void 0:n.event_id}`),[O,A]=o.useState(!1),[g,K]=o.useState(null),[R,$]=o.useState(1),Y=()=>{var M;if(!O){A(!0);return}const a={...g,qty:0,newQty:R};var c=!0,f=(M=n==null?void 0:n.extras)==null?void 0:M.map(i=>(console.log(i),i.id===a.id?(c=!1,{...i,newQty:parseInt(a.newQty)+parseInt((i==null?void 0:i.newQty)??(i==null?void 0:i.qty)??0)}):i));c&&(f=[...f,a]),m(i=>({...i,extras:[...f]})),A(!1),K(null),$(1)},[H,E]=o.useState(!1),L=async()=>{if(E(!0),(await q.post("https://events.essenciacompany.com/api/update-ticket",{ticket:n,can_withdraw:d},{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}})).status==200&&(m(null),u(!1),x(!1),D("Ticket updated successfully!!"),r)){r.stop();const c=new X(s.current,f=>{N(f)},{highlightScanRegion:!0,highlightCodeOutline:!0});l(c),c.start()}E(!1)},J=async()=>{var c;E(!0);const a=await q.post("https://events.essenciacompany.com/api/tickets/activate",{ticket:n==null?void 0:n.id},{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}});a.status==200&&(m((c=a==null?void 0:a.data)==null?void 0:c.ticket),D("Ticket activated successfully!!")),E(!1)},[Z,B]=o.useState(!1);return e.jsxs("section",{className:"scanner-page",children:[n?e.jsxs("div",{className:"ticket-info",children:[e.jsx("h3",{children:"Ticket Information"}),e.jsxs("div",{className:"ticket-details",children:[e.jsxs("p",{children:[e.jsx("strong",{children:"Owner:"})," ",n==null?void 0:n.owner.name]}),(n==null?void 0:n.owner.email)&&e.jsxs("p",{children:[e.jsx("strong",{children:"Email:"})," ",n==null?void 0:n.owner.email]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Event:"})," ",n==null?void 0:n.event_name]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Ticket:"})," ",n==null?void 0:n.product_name]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Price:"})," €",n==null?void 0:n.price]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Status:"})," ",(n==null?void 0:n.status)===0?"Not Used":"Used"]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Dates:"})," ",n==null?void 0:n.dates.join(", ")]}),e.jsx("p",{children:e.jsxs("strong",{children:[(n==null?void 0:n.active)===0&&"Not ","Active",(n==null?void 0:n.active)===0&&e.jsx("span",{className:"btn btn-success ms-3 py-1 px-2",onClick:J,children:"Activate"})]})})]}),((U=n==null?void 0:n.extras)==null?void 0:U.length)>0?e.jsxs("div",{className:"extras",children:[e.jsx("h4",{children:"Extras"}),n==null?void 0:n.extras.map((a,c)=>e.jsx(oe,{extra:a,index:c,handleExtraChange:I}))]}):null,O&&e.jsx("div",{className:"modal-body row",children:e.jsxs("div",{className:"col-md-12",children:[e.jsxs("div",{className:"form-group",children:[e.jsx("label",{htmlFor:"extraSelect",children:"Select Extra"}),e.jsxs("select",{id:"extraSelect",className:"form-control mt-2",value:(g==null?void 0:g.display_name)||"",onChange:a=>{var f;const c=(f=v==null?void 0:v.data)==null?void 0:f.find(M=>M.display_name===a.target.value);K(c||null)},children:[e.jsx("option",{value:"",children:"None"}),(V=v==null?void 0:v.data)==null?void 0:V.map((a,c)=>e.jsx("option",{value:a==null?void 0:a.display_name,children:a==null?void 0:a.display_name},c))]})]}),g&&e.jsxs(e.Fragment,{children:[e.jsxs("div",{className:"form-group mt-3 d-flex flex-column justify-content-center align-items-center",children:[e.jsx("label",{htmlFor:"quantity",children:"Quantity"}),e.jsxs(se,{className:"w-50",children:[e.jsx(z,{variant:"outline-secondary",onClick:()=>$(a=>a-1>0?a-1:a),children:"-"}),e.jsx(ne.Control,{"aria-label":"Example text with two button addons",className:"text-center",readOnly:!0,value:R}),e.jsx(z,{variant:"outline-danger",onClick:()=>$(a=>a+1),children:"+"})]})]}),e.jsxs("label",{htmlFor:"price",children:["Price",e.jsx("br",{}),(g==null?void 0:g.price)*R,"€"]})]})]})}),e.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:e.jsx("button",{type:"button",class:"btn btn-info text-light w-100 py-1",onClick:Y,children:"Add extra"})}),e.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:e.jsx("button",{type:"button",class:"btn btn-success text-light w-100 py-1",onClick:()=>B(!0),children:H?"Processing...":"Save Changes"})})]}):p?"":e.jsxs("div",{className:"d-flex flex-column align-items-center gap-3",children:[e.jsxs("div",{className:"qr-box flex-column",onClick:S,children:[e.jsx("img",{className:"qr-image",src:"/assets/qr-code.png",alt:"QR Code"}),e.jsx("h3",{children:"start scanning"})]}),e.jsx("h3",{children:"or"}),e.jsx("input",{className:"qr-box flex-column",type:"text",onChange:a=>y(a.target.value),onKeyDown:F,placeholder:"Manually enter ticket code"})]}),!n&&e.jsxs("div",{children:[e.jsx("div",{id:"viewfinder",className:"qr-box",style:C?{}:{display:"none"},children:e.jsx("video",{ref:s,children:"Your browser does not support video playback."})}),e.jsx("div",{id:"manual-input",className:"form-group",style:k?{}:{display:"none"},children:e.jsx("input",{type:"text",name:"manual",className:"form-control",id:"manual",value:b,onChange:a=>y(a.target.value),onKeyDown:F,placeholder:"Enter ticket code manually"})})]}),e.jsx(te,{open:Z,onClose:()=>B(!1),ticket:n,handleSubmit:L,withdraw:d,setWithdraw:x})]})};export{he as default};
