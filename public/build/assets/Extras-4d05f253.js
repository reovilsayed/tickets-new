import{u as N,b as w,j as s,a as g,r as h,H as b}from"./app-6cc9246f.js";import{u as E,I,P as x}from"./useInfiniteFetch-b5d0c1f4.js";import{f as P}from"./utils-8b9f25e8.js";import"./index-7ac75a63.js";const _=({extra:e})=>{var r,o,c;N();const{addItem:l,removeItem:n,inCart:a}=w(),t=a(e==null?void 0:e.id);return s.jsx("div",{className:`ticket-item-container col-lg-2 col-md-3 col-sm-3 col-6 my-hover-effect g-3 ${t?"active":""}`,onClick:()=>l(e),children:s.jsxs("div",{className:"extra-item-card",children:[t?s.jsx("button",{className:"delete-btn",onClick:()=>{n(e.id)},children:s.jsx("i",{className:"fa fa-times"})}):"",s.jsxs("div",{className:"custom-card",children:[s.jsxs("span",{className:"extra-item-badge",children:[P(e!=null&&e.sale_price?e==null?void 0:e.sale_price:e==null?void 0:e.price)," €"]}),s.jsxs("div",{className:"card-header position-relative",children:[s.jsx("div",{className:"extra-item-img",children:s.jsx("i",{class:"fas fa-cocktail fa-2x"})}),((r=e==null?void 0:e.event)==null?void 0:r.name)&&s.jsx("span",{className:"extra-item-unit",children:((o=e==null?void 0:e.event)==null?void 0:o.name.length)>15?`${e.event.name.substring(0,15)}...`:(c=e==null?void 0:e.event)==null?void 0:c.name})]}),s.jsx("div",{className:"card-body extra-item-body",children:s.jsx("p",{title:e.display_name,className:"extra-item-name",children:(e==null?void 0:e.display_name.length)>15?`${e.display_name.substring(0,15)}...`:e.display_name})})]})]})})};function $(){var p,u;const e=g(i=>i.searchQuery.query),l=g(i=>i.filter.event),{data:n,isError:a,isLoading:t,isSuccess:r,isFetching:o,hasNextPage:c,fetchNextPage:m,refetch:C}=E(["extras-page",e],"https://events.essenciacompany.com/api/extras",{query:e,event_id:l==null?void 0:l.id}),d=h.useCallback(()=>{const i=document.documentElement.scrollTop;i<500&&i===0&&c&&!o&&m()},[m,c,o]);return h.useEffect(()=>(window.addEventListener("scroll",d),()=>{window.removeEventListener("scroll",d)}),[d]),s.jsx("div",{className:"overflow-y-scroll overflow-x-none pt-3",children:t?s.jsx("div",{style:{width:"100%",height:"100vh",display:"flex",justifyContent:"center",alignItems:"center"},children:s.jsx(b,{color:"#36d7b7"})}):s.jsx(I,{loadMore:m,hasMore:c,loader:s.jsx("div",{style:{textAlign:"center",paddingTop:"25px"},children:s.jsx(x,{color:"#36d7b7"})}),useWindow:!1,style:{overflowY:"scroll",maxHeight:"90vh",padding:"20px 10px"},onScroll:d,children:s.jsx("div",{className:"row g-3",children:a?s.jsx("div",{style:{textAlign:"center",color:"red"},children:"Something went wrong"}):(p=n==null?void 0:n.pages)!=null&&p.length?(u=n==null?void 0:n.pages)==null?void 0:u.map((i,v)=>{var f;return s.jsx(h.Fragment,{children:(f=i==null?void 0:i.data)==null?void 0:f.map((j,y)=>s.jsx(_,{extra:j},y))},v)}):s.jsx("div",{style:{textAlign:"center"},children:"No matching products found."})})})})}export{$ as default};
