import{n as m,r as l,R as p,j as s,p as h,N as x,m as c}from"./app-de3c0a8e.js";const f=()=>{const{pathname:n}=m(),i=async()=>{const e=document.querySelector('meta[name="csrf-token"]').getAttribute("content");await c.post("https://events.essenciacompany.com/logout",{},{headers:{"X-CSRF-TOKEN":e}}),window.location.href="/"},[t,o]=l.useState(!1);return p.useEffect(()=>{(async()=>{try{const a=await c.get("https://events.essenciacompany.com/api/user/pos-permission");o(a.data)}catch(a){console.error("Error fetching POS permission:",a)}})()},[]),s.jsx("div",{className:"nav_inner",children:s.jsxs("ul",{className:"nav_list",children:[h.map((e,a)=>!e.hidden&&!e.permissionName?s.jsx(r,{name:e.name,to:e.path,icon:e.icon,active:n===e.path},a):e.permissionName&&t[e.permissionName]?s.jsx(r,{name:e.name,to:e.path,icon:e.icon,active:n===e.path},a):""),t.report?s.jsx("li",{children:s.jsxs("a",{href:"https://events.essenciacompany.com/pos/reports",target:"__blank",children:[s.jsx("i",{className:"fas fa-file"}),s.jsx("span",{children:"Reports"})]})}):"",s.jsx("li",{onClick:i,children:s.jsxs("a",{className:"logout-trigger",children:[s.jsx("i",{className:"fas fa-sign-out-alt"}),s.jsx("span",{children:"Logout"})]})})]})})},r=({name:n,to:i,icon:t,active:o=!1})=>s.jsx("li",{className:o?"active":"",children:s.jsxs(x,{exact:"true",to:i,children:[s.jsx("i",{className:t}),s.jsx("span",{children:n})]})}),j="/build/assets/Essência-logo-9fa5e606.png";export{j as L,f as N};
