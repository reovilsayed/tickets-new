import{z as k,R as H,r as C,l as P,B as M,j as n}from"./app-6cc9246f.js";import{a as W,I as V,B as F,F as q}from"./useFetch-54b8e691.js";import"./index-7ac75a63.js";class o{constructor(e,t,i,a,l){this._legacyCanvasSize=o.DEFAULT_CANVAS_SIZE,this._preferredCamera="environment",this._maxScansPerSecond=25,this._lastScanTimestamp=-1,this._destroyed=this._flashOn=this._paused=this._active=!1,this.$video=e,this.$canvas=document.createElement("canvas"),i&&typeof i=="object"?this._onDecode=t:(console.warn(i||a||l?"You're using a deprecated version of the QrScanner constructor which will be removed in the future":"Note that the type of the scan result passed to onDecode will change in the future. To already switch to the new api today, you can pass returnDetailedScanResult: true."),this._legacyOnDecode=t),t=typeof i=="object"?i:{},this._onDecodeError=t.onDecodeError||(typeof i=="function"?i:this._onDecodeError),this._calculateScanRegion=t.calculateScanRegion||(typeof a=="function"?a:this._calculateScanRegion),this._preferredCamera=t.preferredCamera||l||this._preferredCamera,this._legacyCanvasSize=typeof i=="number"?i:typeof a=="number"?a:this._legacyCanvasSize,this._maxScansPerSecond=t.maxScansPerSecond||this._maxScansPerSecond,this._onPlay=this._onPlay.bind(this),this._onLoadedMetaData=this._onLoadedMetaData.bind(this),this._onVisibilityChange=this._onVisibilityChange.bind(this),this._updateOverlay=this._updateOverlay.bind(this),e.disablePictureInPicture=!0,e.playsInline=!0,e.muted=!0;let s=!1;if(e.hidden&&(e.hidden=!1,s=!0),document.body.contains(e)||(document.body.appendChild(e),s=!0),i=e.parentElement,t.highlightScanRegion||t.highlightCodeOutline){if(a=!!t.overlay,this.$overlay=t.overlay||document.createElement("div"),l=this.$overlay.style,l.position="absolute",l.display="none",l.pointerEvents="none",this.$overlay.classList.add("scan-region-highlight"),!a&&t.highlightScanRegion){this.$overlay.innerHTML='<svg class="scan-region-highlight-svg" viewBox="0 0 238 238" preserveAspectRatio="none" style="position:absolute;width:100%;height:100%;left:0;top:0;fill:none;stroke:#e9b213;stroke-width:4;stroke-linecap:round;stroke-linejoin:round"><path d="M31 2H10a8 8 0 0 0-8 8v21M207 2h21a8 8 0 0 1 8 8v21m0 176v21a8 8 0 0 1-8 8h-21m-176 0H10a8 8 0 0 1-8-8v-21"/></svg>';try{this.$overlay.firstElementChild.animate({transform:["scale(.98)","scale(1.01)"]},{duration:400,iterations:1/0,direction:"alternate",easing:"ease-in-out"})}catch{}i.insertBefore(this.$overlay,this.$video.nextSibling)}t.highlightCodeOutline&&(this.$overlay.insertAdjacentHTML("beforeend",'<svg class="code-outline-highlight" preserveAspectRatio="none" style="display:none;width:100%;height:100%;fill:none;stroke:#e9b213;stroke-width:5;stroke-dasharray:25;stroke-linecap:round;stroke-linejoin:round"><polygon/></svg>'),this.$codeOutlineHighlight=this.$overlay.lastElementChild)}this._scanRegion=this._calculateScanRegion(e),requestAnimationFrame(()=>{let h=window.getComputedStyle(e);h.display==="none"&&(e.style.setProperty("display","block","important"),s=!0),h.visibility!=="visible"&&(e.style.setProperty("visibility","visible","important"),s=!0),s&&(console.warn("QrScanner has overwritten the video hiding style to avoid Safari stopping the playback."),e.style.opacity="0",e.style.width="0",e.style.height="0",this.$overlay&&this.$overlay.parentElement&&this.$overlay.parentElement.removeChild(this.$overlay),delete this.$overlay,delete this.$codeOutlineHighlight),this.$overlay&&this._updateOverlay()}),e.addEventListener("play",this._onPlay),e.addEventListener("loadedmetadata",this._onLoadedMetaData),document.addEventListener("visibilitychange",this._onVisibilityChange),window.addEventListener("resize",this._updateOverlay),this._qrEnginePromise=o.createQrEngine()}static set WORKER_PATH(e){console.warn("Setting QrScanner.WORKER_PATH is not required and not supported anymore. Have a look at the README for new setup instructions.")}static async hasCamera(){try{return!!(await o.listCameras(!1)).length}catch{return!1}}static async listCameras(e=!1){if(!navigator.mediaDevices)return[];let t=async()=>(await navigator.mediaDevices.enumerateDevices()).filter(a=>a.kind==="videoinput"),i;try{e&&(await t()).every(a=>!a.label)&&(i=await navigator.mediaDevices.getUserMedia({audio:!1,video:!0}))}catch{}try{return(await t()).map((a,l)=>({id:a.deviceId,label:a.label||(l===0?"Default Camera":`Camera ${l+1}`)}))}finally{i&&(console.warn("Call listCameras after successfully starting a QR scanner to avoid creating a temporary video stream"),o._stopVideoStream(i))}}async hasFlash(){let e;try{if(this.$video.srcObject){if(!(this.$video.srcObject instanceof MediaStream))return!1;e=this.$video.srcObject}else e=(await this._getCameraStream()).stream;return"torch"in e.getVideoTracks()[0].getSettings()}catch{return!1}finally{e&&e!==this.$video.srcObject&&(console.warn("Call hasFlash after successfully starting the scanner to avoid creating a temporary video stream"),o._stopVideoStream(e))}}isFlashOn(){return this._flashOn}async toggleFlash(){this._flashOn?await this.turnFlashOff():await this.turnFlashOn()}async turnFlashOn(){if(!this._flashOn&&!this._destroyed&&(this._flashOn=!0,this._active&&!this._paused))try{if(!await this.hasFlash())throw"No flash available";await this.$video.srcObject.getVideoTracks()[0].applyConstraints({advanced:[{torch:!0}]})}catch(e){throw this._flashOn=!1,e}}async turnFlashOff(){this._flashOn&&(this._flashOn=!1,await this._restartVideoStream())}destroy(){this.$video.removeEventListener("loadedmetadata",this._onLoadedMetaData),this.$video.removeEventListener("play",this._onPlay),document.removeEventListener("visibilitychange",this._onVisibilityChange),window.removeEventListener("resize",this._updateOverlay),this._destroyed=!0,this._flashOn=!1,this.stop(),o._postWorkerMessage(this._qrEnginePromise,"close")}async start(){if(this._destroyed)throw Error("The QR scanner can not be started as it had been destroyed.");if((!this._active||this._paused)&&(window.location.protocol!=="https:"&&console.warn("The camera stream is only accessible if the page is transferred via https."),this._active=!0,!document.hidden))if(this._paused=!1,this.$video.srcObject)await this.$video.play();else try{let{stream:e,facingMode:t}=await this._getCameraStream();!this._active||this._paused?o._stopVideoStream(e):(this._setVideoMirror(t),this.$video.srcObject=e,await this.$video.play(),this._flashOn&&(this._flashOn=!1,this.turnFlashOn().catch(()=>{})))}catch(e){if(!this._paused)throw this._active=!1,e}}stop(){this.pause(),this._active=!1}async pause(e=!1){if(this._paused=!0,!this._active)return!0;this.$video.pause(),this.$overlay&&(this.$overlay.style.display="none");let t=()=>{this.$video.srcObject instanceof MediaStream&&(o._stopVideoStream(this.$video.srcObject),this.$video.srcObject=null)};return e?(t(),!0):(await new Promise(i=>setTimeout(i,300)),this._paused?(t(),!0):!1)}async setCamera(e){e!==this._preferredCamera&&(this._preferredCamera=e,await this._restartVideoStream())}static async scanImage(e,t,i,a,l=!1,s=!1){let h,p=!1;t&&("scanRegion"in t||"qrEngine"in t||"canvas"in t||"disallowCanvasResizing"in t||"alsoTryWithoutScanRegion"in t||"returnDetailedScanResult"in t)?(h=t.scanRegion,i=t.qrEngine,a=t.canvas,l=t.disallowCanvasResizing||!1,s=t.alsoTryWithoutScanRegion||!1,p=!0):console.warn(t||i||a||l||s?"You're using a deprecated api for scanImage which will be removed in the future.":"Note that the return type of scanImage will change in the future. To already switch to the new api today, you can pass returnDetailedScanResult: true."),t=!!i;try{let y,d;[i,y]=await Promise.all([i||o.createQrEngine(),o._loadImage(e)]),[a,d]=o._drawToCanvas(y,h,a,l);let _;if(i instanceof Worker){let c=i;t||o._postWorkerMessageSync(c,"inversionMode","both"),_=await new Promise((g,O)=>{let E,S,v,x=-1;S=f=>{f.data.id===x&&(c.removeEventListener("message",S),c.removeEventListener("error",v),clearTimeout(E),f.data.data!==null?g({data:f.data.data,cornerPoints:o._convertPoints(f.data.cornerPoints,h)}):O(o.NO_QR_CODE_FOUND))},v=f=>{c.removeEventListener("message",S),c.removeEventListener("error",v),clearTimeout(E),O("Scanner error: "+(f?f.message||f:"Unknown Error"))},c.addEventListener("message",S),c.addEventListener("error",v),E=setTimeout(()=>v("timeout"),1e4);let j=d.getImageData(0,0,a.width,a.height);x=o._postWorkerMessageSync(c,"decode",j,[j.data.buffer])})}else _=await Promise.race([new Promise((c,g)=>window.setTimeout(()=>g("Scanner error: timeout"),1e4)),(async()=>{try{var[c]=await i.detect(a);if(!c)throw o.NO_QR_CODE_FOUND;return{data:c.rawValue,cornerPoints:o._convertPoints(c.cornerPoints,h)}}catch(g){if(c=g.message||g,/not implemented|service unavailable/.test(c))return o._disableBarcodeDetector=!0,o.scanImage(e,{scanRegion:h,canvas:a,disallowCanvasResizing:l,alsoTryWithoutScanRegion:s});throw`Scanner error: ${c}`}})()]);return p?_:_.data}catch(y){if(!h||!s)throw y;let d=await o.scanImage(e,{qrEngine:i,canvas:a,disallowCanvasResizing:l});return p?d:d.data}finally{t||o._postWorkerMessage(i,"close")}}setGrayscaleWeights(e,t,i,a=!0){o._postWorkerMessage(this._qrEnginePromise,"grayscaleWeights",{red:e,green:t,blue:i,useIntegerApproximation:a})}setInversionMode(e){o._postWorkerMessage(this._qrEnginePromise,"inversionMode",e)}static async createQrEngine(e){if(e&&console.warn("Specifying a worker path is not required and not supported anymore."),e=()=>k(()=>import("./qr-scanner-worker.min-5f44a019.js"),[]).then(i=>i.createWorker()),!(!o._disableBarcodeDetector&&"BarcodeDetector"in window&&BarcodeDetector.getSupportedFormats&&(await BarcodeDetector.getSupportedFormats()).includes("qr_code")))return e();let t=navigator.userAgentData;return t&&t.brands.some(({brand:i})=>/Chromium/i.test(i))&&/mac ?OS/i.test(t.platform)&&await t.getHighEntropyValues(["architecture","platformVersion"]).then(({architecture:i,platformVersion:a})=>/arm/i.test(i||"arm")&&13<=parseInt(a||"13")).catch(()=>!0)?e():new BarcodeDetector({formats:["qr_code"]})}_onPlay(){this._scanRegion=this._calculateScanRegion(this.$video),this._updateOverlay(),this.$overlay&&(this.$overlay.style.display=""),this._scanFrame()}_onLoadedMetaData(){this._scanRegion=this._calculateScanRegion(this.$video),this._updateOverlay()}_onVisibilityChange(){document.hidden?this.pause():this._active&&this.start()}_calculateScanRegion(e){let t=Math.round(.6666666666666666*Math.min(e.videoWidth,e.videoHeight));return{x:Math.round((e.videoWidth-t)/2),y:Math.round((e.videoHeight-t)/2),width:t,height:t,downScaledWidth:this._legacyCanvasSize,downScaledHeight:this._legacyCanvasSize}}_updateOverlay(){requestAnimationFrame(()=>{if(this.$overlay){var e=this.$video,t=e.videoWidth,i=e.videoHeight,a=e.offsetWidth,l=e.offsetHeight,s=e.offsetLeft,h=e.offsetTop,p=window.getComputedStyle(e),y=p.objectFit,d=t/i,_=a/l;switch(y){case"none":var c=t,g=i;break;case"fill":c=a,g=l;break;default:(y==="cover"?d>_:d<_)?(g=l,c=g*d):(c=a,g=c/d),y==="scale-down"&&(c=Math.min(c,t),g=Math.min(g,i))}var[O,E]=p.objectPosition.split(" ").map((v,x)=>{const j=parseFloat(v);return v.endsWith("%")?(x?l-g:a-c)*j/100:j});p=this._scanRegion.width||t,_=this._scanRegion.height||i,y=this._scanRegion.x||0;var S=this._scanRegion.y||0;d=this.$overlay.style,d.width=`${p/t*c}px`,d.height=`${_/i*g}px`,d.top=`${h+E+S/i*g}px`,i=/scaleX\(-1\)/.test(e.style.transform),d.left=`${s+(i?a-O-c:O)+(i?t-y-p:y)/t*c}px`,d.transform=e.style.transform}})}static _convertPoints(e,t){if(!t)return e;let i=t.x||0,a=t.y||0,l=t.width&&t.downScaledWidth?t.width/t.downScaledWidth:1;t=t.height&&t.downScaledHeight?t.height/t.downScaledHeight:1;for(let s of e)s.x=s.x*l+i,s.y=s.y*t+a;return e}_scanFrame(){!this._active||this.$video.paused||this.$video.ended||("requestVideoFrameCallback"in this.$video?this.$video.requestVideoFrameCallback.bind(this.$video):requestAnimationFrame)(async()=>{if(!(1>=this.$video.readyState)){var e=Date.now()-this._lastScanTimestamp,t=1e3/this._maxScansPerSecond;e<t&&await new Promise(a=>setTimeout(a,t-e)),this._lastScanTimestamp=Date.now();try{var i=await o.scanImage(this.$video,{scanRegion:this._scanRegion,qrEngine:this._qrEnginePromise,canvas:this.$canvas})}catch(a){if(!this._active)return;this._onDecodeError(a)}!o._disableBarcodeDetector||await this._qrEnginePromise instanceof Worker||(this._qrEnginePromise=o.createQrEngine()),i?(this._onDecode?this._onDecode(i):this._legacyOnDecode&&this._legacyOnDecode(i.data),this.$codeOutlineHighlight&&(clearTimeout(this._codeOutlineHighlightRemovalTimeout),this._codeOutlineHighlightRemovalTimeout=void 0,this.$codeOutlineHighlight.setAttribute("viewBox",`${this._scanRegion.x||0} ${this._scanRegion.y||0} ${this._scanRegion.width||this.$video.videoWidth} ${this._scanRegion.height||this.$video.videoHeight}`),this.$codeOutlineHighlight.firstElementChild.setAttribute("points",i.cornerPoints.map(({x:a,y:l})=>`${a},${l}`).join(" ")),this.$codeOutlineHighlight.style.display="")):this.$codeOutlineHighlight&&!this._codeOutlineHighlightRemovalTimeout&&(this._codeOutlineHighlightRemovalTimeout=setTimeout(()=>this.$codeOutlineHighlight.style.display="none",100))}this._scanFrame()})}_onDecodeError(e){e!==o.NO_QR_CODE_FOUND&&console.log(e)}async _getCameraStream(){if(!navigator.mediaDevices)throw"Camera not found.";let e=/^(environment|user)$/.test(this._preferredCamera)?"facingMode":"deviceId",t=[{width:{min:1024}},{width:{min:768}},{}],i=t.map(a=>Object.assign({},a,{[e]:{exact:this._preferredCamera}}));for(let a of[...i,...t])try{let l=await navigator.mediaDevices.getUserMedia({video:a,audio:!1}),s=this._getFacingMode(l)||(a.facingMode?this._preferredCamera:this._preferredCamera==="environment"?"user":"environment");return{stream:l,facingMode:s}}catch{}throw"Camera not found."}async _restartVideoStream(){let e=this._paused;await this.pause(!0)&&!e&&this._active&&await this.start()}static _stopVideoStream(e){for(let t of e.getTracks())t.stop(),e.removeTrack(t)}_setVideoMirror(e){this.$video.style.transform="scaleX("+(e==="user"?-1:1)+")"}_getFacingMode(e){return(e=e.getVideoTracks()[0])?/rear|back|environment/i.test(e.label)?"environment":/front|user|face/i.test(e.label)?"user":null:null}static _drawToCanvas(e,t,i,a=!1){i=i||document.createElement("canvas");let l=t&&t.x?t.x:0,s=t&&t.y?t.y:0,h=t&&t.width?t.width:e.videoWidth||e.width,p=t&&t.height?t.height:e.videoHeight||e.height;return a||(a=t&&t.downScaledWidth?t.downScaledWidth:h,t=t&&t.downScaledHeight?t.downScaledHeight:p,i.width!==a&&(i.width=a),i.height!==t&&(i.height=t)),t=i.getContext("2d",{alpha:!1}),t.imageSmoothingEnabled=!1,t.drawImage(e,l,s,h,p,0,0,i.width,i.height),[i,t]}static async _loadImage(e){if(e instanceof Image)return await o._awaitImageLoad(e),e;if(e instanceof HTMLVideoElement||e instanceof HTMLCanvasElement||e instanceof SVGImageElement||"OffscreenCanvas"in window&&e instanceof OffscreenCanvas||"ImageBitmap"in window&&e instanceof ImageBitmap)return e;if(e instanceof File||e instanceof Blob||e instanceof URL||typeof e=="string"){let t=new Image;t.src=e instanceof File||e instanceof Blob?URL.createObjectURL(e):e.toString();try{return await o._awaitImageLoad(t),t}finally{(e instanceof File||e instanceof Blob)&&URL.revokeObjectURL(t.src)}}else throw"Unsupported image type."}static async _awaitImageLoad(e){e.complete&&e.naturalWidth!==0||await new Promise((t,i)=>{let a=l=>{e.removeEventListener("load",a),e.removeEventListener("error",a),l instanceof ErrorEvent?i("Image load error"):t()};e.addEventListener("load",a),e.addEventListener("error",a)})}static async _postWorkerMessage(e,t,i,a){return o._postWorkerMessageSync(await e,t,i,a)}static _postWorkerMessageSync(e,t,i,a){if(!(e instanceof Worker))return-1;let l=o._workerMessageId++;return e.postMessage({id:l,type:t,data:i},a),l}}o.DEFAULT_CANVAS_SIZE=400;o.NO_QR_CODE_FOUND="No QR code found";o._disableBarcodeDetector=!1;o._workerMessageId=0;const B=()=>{var b;const R=H.useRef(null),[e,t]=C.useState(null);C.useEffect(()=>{if(R.current&&!e){const r=new o(R.current,u=>{p(u)},{highlightScanRegion:!0,highlightCodeOutline:!0});t(r)}return()=>{e&&(e.stop(),e.destroy(),t(null))}},[R.current,e]);const i=()=>{e?(e.start(),l(!0)):console.error("Scanner is not initialized yet")},[a,l]=C.useState(!1),[s,h]=C.useState(null),p=async r=>{if(r!=null&&r.data)try{const u=await P.post("https://events.essenciacompany.com/api/tickets/get",{ticket:r==null?void 0:r.data});h(u.data)}catch(u){M("Error scanning ticket",u)}},y=(r,u)=>{const w=parseInt(r==null?void 0:r.qty)??0;if(u=parseInt(u),!(u<w)){r={...r,newQty:u};var $=s.extras.map(m=>m.id===r.id?r:m);h(m=>({...m,extras:[...$]}))}},{data:d,isError:_,isLoading:c,isSuccess:g,refetch:O}=W(["scanner-extras",s],`https://events.essenciacompany.com/api/event-extras/${s==null?void 0:s.event_id}`),[E,S]=C.useState(!1),[v,x]=C.useState(null),[j,f]=C.useState(1),N=()=>{var $;if(!E){S(!0);return}const r={...v,qty:0,newQty:j};var u=!0,w=($=s==null?void 0:s.extras)==null?void 0:$.map(m=>m.id===r.id?(u=!1,{...m,newQty:r.newQty+((m==null?void 0:m.newQty)??(m==null?void 0:m.qty)??0)}):m);u&&(w=[...w,r]),h(m=>({...m,extras:[...w]})),S(!1),x(null),f(1)},[I,D]=C.useState(!1),L=async()=>{if(D(!0),(await P.post("https://events.essenciacompany.com/api/update-ticket",{ticket:s},{headers:{"Content-Type":"application/json","X-Secret-Key":"pos_password"}})).status==200&&(h(null),l(!1),M("Ticket updated successfully!!"),e)){e.stop();const u=new o(R.current,w=>{p(w)},{highlightScanRegion:!0,highlightCodeOutline:!0});t(u),u.start()}D(!1)};return n.jsxs("section",{className:"scanner-page",children:[s?n.jsxs("div",{className:"ticket-info",children:[n.jsx("h3",{children:"Ticket Information"}),n.jsxs("div",{className:"ticket-details",children:[n.jsxs("p",{children:[n.jsx("strong",{children:"Owner:"})," ",s==null?void 0:s.owner.name]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Email:"})," ",s==null?void 0:s.owner.email]}),n.jsxs("p",{children:[n.jsx("strong",{children:"VAT Number:"})," ",s==null?void 0:s.owner.vatNumber]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Address:"})," ",s==null?void 0:s.owner.address]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Event ID:"})," ",s==null?void 0:s.event_id]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Ticket ID:"})," ",s==null?void 0:s.ticket]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Price:"})," $",s==null?void 0:s.price]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Status:"})," ",(s==null?void 0:s.status)===0?"Not Used":"Used"]}),n.jsxs("p",{children:[n.jsx("strong",{children:"Dates:"})," ",s==null?void 0:s.dates.join(", ")]})]}),s!=null&&s.hasExtras?n.jsxs("div",{className:"extras",children:[n.jsx("h4",{children:"Extras"}),n.jsxs("ul",{children:[s==null?void 0:s.extras.map((r,u)=>{const w=parseInt((r==null?void 0:r.newQty)??(r==null?void 0:r.qty)??0),$=parseFloat((r==null?void 0:r.price)??0).toFixed(2);return n.jsxs("span",{className:"d-flex justify-content-between align-items-center",children:[n.jsx("span",{className:"col-md-3 text-start",children:r==null?void 0:r.name}),n.jsxs("div",{className:"update-quantity d-flex align-items-center justify-content-center col-md-3",children:[n.jsx("button",{className:"btn btn-outline-danger btn-sm",onClick:()=>y(r,w-1),children:"-"}),n.jsx("input",{type:"number",value:w,onChange:m=>y(r,m.target.value),className:"form-control text-center mx-2 border-0",style:{width:"40px"}}),n.jsx("button",{className:"btn btn-outline-dark btn-sm",onClick:()=>y(r,w+1),children:"+"})]}),n.jsxs("span",{className:"col-md-3 text-end",children:["X ",$,"$ ="]}),n.jsxs("span",{className:"col-md-3 text-end",children:[$*parseInt(r!=null&&r.newQty?(r==null?void 0:r.newQty)-(r==null?void 0:r.qty):0),"$"]})]},u)}),E&&n.jsx("div",{className:"modal-body row",children:n.jsxs("div",{className:"col-md-12",children:[n.jsxs("div",{className:"form-group",children:[n.jsx("label",{htmlFor:"extraSelect",children:"Select Extra"}),n.jsxs("select",{id:"extraSelect",className:"form-control mt-2",defaultValue:(v==null?void 0:v.display_name)??"Select an extra",children:[n.jsx("option",{onClick:()=>x(null),children:"None"}),(b=d==null?void 0:d.data)==null?void 0:b.map((r,u)=>n.jsx("option",{onClick:()=>x(r),children:r==null?void 0:r.display_name},u))]})]}),v?n.jsxs(n.Fragment,{children:[n.jsxs("div",{className:"form-group mt-3 d-flex flex-column justify-content-center align-items-center",children:[n.jsx("label",{htmlFor:"quantity",children:"Quantity"}),n.jsxs(V,{className:"w-50",children:[n.jsx(F,{variant:"outline-secondary",onClick:()=>f(r=>r-1>0?r-1:r),children:"-"}),n.jsx(q.Control,{"aria-label":"Example text with two button addons",className:"text-center",readOnly:!0,value:j}),n.jsx(F,{variant:"outline-danger",onClick:()=>f(r=>r+1),children:"+"})]})]}),n.jsxs("label",{htmlFor:"price",children:["Price",n.jsx("br",{}),(v==null?void 0:v.price)*j,"$"]})]}):""]})})]})]}):null,n.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:n.jsx("button",{type:"button",class:"btn btn-info text-light w-100 py-1",onClick:N,children:"Add extra"})}),n.jsx("span",{className:"d-flex justify-content-center align-items-center mt-2",children:n.jsx("button",{type:"button",class:"btn btn-success text-light w-100 py-1",onClick:L,children:I?"Processing...":"Save Changes"})})]}):a?"":n.jsxs("div",{className:"qr-box flex-column",onClick:i,children:[n.jsx("img",{className:"qr-image",src:"/assets/qr-code.png",alt:"QR Code"}),n.jsx("h3",{children:"Tap to start scanning"})]}),!s&&n.jsx("div",{id:"viewfinder",className:"qr-box",style:a?{}:{display:"none"},children:n.jsx("video",{ref:R,children:"Your browser does not support video playback."})})]})};export{B as default};