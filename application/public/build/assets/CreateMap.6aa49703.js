import{_ as s}from"./_plugin-vue_export-helper.cdc0426e.js";import{B as a,C as o,o as r,g as i}from"./app.37dcec21.js";const n={props:{mapId:String},data(){return{marker:null,location:{}}},methods:{createMap(){this.$store.getters.getCurrentCoordinates.lat!==null?this.location=this.$store.getters.getCurrentCoordinates:this.location=this.$store.getters.getDefaultCoordinates;const t=new google.maps.Map(document.getElementById("map"),{center:this.location,zoom:12,mapId:this.mapId});this.marker=this.addMarker(this.location,t),a(this.marker)&&(this.marker=o(this.marker)),google.maps.event.addListener(t,"click",e=>{this.location=e.latLng.toJSON(),this.marker&&o(this.marker).setMap(null),this.marker=this.addMarker(o(this.location),t),this.saveCoordinates(o(this.location))})},saveCoordinates(t){this.$store.commit("saveCoordinates",t)},addMarker(t,e){return new google.maps.Marker({position:t,map:e})}},mounted(){this.createMap(),this.$store.watch(()=>this.$store.getters.getCurrentCoordinates,t=>{this.location.lng=t.lng===null?this.location.lng:t.lng,this.location.lat=t.lat===null?this.location.lat:t.lat,this.marker.setPosition(this.location)},{deep:!0})}},l={class:"map",id:"map"};function c(t,e,h,m,d,p){return r(),i("div",l)}const k=s(n,[["render",c]]);export{k as default};
