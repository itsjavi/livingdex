(this.webpackJsonplivingdex=this.webpackJsonplivingdex||[]).push([[0],{12:function(e,t,n){e.exports={"box-group":"BoxesPage_box-group__2qvAr","box-group-content":"BoxesPage_box-group-content__cmXdh",box:"BoxesPage_box__3SWQq","box-header":"BoxesPage_box-header__3Ultd","box-title":"BoxesPage_box-title__3ji1O","box-grid":"BoxesPage_box-grid__LBmRE","box-cell":"BoxesPage_box-cell__KpmHB","box-cell-content":"BoxesPage_box-cell-content__VCZHE","box-img":"BoxesPage_box-img__MykXM","has-gmax":"BoxesPage_has-gmax__1Cq7o"}},14:function(e,t,n){e.exports={layoutHeader:"LayoutHeader_layoutHeader__3X1tP",layoutHeaderTop:"LayoutHeader_layoutHeaderTop__3ygrb",layoutHeaderTitle:"LayoutHeader_layoutHeaderTitle__10aII",layoutHeaderRightMenu:"LayoutHeader_layoutHeaderRightMenu__2aQbs",active:"LayoutHeader_active__2A29m",layoutHeaderBottom:"LayoutHeader_layoutHeaderBottom__1VMWe",layoutHeaderSubMenuTitle:"LayoutHeader_layoutHeaderSubMenuTitle__X6vnu"}},24:function(e,t,n){e.exports={layout:"Layout_layout__3PvPc",layoutBody:"Layout_layoutBody__aAcW8",layoutBodyInner:"Layout_layoutBodyInner__2lEVU"}},25:function(e,t,n){e.exports={button:"Button_button__3QF_k",buttonShoulderLeft:"Button_buttonShoulderLeft__G3rF_",buttonShoulderRight:"Button_buttonShoulderRight__7TR2f",buttonIcon:"Button_buttonIcon___rrTs"}},30:function(e,t,n){e.exports={pokedexList:"PokedexPage_pokedexList__3jQ9k",pokedexListItem:"PokedexPage_pokedexListItem__3MDzB"}},42:function(e,t,n){},43:function(e,t,n){},53:function(e,t,n){},54:function(e,t,n){},57:function(e,t,n){"use strict";n.r(t);var a=n(0),r=n.n(a),s=n(19),o=n.n(s),c=(n(42),n(43),n(17)),i=n(34),u=n(13),l=n(24),h=n.n(l),b=n(14),d=n.n(b),p=n.p+"static/media/box-icon.c2afa28f.svg",j=n(6),f=n(1);function g(e){return Object(f.jsxs)("div",{className:d.a.layoutHeader,children:[Object(f.jsxs)("div",{className:d.a.layoutHeaderTop+" bgGradientLeft",children:[Object(f.jsxs)(j.b,{to:"/",className:d.a.layoutHeaderTitle,children:[Object(f.jsx)("img",{alt:"icon",src:p}),Object(f.jsx)("h1",{children:e.title})]}),Object(f.jsx)("div",{className:d.a.layoutHeaderRightMenu,children:Object(f.jsxs)("nav",{children:[Object(f.jsxs)(j.c,{to:"/",activeClassName:d.a.active,isActive:function(e,t){return!!t&&"/"===t.pathname},children:[Object(f.jsx)("i",{className:"icon-box-add"}),Object(f.jsx)("span",{children:"Boxes"})]}),Object(f.jsxs)(j.c,{to:"/pokedex",activeClassName:d.a.active,children:[Object(f.jsx)("i",{className:"icon-books"}),Object(f.jsx)("span",{children:"Pok\xe9dex"})]}),Object(f.jsxs)("a",{href:"https://github.com/itsjavi/livingdex#pok%C3%A9mon-living-dex",target:"_blank",rel:"noreferrer",children:[Object(f.jsx)("i",{className:"icon-github",title:"Github"}),Object(f.jsx)("span",{children:"Github"})]})]})})]}),Object(f.jsx)("div",{className:d.a.layoutHeaderBottom+" bgGradientDownLight",children:Object(f.jsx)("h2",{className:d.a.layoutHeaderSubMenuTitle,children:e.subtitle})})]})}function m(e){return Object(f.jsxs)("div",{className:h.a.layout,children:[Object(f.jsx)(g,{title:e.title,subtitle:e.subtitle}),Object(f.jsx)("div",{className:h.a.layoutBody,children:Object(f.jsx)("div",{className:h.a.layoutBodyInner,children:e.children})})]})}var x=n(30),v=n.n(x),O=n(2),y=n.n(O),_=n(5),k=n(20),w=n(21),N=n(15),S=n(31),B="/livingdex/assets/data/json",P=Object(S.a)("baseUrl"),H=Object(S.a)("generation"),L=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:8,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:B;Object(k.a)(this,e),Object.defineProperty(this,P,{writable:!0,value:void 0}),Object.defineProperty(this,H,{writable:!0,value:void 0}),Object(N.a)(this,H)[H]=t,Object(N.a)(this,P)[P]=n}return Object(w.a)(e,[{key:"generation",get:function(){return Object(N.a)(this,H)[H]},set:function(e){Object(N.a)(this,H)[H]=e}},{key:"baseUrl",get:function(){return Object(N.a)(this,P)[P]},set:function(e){Object(N.a)(this,P)[P]=e}},{key:"_getJson",value:function(){var e=Object(_.a)(y.a.mark((function e(t){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",fetch(Object(N.a)(this,P)[P]+"/"+t+".json").then((function(e){return e.json()})));case 1:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()},{key:"getPokemonList",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("gen/".concat(this.generation,"/pokemon-forms")));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getPokemon",value:function(){var e=Object(_.a)(y.a.mark((function e(t){var n,a,r=this,s=arguments;return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=s.length>1&&void 0!==s[1]&&s[1],a=this._getJson("gen/".concat(this.generation,"/pokemon/").concat(t)),n&&a.then((function(e){return Promise.all([e,r.getLearnset(t)])})).then((function(e){e[0].learnset=e[1]})),e.abrupt("return",a);case 4:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()},{key:"getLearnset",value:function(){var e=Object(_.a)(y.a.mark((function e(t){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("gen/".concat(this.generation,"/learnsets/").concat(t)));case 1:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()},{key:"getMoves",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("gen/".concat(this.generation,"/moves")));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getMove",value:function(){var e=Object(_.a)(y.a.mark((function e(t){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this.getMoves().then((function(e){return e[t]})));case 1:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()},{key:"getItems",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("gen/".concat(this.generation,"/items")));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getItem",value:function(){var e=Object(_.a)(y.a.mark((function e(t){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this.getItems().then((function(e){return e[t]})));case 1:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()},{key:"getAbilities",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("gen/".concat(this.generation,"/abilities")));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getGames",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("games"));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getAbility",value:function(){var e=Object(_.a)(y.a.mark((function e(t){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this.getAbilities().then((function(e){return e[t]})));case 1:case"end":return e.stop()}}),e,this)})));return function(t){return e.apply(this,arguments)}}()},{key:"getTypes",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("types"));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getEggGroups",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("egg-groups"));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()},{key:"getNatures",value:function(){var e=Object(_.a)(y.a.mark((function e(){return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.abrupt("return",this._getJson("natures"));case 1:case"end":return e.stop()}}),e,this)})));return function(){return e.apply(this,arguments)}}()}]),e}(),I=new L;function M(e,t){if(e.onlyHomeStorable&&!t.isHomeStorable)return!0;if(e.onlyHomeStorable&&t.isGmax)return!0;if(!e.showForms&&t.isForm)return!0;if(!e.showCosmeticForms&&t.isCosmetic)return!0;if(e.search.length>2){var n=new RegExp(e.search,"gi"),a=null!==t.type1&&t.type1.match(n)||null!==t.type2&&t.type2.match(n);if(!t.name.match(n)&&!t.slug.match(n))return!a}return!1}var T=function(e){var t=Object(a.useState)(e),n=Object(u.a)(t,1)[0],r=Object(a.useState)([]),s=Object(u.a)(r,2),o=s[0],c=s[1],i=Object(a.useState)(!0),l=Object(u.a)(i,2),h=l[0],b=l[1];return Object(a.useEffect)((function(){function e(){return(e=Object(_.a)(y.a.mark((function e(){var t;return y.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return b(!0),I.generation=n.gen,e.next=4,I.getPokemonList().then((function(e){var t=[],a=0;for(var r in e){var s=e[r];M(n,s)||(s.tabIndex=a,a++,t.push(s))}return t}));case 4:t=e.sent,c(t),b(!1);case 7:case"end":return e.stop()}}),e)})))).apply(this,arguments)}!function(){e.apply(this,arguments)}()}),[n]),{pokemon:o,loading:h,options:n}},C=n(4),F=function(){function e(){Object(k.a)(this,e),this._gen=8,this._search="",this.showForms=!0,this.showCosmeticForms=!0,this.separateBoxPikachu=!1,this.separateBoxForms=!1,this.onlyHomeStorable=!1,this.viewShiny=!1}return Object(w.a)(e,[{key:"gen",get:function(){return this._gen},set:function(e){this._gen=Math.min(8,Math.max(1,parseInt(e+""))||8)}},{key:"search",get:function(){return this._search},set:function(e){this._search=null===e?"":e}}]),e}(),D=(new F,F);var J=function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t=Object(C.g)().search;return Object(a.useMemo)((function(){var n=new URLSearchParams(t),a=new D;return a.gen=n.get("gen"),a.search=n.get("q"),e?(a.showForms=n.has("all"),a.showCosmeticForms=n.has("all")):(a.showForms=!n.has("noforms")||n.has("all"),a.showCosmeticForms=!n.has("nocosmetic")||n.has("all")),a.viewShiny=n.has("shiny"),a.onlyHomeStorable=!n.has("all"),a.separateBoxPikachu=n.get("sbpika"),a.separateBoxForms=n.get("sbforms"),a}),[t,e])};n(53);function A(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"",r=arguments.length>4&&void 0!==arguments[4]&&arguments[4],s=r?"pkmi":"pkm",o=r?"placeholder-68x56.png":"placeholder-64x64.png",c=(a=a.length>0?" "+a:"").length>0?a+"-wrapper":"",i="".concat(s," ").concat(s,"-").concat(e)+a;return n&&(i+=" shiny"),Object(f.jsx)("span",{className:s+"-wrapper"+c,children:Object(f.jsx)("img",{className:i,src:"/livingdex/placeholders/"+o,alt:t})})}var E=function(){var e=Object(C.f)(),t=J(!0);t.onlyHomeStorable=!1;var n=Object(a.useState)(t),r=Object(u.a)(n,1)[0],s=T(r),o=s.pokemon,l=s.loading,h=[],b=Object(f.jsx)("span",{children:"Living Dex"}),d="Loading...";if(!1===l){var p,j=function(t){e.push("/pokemon/"+t.currentTarget.dataset.slug)},g=0,x=Object(i.a)(o);try{for(x.s();!(p=x.n()).done;){var O=p.value;if(null===O.baseSpecies){g++;var y=A(O.slug,O.name,t.viewShiny),_={"data-slug":O.slug};h.push(Object(f.jsx)("div",Object(c.a)(Object(c.a)({title:O.name,tabIndex:O.num,className:v.a.pokedexListItem},_),{},{onClick:j,children:y}),O.id))}}}catch(k){x.e(k)}finally{x.f()}d="National Pok\xe9dex ("+g+" Pok\xe9mon)"}return Object(f.jsx)("div",{className:"app themePurple bgGradientDown",children:Object(f.jsx)(m,{title:b,subtitle:d,children:Object(f.jsx)("div",{className:v.a.pokedexList,children:h})})})},G=n(12),R=n.n(G);function U(e){for(var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:5,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:6,a=-1,r=0,s=0,o=0,c="\n";a<e;){if(s+1>n)s=0,o++,c+="\n";else{if(++a===e){c+=" * \n\n";break}c+=" - ",s++}o+1>t&&(r++,o=0,s=0,c+="\n\n")}return{box:r,row:o,col:s,debug:c}}function W(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],a=A(e.slug,e.name,n,R.a["box-img"]),r=function(e){t.push("/pokemon/"+e.currentTarget.dataset.slug)},s={"data-slug":e.slug};return Object(f.jsx)("div",{title:e.name,tabIndex:e.tabIndex,className:R.a["box-cell"],children:Object(f.jsx)("figure",{children:Object(f.jsxs)("div",{className:R.a["box-cell-content"],children:[Object(f.jsx)("span",{className:R.a["box-cell-thumbnail"],children:a}),Object(f.jsx)("figcaption",Object(c.a)(Object(c.a)({onClick:r},s),{},{children:e.name}))]})})},e.id)}var q=function(){var e=Object(C.f)(),t=J(),n=T(t),a=n.pokemon,r=n.loading,s=null,o=Object(f.jsx)("span",{children:"Living Dex"}),c="Loading...";return!1===r&&(s=function(e,t){var n=arguments.length>2&&void 0!==arguments[2]&&arguments[2],a=new Map;e.forEach((function(e,t){var n=U(t,5,6);a.has(n.box)||a.set(n.box,new Map);var r=a.get(n.box);r.has(n.row)||r.set(n.row,new Map),r.get(n.row).set(n.col,e)}));var r=[];return a.forEach((function(e,a){var s=[];e.forEach((function(e,a){e.forEach((function(e,a){s.push(W(e,t,n))}))})),r.push(Object(f.jsxs)("div",{tabIndex:-1*a,className:R.a.box,children:[Object(f.jsx)("div",{className:R.a["box-header"],children:Object(f.jsx)("div",{className:R.a["box-title"],children:"Box "+(a+1)})}),Object(f.jsx)("div",{className:R.a["box-grid"],children:s})]},a))})),r}(a,e,t.viewShiny),c="Box Organization ("+a.length+" Storable Pok\xe9mon)"),Object(f.jsx)("div",{className:"app themeTeal bgGradientDown",children:Object(f.jsx)(m,{title:o,subtitle:c,children:Object(f.jsx)("div",{className:R.a["box-group"],children:Object(f.jsx)("div",{className:R.a["box-group-content"],children:s})})})})},Q=(n(54),new L);function V(e){return Q.getPokemon(e,!1).then((function(e){e.dexNum=e.num;var t=Promise.resolve(e);return null!==e.baseSpecies&&(t=t.then((function(t){return V(e.baseSpecies).then((function(e){return t.baseSpecies=e,t}))}))),t}))}var X=function(e,t){var n=Object(a.useState)(null),r=Object(u.a)(n,2),s=r[0],o=r[1],c=Object(a.useState)(!0),i=Object(u.a)(c,2),l=i[0],h=i[1];return Object(a.useEffect)((function(){function n(){return(n=Object(_.a)(y.a.mark((function n(){var a;return y.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return h(!0),Q.generation=e,n.next=4,V(t);case 4:a=n.sent,o(a),h(!1);case 7:case"end":return n.stop()}}),n)})))).apply(this,arguments)}!function(){n.apply(this,arguments)}()}),[e,t]),{pokemon:s,loading:l}},z=n(25),K=n.n(z);function Z(e){var t,n=null,a=K.a.button;if(e.icon&&(n=Object(f.jsx)("i",{className:K.a.buttonIcon,children:e.icon})),e.type){var r="button"+((t=e.type).charAt(0).toUpperCase()+t.slice(1));a+=" "+K.a[r]}return e.href?Object(f.jsxs)("a",{rel:"noreferrer nofollow",target:e.target,href:e.href,role:"button",className:a,children:[n,e.children]}):Object(f.jsxs)("div",{role:"button",className:a,children:[n,e.children]})}var $=function(){var e=Object(C.h)().slug,t=J(),n=X(t.gen,e),a=n.pokemon,r="Loading...";if(n.loading)return Object(f.jsx)("div",{className:"app themeTeal bgGradientDown",children:Object(f.jsx)(m,{title:"Living Dex",subtitle:r,children:Object(f.jsx)("div",{className:"pokemonDetailsPage",children:"---"})})});r=a.name;var s=A(a.slug,a.name,t.viewShiny,"pkm-2x"),o=null;a.baseSpecies&&(o=[Object(f.jsx)("hr",{}),Object(f.jsx)("p",{children:Object(f.jsx)("b",{children:"Default Form:"})}),Object(f.jsx)("span",{children:Object(f.jsx)(j.b,{className:"mugShot",to:"/pokemon/"+a.baseSpecies.slug,children:A(a.baseSpecies.slug,a.baseSpecies.name,t.viewShiny)})}),Object(f.jsx)("hr",{})]);var c=[];if(a.forms.length>0){for(var i in c.push(Object(f.jsx)("hr",{}),Object(f.jsxs)("h3",{children:["Forms (",a.forms.length+1,"):"]})),c.push(Object(f.jsx)("span",{children:Object(f.jsx)(j.b,{className:"mugShot currentMugShot",to:"/pokemon/"+a.slug,children:A(a.slug,a.name,t.viewShiny)})})),a.forms){var u=a.forms[i];c.push(Object(f.jsx)("span",{children:Object(f.jsx)(j.b,{className:"mugShot",to:"/pokemon/"+u,children:A(u,u,t.viewShiny)})}))}c.push(Object(f.jsx)("hr",{}))}var l=B+"/gen/".concat(t.gen,"/pokemon/").concat(a.slug,".json");return Object(f.jsx)("div",{className:"app themePurple bgGradientDown",children:Object(f.jsx)(m,{title:"Living Dex",subtitle:"Pok\xe9dex",children:Object(f.jsxs)("div",{className:"pokemonDetailsPage",style:{textAlign:"center"},children:[Object(f.jsx)("h2",{children:a.name}),Object(f.jsx)("div",{className:"pokemonCardWrapper",children:Object(f.jsx)("div",{className:"pokemonCard",children:s})}),Object(f.jsx)(Z,{href:l,children:"View Data"}),null,o,c,Object(f.jsx)("p",{className:"infoBox",children:"This page is still a work in progress."})]})})})};var Y=function(){var e=Object(C.g)(),t=e.pathname+"@"+e.hash+"@"+e.search.toString();return Object(f.jsxs)(C.c,{children:[Object(f.jsx)(C.a,{path:"/pokedex",children:Object(f.jsx)(E,{})}),Object(f.jsx)(C.a,{path:"/pokemon/:slug",children:Object(f.jsx)($,{})}),Object(f.jsx)(C.a,{path:"/",children:Object(f.jsx)(q,{})})]},t)},ee=n(22),te=Object(ee.b)({name:"counter",initialState:{value:0},reducers:{increment:function(e){e.value+=1},decrement:function(e){e.value-=1},incrementByAmount:function(e,t){e.value+=t.payload}}}),ne=te.actions,ae=(ne.increment,ne.decrement,ne.incrementByAmount,te.reducer),re=Object(ee.a)({reducer:{counter:ae}}),se=n(37);Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));o.a.render(Object(f.jsx)(r.a.StrictMode,{children:Object(f.jsx)(se.a,{store:re,children:Object(f.jsx)(j.a,{basename:"/",children:Object(f.jsx)(Y,{})})})}),document.getElementById("root")),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()}))}},[[57,1,2]]]);
//# sourceMappingURL=main.166dc285.chunk.js.map