import{e as o,j as s,n as c,N as i,f as l}from"./app-37fc078d.js";const x=()=>{const{pathname:e}=o(),n=async()=>{const a=document.querySelector('meta[name="csrf-token"]').getAttribute("content");await l.post("http://127.0.0.1:8000/logout",{},{headers:{"X-CSRF-TOKEN":a}}),window.location.href="/"};return s.jsx("div",{className:"nav_inner",children:s.jsxs("ul",{className:"nav_list",children:[c.map((a,t)=>s.jsx(r,{name:a.name,to:a.path,icon:a.icon,active:e===a.path},t)),s.jsx("li",{onClick:n,children:s.jsxs("a",{className:"logout-trigger",children:[s.jsx("i",{className:"fas fa-sign-out-alt"}),s.jsx("span",{children:"Logout"})]})})]})})},r=({name:e,to:n,icon:a,active:t=!1})=>s.jsx("li",{className:t?"active":"",children:s.jsxs(i,{exact:"true",to:n,children:[s.jsx("i",{className:a}),s.jsx("span",{children:e})]})}),h="/build/assets/Essência-logo-9fa5e606.png";export{h as L,x as N};
