import{H as p,q as r,o,g as s,a as d,d as e,F as n,z as i,k as l,t as h}from"./app.37dcec21.js";import{H as f}from"./HomeLayout.ece2bcf7.js";import{_ as m}from"./_plugin-vue_export-helper.cdc0426e.js";import"./SearchForm.7135984c.js";const g={name:"ShowResult",components:{HomeLayout:f,Head:p},props:{conferences:Object,reports:Object}},b={class:"search-result"},y={class:"accordion accordion-flush mt-10",style:{width:"230px"},id:"accordionFlushExample"},v={key:0,class:"accordion-item"},w=e("h2",{class:"accordion-header",id:"flush-headingOne"},[e("button",{class:"accordion-button collapsed",type:"button","data-bs-toggle":"collapse","data-bs-target":"#flush-collapseOne","aria-expanded":"false","aria-controls":"flush-collapseOne"}," Conference ")],-1),k={id:"flush-collapseOne",class:"accordion-collapse collapse","aria-labelledby":"flush-headingOne","data-bs-parent":"#accordionFlushExample"},H={class:"accordion-body"},O=["href"],x={key:1,class:"accordion-item"},F=e("h2",{class:"accordion-header",id:"flush-headingTwo"},[e("button",{class:"accordion-button collapsed",type:"button","data-bs-toggle":"collapse","data-bs-target":"#flush-collapseTwo","aria-expanded":"false","aria-controls":"flush-collapseTwo"}," Report ")],-1),R={id:"flush-collapseTwo",class:"accordion-collapse collapse","aria-labelledby":"flush-headingTwo","data-bs-parent":"#accordionFlushExample"},T={class:"accordion-body"},E=["href"],L={key:0,class:"conference-empty"};function N(c,S,t,B,C,V){const u=r("Head"),_=r("HomeLayout");return o(),s(n,null,[d(u,{title:"Search Result"}),d(_,{"can-register":c.canRegister},null,8,["can-register"]),e("div",b,[e("div",y,[t.conferences.length>=1?(o(),s("div",v,[w,e("div",k,[e("div",H,[(o(!0),s(n,null,i(t.conferences,a=>(o(),s("ul",null,[e("a",{target:"_blank",href:c.route("conferences.show",{conference:a.id})},h(a.title),9,O)]))),256))])])])):l("",!0),t.reports.length>=1?(o(),s("div",x,[F,e("div",R,[e("div",T,[(o(!0),s(n,null,i(t.reports,a=>(o(),s("ul",null,[e("a",{target:"_blank",href:c.route("report.home",{report:a.id})},h(a.title),9,E)]))),256))])])])):l("",!0)])]),t.reports.length<1&&t.conferences.length<1?(o(),s("div",L," Nothing was found ")):l("",!0)],64)}const A=m(g,[["render",N]]);export{A as default};