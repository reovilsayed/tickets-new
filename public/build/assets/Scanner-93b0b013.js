import{r as t,j as e,a as T,R as ne,B as L}from"./app-29ce534f.js";import{e as z}from"./qr-scanner.min-00b2fd46.js";import{a as Y,P as H,I as le,B as G,F as te}from"./PhoneNumberInput-24369530.js";import"./index-b9f6117c.js";function oe({item:s}){const d=t.useMemo(()=>((s==null?void 0:s.newQty)??0)-((s==null?void 0:s.qty)??0),[s==null?void 0:s.newQty,s==null?void 0:s.qty]);return e.jsx(e.Fragment,{children:e.jsxs("tr",{className:"table-info",children:[e.jsx("td",{children:(s==null?void 0:s.display_name)??(s==null?void 0:s.name)}),e.jsxs("td",{children:[s==null?void 0:s.price," €"]}),e.jsx("td",{children:d}),e.jsxs("td",{children:[(s==null?void 0:s.price)*d," €"]})]})})}function re({items:s=[],cartTotal:d=0,discount:l=0}){const y=t.useMemo(()=>d-l,[d,l]);return e.jsxs("div",{className:"h-100 d-flex flex-column justify-content-start",children:[e.jsx("h5",{className:"modal-title text-start mb-2",id:"paymentModalLabel",children:"Cart Information"}),e.jsx("div",{className:"cart-info-items-container",children:e.jsx("div",{className:"card",children:e.jsxs("table",{className:"table mb-0 rounded",children:[e.jsx("thead",{children:e.jsxs("tr",{children:[e.jsx("th",{children:"Item"}),e.jsx("th",{children:"Price"}),e.jsx("th",{children:"Quantity"}),e.jsx("th",{children:"Total"})]})}),e.jsx("tbody",{children:s==null?void 0:s.map((u,a)=>u.newQty?e.jsx(oe,{item:u},a):"")})]})})}),e.jsx("div",{className:"card mt-auto",children:e.jsx("table",{className:"table mb-0",children:e.jsxs("tbody",{children:[e.jsxs("tr",{children:[e.jsx("td",{children:"Subtotal"}),e.jsxs("td",{children:[d," €"]})]}),e.jsxs("tr",{children:[e.jsx("td",{children:"Discount"}),e.jsxs("td",{children:[l," €"]})]}),e.jsxs("tr",{children:[e.jsx("td",{children:"Total"}),e.jsxs("td",{children:[y," €"]})]})]})})})]})}const ce=({open:s,onClose:d,ticket:l,handleSubmit:y,withdraw:u,setWithdraw:a})=>{const[m,v]=t.useState(!0),[j,N]=t.useState(!1),_=()=>{N(r=>!r)},R=()=>{v(r=>!r)},g=t.useMemo(()=>{var P;var r=0;return(P=l==null?void 0:l.extras)==null||P.map(f=>{(f==null?void 0:f.newQty)>0&&(r+=((f==null?void 0:f.newQty)-f.qty)*f.price)}),r},[l==null?void 0:l.extras]),[i,h]=t.useState({name:"",email:"",phone:"",vatNumber:"",discount:0,paymentMethod:"Cash",withdraw:u}),[C,I]=t.useState(0),E=t.useMemo(()=>C>g-i.discount?parseFloat(C-g-i.discount):0,[g,i.discount,C]),{data:S}=Y(["withdraw_checked"],"https://events.essenciacompany.com/api/withdraw_checked");t.useEffect(()=>{a(S==null?void 0:S.checked)},[S]),t.useEffect(()=>{var r;(r=l==null?void 0:l.order_id)!=null&&r.billing&&h({name:l.order_id.billing.name||"",email:l.order_id.billing.email||"",phone:l.order_id.billing.phone||"",vatNumber:l.order_id.billing.vatNumber||"",discount:0,paymentMethod:"Cash"})},[l]);const w=r=>{const{name:P,value:f}=r.target;h(M=>({...M,[P]:f}))},[q,o]=t.useState(!1);t.useEffect(()=>{const r=document.getElementById("scannerPaymentModal");s?(r.classList.add("show","fade-in"),r.style.display="block"):(r.classList.remove("fade-in"),r.classList.add("fade-out"),setTimeout(()=>{r.style.display="none",r.classList.remove("show","fade-out")},300))},[s]);const b=()=>d(),A=async()=>{var f;o(!0);const r={biling:i,tickets:[],extras:(f=l==null?void 0:l.extras)==null?void 0:f.map(M=>{if(M.newQty>0)return{...M,quantity:M.newQty-M.qty}}),discount:i.discount,paymentMethod:i.paymentMethod,subTotal:g,total:g,sendToMail:j,sendToPhone:m};(await T.post("https://events.essenciacompany.com/api/create-order",r,{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}})).status==200&&(y(),h({name:"",email:"",phone:"",vatNumber:"",discount:0,paymentMethod:"Cash"}),N(!1),v(!1),b()),o(!1)};return e.jsxs(e.Fragment,{children:[s&&e.jsx("div",{className:"payment-modal-backdrop payment-modal-fade-in"}),e.jsx("div",{className:`modal payment-modal ${s?"payment-modal-fade-in":"payment-modal-fade-out"}`,id:"scannerPaymentModal",tabIndex:"-1","aria-labelledby":"paymentModalLabel","aria-hidden":!s,onClick:b,children:e.jsx("div",{className:"modal-dialog modal-center modal-lg",onClick:r=>r.stopPropagation(),children:e.jsxs("div",{className:"modal-content p-0",children:[e.jsxs("div",{className:"modal-header",children:[e.jsx("h5",{className:"modal-title text-center",id:"paymentModalLabel",children:"Place Order"}),e.jsx("button",{type:"button",className:"btn-close","aria-label":"Close",onClick:b})]}),e.jsxs("div",{className:"modal-body row",children:[e.jsxs("div",{className:"col-md-6",children:[e.jsx("h5",{className:"modal-title text-start mb-2",id:"paymentModalLabel",children:"Payment Information"}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsx("label",{htmlFor:"nameInput",children:"Name"}),e.jsx("input",{id:"nameInput",name:"name",className:"form-control",value:i.name,onChange:w,placeholder:"Enter name"})]}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsxs("label",{htmlFor:"emailInput",children:["Email"," ",i.vatNumber||j?"":"(optional)"]}),e.jsx("input",{id:"emailInput",className:"form-control",name:"email",value:i.email,onChange:w,placeholder:"Enter email"})]}),m?e.jsx(H,{value:i.phone,onChange:r=>h(P=>({...P,phone:"+"+r}))}):"",e.jsxs("div",{className:"form-group mb-2",children:[e.jsx("label",{htmlFor:"vatInput",children:"VAT Number (optional)"}),e.jsx("input",{id:"vatInput",className:"form-control",name:"vatNumber",value:i.vatNumber,onChange:w,placeholder:"Enter VAT number"})]}),e.jsxs("div",{className:"form-group row mb-4",children:[e.jsxs("div",{className:"col-md-4",children:[e.jsx("label",{htmlFor:"discountInput",children:"Payment Method"}),e.jsxs("select",{class:"form-select","aria-label":"Default select example",onChange:r=>h(P=>({...P,paymentMethod:r.target.value})),children:[e.jsx("option",{value:"Cash",selected:!0,children:"Cash"}),e.jsx("option",{value:"Card",children:"Card"})]})]}),e.jsxs("div",{className:"col-md-3",children:[e.jsx("label",{htmlFor:"amountPaid",children:"Amount Paid"}),e.jsx("input",{id:"ap",className:"form-control",name:"ap",type:"number",value:C,onChange:r=>I(parseFloat(r.target.value))})]}),e.jsxs("div",{className:"col-md-3",children:[e.jsx("label",{htmlFor:"amountPaid",children:"Amount to Return"}),e.jsx("input",{id:"atr",className:"form-control",name:"atr",value:parseFloat(E).toFixed(2),readOnly:!0,disabled:!0})]})]}),e.jsxs("div",{className:"form-check",children:[e.jsx("input",{className:"form-check-input",type:"checkbox",value:"",id:"flexCheckDefault",checked:u,onChange:()=>a(!u)}),e.jsx("label",{className:"form-check-label",for:"flexCheckDefault",children:"Withdraw"})]}),e.jsxs("div",{class:"form-check",children:[e.jsx("input",{class:"form-check-input",type:"checkbox",value:m,checked:m,onChange:R,id:"sendToPhoneCheck"}),e.jsx("label",{class:"form-check-label",htmlFor:"sendToPhoneCheck",children:"Send to phone"})]}),e.jsxs("div",{class:"form-check",children:[e.jsx("input",{class:"form-check-input",type:"checkbox",value:j,checked:j,onChange:_,id:"sendToMailCheck"}),e.jsx("label",{class:"form-check-label",htmlFor:"sendToMailCheck",children:"Send to mail"})]})]}),e.jsx("div",{className:"col-md-6",children:e.jsx(re,{items:l==null?void 0:l.extras,cartTotal:g,discount:i.discount})})]}),e.jsxs("div",{className:"modal-footer",children:[e.jsx("button",{type:"button",className:"btn btn-secondary",onClick:b,children:"Close"}),e.jsx("button",{type:"button",className:"btn btn-primary",onClick:A,disabled:!i.name||(i.vatNumber?!(i.email||i.phone):!1)||q,children:q?"Processing...":"Proceed"})]})]})})})]})},de=({extra:s,index:d,handleExtraChange:l})=>{const[y,u]=t.useState(0);parseInt((s==null?void 0:s.newQty)??0)||parseInt((s==null?void 0:s.qty)??0);const a=parseFloat((s==null?void 0:s.price)??0).toFixed(2),m=j=>{const N=parseInt(j.target.value)||0;u(N)},v=()=>{y>0&&y<=s.qty-s.used&&(l(s,y),u(0))};return e.jsx("div",{className:"card",children:e.jsxs("div",{className:"card-body text-start",children:[e.jsxs("div",{className:"d-flex justify-content-between align-items-center",children:[e.jsxs("p",{className:"h6",children:[(s==null?void 0:s.display_name)??(s==null?void 0:s.name)," X ",(s==null?void 0:s.qty)-(s==null?void 0:s.used)]}),e.jsxs("h6",{children:["€"," ",(a*parseInt(s!=null&&s.newQty?(s==null?void 0:s.newQty)-(s==null?void 0:s.qty):0)).toFixed(2)]})]}),e.jsxs("div",{className:"mt-3",children:[e.jsxs("label",{htmlFor:"",children:["Withdraw (Available: ",(s==null?void 0:s.qty)-(s==null?void 0:s.used),")"]}),e.jsxs("div",{className:"form-inline d-flex gap-2",children:[e.jsx("input",{type:"number",min:1,max:(s==null?void 0:s.qty)-(s==null?void 0:s.used),value:y,onChange:m,className:"form-control"}),e.jsx("button",{className:"btn btn-sm btn-dark",onClick:v,children:e.jsx("i",{className:"fa fa-check"})})]})]})]})},d)},ie=({open:s,onClose:d,ticket:l,onSubmit:y})=>{const[u,a]=t.useState(!0),[m,v]=t.useState(!1),j=t.useMemo(()=>l==null?void 0:l.price,[l]),[N,_]=t.useState(0),R=t.useMemo(()=>N>j?parseFloat(N-j):0,[j,N]),g=()=>{v(o=>!o)},i=()=>{a(o=>!o)},[h,C]=t.useState({name:"",email:"",phone:"",vatNumber:"",discount:0,paymentMethod:"Cash"});t.useEffect(()=>{var o;(o=l==null?void 0:l.order_id)!=null&&o.billing&&C({name:l.order_id.billing.name||"",email:l.order_id.billing.email||"",phone:l.order_id.billing.phone||"",vatNumber:l.order_id.billing.vatNumber||"",discount:0,paymentMethod:"Cash"})},[l]);const I=o=>{const{name:b,value:A}=o.target;C(r=>({...r,[b]:A}))},[E,S]=t.useState(!1);t.useEffect(()=>{const o=document.getElementById("scannerPaidInviteModal");s?(o.classList.add("show","fade-in"),o.style.display="block"):(o.classList.remove("fade-in"),o.classList.add("fade-out"),setTimeout(()=>{o.style.display="none",o.classList.remove("show","fade-out")},300))},[s]);const w=()=>d(),q=async()=>{S(!0);const o={biling:h,ticket:l.id,paymentMethod:h.paymentMethod,sendToMail:m,sendToPhone:u},b=await T.post("https://events.essenciacompany.com/api/paid-ticket/update",o,{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}});b.status==200&&(v(!1),a(!1),y(b.ticket),w()),S(!1)};return e.jsxs(e.Fragment,{children:[s&&e.jsx("div",{className:"payment-modal-backdrop payment-modal-fade-in"}),e.jsx("div",{className:`modal payment-modal ${s?"payment-modal-fade-in":"payment-modal-fade-out"}`,id:"scannerPaidInviteModal",tabIndex:"-1","aria-labelledby":"paymentModalLabel","aria-hidden":!s,onClick:w,children:e.jsx("div",{className:"modal-dialog modal-center modal-lg",onClick:o=>o.stopPropagation(),children:e.jsxs("div",{className:"modal-content p-0",children:[e.jsxs("div",{className:"modal-header",children:[e.jsx("h5",{className:"modal-title text-center",id:"paymentModalLabel",children:"Activate TIcket"}),e.jsx("button",{type:"button",className:"btn-close","aria-label":"Close",onClick:w})]}),e.jsxs("div",{className:"modal-body row",children:[e.jsxs("div",{className:"col-md-6",children:[e.jsx("h5",{className:"modal-title text-start mb-2",id:"paymentModalLabel",children:"Payment Information"}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsx("label",{htmlFor:"nameInput",children:"Name"}),e.jsx("input",{id:"nameInput",name:"name",className:"form-control",value:h.name,onChange:I,placeholder:"Enter name"})]}),e.jsxs("div",{className:"form-group mb-2",children:[e.jsxs("label",{htmlFor:"emailInput",children:["Email"," ",h.vatNumber||m?"":"(optional)"]}),e.jsx("input",{id:"emailInput",className:"form-control",name:"email",value:h.email,onChange:I,placeholder:"Enter email"})]}),u?e.jsx(H,{value:h.phone,onChange:o=>C(b=>({...b,phone:"+"+o}))}):"",e.jsxs("div",{className:"form-group mb-2",children:[e.jsx("label",{htmlFor:"vatInput",children:"VAT Number (optional)"}),e.jsx("input",{id:"vatInput",className:"form-control",name:"vatNumber",value:h.vatNumber,onChange:I,placeholder:"Enter VAT number"})]}),e.jsxs("div",{className:"form-group row mb-4",children:[e.jsxs("div",{className:"col-md-4",children:[e.jsx("label",{htmlFor:"discountInput",children:"Payment Method"}),e.jsxs("select",{class:"form-select","aria-label":"Default select example",onChange:o=>C(b=>({...b,paymentMethod:o.target.value})),children:[e.jsx("option",{value:"Cash",selected:!0,children:"Cash"}),e.jsx("option",{value:"Card",children:"Card"})]})]}),e.jsxs("div",{className:"col-md-3",children:[e.jsx("label",{htmlFor:"amountPaid",children:"Amount Paid"}),e.jsx("input",{id:"ap",className:"form-control",name:"ap",type:"number",value:N,onChange:o=>_(parseFloat(o.target.value))})]}),e.jsxs("div",{className:"col-md-3",children:[e.jsx("label",{htmlFor:"amountPaid",children:"Amount to Return"}),e.jsx("input",{id:"atr",className:"form-control",name:"atr",value:parseFloat(R).toFixed(2),readOnly:!0,disabled:!0})]})]}),e.jsxs("div",{class:"form-check",children:[e.jsx("input",{class:"form-check-input",type:"checkbox",value:u,checked:u,onChange:i,id:"sendToPhoneCheck"}),e.jsx("label",{class:"form-check-label",htmlFor:"sendToPhoneCheck",children:"Send to phone"})]}),e.jsxs("div",{class:"form-check",children:[e.jsx("input",{class:"form-check-input",type:"checkbox",value:m,checked:m,onChange:g,id:"sendToMailCheck"}),e.jsx("label",{class:"form-check-label",htmlFor:"sendToMailCheck",children:"Send to mail"})]})]}),e.jsx("div",{className:"col-md-6",children:e.jsxs("div",{className:"h-100 d-flex flex-column justify-content-start",children:[e.jsx("h5",{className:"modal-title text-start mb-2",id:"paymentModalLabel",children:"Cart Information"}),e.jsx("div",{className:"cart-info-items-container",children:e.jsx("div",{className:"card",children:e.jsxs("table",{className:"table mb-0 rounded",children:[e.jsx("thead",{children:e.jsxs("tr",{children:[e.jsx("th",{children:"Item"}),e.jsx("th",{children:"Price"}),e.jsx("th",{children:"Quantity"}),e.jsx("th",{children:"Total"})]})}),e.jsx("tbody",{children:e.jsxs("tr",{className:"table-info",children:[e.jsx("td",{children:l==null?void 0:l.product_name}),e.jsxs("td",{children:[l==null?void 0:l.price," €"]}),e.jsx("td",{children:"1"}),e.jsxs("td",{children:[j," €"]})]})})]})})}),e.jsx("div",{className:"card mt-auto",children:e.jsx("table",{className:"table mb-0",children:e.jsx("tbody",{children:e.jsxs("tr",{children:[e.jsx("td",{children:"Total"}),e.jsxs("td",{children:[j," €"]})]})})})})]})})]}),e.jsxs("div",{className:"modal-footer",children:[e.jsx("button",{type:"button",className:"btn btn-secondary",onClick:w,children:"Close"}),e.jsx("button",{type:"button",className:"btn btn-primary",onClick:q,disabled:!h.name||(h.vatNumber?!(h.email||h.phone):!1)||E,children:E?"Processing...":"Proceed"})]})]})})})]})},je=()=>{var X,U;const s=ne.useRef(null),[d,l]=t.useState(null),[y,u]=t.useState(!1),[a,m]=t.useState(null),[v,j]=t.useState(""),[N,_]=t.useState(!1),[R,g]=t.useState(!1),[i,h]=t.useState(!1);t.useEffect(()=>{if(s.current&&!d){const n=new z(s.current,c=>{I(c)},{highlightScanRegion:!0,highlightCodeOutline:!0});l(n)}return()=>{d&&(d.stop(),d.destroy(),l(null))}},[s.current,d]);const C=()=>{d?(u(!0),_(!0),d.start()):console.error("Scanner is not initialized yet")},I=async n=>{var c;if(n!=null&&n.data)try{const p=await T.post("https://events.essenciacompany.com/api/tickets/get",{ticket:n==null?void 0:n.data});m(p.data),((c=p.data)==null?void 0:c.active)===0&&k(!0)}catch(p){L("Error scanning ticket",p)}},E=()=>{u(!1),m(null),j(""),_(!1),g(!1),h(!1)},S=n=>{n.key==="Enter"&&w()},w=async()=>{var n;if(v){g(!1),u(!1);try{const c=await T.post("https://events.essenciacompany.com/api/tickets/get",{ticket:v});m(c.data),j(""),((n=c.data)==null?void 0:n.active)===0&&k(!0)}catch(c){L("Error scanning ticket",c)}finally{setIsProcessing(!1)}}},q=(n,c)=>{const p=parseInt(n==null?void 0:n.used)??0;if(c=parseInt(c),c>n.qty-(n==null?void 0:n.used))return;n={...n,used:c+p};var Q=a.extras.map(W=>W.id===n.id?n:W);let x=a;x.extras=Q,m(x),console.log(a),V()},{data:o,isError:b,isLoading:A,isSuccess:r,refetch:P}=Y(["scanner-extras",a],`https://events.essenciacompany.com/api/event-extras/${a==null?void 0:a.event_id}`),[f,M]=t.useState(!1),[F,K]=t.useState(null),[O,$]=t.useState(1),J=()=>{var Q;if(!f){M(!0);return}const n={...F,qty:0,newQty:O};var c=!0,p=(Q=a==null?void 0:a.extras)==null?void 0:Q.map(x=>(console.log(x),x.id===n.id?(c=!1,{...x,newQty:parseInt(n.newQty)+parseInt((x==null?void 0:x.newQty)??(x==null?void 0:x.qty)??0)}):x));c&&(p=[...p,n]),m(x=>({...x,extras:[...p]})),M(!1),K(null),$(1)},[Z,D]=t.useState(!1),V=async()=>{if(D(!0),(await T.post("https://events.essenciacompany.com/api/update-ticket",{ticket:a,can_withdraw:i},{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}})).status==200&&(m(null),u(!1),h(!1),L("Ticket updated successfully!!"),d)){d.stop();const c=new z(s.current,p=>{I(p)},{highlightScanRegion:!0,highlightCodeOutline:!0});l(c),c.start()}D(!1)},ee=async(n={})=>{var p;D(!0);const c=await T.post("https://events.essenciacompany.com/api/paid-ticket/update",{ticket:a==null?void 0:a.id,...n},{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}});c.status==200&&(m((p=c==null?void 0:c.data)==null?void 0:p.ticket),L("Ticket activated successfully!!")),D(!1)},[se,B]=t.useState(!1),[ae,k]=t.useState(!1);return e.jsxs("section",{className:"scanner-page",children:[a&&(a==null?void 0:a.active)===1?e.jsxs("div",{className:"ticket-info",children:[e.jsx("h3",{children:"Ticket Information"}),e.jsxs("div",{className:"ticket-details",children:[e.jsxs("p",{children:[e.jsx("strong",{children:"Owner:"})," ",a==null?void 0:a.owner.name]}),(a==null?void 0:a.owner.email)&&e.jsxs("p",{children:[e.jsx("strong",{children:"Email:"})," ",a==null?void 0:a.owner.email]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Event:"})," ",a==null?void 0:a.event_name]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Ticket:"})," ",a==null?void 0:a.product_name]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Price:"})," €",a==null?void 0:a.price]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Status:"})," ",(a==null?void 0:a.status)===0?"Not Used":"Used"]}),e.jsxs("p",{children:[e.jsx("strong",{children:"Dates:"})," ",a==null?void 0:a.dates.join(", ")]}),e.jsx("p",{children:e.jsx("strong",{children:(a==null?void 0:a.active)===1?"Active":"Inactive"})})]}),((X=a==null?void 0:a.extras)==null?void 0:X.length)>0?e.jsxs("div",{className:"extras",children:[e.jsx("h4",{children:"Extras"}),a==null?void 0:a.extras.map((n,c)=>e.jsx(de,{extra:n,index:c,handleExtraChange:q}))]}):null,f&&e.jsx("div",{className:"modal-body row",children:e.jsxs("div",{className:"col-md-12",children:[e.jsxs("div",{className:"form-group",children:[e.jsx("label",{htmlFor:"extraSelect",children:"Select Extra"}),e.jsxs("select",{id:"extraSelect",className:"form-control mt-2",value:(F==null?void 0:F.display_name)||"",onChange:n=>{var p;const c=(p=o==null?void 0:o.data)==null?void 0:p.find(Q=>Q.display_name===n.target.value);K(c||null)},children:[e.jsx("option",{value:"",children:"None"}),(U=o==null?void 0:o.data)==null?void 0:U.map((n,c)=>e.jsx("option",{value:n==null?void 0:n.display_name,children:n==null?void 0:n.display_name},c))]})]}),F&&e.jsxs(e.Fragment,{children:[e.jsxs("div",{className:"form-group mt-3 d-flex flex-column justify-content-center align-items-center",children:[e.jsx("label",{htmlFor:"quantity",children:"Quantity"}),e.jsxs(le,{className:"w-50",children:[e.jsx(G,{variant:"outline-secondary",onClick:()=>$(n=>n-1>0?n-1:n),children:"-"}),e.jsx(te.Control,{"aria-label":"Example text with two button addons",className:"text-center",readOnly:!0,value:O}),e.jsx(G,{variant:"outline-danger",onClick:()=>$(n=>n+1),children:"+"})]})]}),e.jsxs("label",{htmlFor:"price",children:["Price",e.jsx("br",{}),(F==null?void 0:F.price)*O,"€"]})]})]})}),e.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:e.jsx("button",{type:"button",class:"btn btn-info text-light w-100 py-1",onClick:J,children:"Add extra"})}),e.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:e.jsx("button",{type:"button",class:"btn btn-success text-light w-100 py-1",onClick:()=>B(!0),children:Z?"Processing...":"Save Changes"})}),e.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:e.jsx("button",{type:"button",class:"btn btn-warning text-light w-100 py-1",onClick:E,children:"Re-Scan"})})]}):y?"":e.jsxs("div",{className:"d-flex flex-column align-items-center gap-3",children:[e.jsxs("div",{className:"qr-box flex-column",onClick:C,children:[e.jsx("img",{className:"qr-image",src:"/assets/qr-code.png",alt:"QR Code"}),e.jsx("h3",{children:"start scanning"})]}),e.jsx("h3",{children:"or"}),e.jsx("input",{className:"qr-box flex-column",type:"text",onChange:n=>j(n.target.value),onKeyDown:S,placeholder:"Manually enter ticket code"})]}),!a&&e.jsxs("div",{children:[e.jsx("div",{id:"viewfinder",className:"qr-box",style:N?{}:{display:"none"},children:e.jsx("video",{ref:s,children:"Your browser does not support video playback."})}),e.jsx("div",{id:"manual-input",className:"form-group",style:R?{}:{display:"none"},children:e.jsx("input",{type:"text",name:"manual",className:"form-control",id:"manual",value:v,onChange:n=>j(n.target.value),onKeyDown:S,placeholder:"Enter ticket code manually"})})]}),e.jsx(ce,{open:se,onClose:()=>B(!1),ticket:a,handleSubmit:V,withdraw:i,setWithdraw:h}),e.jsx(ie,{open:ae,onClose:()=>k(!1),ticket:a,handleSubmit:ee,onSubmit:m})]})};export{je as default};
