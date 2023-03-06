import{H as C,L as h,q as t,o as s,g as i,a as e,d as m,t as x,k as g,w as N,F as k,e as y}from"./app.37dcec21.js";import{H as b}from"./HomeLayout.ece2bcf7.js";import v from"./Report.2d5d4aac.js";import{C as a}from"./ckeditor.7473ce14.js";import{_ as V}from"./_plugin-vue_export-helper.cdc0426e.js";import"./SearchForm.7135984c.js";import"./BackButton.45c05563.js";import"./axios.2237760a.js";const H={name:"CreateComment",components:{Report:v,ConferenceLayout:b,Head:C,Link:h,ClassicEditor:a},props:{report:Array,isCreator:Boolean,firstName:String,lastName:String,creatorId:Number,errors:Object,text:String,commentId:Number},data(){return{editor:a,form:{report_id:"",text:"",first_name:"",last_name:""},editorConfig:{}}},methods:{submit(){confirm("Do you want save it?")&&this.$inertia.post(`/comments/${this.commentId}/update`,this.form)}},mounted(){this.form.text=this.text,this.form.report_id=this.report.id,this.form.first_name=this.firstName,this.form.last_name=this.lastName}},L={class:"comment-editor"},B={key:0,class:"error-form"},S={class:"comment-editor-footer"};function w(E,n,o,I,r,c){const d=t("Head"),f=t("ConferenceLayout"),l=t("Report"),_=t("ckeditor"),p=t("v-btn");return s(),i(k,null,[e(d,{title:"Create comment"}),e(f),e(l,{"is-creator":o.isCreator,report:o.report},null,8,["is-creator","report"]),m("div",L,[e(_,{editor:r.editor,modelValue:r.form.text,"onUpdate:modelValue":n[0]||(n[0]=u=>r.form.text=u),config:r.editorConfig},null,8,["editor","modelValue","config"]),o.errors.text?(s(),i("div",B,x(o.errors.text),1)):g("",!0),m("div",S,[e(p,{onClick:c.submit},{default:N(()=>[y("send")]),_:1},8,["onClick"])])])],64)}const U=V(H,[["render",w]]);export{U as default};
