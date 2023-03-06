import{L as k,H as c,q as m,s as g,o as d,g as n,a as r,d as s,w as i,F as R,t as u,k as f,h as P,e as v}from"./app.37dcec21.js";import{_ as U}from"./_plugin-vue_export-helper.cdc0426e.js";const q={components:{Link:k,Head:c},props:{countries:Array,errors:Object},data:()=>({valid:!0,phoneRules:[e=>e&&e.length>=10||"minimum 10 characters"],passwordRules:[e=>!!e||"Please type password.",e=>e&&e.length>=6||"minimum 6 characters"],nameRules:[e=>!!e||"Name is required",e=>e&&e.length<=25||"Name must be less than 25 characters",e=>e&&e.length>=2||"Name must be more than 2 characters"],emailRules:[e=>!!e||"E-mail is required",e=>/.+@.+\..+/.test(e)||"E-mail must be valid"],roles:[{role:"Announcer",id:2},{role:"Listener",id:1}],form:{firstName:"",lastName:"",password:"",confirmPassword:"",email:"",countryId:227,roleId:1,birthDate:"",phone:""}}),methods:{validate(){this.$refs.form.validate()},submit(){this.$inertia.post("/register",this.form)}}},C={class:"register-form"},D={key:0,class:"mb-5"},I={key:0,class:"mb-5"},L={key:0,class:"error-form"},E={class:"register-form-footer"};function H(e,l,a,B,F,b){const V=m("Head"),t=m("v-text-field"),p=m("v-select"),w=m("Link"),h=m("v-btn"),y=m("v-form"),N=g("mask");return d(),n(R,null,[r(V,{title:"Register"}),s("div",C,[r(y,{ref:"form",modelValue:e.valid,"onUpdate:modelValue":l[9]||(l[9]=o=>e.valid=o),"lazy-validation":"",style:{width:"360px"},class:"mt-5"},{default:i(()=>[s("div",null,[r(t,{modelValue:e.form.firstName,"onUpdate:modelValue":l[0]||(l[0]=o=>e.form.firstName=o),counter:25,rules:e.nameRules,label:"First Name",required:""},null,8,["modelValue","rules"]),a.errors.firstName?(d(),n("div",D,u(a.errors.firstName),1)):f("",!0)]),s("div",null,[r(t,{modelValue:e.form.lastName,"onUpdate:modelValue":l[1]||(l[1]=o=>e.form.lastName=o),counter:25,rules:e.nameRules,label:"Last Name",required:""},null,8,["modelValue","rules"]),a.errors.lastName?(d(),n("div",I,u(a.errors.lastName),1)):f("",!0)]),s("div",null,[r(t,{modelValue:e.form.email,"onUpdate:modelValue":l[2]||(l[2]=o=>e.form.email=o),rules:e.emailRules,label:"E-mail",required:""},null,8,["modelValue","rules"]),a.errors.email?(d(),n("div",L,u(a.errors.email),1)):f("",!0)]),s("div",null,[r(t,{modelValue:e.form.password,"onUpdate:modelValue":l[3]||(l[3]=o=>e.form.password=o),label:"Password",name:"password",type:"password",rules:e.passwordRules},null,8,["modelValue","rules"])]),s("div",null,[r(t,{modelValue:e.form.confirmPassword,"onUpdate:modelValue":l[4]||(l[4]=o=>e.form.confirmPassword=o),label:"Confirm Password",name:"confirmPassword",type:"password",rules:[!!e.form.confirmPassword||"type confirm password",e.form.password===e.form.confirmPassword||"The password confirmation does not match."]},null,8,["modelValue","rules"])]),s("div",null,[r(p,{modelValue:e.form.roleId,"onUpdate:modelValue":l[5]||(l[5]=o=>e.form.roleId=o),items:this.roles,"item-value":"id","item-title":"role"},null,8,["modelValue","items"])]),s("div",null,[r(p,{modelValue:e.form.countryId,"onUpdate:modelValue":l[6]||(l[6]=o=>e.form.countryId=o),items:a.countries,"item-value":"id","item-title":"name",label:"Country",required:""},null,8,["modelValue","items"])]),s("div",null,[r(t,{type:"date",modelValue:e.form.birthDate,"onUpdate:modelValue":l[7]||(l[7]=o=>e.form.birthDate=o),placeholder:"dd-mm-yyyy",max:"2018-12-31"},null,8,["modelValue"])]),s("div",null,[P(r(t,{type:"text",modelValue:e.form.phone,"onUpdate:modelValue":l[8]||(l[8]=o=>e.form.phone=o),placeholder:"+00 (000) 00 00 000",rules:e.phoneRules,label:"Phone Number"},null,8,["modelValue","rules"]),[[N,"+00 (000) 00 00 000"]])]),s("div",E,[r(w,{href:e.route("home"),class:"ml-4 btn btn-secondary btn-back v-btn v-btn--elevated v-theme--light v-btn--density-default v-btn--size-default v-btn--variant-elevated"},{default:i(()=>[v(" back ")]),_:1},8,["href"]),r(h,{onClick:b.submit,disabled:!e.valid,color:"success",class:"mr-4"},{default:i(()=>[v(" submit ")]),_:1},8,["onClick","disabled"])])]),_:1},8,["modelValue"])])],64)}const T=U(q,[["render",H]]);export{T as default};
