import{H as b}from"./HomeLayout.ece2bcf7.js";import{H as V,q as l,o as s,g as i,a as r,w as u,F as h,d,t as x,k as m,f as k,e as L}from"./app.37dcec21.js";import{_ as H}from"./InputLabel.3f302162.js";import{_ as T}from"./_plugin-vue_export-helper.cdc0426e.js";import"./SearchForm.7135984c.js";const F={name:"Create",components:{InputLabel:H,ConferenceLayout:b,Head:V},props:{parentCategories:Array,errors:Object},data(){return{valid:!0,titleRules:[t=>!!t||"Title is required",t=>t&&t.length<=25||"Title must be less than 25 characters",t=>t&&t.length>=2||"Title must be more than 2 characters"],form:{title:"",parent_category_id:null}}},methods:{validate(){this.$refs.form.validate()},submit(){this.$inertia.post("/categories",this.form),setTimeout(this.clearForm,1e3)},clearForm(){this.form.parent_category_id=null,this.form.title=null}}},N={key:0,class:"mb-5",style:{color:"red"}},q={key:0},w={class:"parent-category-input"};function B(t,o,a,I,e,_){const f=l("Head"),p=l("ConferenceLayout"),c=l("InputLabel"),g=l("v-text-field"),y=l("v-select"),v=l("v-btn"),C=l("v-form");return s(),i(h,null,[r(f,{title:"Create Category"}),r(p),r(C,{ref:"form",modelValue:e.valid,"onUpdate:modelValue":o[3]||(o[3]=n=>e.valid=n),"lazy-validation":"",class:"category-form"},{default:u(()=>[d("div",null,[r(c,{for:"titleCategory",value:"Title Category"}),r(g,{id:"titleCategory",modelValue:e.form.title,"onUpdate:modelValue":o[0]||(o[0]=n=>e.form.title=n),counter:25,rules:e.titleRules,required:""},null,8,["modelValue","rules"]),a.errors.title?(s(),i("div",N,x(a.errors.title),1)):m("",!0)]),a.parentCategories.length>=1?(s(),i("div",q,[r(c,{for:"parentCategory",value:"Parent Category"}),d("div",w,[r(y,{id:"parentCategory",modelValue:e.form.parent_category_id,"onUpdate:modelValue":o[1]||(o[1]=n=>e.form.parent_category_id=n),items:a.parentCategories,"item-value":"id","item-title":"title"},null,8,["modelValue","items"]),e.form.parent_category_id!==null?(s(),i("button",{key:0,style:{"font-size":"35px","margin-bottom":"25px"},class:"bi bi-x-lg",onClick:o[2]||(o[2]=k(n=>e.form.parent_category_id=null,["prevent"]))})):m("",!0)])])):m("",!0),r(v,{onClick:_.submit,disabled:!e.valid,color:"success",class:"mr-4"},{default:u(()=>[L(" create ")]),_:1},8,["onClick","disabled"])]),_:1},8,["modelValue"])],64)}const D=T(F,[["render",B]]);export{D as default};