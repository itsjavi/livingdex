(window.webpackJsonp=window.webpackJsonp||[]).push([[5],{RXBc:function(e,a,t){"use strict";t.r(a);var l=t("q1tI"),n=t.n(l),r=t("7oih"),i=t("EYWl"),c=t("Wbzz"),s=function(e){var a=e.src,t=e.alt,l=void 0===t?"":t,r=e.title,i=void 0===r?"":r,c=e.className,s=void 0===c?"":c;return i=(i=i.replace(/-/g," ")).toLowerCase().split(" ").map((function(e){return e.charAt(0).toUpperCase()+e.substring(1)})).join(" "),n.a.createElement(n.a.Fragment,null,n.a.createElement("span",{"aria-label":i,"data-tooltip":i,className:"pk-link "+s},n.a.createElement("img",{className:"pk-img",alt:l,src:a})))},m=function(e){var a=e.boxCell,t=a.pid+" - "+a.name,l="";a.tags&&a.tags.length>0&&(l=" pk-tag-"+a.tags.join(" pk-tag-"));var r="pk-box-poke"+l+" column";if(!a.tags.includes("has-gigantamax"))return n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:r},n.a.createElement(s,{title:t,alt:t,src:a.image})));var i=t.split("-")[0]+"-"+t.split("-")[1]+"-gigantamax";return n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:r},n.a.createElement(s,{className:"pk-img-default",title:t,alt:t,src:a.image}),n.a.createElement(s,{className:"pk-img-hover",title:i,alt:i,src:a.image.replace("-female","").replace(".png","-gmax.png")})))},o=function(){return n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:"pk-box-poke pk-box-poke-gap column"},n.a.createElement(s,{alt:"-",src:"media/renders/000-gap.png"})))},u=function(e){var a=e.boxRow.map((function(e,a){return n.a.createElement(m,{key:a,boxCell:e})}));if(a.length<6)for(var t=a.length;t<6;t++)a.push(n.a.createElement(o,{key:t}));return n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:"pk-box-row columns is-mobile"},a))},g=function(){var e=[0,1,2,3,4,5].map((function(e,a){return n.a.createElement(o,{key:a})}));return n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:"pk-box-row columns is-mobile"},e))},p=function(e){var a=e.boxTitle,t=e.boxRows.map((function(e,a){return n.a.createElement(u,{key:a,boxRow:e.cells})}));if(t.length<5)for(var l=t.length;l<5;l++)t.push(n.a.createElement(g,{key:l}));return n.a.createElement(n.a.Fragment,null,n.a.createElement("div",{className:"pk-box-container hero"},n.a.createElement("div",{className:"hero-head"},n.a.createElement("p",{className:"title"},a)),n.a.createElement("div",{className:"hero-body"},t)))},d=function(){var e=Object(c.useStaticQuery)("4189430359"),a=[],t=[];if(e.dataJson.boxes.forEach((function(e,l){var r="BOX "+(l+1);a.push(n.a.createElement("div",{key:l,className:"column is-one-third-widescreen is-half is-full-mobile"},n.a.createElement(p,{boxTitle:r,boxRows:e.rows}))),3===a.length&&(t.push(n.a.createElement("div",{key:l,className:"columns is-full-mobile"},a)),a=[])})),a.length>0&&t.push(n.a.createElement("div",{key:-1,className:"columns is-full-mobile"},a)),a.length<3)for(var l=3..length;l<3;l++)t.push(n.a.createElement("div",{key:-(l+2),className:"columns is-full-mobile"}," "));return t};a.default=function(){return n.a.createElement(r.a,null,n.a.createElement(i.a,{title:"Pokémon HOME Box Organizer"}),n.a.createElement("div",{className:"container"},n.a.createElement("div",{className:"hero is-light",style:{borderRadius:"20px",background:"linear-gradient(180deg, rgba(245,245,245,0.6) 0%, #f5f5f5 100%)"}},n.a.createElement("div",{className:"hero-body"},n.a.createElement("div",{className:"content  has-text-centered is-medium"},"Living Dex is a visual guide for organizing Pokémon HOME boxes.",n.a.createElement("br",null),"This page contains a view of all storable Pokémon forms, including all gender differences.",n.a.createElement("br",null),"The project is still in a very early state, but please feel free to send any feedback directly ",n.a.createElement("a",{href:"https://github.com/itsjavi/livingdex",rel:"noopener noreferrer",target:"_blank"},"via Github."))))),n.a.createElement(d,null))}}}]);
//# sourceMappingURL=component---src-pages-index-js-9d0d1cce0a92db74ac43.js.map