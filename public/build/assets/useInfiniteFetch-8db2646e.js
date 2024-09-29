var _=Object.defineProperty;var x=(r,e,t)=>e in r?_(r,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):r[e]=t;var E=(r,e,t)=>(x(r,typeof e!="symbol"?e+"":e,t),t);import{q as T,r as P,s as O,d as N,_ as M,t as S,v as $,w as D,x as H,R as W,y as j,l as z}from"./app-16a0818f.js";import{Q as F,u as I,P as a}from"./index-f2d12c73.js";var w=globalThis&&globalThis.__assign||function(){return w=Object.assign||function(r){for(var e,t=1,i=arguments.length;t<i;t++){e=arguments[t];for(var s in e)Object.prototype.hasOwnProperty.call(e,s)&&(r[s]=e[s])}return r},w.apply(this,arguments)},Q=globalThis&&globalThis.__rest||function(r,e){var t={};for(var i in r)Object.prototype.hasOwnProperty.call(r,i)&&e.indexOf(i)<0&&(t[i]=r[i]);if(r!=null&&typeof Object.getOwnPropertySymbols=="function")for(var s=0,i=Object.getOwnPropertySymbols(r);s<i.length;s++)e.indexOf(i[s])<0&&Object.prototype.propertyIsEnumerable.call(r,i[s])&&(t[i[s]]=r[i[s]]);return t},q=T("PulseLoader","0% {transform: scale(1); opacity: 1} 45% {transform: scale(0.1); opacity: 0.7} 80% {transform: scale(1); opacity: 1}","pulse");function G(r){var e=r.loading,t=e===void 0?!0:e,i=r.color,s=i===void 0?"#000000":i,o=r.speedMultiplier,l=o===void 0?1:o,c=r.cssOverride,m=c===void 0?{}:c,g=r.size,u=g===void 0?15:g,p=r.margin,h=p===void 0?2:p,d=Q(r,["loading","color","speedMultiplier","cssOverride","size","margin"]),b=w({display:"inherit"},m),v=function(f){return{backgroundColor:s,width:O(u),height:O(u),margin:O(h),borderRadius:"100%",display:"inline-block",animation:"".concat(q," ").concat(.75/l,"s ").concat(f*.12/l,"s infinite cubic-bezier(0.2, 0.68, 0.18, 1.08)"),animationFillMode:"both"}};return t?P.createElement("span",w({style:b},d),P.createElement("span",{style:v(1)}),P.createElement("span",{style:v(2)}),P.createElement("span",{style:v(3)})):null}var A=function(r){N(e,r);function e(i,s){return r.call(this,i,s)||this}var t=e.prototype;return t.bindMethods=function(){r.prototype.bindMethods.call(this),this.fetchNextPage=this.fetchNextPage.bind(this),this.fetchPreviousPage=this.fetchPreviousPage.bind(this)},t.setOptions=function(s,o){r.prototype.setOptions.call(this,M({},s,{behavior:S()}),o)},t.getOptimisticResult=function(s){return s.behavior=S(),r.prototype.getOptimisticResult.call(this,s)},t.fetchNextPage=function(s){var o;return this.fetch({cancelRefetch:(o=s==null?void 0:s.cancelRefetch)!=null?o:!0,throwOnError:s==null?void 0:s.throwOnError,meta:{fetchMore:{direction:"forward",pageParam:s==null?void 0:s.pageParam}}})},t.fetchPreviousPage=function(s){var o;return this.fetch({cancelRefetch:(o=s==null?void 0:s.cancelRefetch)!=null?o:!0,throwOnError:s==null?void 0:s.throwOnError,meta:{fetchMore:{direction:"backward",pageParam:s==null?void 0:s.pageParam}}})},t.createResult=function(s,o){var l,c,m,g,u,p,h=s.state,d=r.prototype.createResult.call(this,s,o);return M({},d,{fetchNextPage:this.fetchNextPage,fetchPreviousPage:this.fetchPreviousPage,hasNextPage:$(o,(l=h.data)==null?void 0:l.pages),hasPreviousPage:D(o,(c=h.data)==null?void 0:c.pages),isFetchingNextPage:h.isFetching&&((m=h.fetchMeta)==null||(g=m.fetchMore)==null?void 0:g.direction)==="forward",isFetchingPreviousPage:h.isFetching&&((u=h.fetchMeta)==null||(p=u.fetchMore)==null?void 0:p.direction)==="backward"})},e}(F);function Y(r,e,t){var i=H(r,e,t);return I(i,A)}class C extends P.Component{constructor(e){super(e),this.scrollListener=this.scrollListener.bind(this),this.eventListenerOptions=this.eventListenerOptions.bind(this),this.mousewheelListener=this.mousewheelListener.bind(this)}componentDidMount(){this.pageLoaded=this.props.pageStart,this.options=this.eventListenerOptions(),this.attachScrollListener()}componentDidUpdate(){if(this.props.isReverse&&this.loadMore){const e=this.getParentElement(this.scrollComponent);e.scrollTop=e.scrollHeight-this.beforeScrollHeight+this.beforeScrollTop,this.loadMore=!1}this.attachScrollListener()}componentWillUnmount(){this.detachScrollListener(),this.detachMousewheelListener()}isPassiveSupported(){let e=!1;const t={get passive(){e=!0}};try{document.addEventListener("test",null,t),document.removeEventListener("test",null,t)}catch{}return e}eventListenerOptions(){let e=this.props.useCapture;return this.isPassiveSupported()?e={useCapture:this.props.useCapture,passive:!0}:e={passive:!1},e}setDefaultLoader(e){this.defaultLoader=e}detachMousewheelListener(){let e=window;this.props.useWindow===!1&&(e=this.scrollComponent.parentNode),e.removeEventListener("mousewheel",this.mousewheelListener,this.options?this.options:this.props.useCapture)}detachScrollListener(){let e=window;this.props.useWindow===!1&&(e=this.getParentElement(this.scrollComponent)),e.removeEventListener("scroll",this.scrollListener,this.options?this.options:this.props.useCapture),e.removeEventListener("resize",this.scrollListener,this.options?this.options:this.props.useCapture)}getParentElement(e){const t=this.props.getScrollParent&&this.props.getScrollParent();return t??(e&&e.parentNode)}filterProps(e){return e}attachScrollListener(){const e=this.getParentElement(this.scrollComponent);if(!this.props.hasMore||!e)return;let t=window;this.props.useWindow===!1&&(t=e),t.addEventListener("mousewheel",this.mousewheelListener,this.options?this.options:this.props.useCapture),t.addEventListener("scroll",this.scrollListener,this.options?this.options:this.props.useCapture),t.addEventListener("resize",this.scrollListener,this.options?this.options:this.props.useCapture),this.props.initialLoad&&this.scrollListener()}mousewheelListener(e){e.deltaY===1&&!this.isPassiveSupported()&&e.preventDefault()}scrollListener(){const e=this.scrollComponent,t=window,i=this.getParentElement(e);let s;if(this.props.useWindow){const o=document.documentElement||document.body.parentNode||document.body,l=t.pageYOffset!==void 0?t.pageYOffset:o.scrollTop;this.props.isReverse?s=l:s=this.calculateOffset(e,l)}else this.props.isReverse?s=i.scrollTop:s=e.scrollHeight-i.scrollTop-i.clientHeight;s<Number(this.props.threshold)&&e&&e.offsetParent!==null&&(this.detachScrollListener(),this.beforeScrollHeight=i.scrollHeight,this.beforeScrollTop=i.scrollTop,typeof this.props.loadMore=="function"&&(this.props.loadMore(this.pageLoaded+=1),this.loadMore=!0))}calculateOffset(e,t){return e?this.calculateTopPosition(e)+(e.offsetHeight-t-window.innerHeight):0}calculateTopPosition(e){return e?e.offsetTop+this.calculateTopPosition(e.offsetParent):0}render(){const e=this.filterProps(this.props),{children:t,element:i,hasMore:s,initialLoad:o,isReverse:l,loader:c,loadMore:m,pageStart:g,ref:u,threshold:p,useCapture:h,useWindow:d,getScrollParent:b,...v}=e;v.ref=y=>{this.scrollComponent=y,u&&u(y)};const f=[t];return s&&(c?l?f.unshift(c):f.push(c):this.defaultLoader&&(l?f.unshift(this.defaultLoader):f.push(this.defaultLoader))),W.createElement(i,v,f)}}E(C,"propTypes",{children:a.node.isRequired,element:a.node,hasMore:a.bool,initialLoad:a.bool,isReverse:a.bool,loader:a.node,loadMore:a.func.isRequired,pageStart:a.number,ref:a.func,getScrollParent:a.func,threshold:a.number,useCapture:a.bool,useWindow:a.bool}),E(C,"defaultProps",{element:"div",hasMore:!1,initialLoad:!0,pageStart:0,ref:null,threshold:250,useWindow:!0,isReverse:!1,useCapture:!1,loader:null,getScrollParent:null});const J=(r,e,t={},i={})=>{const{prefetch:s,pageSize:o=10,...l}=i,c=j(),m=async({pageParam:n=1})=>(await z.get(`${e}?page=${n}&per_page=5&query=${(t==null?void 0:t.query)??""}&event_id=${(t==null?void 0:t.event_id)??""}&event_date=${(t==null?void 0:t.eventDate)??""}`,{headers:{"Content-Type":"application/json"}})).data,{data:g,isLoading:u,isError:p,isSuccess:h,error:d,hasNextPage:b,fetchNextPage:v,isFetching:f}=Y(r,m,{...l,getNextPageParam:n=>{const L=n==null?void 0:n.current_page,R=n==null?void 0:n.last_page;return L<R?L+1:null}});return P.useEffect(()=>{var n;((n=d==null?void 0:d.response)==null?void 0:n.status)===401&&localStorage.setItem("authData",null)},[p,d]),{data:g,isLoading:u,isError:p,isSuccess:h,hasNextPage:b,isFetching:f,fetchNextPage:v,refetch:n=>{c.invalidateQueries(n||r)},setData:n=>{c.setQueryData(r,L=>n(L))}}};export{C as I,G as P,J as u};