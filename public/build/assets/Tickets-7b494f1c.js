var _=Object.defineProperty;var R=(e,t,s)=>t in e?_(e,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[t]=s;var N=(e,t,s)=>(R(e,typeof t!="symbol"?t+"":t,s),s);import{t as T,r as P,v as E,d as $,_ as O,w as S,x as D,y as I,p as z,R as F,u as H,b as W,j as o,z as Q,h as A,i as q,a as j,H as Y}from"./app-8014aa81.js";import{Q as B,u as U,P as m,f as V,v as X,a as G}from"./index-becbb646.js";var w=globalThis&&globalThis.__assign||function(){return w=Object.assign||function(e){for(var t,s=1,n=arguments.length;s<n;s++){t=arguments[s];for(var r in t)Object.prototype.hasOwnProperty.call(t,r)&&(e[r]=t[r])}return e},w.apply(this,arguments)},J=globalThis&&globalThis.__rest||function(e,t){var s={};for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&t.indexOf(n)<0&&(s[n]=e[n]);if(e!=null&&typeof Object.getOwnPropertySymbols=="function")for(var r=0,n=Object.getOwnPropertySymbols(e);r<n.length;r++)t.indexOf(n[r])<0&&Object.prototype.propertyIsEnumerable.call(e,n[r])&&(s[n[r]]=e[n[r]]);return s},K=T("PulseLoader","0% {transform: scale(1); opacity: 1} 45% {transform: scale(0.1); opacity: 0.7} 80% {transform: scale(1); opacity: 1}","pulse");function Z(e){var t=e.loading,s=t===void 0?!0:t,n=e.color,r=n===void 0?"#000000":n,a=e.speedMultiplier,l=a===void 0?1:a,c=e.cssOverride,f=c===void 0?{}:c,h=e.size,d=h===void 0?15:h,i=e.margin,u=i===void 0?2:i,g=J(e,["loading","color","speedMultiplier","cssOverride","size","margin"]),x=w({display:"inherit"},f),b=function(v){return{backgroundColor:r,width:E(d),height:E(d),margin:E(u),borderRadius:"100%",display:"inline-block",animation:"".concat(K," ").concat(.75/l,"s ").concat(v*.12/l,"s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08)"),animationFillMode:"both"}};return s?P.createElement("span",w({style:x},g),P.createElement("span",{style:b(1)}),P.createElement("span",{style:b(2)}),P.createElement("span",{style:b(3)})):null}var k=function(e){$(t,e);function t(n,r){return e.call(this,n,r)||this}var s=t.prototype;return s.bindMethods=function(){e.prototype.bindMethods.call(this),this.fetchNextPage=this.fetchNextPage.bind(this),this.fetchPreviousPage=this.fetchPreviousPage.bind(this)},s.setOptions=function(r,a){e.prototype.setOptions.call(this,O({},r,{behavior:S()}),a)},s.getOptimisticResult=function(r){return r.behavior=S(),e.prototype.getOptimisticResult.call(this,r)},s.fetchNextPage=function(r){var a;return this.fetch({cancelRefetch:(a=r==null?void 0:r.cancelRefetch)!=null?a:!0,throwOnError:r==null?void 0:r.throwOnError,meta:{fetchMore:{direction:"forward",pageParam:r==null?void 0:r.pageParam}}})},s.fetchPreviousPage=function(r){var a;return this.fetch({cancelRefetch:(a=r==null?void 0:r.cancelRefetch)!=null?a:!0,throwOnError:r==null?void 0:r.throwOnError,meta:{fetchMore:{direction:"backward",pageParam:r==null?void 0:r.pageParam}}})},s.createResult=function(r,a){var l,c,f,h,d,i,u=r.state,g=e.prototype.createResult.call(this,r,a);return O({},g,{fetchNextPage:this.fetchNextPage,fetchPreviousPage:this.fetchPreviousPage,hasNextPage:D(a,(l=u.data)==null?void 0:l.pages),hasPreviousPage:I(a,(c=u.data)==null?void 0:c.pages),isFetchingNextPage:u.isFetching&&((f=u.fetchMeta)==null||(h=f.fetchMore)==null?void 0:h.direction)==="forward",isFetchingPreviousPage:u.isFetching&&((d=u.fetchMeta)==null||(i=d.fetchMore)==null?void 0:i.direction)==="backward"})},t}(B);function ee(e,t,s){var n=z(e,t,s);return U(n,k)}class M extends P.Component{constructor(t){super(t),this.scrollListener=this.scrollListener.bind(this),this.eventListenerOptions=this.eventListenerOptions.bind(this),this.mousewheelListener=this.mousewheelListener.bind(this)}componentDidMount(){this.pageLoaded=this.props.pageStart,this.options=this.eventListenerOptions(),this.attachScrollListener()}componentDidUpdate(){if(this.props.isReverse&&this.loadMore){const t=this.getParentElement(this.scrollComponent);t.scrollTop=t.scrollHeight-this.beforeScrollHeight+this.beforeScrollTop,this.loadMore=!1}this.attachScrollListener()}componentWillUnmount(){this.detachScrollListener(),this.detachMousewheelListener()}isPassiveSupported(){let t=!1;const s={get passive(){t=!0}};try{document.addEventListener("test",null,s),document.removeEventListener("test",null,s)}catch{}return t}eventListenerOptions(){let t=this.props.useCapture;return this.isPassiveSupported()?t={useCapture:this.props.useCapture,passive:!0}:t={passive:!1},t}setDefaultLoader(t){this.defaultLoader=t}detachMousewheelListener(){let t=window;this.props.useWindow===!1&&(t=this.scrollComponent.parentNode),t.removeEventListener("mousewheel",this.mousewheelListener,this.options?this.options:this.props.useCapture)}detachScrollListener(){let t=window;this.props.useWindow===!1&&(t=this.getParentElement(this.scrollComponent)),t.removeEventListener("scroll",this.scrollListener,this.options?this.options:this.props.useCapture),t.removeEventListener("resize",this.scrollListener,this.options?this.options:this.props.useCapture)}getParentElement(t){const s=this.props.getScrollParent&&this.props.getScrollParent();return s??(t&&t.parentNode)}filterProps(t){return t}attachScrollListener(){const t=this.getParentElement(this.scrollComponent);if(!this.props.hasMore||!t)return;let s=window;this.props.useWindow===!1&&(s=t),s.addEventListener("mousewheel",this.mousewheelListener,this.options?this.options:this.props.useCapture),s.addEventListener("scroll",this.scrollListener,this.options?this.options:this.props.useCapture),s.addEventListener("resize",this.scrollListener,this.options?this.options:this.props.useCapture),this.props.initialLoad&&this.scrollListener()}mousewheelListener(t){t.deltaY===1&&!this.isPassiveSupported()&&t.preventDefault()}scrollListener(){const t=this.scrollComponent,s=window,n=this.getParentElement(t);let r;if(this.props.useWindow){const a=document.documentElement||document.body.parentNode||document.body,l=s.pageYOffset!==void 0?s.pageYOffset:a.scrollTop;this.props.isReverse?r=l:r=this.calculateOffset(t,l)}else this.props.isReverse?r=n.scrollTop:r=t.scrollHeight-n.scrollTop-n.clientHeight;r<Number(this.props.threshold)&&t&&t.offsetParent!==null&&(this.detachScrollListener(),this.beforeScrollHeight=n.scrollHeight,this.beforeScrollTop=n.scrollTop,typeof this.props.loadMore=="function"&&(this.props.loadMore(this.pageLoaded+=1),this.loadMore=!0))}calculateOffset(t,s){return t?this.calculateTopPosition(t)+(t.offsetHeight-s-window.innerHeight):0}calculateTopPosition(t){return t?t.offsetTop+this.calculateTopPosition(t.offsetParent):0}render(){const t=this.filterProps(this.props),{children:s,element:n,hasMore:r,initialLoad:a,isReverse:l,loader:c,loadMore:f,pageStart:h,ref:d,threshold:i,useCapture:u,useWindow:g,getScrollParent:x,...b}=t;b.ref=L=>{this.scrollComponent=L,d&&d(L)};const v=[s];return r&&(c?l?v.unshift(c):v.push(c):this.defaultLoader&&(l?v.unshift(this.defaultLoader):v.push(this.defaultLoader))),F.createElement(n,b,v)}}N(M,"propTypes",{children:m.node.isRequired,element:m.node,hasMore:m.bool,initialLoad:m.bool,isReverse:m.bool,loader:m.node,loadMore:m.func.isRequired,pageStart:m.number,ref:m.func,getScrollParent:m.func,threshold:m.number,useCapture:m.bool,useWindow:m.bool}),N(M,"defaultProps",{element:"div",hasMore:!1,initialLoad:!0,pageStart:0,ref:null,threshold:250,useWindow:!0,isReverse:!1,useCapture:!1,loader:null,getScrollParent:null});const te=({ticket:e})=>{var c,f,h,d,i;const t=H(),s=u=>{u.stopPropagation(),t(Q(e))},{addItem:n,removeItem:r,inCart:a}=W(),l=a(e==null?void 0:e.id);return o.jsx("div",{className:`ticket-item-container col-lg-2 col-md-3 col-sm-3 col-6 my-hover-effect g-3 ${l?"active":""}`,onClick:()=>n(e),children:o.jsxs("div",{className:"ticket-item-card",children:[l?o.jsx("button",{className:"delete-btn",onClick:()=>{r(e.id)},children:o.jsx("i",{className:"fa fa-times"})}):"",o.jsxs("div",{className:"custom-card",children:[o.jsx("span",{className:"ticket-item-badge",children:V(e!=null&&e.sale_price?e==null?void 0:e.sale_price:e==null?void 0:e.price)}),o.jsxs("div",{className:"card-header position-relative",children:[o.jsx("img",{className:"ticket-item-img",src:X(e==null?void 0:e.event_thumbnail)}),((c=e==null?void 0:e.event)==null?void 0:c.name)&&o.jsx("span",{className:"ticket-item-unit",children:((f=e==null?void 0:e.event)==null?void 0:f.name.length)>15?`${e.event.name.substring(0,15)}...`:(h=e==null?void 0:e.event)==null?void 0:h.name})]}),o.jsxs("div",{className:"card-body ticket-item-body",children:[o.jsx("p",{title:e.name,className:"ticket-item-name",children:(e==null?void 0:e.name.length)>15?`${e.name.substring(0,15)}...`:e.name}),o.jsx("small",{className:"ticket-item-generic",children:((i=(d=e==null?void 0:e.event)==null?void 0:d.organizer)==null?void 0:i.length)>25?`${e.event.organizer.substring(0,25)}...`:e==null?void 0:e.event.organizer}),(e==null?void 0:e.start_date)&&(e==null?void 0:e.end_date)&&o.jsxs("small",{children:["(",G(e.start_date,e.end_date),")"]}),o.jsx("button",{onClick:s,className:"btn btn-primary btn-sm position-absolute rounded-circle ticket-item-info-btn",children:o.jsx("i",{className:"fa fa-info"})})]})]})]})})},se=(e,t,s={},n={})=>{const{prefetch:r,pageSize:a=10,...l}=n,c=A(),f=async({pageParam:p=1})=>(await q.get(`${t}?page=${p}&per_page=5&query=${(s==null?void 0:s.query)??""}&event_id=${(s==null?void 0:s.event_id)??""}&event_date=${(s==null?void 0:s.eventDate)??""}`,{headers:{"Content-Type":"application/json"}})).data,{data:h,isLoading:d,isError:i,isSuccess:u,error:g,hasNextPage:x,fetchNextPage:b,isFetching:v}=ee(e,f,{...l,getNextPageParam:p=>{const y=p==null?void 0:p.current_page,C=p==null?void 0:p.last_page;return y<C?y+1:null}});return P.useEffect(()=>{var p;((p=g==null?void 0:g.response)==null?void 0:p.status)===401&&localStorage.setItem("authData",null)},[i,g]),{data:h,isLoading:d,isError:i,isSuccess:u,hasNextPage:x,isFetching:v,fetchNextPage:b,refetch:p=>{c.invalidateQueries(p||e)},setData:p=>{c.setQueryData(e,y=>p(y))}}};function ae(){var d;const e=j(i=>i.searchQuery.query),t=j(i=>i.filter.event),s=j(i=>i.filter.date),{data:n,isError:r,isLoading:a,isFetching:l,hasNextPage:c,fetchNextPage:f}=se(["tickets",e,t,s],"https://events.essenciacompany.com/api/tickets",{query:e,event_id:t==null?void 0:t.id,eventDate:s}),h=P.useCallback(()=>{const i=document.documentElement.scrollTop;i<500&&i===0&&c&&!l&&f()},[f,c,l]);return P.useEffect(()=>(window.addEventListener("scroll",h),()=>{window.removeEventListener("scroll",h)}),[h]),o.jsx("div",{className:"overflow-y-scroll overflow-x-none pt-3",children:t?a?o.jsx("div",{style:{width:"100%",height:"100vh",display:"flex",justifyContent:"center",alignItems:"center"},children:o.jsx(Y,{color:"#36d7b7"})}):o.jsx(M,{loadMore:f,hasMore:c,loader:o.jsx("div",{style:{textAlign:"center",paddingTop:"25px"},children:o.jsx(Z,{color:"#36d7b7"})}),useWindow:!1,style:{overflowY:"scroll",overflowX:"hidden",maxHeight:"90vh",padding:"20px 10px"},onScroll:h,children:o.jsx("div",{className:"row g-3",children:r?o.jsx("div",{style:{textAlign:"center",color:"red"},children:"Something went wrong"}):(d=n==null?void 0:n.pages)!=null&&d.length?n.pages.map((i,u)=>o.jsx(P.Fragment,{children:i.data.map((g,x)=>o.jsx(te,{ticket:g},x))},u)):o.jsx("div",{style:{textAlign:"center"},children:"No matching products found."})})}):o.jsx("h4",{className:"text-info text-center",children:"Please Select An Event"})})}export{ae as default};
