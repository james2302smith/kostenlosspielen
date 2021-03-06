﻿
var cr={};cr.plugins_={};cr.behaviors={};if(typeof Object.getPrototypeOf!=="function")
{if(typeof"test".__proto__==="object")
{Object.getPrototypeOf=function(object){return object.__proto__;};}
else
{Object.getPrototypeOf=function(object){return object.constructor.prototype;};}}
(function(){cr.logexport=function(msg)
{if(window.console&&window.console.log)
window.console.log(msg);};cr.seal=function(x)
{return x;};cr.freeze=function(x)
{return x;};cr.is_undefined=function(x)
{return typeof x==="undefined";};cr.is_number=function(x)
{return typeof x==="number";};cr.is_string=function(x)
{return typeof x==="string";};cr.isPOT=function(x)
{return x>0&&((x-1)&x)===0;};cr.abs=function(x)
{return(x<0?-x:x);};cr.max=function(a,b)
{return(a>b?a:b);};cr.min=function(a,b)
{return(a<b?a:b);};cr.PI=Math.PI;cr.round=function(x)
{return(x+0.5)|0;};cr.floor=function(x)
{return x|0;};function Vector2(x,y)
{this.x=x;this.y=y;cr.seal(this);};Vector2.prototype.offset=function(px,py)
{this.x+=px;this.y+=py;return this;};Vector2.prototype.mul=function(px,py)
{this.x*=px;this.y*=py;return this;};cr.vector2=Vector2;cr.segments_intersect=function(a1x,a1y,a2x,a2y,b1x,b1y,b2x,b2y)
{if(cr.max(a1x,a2x)<cr.min(b1x,b2x)||cr.min(a1x,a2x)>cr.max(b1x,b2x)||cr.max(a1y,a2y)<cr.min(b1y,b2y)||cr.min(a1y,a2y)>cr.max(b1y,b2y))
{return false;}
var dpx=b1x-a1x+b2x-a2x;var dpy=b1y-a1y+b2y-a2y;var qax=a2x-a1x;var qay=a2y-a1y;var qbx=b2x-b1x;var qby=b2y-b1y;var d=cr.abs(qay*qbx-qby*qax);var la=qbx*dpy-qby*dpx;var lb=qax*dpy-qay*dpx;return cr.abs(la)<=d&&cr.abs(lb)<=d;};function Rect(left,top,right,bottom)
{this.set(left,top,right,bottom);cr.seal(this);};Rect.prototype.set=function(left,top,right,bottom)
{this.left=left;this.top=top;this.right=right;this.bottom=bottom;};Rect.prototype.width=function()
{return this.right-this.left;};Rect.prototype.height=function()
{return this.bottom-this.top;};Rect.prototype.offset=function(px,py)
{this.left+=px;this.top+=py;this.right+=px;this.bottom+=py;return this;};Rect.prototype.intersects_rect=function(rc)
{return!(rc.right<this.left||rc.bottom<this.top||rc.left>this.right||rc.top>this.bottom);};Rect.prototype.contains_pt=function(x,y)
{return(x>=this.left&&x<=this.right)&&(y>=this.top&&y<=this.bottom);};cr.rect=Rect;function Quad()
{this.tlx=0;this.tly=0;this.trx=0;this.try_=0;this.brx=0;this.bry=0;this.blx=0;this.bly=0;cr.seal(this);};Quad.prototype.set_from_rect=function(rc)
{this.tlx=rc.left;this.tly=rc.top;this.trx=rc.right;this.try_=rc.top;this.brx=rc.right;this.bry=rc.bottom;this.blx=rc.left;this.bly=rc.bottom;};Quad.prototype.set_from_rotated_rect=function(rc,a)
{if(a===0)
{this.set_from_rect(rc);}
else
{var sin_a=Math.sin(a);var cos_a=Math.cos(a);var left_sin_a=rc.left*sin_a;var top_sin_a=rc.top*sin_a;var right_sin_a=rc.right*sin_a;var bottom_sin_a=rc.bottom*sin_a;var left_cos_a=rc.left*cos_a;var top_cos_a=rc.top*cos_a;var right_cos_a=rc.right*cos_a;var bottom_cos_a=rc.bottom*cos_a;this.tlx=left_cos_a-top_sin_a;this.tly=top_cos_a+left_sin_a;this.trx=right_cos_a-top_sin_a;this.try_=top_cos_a+right_sin_a;this.brx=right_cos_a-bottom_sin_a;this.bry=bottom_cos_a+right_sin_a;this.blx=left_cos_a-bottom_sin_a;this.bly=bottom_cos_a+left_sin_a;}};Quad.prototype.offset=function(px,py)
{this.tlx+=px;this.tly+=py;this.trx+=px;this.try_+=py;this.brx+=px;this.bry+=py;this.blx+=px;this.bly+=py;return this;};Quad.prototype.bounding_box=function(rc)
{rc.left=cr.min(cr.min(this.tlx,this.trx),cr.min(this.brx,this.blx));rc.top=cr.min(cr.min(this.tly,this.try_),cr.min(this.bry,this.bly));rc.right=cr.max(cr.max(this.tlx,this.trx),cr.max(this.brx,this.blx));rc.bottom=cr.max(cr.max(this.tly,this.try_),cr.max(this.bry,this.bly));};Quad.prototype.contains_pt=function(x,y)
{var v0x=this.trx-this.tlx;var v0y=this.try_-this.tly;var v1x=this.brx-this.tlx;var v1y=this.bry-this.tly;var v2x=x-this.tlx;var v2y=y-this.tly;var dot00=v0x*v0x+v0y*v0y
var dot01=v0x*v1x+v0y*v1y
var dot02=v0x*v2x+v0y*v2y
var dot11=v1x*v1x+v1y*v1y
var dot12=v1x*v2x+v1y*v2y
var invDenom=1.0/(dot00*dot11-dot01*dot01);var u=(dot11*dot02-dot01*dot12)*invDenom;var v=(dot00*dot12-dot01*dot02)*invDenom;if((u>=0.0)&&(v>0.0)&&(u+v<1))
return true;v0x=this.blx-this.tlx;v0y=this.bly-this.tly;var dot00=v0x*v0x+v0y*v0y
var dot01=v0x*v1x+v0y*v1y
var dot02=v0x*v2x+v0y*v2y
invDenom=1.0/(dot00*dot11-dot01*dot01);u=(dot11*dot02-dot01*dot12)*invDenom;v=(dot00*dot12-dot01*dot02)*invDenom;return(u>=0.0)&&(v>0.0)&&(u+v<1);};Quad.prototype.at=function(i,xory)
{switch(i)
{case 0:return xory?this.tlx:this.tly;case 1:return xory?this.trx:this.try_;case 2:return xory?this.brx:this.bry;case 3:return xory?this.blx:this.bly;case 4:return xory?this.tlx:this.tly;default:return xory?this.tlx:this.tly;}};Quad.prototype.midX=function()
{return(this.tlx+this.trx+this.brx+this.blx)/4;};Quad.prototype.midY=function()
{return(this.tly+this.try_+this.bry+this.bly)/4;};Quad.prototype.intersects_segment=function(x1,y1,x2,y2)
{if(this.contains_pt(x1,y1)||this.contains_pt(x2,y2))
return true;var a1x,a1y,a2x,a2y;var i;for(i=0;i<4;i++)
{a1x=this.at(i,true);a1y=this.at(i,false);a2x=this.at(i+1,true);a2y=this.at(i+1,false);if(cr.segments_intersect(x1,y1,x2,y2,a1x,a1y,a2x,a2y))
return true;}
return false;};Quad.prototype.intersects_quad=function(rhs)
{var midx=rhs.midX();var midy=rhs.midY();if(this.contains_pt(midx,midy))
return true;midx=this.midX();midy=this.midY();if(rhs.contains_pt(midx,midy))
return true;var a1x,a1y,a2x,a2y,b1x,b1y,b2x,b2y;var i,j;for(i=0;i<4;i++)
{for(j=0;j<4;j++)
{a1x=this.at(i,true);a1y=this.at(i,false);a2x=this.at(i+1,true);a2y=this.at(i+1,false);b1x=rhs.at(j,true);b1y=rhs.at(j,false);b2x=rhs.at(j+1,true);b2y=rhs.at(j+1,false);if(cr.segments_intersect(a1x,a1y,a2x,a2y,b1x,b1y,b2x,b2y))
return true;}}
return false;};cr.quad=Quad;cr.RGB=function(red,green,blue)
{return Math.max(Math.min(red,255),0)|(Math.max(Math.min(green,255),0)<<8)|(Math.max(Math.min(blue,255),0)<<16);};cr.GetRValue=function(rgb)
{return rgb&0xFF;};cr.GetGValue=function(rgb)
{return(rgb&0xFF00)>>8;};cr.GetBValue=function(rgb)
{return(rgb&0xFF0000)>>16;};cr.shallowCopy=function(a,b,allowOverwrite)
{var attr;for(attr in b)
{if(b.hasOwnProperty(attr))
{;a[attr]=b[attr];}}
return a;};cr.arrayRemove=function(arr,index)
{var i,len;index=cr.floor(index);if(index<0||index>=arr.length)
return;if(index===0)
arr.shift();else if(index===arr.length-1)
arr.pop();else
{for(i=index,len=arr.length-1;i<len;i++)
arr[i]=arr[i+1];arr.length=len;}};cr.shallowAssignArray=function(dest,src)
{dest.length=src.length;var i,len;for(i=0,len=src.length;i<len;i++)
dest[i]=src[i];};cr.arrayFindRemove=function(arr,item)
{var index=arr.indexOf(item);if(index!==-1)
cr.arrayRemove(arr,index);};cr.clamp=function(x,a,b)
{if(x<a)
return a;else if(x>b)
return b;else
return x;};cr.to_radians=function(x)
{return x/(180.0/cr.PI);};cr.to_degrees=function(x)
{return x*(180.0/cr.PI);};cr.clamp_angle_degrees=function(a)
{a%=360;if(a<0)
a+=360;return a;};cr.clamp_angle=function(a)
{a%=2*cr.PI;if(a<0)
a+=2*cr.PI;return a;};cr.to_clamped_degrees=function(x)
{return cr.clamp_angle_degrees(cr.to_degrees(x));};cr.to_clamped_radians=function(x)
{return cr.clamp_angle(cr.to_radians(x));};cr.angleTo=function(x1,y1,x2,y2)
{var dx=x2-x1;var dy=y2-y1;return Math.atan2(dy,dx);};cr.angleDiff=function(a1,a2)
{if(a1===a2)
return 0;var s1=Math.sin(a1);var c1=Math.cos(a1);var s2=Math.sin(a2);var c2=Math.cos(a2);var n=s1*s2+c1*c2;if(n>=1)
return 0;if(n<=-1)
return cr.PI;return Math.acos(n);};cr.angleRotate=function(start,end,step)
{var ss=Math.sin(start);var cs=Math.cos(start);var se=Math.sin(end);var ce=Math.cos(end);if(Math.acos(ss*se+cs*ce)>step)
{if(cs*se-ss*ce>0)
return cr.clamp_angle(start+step);else
return cr.clamp_angle(start-step);}
else
return cr.clamp_angle(end);};cr.angleClockwise=function(a1,a2)
{var s1=Math.sin(a1);var c1=Math.cos(a1);var s2=Math.sin(a2);var c2=Math.cos(a2);return c1*s2-s1*c2<=0;};cr.rotatePtAround=function(px,py,a,ox,oy,getx)
{if(a===0)
return getx?px:py;var sin_a=Math.sin(a);var cos_a=Math.cos(a);px-=ox;py-=oy;var left_sin_a=px*sin_a;var top_sin_a=py*sin_a;var left_cos_a=px*cos_a;var top_cos_a=py*cos_a;px=left_cos_a-top_sin_a;py=top_cos_a+left_sin_a;px+=ox;py+=oy;return getx?px:py;}
cr.distanceTo=function(x1,y1,x2,y2)
{var dx=x2-x1;var dy=y2-y1;return Math.sqrt(dx*dx+dy*dy);};cr.xor=function(x,y)
{return!x!==!y;};cr.lerp=function(a,b,x)
{return a+(b-a)*x;};cr.hasAnyOwnProperty=function(o)
{var p;for(p in o)
{if(o.hasOwnProperty(p))
return true;}
return false;};cr.wipe=function(obj)
{var p;for(p in obj)
{if(obj.hasOwnProperty(p))
delete obj[p];}};var startup_time=+(new Date());cr.performance_now=function()
{if(typeof window["performance"]!=="undefined")
{var winperf=window["performance"];if(typeof winperf.now!=="undefined")
return winperf.now();else if(typeof winperf["webkitNow"]!=="undefined")
return winperf["webkitNow"]();else if(typeof winperf["msNow"]!=="undefined")
return winperf["msNow"]();}
return Date.now()-startup_time;};var supports_set=(typeof Set!=="undefined"&&typeof Set.prototype["forEach"]!=="undefined");function ObjectSet_()
{if(supports_set)
{this.s=new Set();}
else
{this.items={};this.item_count=0;}
this.values_cache=[];this.cache_valid=true;cr.seal(this);};ObjectSet_.prototype.contains=function(x)
{if(supports_set)
return this.s["has"](x);else
return this.items.hasOwnProperty(x.toString());};ObjectSet_.prototype.add=function(x)
{if(supports_set)
{if(!this.s["has"](x))
{this.s["add"](x);this.cache_valid=false;}}
else
{var str=x.toString();if(!this.items.hasOwnProperty(str))
{this.items[str]=x;this.item_count++;this.cache_valid=false;}}
return this;};ObjectSet_.prototype.remove=function(x)
{if(supports_set)
{if(this.s["has"](x))
{this.s["delete"](x);this.cache_valid=false;}}
else
{var str=x.toString();if(this.items.hasOwnProperty(str))
{delete this.items[str];this.item_count--;this.cache_valid=false;}}
return this;};ObjectSet_.prototype.clear=function()
{if(supports_set)
{this.s["clear"]();}
else
{cr.wipe(this.items);this.item_count=0;}
this.values_cache.length=0;this.cache_valid=true;return this;};ObjectSet_.prototype.isEmpty=function()
{if(supports_set)
return this.s["size"]===0;else
return this.item_count===0;};ObjectSet_.prototype.count=function()
{if(supports_set)
return this.s["size"];else
return this.item_count;};var current_arr=null;var current_index=0;function set_append_to_arr(x)
{current_arr[current_index++]=x;};ObjectSet_.prototype.update_cache=function()
{if(this.cache_valid)
return;if(supports_set)
{this.values_cache.length=this.s["size"];current_arr=this.values_cache;current_index=0;this.s["forEach"](set_append_to_arr);;current_arr=null;current_index=0;}
else
{this.values_cache.length=this.item_count;var p,n=0;for(p in this.items)
{if(this.items.hasOwnProperty(p))
this.values_cache[n++]=this.items[p];};}
this.cache_valid=true;};ObjectSet_.prototype.values=function()
{this.update_cache();return this.values_cache.slice(0);};ObjectSet_.prototype.valuesRef=function()
{this.update_cache();return this.values_cache;};cr.ObjectSet=ObjectSet_;function KahanAdder_()
{this.c=0;this.y=0;this.t=0;this.sum=0;cr.seal(this);};KahanAdder_.prototype.add=function(v)
{this.y=v-this.c;this.t=this.sum+this.y;this.c=(this.t-this.sum)-this.y;this.sum=this.t;};KahanAdder_.prototype.reset=function()
{this.c=0;this.y=0;this.t=0;this.sum=0;};cr.KahanAdder=KahanAdder_;cr.regexp_escape=function(text)
{return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g,"\\$&");};function CollisionPoly_(pts_array_)
{this.pts_cache=[];this.set_pts(pts_array_);cr.seal(this);};CollisionPoly_.prototype.set_pts=function(pts_array_)
{this.pts_array=pts_array_;this.pts_count=pts_array_.length/2;this.pts_cache.length=pts_array_.length;this.cache_width=-1;this.cache_height=-1;this.cache_angle=0;};CollisionPoly_.prototype.is_empty=function()
{return!this.pts_array.length;};CollisionPoly_.prototype.set_from_quad=function(q,offx,offy,w,h)
{this.pts_cache.length=8;this.pts_count=4;var myptscache=this.pts_cache;myptscache[0]=q.tlx-offx;myptscache[1]=q.tly-offy;myptscache[2]=q.trx-offx;myptscache[3]=q.try_-offy;myptscache[4]=q.brx-offx;myptscache[5]=q.bry-offy;myptscache[6]=q.blx-offx;myptscache[7]=q.bly-offy;this.cache_width=w;this.cache_height=h;};CollisionPoly_.prototype.set_from_poly=function(r)
{this.pts_count=r.pts_count;cr.shallowAssignArray(this.pts_cache,r.pts_cache);};CollisionPoly_.prototype.cache_poly=function(w,h,a)
{if(this.cache_width===w&&this.cache_height===h&&this.cache_angle===a)
return;this.cache_width=w;this.cache_height=h;this.cache_angle=a;var i,len,x,y;var sina=0;var cosa=1;var myptsarray=this.pts_array;var myptscache=this.pts_cache;if(a!==0)
{sina=Math.sin(a);cosa=Math.cos(a);}
for(i=0,len=this.pts_count;i<len;i++)
{x=myptsarray[i*2]*w;y=myptsarray[i*2+1]*h;myptscache[i*2]=(x*cosa)-(y*sina);myptscache[i*2+1]=(y*cosa)+(x*sina);}};CollisionPoly_.prototype.contains_pt=function(a2x,a2y)
{var myptscache=this.pts_cache;if(a2x===myptscache[0]&&a2y===myptscache[1])
return true;var i,x,y,len=this.pts_count;var bboxLeft=myptscache[0];var bboxRight=bboxLeft;var bboxTop=myptscache[1];var bboxBottom=bboxTop;for(i=1;i<len;i++)
{x=myptscache[i*2];y=myptscache[i*2+1];if(x<bboxLeft)
bboxLeft=x;if(x>bboxRight)
bboxRight=x;if(y<bboxTop)
bboxTop=y;if(y>bboxBottom)
bboxBottom=y;}
var a1x=bboxLeft-110;var a1y=bboxTop-101;var a3x=bboxRight+131
var a3y=bboxBottom+120;var b1x,b1y,b2x,b2y;var count1=0,count2=0;for(i=0;i<len;i++)
{b1x=myptscache[i*2];b1y=myptscache[i*2+1];b2x=myptscache[((i+1)%len)*2];b2y=myptscache[((i+1)%len)*2+1];if(cr.segments_intersect(a1x,a1y,a2x,a2y,b1x,b1y,b2x,b2y))
count1++;if(cr.segments_intersect(a3x,a3y,a2x,a2y,b1x,b1y,b2x,b2y))
count2++;}
return(count1%2===1)||(count2%2===1);};CollisionPoly_.prototype.intersects_poly=function(rhs,offx,offy)
{var rhspts=rhs.pts_cache;var mypts=this.pts_cache;if(this.contains_pt(rhspts[0]+offx,rhspts[1]+offy))
return true;if(rhs.contains_pt(mypts[0]-offx,mypts[1]-offy))
return true;var i,leni,j,lenj;var a1x,a1y,a2x,a2y,b1x,b1y,b2x,b2y;for(i=0,leni=this.pts_count;i<leni;i++)
{a1x=mypts[i*2];a1y=mypts[i*2+1];a2x=mypts[((i+1)%leni)*2];a2y=mypts[((i+1)%leni)*2+1];for(j=0,lenj=rhs.pts_count;j<lenj;j++)
{b1x=rhspts[j*2]+offx;b1y=rhspts[j*2+1]+offy;b2x=rhspts[((j+1)%lenj)*2]+offx;b2y=rhspts[((j+1)%lenj)*2+1]+offy;if(cr.segments_intersect(a1x,a1y,a2x,a2y,b1x,b1y,b2x,b2y))
return true;}}
return false;};CollisionPoly_.prototype.intersects_segment=function(offx,offy,x1,y1,x2,y2)
{var mypts=this.pts_cache;if(this.contains_pt(x1-offx,y1-offy))
return true;var i,leni;var a1x,a1y,a2x,a2y;for(i=0,leni=this.pts_count;i<leni;i++)
{a1x=mypts[i*2]+offx;a1y=mypts[i*2+1]+offy;a2x=mypts[((i+1)%leni)*2]+offx;a2y=mypts[((i+1)%leni)*2+1]+offy;if(cr.segments_intersect(x1,y1,x2,y2,a1x,a1y,a2x,a2y))
return true;}
return false;};cr.CollisionPoly=CollisionPoly_;var fxNames=["lighter","xor","copy","destination-over","source-in","destination-in","source-out","destination-out","source-atop","destination-atop"];cr.effectToCompositeOp=function(effect)
{if(effect<=0||effect>=11)
return"source-over";return fxNames[effect-1];};cr.setGLBlend=function(this_,effect,gl)
{if(!gl)
return;this_.srcBlend=gl.ONE;this_.destBlend=gl.ONE_MINUS_SRC_ALPHA;switch(effect){case 1:this_.srcBlend=gl.ONE;this_.destBlend=gl.ONE;break;case 2:break;case 3:this_.srcBlend=gl.ONE;this_.destBlend=gl.ZERO;break;case 4:this_.srcBlend=gl.ONE_MINUS_DST_ALPHA;this_.destBlend=gl.ONE;break;case 5:this_.srcBlend=gl.DST_ALPHA;this_.destBlend=gl.ZERO;break;case 6:this_.srcBlend=gl.ZERO;this_.destBlend=gl.SRC_ALPHA;break;case 7:this_.srcBlend=gl.ONE_MINUS_DST_ALPHA;this_.destBlend=gl.ZERO;break;case 8:this_.srcBlend=gl.ZERO;this_.destBlend=gl.ONE_MINUS_SRC_ALPHA;break;case 9:this_.srcBlend=gl.DST_ALPHA;this_.destBlend=gl.ONE_MINUS_SRC_ALPHA;break;case 10:this_.srcBlend=gl.ONE_MINUS_DST_ALPHA;this_.destBlend=gl.SRC_ALPHA;break;}};cr.round6dp=function(x)
{return Math.round(x*1000000)/1000000;};cr.equals_nocase=function(a,b)
{if(typeof a!=="string"||typeof b!=="string")
return false;if(a.length!==b.length)
return false;if(a===b)
return true;return a.toLowerCase()===b.toLowerCase();};}());var MatrixArray=typeof Float32Array!=="undefined"?Float32Array:Array,glMatrixArrayType=MatrixArray,vec3={},mat3={},mat4={},quat4={};vec3.create=function(a){var b=new MatrixArray(3);a&&(b[0]=a[0],b[1]=a[1],b[2]=a[2]);return b};vec3.set=function(a,b){b[0]=a[0];b[1]=a[1];b[2]=a[2];return b};vec3.add=function(a,b,c){if(!c||a===c)return a[0]+=b[0],a[1]+=b[1],a[2]+=b[2],a;c[0]=a[0]+b[0];c[1]=a[1]+b[1];c[2]=a[2]+b[2];return c};vec3.subtract=function(a,b,c){if(!c||a===c)return a[0]-=b[0],a[1]-=b[1],a[2]-=b[2],a;c[0]=a[0]-b[0];c[1]=a[1]-b[1];c[2]=a[2]-b[2];return c};vec3.negate=function(a,b){b||(b=a);b[0]=-a[0];b[1]=-a[1];b[2]=-a[2];return b};vec3.scale=function(a,b,c){if(!c||a===c)return a[0]*=b,a[1]*=b,a[2]*=b,a;c[0]=a[0]*b;c[1]=a[1]*b;c[2]=a[2]*b;return c};vec3.normalize=function(a,b){b||(b=a);var c=a[0],d=a[1],e=a[2],g=Math.sqrt(c*c+d*d+e*e);if(g){if(g===1)return b[0]=c,b[1]=d,b[2]=e,b}else return b[0]=0,b[1]=0,b[2]=0,b;g=1/g;b[0]=c*g;b[1]=d*g;b[2]=e*g;return b};vec3.cross=function(a,b,c){c||(c=a);var d=a[0],e=a[1],a=a[2],g=b[0],f=b[1],b=b[2];c[0]=e*b-a*f;c[1]=a*g-d*b;c[2]=d*f-e*g;return c};vec3.length=function(a){var b=a[0],c=a[1],a=a[2];return Math.sqrt(b*b+c*c+a*a)};vec3.dot=function(a,b){return a[0]*b[0]+a[1]*b[1]+a[2]*b[2]};vec3.direction=function(a,b,c){c||(c=a);var d=a[0]-b[0],e=a[1]-b[1],a=a[2]-b[2],b=Math.sqrt(d*d+e*e+a*a);if(!b)return c[0]=0,c[1]=0,c[2]=0,c;b=1/b;c[0]=d*b;c[1]=e*b;c[2]=a*b;return c};vec3.lerp=function(a,b,c,d){d||(d=a);d[0]=a[0]+c*(b[0]-a[0]);d[1]=a[1]+c*(b[1]-a[1]);d[2]=a[2]+c*(b[2]-a[2]);return d};vec3.str=function(a){return"["+a[0]+", "+a[1]+", "+a[2]+"]"};mat3.create=function(a){var b=new MatrixArray(9);a&&(b[0]=a[0],b[1]=a[1],b[2]=a[2],b[3]=a[3],b[4]=a[4],b[5]=a[5],b[6]=a[6],b[7]=a[7],b[8]=a[8]);return b};mat3.set=function(a,b){b[0]=a[0];b[1]=a[1];b[2]=a[2];b[3]=a[3];b[4]=a[4];b[5]=a[5];b[6]=a[6];b[7]=a[7];b[8]=a[8];return b};mat3.identity=function(a){a[0]=1;a[1]=0;a[2]=0;a[3]=0;a[4]=1;a[5]=0;a[6]=0;a[7]=0;a[8]=1;return a};mat3.transpose=function(a,b){if(!b||a===b){var c=a[1],d=a[2],e=a[5];a[1]=a[3];a[2]=a[6];a[3]=c;a[5]=a[7];a[6]=d;a[7]=e;return a}b[0]=a[0];b[1]=a[3];b[2]=a[6];b[3]=a[1];b[4]=a[4];b[5]=a[7];b[6]=a[2];b[7]=a[5];b[8]=a[8];return b};mat3.toMat4=function(a,b){b||(b=mat4.create());b[15]=1;b[14]=0;b[13]=0;b[12]=0;b[11]=0;b[10]=a[8];b[9]=a[7];b[8]=a[6];b[7]=0;b[6]=a[5];b[5]=a[4];b[4]=a[3];b[3]=0;b[2]=a[2];b[1]=a[1];b[0]=a[0];return b};mat3.str=function(a){return"["+a[0]+", "+a[1]+", "+a[2]+", "+a[3]+", "+a[4]+", "+a[5]+", "+a[6]+", "+a[7]+", "+a[8]+"]"};mat4.create=function(a){var b=new MatrixArray(16);a&&(b[0]=a[0],b[1]=a[1],b[2]=a[2],b[3]=a[3],b[4]=a[4],b[5]=a[5],b[6]=a[6],b[7]=a[7],b[8]=a[8],b[9]=a[9],b[10]=a[10],b[11]=a[11],b[12]=a[12],b[13]=a[13],b[14]=a[14],b[15]=a[15]);return b};mat4.set=function(a,b){b[0]=a[0];b[1]=a[1];b[2]=a[2];b[3]=a[3];b[4]=a[4];b[5]=a[5];b[6]=a[6];b[7]=a[7];b[8]=a[8];b[9]=a[9];b[10]=a[10];b[11]=a[11];b[12]=a[12];b[13]=a[13];b[14]=a[14];b[15]=a[15];return b};mat4.identity=function(a){a[0]=1;a[1]=0;a[2]=0;a[3]=0;a[4]=0;a[5]=1;a[6]=0;a[7]=0;a[8]=0;a[9]=0;a[10]=1;a[11]=0;a[12]=0;a[13]=0;a[14]=0;a[15]=1;return a};mat4.transpose=function(a,b){if(!b||a===b){var c=a[1],d=a[2],e=a[3],g=a[6],f=a[7],h=a[11];a[1]=a[4];a[2]=a[8];a[3]=a[12];a[4]=c;a[6]=a[9];a[7]=a[13];a[8]=d;a[9]=g;a[11]=a[14];a[12]=e;a[13]=f;a[14]=h;return a}b[0]=a[0];b[1]=a[4];b[2]=a[8];b[3]=a[12];b[4]=a[1];b[5]=a[5];b[6]=a[9];b[7]=a[13];b[8]=a[2];b[9]=a[6];b[10]=a[10];b[11]=a[14];b[12]=a[3];b[13]=a[7];b[14]=a[11];b[15]=a[15];return b};mat4.determinant=function(a){var b=a[0],c=a[1],d=a[2],e=a[3],g=a[4],f=a[5],h=a[6],i=a[7],j=a[8],k=a[9],l=a[10],n=a[11],o=a[12],m=a[13],p=a[14],a=a[15];return o*k*h*e-j*m*h*e-o*f*l*e+g*m*l*e+j*f*p*e-g*k*p*e-o*k*d*i+j*m*d*i+o*c*l*i-b*m*l*i-j*c*p*i+b*k*p*i+o*f*d*n-g*m*d*n-o*c*h*n+b*m*h*n+g*c*p*n-b*f*p*n-j*f*d*a+g*k*d*a+j*c*h*a-b*k*h*a-g*c*l*a+b*f*l*a};mat4.inverse=function(a,b){b||(b=a);var c=a[0],d=a[1],e=a[2],g=a[3],f=a[4],h=a[5],i=a[6],j=a[7],k=a[8],l=a[9],n=a[10],o=a[11],m=a[12],p=a[13],r=a[14],s=a[15],A=c*h-d*f,B=c*i-e*f,t=c*j-g*f,u=d*i-e*h,v=d*j-g*h,w=e*j-g*i,x=k*p-l*m,y=k*r-n*m,z=k*s-o*m,C=l*r-n*p,D=l*s-o*p,E=n*s-o*r,q=1/(A*E-B*D+t*C+u*z-v*y+w*x);b[0]=(h*E-i*D+j*C)*q;b[1]=(-d*E+e*D-g*C)*q;b[2]=(p*w-r*v+s*u)*q;b[3]=(-l*w+n*v-o*u)*q;b[4]=(-f*E+i*z-j*y)*q;b[5]=(c*E-e*z+g*y)*q;b[6]=(-m*w+r*t-s*B)*q;b[7]=(k*w-n*t+o*B)*q;b[8]=(f*D-h*z+j*x)*q;b[9]=(-c*D+d*z-g*x)*q;b[10]=(m*v-p*t+s*A)*q;b[11]=(-k*v+l*t-o*A)*q;b[12]=(-f*C+h*y-i*x)*q;b[13]=(c*C-d*y+e*x)*q;b[14]=(-m*u+p*B-r*A)*q;b[15]=(k*u-l*B+n*A)*q;return b};mat4.toRotationMat=function(a,b){b||(b=mat4.create());b[0]=a[0];b[1]=a[1];b[2]=a[2];b[3]=a[3];b[4]=a[4];b[5]=a[5];b[6]=a[6];b[7]=a[7];b[8]=a[8];b[9]=a[9];b[10]=a[10];b[11]=a[11];b[12]=0;b[13]=0;b[14]=0;b[15]=1;return b};mat4.toMat3=function(a,b){b||(b=mat3.create());b[0]=a[0];b[1]=a[1];b[2]=a[2];b[3]=a[4];b[4]=a[5];b[5]=a[6];b[6]=a[8];b[7]=a[9];b[8]=a[10];return b};mat4.toInverseMat3=function(a,b){var c=a[0],d=a[1],e=a[2],g=a[4],f=a[5],h=a[6],i=a[8],j=a[9],k=a[10],l=k*f-h*j,n=-k*g+h*i,o=j*g-f*i,m=c*l+d*n+e*o;if(!m)return null;m=1/m;b||(b=mat3.create());b[0]=l*m;b[1]=(-k*d+e*j)*m;b[2]=(h*d-e*f)*m;b[3]=n*m;b[4]=(k*c-e*i)*m;b[5]=(-h*c+e*g)*m;b[6]=o*m;b[7]=(-j*c+d*i)*m;b[8]=(f*c-d*g)*m;return b};mat4.multiply=function(a,b,c){c||(c=a);var d=a[0],e=a[1],g=a[2],f=a[3],h=a[4],i=a[5],j=a[6],k=a[7],l=a[8],n=a[9],o=a[10],m=a[11],p=a[12],r=a[13],s=a[14],a=a[15],A=b[0],B=b[1],t=b[2],u=b[3],v=b[4],w=b[5],x=b[6],y=b[7],z=b[8],C=b[9],D=b[10],E=b[11],q=b[12],F=b[13],G=b[14],b=b[15];c[0]=A*d+B*h+t*l+u*p;c[1]=A*e+B*i+t*n+u*r;c[2]=A*g+B*j+t*o+u*s;c[3]=A*f+B*k+t*m+u*a;c[4]=v*d+w*h+x*l+y*p;c[5]=v*e+w*i+x*n+y*r;c[6]=v*g+w*j+x*o+y*s;c[7]=v*f+w*k+x*m+y*a;c[8]=z*d+C*h+D*l+E*p;c[9]=z*e+C*i+D*n+E*r;c[10]=z*g+C*j+D*o+E*s;c[11]=z*f+C*k+D*m+E*a;c[12]=q*d+F*h+G*l+b*p;c[13]=q*e+F*i+G*n+b*r;c[14]=q*g+F*j+G*o+b*s;c[15]=q*f+F*k+G*m+b*a;return c};mat4.multiplyVec3=function(a,b,c){c||(c=b);var d=b[0],e=b[1],b=b[2];c[0]=a[0]*d+a[4]*e+a[8]*b+a[12];c[1]=a[1]*d+a[5]*e+a[9]*b+a[13];c[2]=a[2]*d+a[6]*e+a[10]*b+a[14];return c};mat4.multiplyVec4=function(a,b,c){c||(c=b);var d=b[0],e=b[1],g=b[2],b=b[3];c[0]=a[0]*d+a[4]*e+a[8]*g+a[12]*b;c[1]=a[1]*d+a[5]*e+a[9]*g+a[13]*b;c[2]=a[2]*d+a[6]*e+a[10]*g+a[14]*b;c[3]=a[3]*d+a[7]*e+a[11]*g+a[15]*b;return c};mat4.translate=function(a,b,c){var d=b[0],e=b[1],b=b[2],g,f,h,i,j,k,l,n,o,m,p,r;if(!c||a===c)return a[12]=a[0]*d+a[4]*e+a[8]*b+a[12],a[13]=a[1]*d+a[5]*e+a[9]*b+a[13],a[14]=a[2]*d+a[6]*e+a[10]*b+a[14],a[15]=a[3]*d+a[7]*e+a[11]*b+a[15],a;g=a[0];f=a[1];h=a[2];i=a[3];j=a[4];k=a[5];l=a[6];n=a[7];o=a[8];m=a[9];p=a[10];r=a[11];c[0]=g;c[1]=f;c[2]=h;c[3]=i;c[4]=j;c[5]=k;c[6]=l;c[7]=n;c[8]=o;c[9]=m;c[10]=p;c[11]=r;c[12]=g*d+j*e+o*b+a[12];c[13]=f*d+k*e+m*b+a[13];c[14]=h*d+l*e+p*b+a[14];c[15]=i*d+n*e+r*b+a[15];return c};mat4.scale=function(a,b,c){var d=b[0],e=b[1],b=b[2];if(!c||a===c)return a[0]*=d,a[1]*=d,a[2]*=d,a[3]*=d,a[4]*=e,a[5]*=e,a[6]*=e,a[7]*=e,a[8]*=b,a[9]*=b,a[10]*=b,a[11]*=b,a;c[0]=a[0]*d;c[1]=a[1]*d;c[2]=a[2]*d;c[3]=a[3]*d;c[4]=a[4]*e;c[5]=a[5]*e;c[6]=a[6]*e;c[7]=a[7]*e;c[8]=a[8]*b;c[9]=a[9]*b;c[10]=a[10]*b;c[11]=a[11]*b;c[12]=a[12];c[13]=a[13];c[14]=a[14];c[15]=a[15];return c};mat4.rotate=function(a,b,c,d){var e=c[0],g=c[1],c=c[2],f=Math.sqrt(e*e+g*g+c*c),h,i,j,k,l,n,o,m,p,r,s,A,B,t,u,v,w,x,y,z;if(!f)return null;f!==1&&(f=1/f,e*=f,g*=f,c*=f);h=Math.sin(b);i=Math.cos(b);j=1-i;b=a[0];f=a[1];k=a[2];l=a[3];n=a[4];o=a[5];m=a[6];p=a[7];r=a[8];s=a[9];A=a[10];B=a[11];t=e*e*j+i;u=g*e*j+c*h;v=c*e*j-g*h;w=e*g*j-c*h;x=g*g*j+i;y=c*g*j+e*h;z=e*c*j+g*h;e=g*c*j-e*h;g=c*c*j+i;d?a!==d&&(d[12]=a[12],d[13]=a[13],d[14]=a[14],d[15]=a[15]):d=a;d[0]=b*t+n*u+r*v;d[1]=f*t+o*u+s*v;d[2]=k*t+m*u+A*v;d[3]=l*t+p*u+B*v;d[4]=b*w+n*x+r*y;d[5]=f*w+o*x+s*y;d[6]=k*w+m*x+A*y;d[7]=l*w+p*x+B*y;d[8]=b*z+n*e+r*g;d[9]=f*z+o*e+s*g;d[10]=k*z+m*e+A*g;d[11]=l*z+p*e+B*g;return d};mat4.rotateX=function(a,b,c){var d=Math.sin(b),b=Math.cos(b),e=a[4],g=a[5],f=a[6],h=a[7],i=a[8],j=a[9],k=a[10],l=a[11];c?a!==c&&(c[0]=a[0],c[1]=a[1],c[2]=a[2],c[3]=a[3],c[12]=a[12],c[13]=a[13],c[14]=a[14],c[15]=a[15]):c=a;c[4]=e*b+i*d;c[5]=g*b+j*d;c[6]=f*b+k*d;c[7]=h*b+l*d;c[8]=e*-d+i*b;c[9]=g*-d+j*b;c[10]=f*-d+k*b;c[11]=h*-d+l*b;return c};mat4.rotateY=function(a,b,c){var d=Math.sin(b),b=Math.cos(b),e=a[0],g=a[1],f=a[2],h=a[3],i=a[8],j=a[9],k=a[10],l=a[11];c?a!==c&&(c[4]=a[4],c[5]=a[5],c[6]=a[6],c[7]=a[7],c[12]=a[12],c[13]=a[13],c[14]=a[14],c[15]=a[15]):c=a;c[0]=e*b+i*-d;c[1]=g*b+j*-d;c[2]=f*b+k*-d;c[3]=h*b+l*-d;c[8]=e*d+i*b;c[9]=g*d+j*b;c[10]=f*d+k*b;c[11]=h*d+l*b;return c};mat4.rotateZ=function(a,b,c){var d=Math.sin(b),b=Math.cos(b),e=a[0],g=a[1],f=a[2],h=a[3],i=a[4],j=a[5],k=a[6],l=a[7];c?a!==c&&(c[8]=a[8],c[9]=a[9],c[10]=a[10],c[11]=a[11],c[12]=a[12],c[13]=a[13],c[14]=a[14],c[15]=a[15]):c=a;c[0]=e*b+i*d;c[1]=g*b+j*d;c[2]=f*b+k*d;c[3]=h*b+l*d;c[4]=e*-d+i*b;c[5]=g*-d+j*b;c[6]=f*-d+k*b;c[7]=h*-d+l*b;return c};mat4.frustum=function(a,b,c,d,e,g,f){f||(f=mat4.create());var h=b-a,i=d-c,j=g-e;f[0]=e*2/h;f[1]=0;f[2]=0;f[3]=0;f[4]=0;f[5]=e*2/i;f[6]=0;f[7]=0;f[8]=(b+a)/h;f[9]=(d+c)/i;f[10]=-(g+e)/j;f[11]=-1;f[12]=0;f[13]=0;f[14]=-(g*e*2)/j;f[15]=0;return f};mat4.perspective=function(a,b,c,d,e){a=c*Math.tan(a*Math.PI/360);b*=a;return mat4.frustum(-b,b,-a,a,c,d,e)};mat4.ortho=function(a,b,c,d,e,g,f){f||(f=mat4.create());var h=b-a,i=d-c,j=g-e;f[0]=2/h;f[1]=0;f[2]=0;f[3]=0;f[4]=0;f[5]=2/i;f[6]=0;f[7]=0;f[8]=0;f[9]=0;f[10]=-2/j;f[11]=0;f[12]=-(a+b)/h;f[13]=-(d+c)/i;f[14]=-(g+e)/j;f[15]=1;return f};mat4.lookAt=function(a,b,c,d){d||(d=mat4.create());var e,g,f,h,i,j,k,l,n=a[0],o=a[1],a=a[2];g=c[0];f=c[1];e=c[2];c=b[1];j=b[2];if(n===b[0]&&o===c&&a===j)return mat4.identity(d);c=n-b[0];j=o-b[1];k=a-b[2];l=1/Math.sqrt(c*c+j*j+k*k);c*=l;j*=l;k*=l;b=f*k-e*j;e=e*c-g*k;g=g*j-f*c;(l=Math.sqrt(b*b+e*e+g*g))?(l=1/l,b*=l,e*=l,g*=l):g=e=b=0;f=j*g-k*e;h=k*b-c*g;i=c*e-j*b;(l=Math.sqrt(f*f+h*h+i*i))?(l=1/l,f*=l,h*=l,i*=l):i=h=f=0;d[0]=b;d[1]=f;d[2]=c;d[3]=0;d[4]=e;d[5]=h;d[6]=j;d[7]=0;d[8]=g;d[9]=i;d[10]=k;d[11]=0;d[12]=-(b*n+e*o+g*a);d[13]=-(f*n+h*o+i*a);d[14]=-(c*n+j*o+k*a);d[15]=1;return d};mat4.fromRotationTranslation=function(a,b,c){c||(c=mat4.create());var d=a[0],e=a[1],g=a[2],f=a[3],h=d+d,i=e+e,j=g+g,a=d*h,k=d*i;d*=j;var l=e*i;e*=j;g*=j;h*=f;i*=f;f*=j;c[0]=1-(l+g);c[1]=k+f;c[2]=d-i;c[3]=0;c[4]=k-f;c[5]=1-(a+g);c[6]=e+h;c[7]=0;c[8]=d+i;c[9]=e-h;c[10]=1-(a+l);c[11]=0;c[12]=b[0];c[13]=b[1];c[14]=b[2];c[15]=1;return c};mat4.str=function(a){return"["+a[0]+", "+a[1]+", "+a[2]+", "+a[3]+", "+a[4]+", "+a[5]+", "+a[6]+", "+a[7]+", "+a[8]+", "+a[9]+", "+a[10]+", "+a[11]+", "+a[12]+", "+a[13]+", "+a[14]+", "+a[15]+"]"};quat4.create=function(a){var b=new MatrixArray(4);a&&(b[0]=a[0],b[1]=a[1],b[2]=a[2],b[3]=a[3]);return b};quat4.set=function(a,b){b[0]=a[0];b[1]=a[1];b[2]=a[2];b[3]=a[3];return b};quat4.calculateW=function(a,b){var c=a[0],d=a[1],e=a[2];if(!b||a===b)return a[3]=-Math.sqrt(Math.abs(1-c*c-d*d-e*e)),a;b[0]=c;b[1]=d;b[2]=e;b[3]=-Math.sqrt(Math.abs(1-c*c-d*d-e*e));return b};quat4.inverse=function(a,b){if(!b||a===b)return a[0]*=-1,a[1]*=-1,a[2]*=-1,a;b[0]=-a[0];b[1]=-a[1];b[2]=-a[2];b[3]=a[3];return b};quat4.length=function(a){var b=a[0],c=a[1],d=a[2],a=a[3];return Math.sqrt(b*b+c*c+d*d+a*a)};quat4.normalize=function(a,b){b||(b=a);var c=a[0],d=a[1],e=a[2],g=a[3],f=Math.sqrt(c*c+d*d+e*e+g*g);if(f===0)return b[0]=0,b[1]=0,b[2]=0,b[3]=0,b;f=1/f;b[0]=c*f;b[1]=d*f;b[2]=e*f;b[3]=g*f;return b};quat4.multiply=function(a,b,c){c||(c=a);var d=a[0],e=a[1],g=a[2],a=a[3],f=b[0],h=b[1],i=b[2],b=b[3];c[0]=d*b+a*f+e*i-g*h;c[1]=e*b+a*h+g*f-d*i;c[2]=g*b+a*i+d*h-e*f;c[3]=a*b-d*f-e*h-g*i;return c};quat4.multiplyVec3=function(a,b,c){c||(c=b);var d=b[0],e=b[1],g=b[2],b=a[0],f=a[1],h=a[2],a=a[3],i=a*d+f*g-h*e,j=a*e+h*d-b*g,k=a*g+b*e-f*d,d=-b*d-f*e-h*g;c[0]=i*a+d*-b+j*-h-k*-f;c[1]=j*a+d*-f+k*-b-i*-h;c[2]=k*a+d*-h+i*-f-j*-b;return c};quat4.toMat3=function(a,b){b||(b=mat3.create());var c=a[0],d=a[1],e=a[2],g=a[3],f=c+c,h=d+d,i=e+e,j=c*f,k=c*h;c*=i;var l=d*h;d*=i;e*=i;f*=g;h*=g;g*=i;b[0]=1-(l+e);b[1]=k+g;b[2]=c-h;b[3]=k-g;b[4]=1-(j+e);b[5]=d+f;b[6]=c+h;b[7]=d-f;b[8]=1-(j+l);return b};quat4.toMat4=function(a,b){b||(b=mat4.create());var c=a[0],d=a[1],e=a[2],g=a[3],f=c+c,h=d+d,i=e+e,j=c*f,k=c*h;c*=i;var l=d*h;d*=i;e*=i;f*=g;h*=g;g*=i;b[0]=1-(l+e);b[1]=k+g;b[2]=c-h;b[3]=0;b[4]=k-g;b[5]=1-(j+e);b[6]=d+f;b[7]=0;b[8]=c+h;b[9]=d-f;b[10]=1-(j+l);b[11]=0;b[12]=0;b[13]=0;b[14]=0;b[15]=1;return b};quat4.slerp=function(a,b,c,d){d||(d=a);var e=a[0]*b[0]+a[1]*b[1]+a[2]*b[2]+a[3]*b[3],g,f;if(Math.abs(e)>=1)return d!==a&&(d[0]=a[0],d[1]=a[1],d[2]=a[2],d[3]=a[3]),d;g=Math.acos(e);f=Math.sqrt(1-e*e);if(Math.abs(f)<0.001)return d[0]=a[0]*0.5+b[0]*0.5,d[1]=a[1]*0.5+b[1]*0.5,d[2]=a[2]*0.5+b[2]*0.5,d[3]=a[3]*0.5+b[3]*0.5,d;e=Math.sin((1-c)*g)/f;c=Math.sin(c*g)/f;d[0]=a[0]*e+b[0]*c;d[1]=a[1]*e+b[1]*c;d[2]=a[2]*e+b[2]*c;d[3]=a[3]*e+b[3]*c;return d};quat4.str=function(a){return"["+a[0]+", "+a[1]+", "+a[2]+", "+a[3]+"]"};(function()
{var MAX_VERTICES=8000;var MAX_INDICES=(MAX_VERTICES/2)*3;var MAX_POINTS=8000;var MULTI_BUFFERS=4;var BATCH_NULL=0;var BATCH_QUAD=1;var BATCH_SETTEXTURE=2;var BATCH_SETOPACITY=3;var BATCH_SETBLEND=4;var BATCH_UPDATEMODELVIEW=5;var BATCH_RENDERTOTEXTURE=6;var BATCH_CLEAR=7;var BATCH_POINTS=8;var BATCH_SETPROGRAM=9;var BATCH_SETPROGRAMPARAMETERS=10;function GLWrap_(gl,isMobile)
{this.width=0;this.height=0;this.cam=vec3.create([0,0,100]);this.look=vec3.create([0,0,0]);this.up=vec3.create([0,1,0]);this.worldScale=vec3.create([1,1,1]);this.matP=mat4.create();this.matMV=mat4.create();this.lastMV=mat4.create();this.currentMV=mat4.create();this.gl=gl;this.initState();};GLWrap_.prototype.initState=function()
{var gl=this.gl;var i,len;this.lastOpacity=1;this.lastTexture=null;this.currentOpacity=1;gl.clearColor(0,0,0,0);gl.clear(gl.COLOR_BUFFER_BIT);gl.enable(gl.BLEND);gl.blendFunc(gl.ONE,gl.ONE_MINUS_SRC_ALPHA);gl.disable(gl.CULL_FACE);gl.disable(gl.DEPTH_TEST);this.maxTextureSize=gl.getParameter(gl.MAX_TEXTURE_SIZE);this.lastSrcBlend=gl.ONE;this.lastDestBlend=gl.ONE_MINUS_SRC_ALPHA;this.pointBuffer=gl.createBuffer();gl.bindBuffer(gl.ARRAY_BUFFER,this.pointBuffer);this.vertexBuffers=new Array(MULTI_BUFFERS);this.texcoordBuffers=new Array(MULTI_BUFFERS);for(i=0;i<MULTI_BUFFERS;i++)
{this.vertexBuffers[i]=gl.createBuffer();gl.bindBuffer(gl.ARRAY_BUFFER,this.vertexBuffers[i]);this.texcoordBuffers[i]=gl.createBuffer();gl.bindBuffer(gl.ARRAY_BUFFER,this.texcoordBuffers[i]);}
this.curBuffer=0;this.indexBuffer=gl.createBuffer();gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER,this.indexBuffer);this.vertexData=new Float32Array(MAX_VERTICES*2);this.texcoordData=new Float32Array(MAX_VERTICES*2);this.pointData=new Float32Array(MAX_POINTS*4);var indexData=new Uint16Array(MAX_INDICES);i=0,len=MAX_INDICES;var fv=0;while(i<len)
{indexData[i++]=fv;indexData[i++]=fv+1;indexData[i++]=fv+2;indexData[i++]=fv;indexData[i++]=fv+2;indexData[i++]=fv+3;fv+=4;}
gl.bufferData(gl.ELEMENT_ARRAY_BUFFER,indexData,gl.STATIC_DRAW);this.vertexPtr=0;this.pointPtr=0;var fsSource,vsSource;this.shaderPrograms=[];fsSource=["varying mediump vec2 vTex;","uniform lowp float opacity;","uniform lowp sampler2D samplerFront;","void main(void) {","	gl_FragColor = texture2D(samplerFront, vTex);","	gl_FragColor *= opacity;","}"].join("\n");vsSource=["attribute highp vec2 aPos;","attribute mediump vec2 aTex;","varying mediump vec2 vTex;","uniform highp mat4 matP;","uniform highp mat4 matMV;","void main(void) {","	gl_Position = matP * matMV * vec4(aPos.x, aPos.y, 0.0, 1.0);","	vTex = aTex;","}"].join("\n");var shaderProg=this.createShaderProgram({src:fsSource},vsSource,"<default>");;this.shaderPrograms.push(shaderProg);fsSource=["uniform mediump sampler2D samplerFront;","varying lowp float opacity;","void main(void) {","	gl_FragColor = texture2D(samplerFront, gl_PointCoord);","	gl_FragColor *= opacity;","}"].join("\n");var pointVsSource=["attribute vec4 aPos;","varying float opacity;","uniform mat4 matP;","uniform mat4 matMV;","void main(void) {","	gl_Position = matP * matMV * vec4(aPos.x, aPos.y, 0.0, 1.0);","	gl_PointSize = aPos.z;","	opacity = aPos.w;","}"].join("\n");shaderProg=this.createShaderProgram({src:fsSource},pointVsSource,"<point>");;this.shaderPrograms.push(shaderProg);for(var shader_name in cr.shaders)
{if(cr.shaders.hasOwnProperty(shader_name))
this.shaderPrograms.push(this.createShaderProgram(cr.shaders[shader_name],vsSource,shader_name));}
gl.activeTexture(gl.TEXTURE0);gl.bindTexture(gl.TEXTURE_2D,null);this.batch=[];this.batchPtr=0;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;this.lastProgram=-1;this.currentProgram=-1;this.currentShader=null;this.fbo=gl.createFramebuffer();this.renderToTex=null;this.tmpVec3=vec3.create([0,0,0]);;;var pointsizes=gl.getParameter(gl.ALIASED_POINT_SIZE_RANGE);this.minPointSize=pointsizes[0];this.maxPointSize=pointsizes[1];;this.switchProgram(0);cr.seal(this);};function GLShaderProgram(gl,shaderProgram,name)
{this.gl=gl;this.shaderProgram=shaderProgram;this.name=name;this.locAPos=gl.getAttribLocation(shaderProgram,"aPos");this.locATex=gl.getAttribLocation(shaderProgram,"aTex");this.locMatP=gl.getUniformLocation(shaderProgram,"matP");this.locMatMV=gl.getUniformLocation(shaderProgram,"matMV");this.locOpacity=gl.getUniformLocation(shaderProgram,"opacity");this.locSamplerFront=gl.getUniformLocation(shaderProgram,"samplerFront");this.locSamplerBack=gl.getUniformLocation(shaderProgram,"samplerBack");this.locDestStart=gl.getUniformLocation(shaderProgram,"destStart");this.locDestEnd=gl.getUniformLocation(shaderProgram,"destEnd");this.locSeconds=gl.getUniformLocation(shaderProgram,"seconds");this.locPixelWidth=gl.getUniformLocation(shaderProgram,"pixelWidth");this.locPixelHeight=gl.getUniformLocation(shaderProgram,"pixelHeight");this.locLayerScale=gl.getUniformLocation(shaderProgram,"layerScale");if(this.locOpacity)
gl.uniform1f(this.locOpacity,1);if(this.locSamplerFront)
gl.uniform1i(this.locSamplerFront,0);if(this.locSamplerBack)
gl.uniform1i(this.locSamplerBack,1);if(this.locDestStart)
gl.uniform2f(this.locDestStart,0.0,0.0);if(this.locDestEnd)
gl.uniform2f(this.locDestEnd,1.0,1.0);this.hasCurrentMatMV=false;};GLWrap_.prototype.createShaderProgram=function(shaderEntry,vsSource,name)
{var gl=this.gl;var fragmentShader=gl.createShader(gl.FRAGMENT_SHADER);gl.shaderSource(fragmentShader,shaderEntry.src);gl.compileShader(fragmentShader);if(!gl.getShaderParameter(fragmentShader,gl.COMPILE_STATUS))
{;gl.deleteShader(fragmentShader);return null;}
var vertexShader=gl.createShader(gl.VERTEX_SHADER);gl.shaderSource(vertexShader,vsSource);gl.compileShader(vertexShader);if(!gl.getShaderParameter(vertexShader,gl.COMPILE_STATUS))
{;gl.deleteShader(fragmentShader);gl.deleteShader(vertexShader);return null;}
var shaderProgram=gl.createProgram();gl.attachShader(shaderProgram,fragmentShader);gl.attachShader(shaderProgram,vertexShader);gl.linkProgram(shaderProgram);if(!gl.getProgramParameter(shaderProgram,gl.LINK_STATUS))
{;gl.deleteShader(fragmentShader);gl.deleteShader(vertexShader);gl.deleteProgram(shaderProgram);return null;}
gl.useProgram(shaderProgram);;gl.deleteShader(fragmentShader);gl.deleteShader(vertexShader);var ret=new GLShaderProgram(gl,shaderProgram,name);ret.extendBoxHorizontal=shaderEntry.extendBoxHorizontal||0;ret.extendBoxVertical=shaderEntry.extendBoxVertical||0;ret.crossSampling=!!shaderEntry.crossSampling;ret.animated=!!shaderEntry.animated;ret.parameters=shaderEntry.parameters||[];var i,len;for(i=0,len=ret.parameters.length;i<len;i++)
{ret.parameters[i][1]=gl.getUniformLocation(shaderProgram,ret.parameters[i][0]);gl.uniform1f(ret.parameters[i][1],0);}
cr.seal(ret);return ret;};GLWrap_.prototype.getShaderIndex=function(name_)
{var i,len;for(i=0,len=this.shaderPrograms.length;i<len;i++)
{if(this.shaderPrograms[i].name===name_)
return i;}
return-1;};GLWrap_.prototype.project=function(x,y,out)
{var viewport=[0,0,this.width,this.height];var mv=this.matMV;var proj=this.matP;var fTempo=[0,0,0,0,0,0,0,0];fTempo[0]=mv[0]*x+mv[4]*y+mv[12];fTempo[1]=mv[1]*x+mv[5]*y+mv[13];fTempo[2]=mv[2]*x+mv[6]*y+mv[14];fTempo[3]=mv[3]*x+mv[7]*y+mv[15];fTempo[4]=proj[0]*fTempo[0]+proj[4]*fTempo[1]+proj[8]*fTempo[2]+proj[12]*fTempo[3];fTempo[5]=proj[1]*fTempo[0]+proj[5]*fTempo[1]+proj[9]*fTempo[2]+proj[13]*fTempo[3];fTempo[6]=proj[2]*fTempo[0]+proj[6]*fTempo[1]+proj[10]*fTempo[2]+proj[14]*fTempo[3];fTempo[7]=-fTempo[2];if(fTempo[7]===0.0)
return;fTempo[7]=1.0/fTempo[7];fTempo[4]*=fTempo[7];fTempo[5]*=fTempo[7];fTempo[6]*=fTempo[7];out[0]=(fTempo[4]*0.5+0.5)*viewport[2]+viewport[0];out[1]=(fTempo[5]*0.5+0.5)*viewport[3]+viewport[1];};GLWrap_.prototype.setSize=function(w,h,force)
{if(this.width===w&&this.height===h&&!force)
return;this.endBatch();this.width=w;this.height=h;this.gl.viewport(0,0,w,h);mat4.perspective(45,w/h,1,1000,this.matP);mat4.lookAt(this.cam,this.look,this.up,this.matMV);var tl=[0,0];var br=[0,0];this.project(0,0,tl);this.project(1,1,br);this.worldScale[0]=1/(br[0]-tl[0]);this.worldScale[1]=-1/(br[1]-tl[1]);var i,len,s;for(i=0,len=this.shaderPrograms.length;i<len;i++)
{s=this.shaderPrograms[i];s.hasCurrentMatMV=false;if(s.locMatP)
{this.gl.useProgram(s.shaderProgram);this.gl.uniformMatrix4fv(s.locMatP,false,this.matP);}}
this.gl.useProgram(this.shaderPrograms[this.lastProgram].shaderProgram);this.gl.bindTexture(this.gl.TEXTURE_2D,null);this.lastTexture=null;};GLWrap_.prototype.resetModelView=function()
{mat4.lookAt(this.cam,this.look,this.up,this.matMV);mat4.scale(this.matMV,this.worldScale);};GLWrap_.prototype.translate=function(x,y)
{if(x===0&&y===0)
return;this.tmpVec3[0]=x;this.tmpVec3[1]=y;this.tmpVec3[2]=0;mat4.translate(this.matMV,this.tmpVec3);};GLWrap_.prototype.scale=function(x,y)
{if(x===1&&y===1)
return;this.tmpVec3[0]=x;this.tmpVec3[1]=y;this.tmpVec3[2]=1;mat4.scale(this.matMV,this.tmpVec3);};GLWrap_.prototype.rotateZ=function(a)
{if(a===0)
return;mat4.rotateZ(this.matMV,a);};GLWrap_.prototype.updateModelView=function()
{var anydiff=false;for(var i=0;i<16;i++)
{if(this.lastMV[i]!==this.matMV[i])
{anydiff=true;break;}}
if(!anydiff)
return;var b=this.pushBatch();b.type=BATCH_UPDATEMODELVIEW;if(b.mat4param)
mat4.set(this.matMV,b.mat4param);else
b.mat4param=mat4.create(this.matMV);mat4.set(this.matMV,this.lastMV);this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};function GLBatchJob(type_,glwrap_)
{this.type=type_;this.glwrap=glwrap_;this.gl=glwrap_.gl;this.opacityParam=0;this.startIndex=0;this.indexCount=0;this.texParam=null;this.mat4param=null;this.shaderParams=[];cr.seal(this);};GLBatchJob.prototype.doSetTexture=function()
{this.gl.bindTexture(this.gl.TEXTURE_2D,this.texParam);};GLBatchJob.prototype.doSetOpacity=function()
{var o=this.opacityParam;var glwrap=this.glwrap;glwrap.currentOpacity=o;var curProg=glwrap.currentShader;if(curProg.locOpacity)
this.gl.uniform1f(curProg.locOpacity,o);};GLBatchJob.prototype.doQuad=function()
{this.gl.drawElements(this.gl.TRIANGLES,this.indexCount,this.gl.UNSIGNED_SHORT,this.startIndex*2);};GLBatchJob.prototype.doSetBlend=function()
{this.gl.blendFunc(this.startIndex,this.indexCount);};GLBatchJob.prototype.doUpdateModelView=function()
{var i,len,s,shaderPrograms=this.glwrap.shaderPrograms,currentProgram=this.glwrap.currentProgram;for(i=0,len=shaderPrograms.length;i<len;i++)
{s=shaderPrograms[i];if(i===currentProgram&&s.locMatMV)
{this.gl.uniformMatrix4fv(s.locMatMV,false,this.mat4param);s.hasCurrentMatMV=true;}
else
s.hasCurrentMatMV=false;}
mat4.set(this.mat4param,this.glwrap.currentMV);};GLBatchJob.prototype.doRenderToTexture=function()
{var gl=this.gl;var glwrap=this.glwrap;if(this.texParam)
{gl.bindFramebuffer(gl.FRAMEBUFFER,glwrap.fbo);gl.framebufferTexture2D(gl.FRAMEBUFFER,gl.COLOR_ATTACHMENT0,gl.TEXTURE_2D,this.texParam,0);;}
else
{gl.framebufferTexture2D(gl.FRAMEBUFFER,gl.COLOR_ATTACHMENT0,gl.TEXTURE_2D,null,0);gl.bindFramebuffer(gl.FRAMEBUFFER,null);}};GLBatchJob.prototype.doClear=function()
{var gl=this.gl;if(this.startIndex===0)
{gl.clearColor(this.mat4param[0],this.mat4param[1],this.mat4param[2],this.mat4param[3]);gl.clear(gl.COLOR_BUFFER_BIT);}
else
{gl.enable(gl.SCISSOR_TEST);gl.scissor(this.mat4param[0],this.mat4param[1],this.mat4param[2],this.mat4param[3]);gl.clearColor(0,0,0,0);gl.clear(this.gl.COLOR_BUFFER_BIT);gl.disable(gl.SCISSOR_TEST);}};GLBatchJob.prototype.doPoints=function()
{var gl=this.gl;var glwrap=this.glwrap;var s=glwrap.shaderPrograms[1];gl.useProgram(s.shaderProgram);if(!s.hasCurrentMatMV&&s.locMatMV)
{gl.uniformMatrix4fv(s.locMatMV,false,glwrap.currentMV);s.hasCurrentMatMV=true;}
gl.enableVertexAttribArray(s.locAPos);gl.bindBuffer(gl.ARRAY_BUFFER,glwrap.pointBuffer);gl.vertexAttribPointer(s.locAPos,4,gl.FLOAT,false,0,0);gl.drawArrays(gl.POINTS,this.startIndex/4,this.indexCount);s=glwrap.currentShader;gl.useProgram(s.shaderProgram);if(s.locAPos>=0)
{gl.enableVertexAttribArray(s.locAPos);gl.bindBuffer(gl.ARRAY_BUFFER,glwrap.vertexBuffers[glwrap.curBuffer]);gl.vertexAttribPointer(s.locAPos,2,gl.FLOAT,false,0,0);}
if(s.locATex>=0)
{gl.enableVertexAttribArray(s.locATex);gl.bindBuffer(gl.ARRAY_BUFFER,glwrap.texcoordBuffers[glwrap.curBuffer]);gl.vertexAttribPointer(s.locATex,2,gl.FLOAT,false,0,0);}};GLBatchJob.prototype.doSetProgram=function()
{var gl=this.gl;var glwrap=this.glwrap;var s=glwrap.shaderPrograms[this.startIndex];glwrap.currentProgram=this.startIndex;glwrap.currentShader=s;gl.useProgram(s.shaderProgram);if(!s.hasCurrentMatMV&&s.locMatMV)
{gl.uniformMatrix4fv(s.locMatMV,false,glwrap.currentMV);s.hasCurrentMatMV=true;}
if(s.locOpacity)
gl.uniform1f(s.locOpacity,glwrap.currentOpacity);if(s.locAPos>=0)
{gl.enableVertexAttribArray(s.locAPos);gl.bindBuffer(gl.ARRAY_BUFFER,glwrap.vertexBuffers[glwrap.curBuffer]);gl.vertexAttribPointer(s.locAPos,2,gl.FLOAT,false,0,0);}
if(s.locATex>=0)
{gl.enableVertexAttribArray(s.locATex);gl.bindBuffer(gl.ARRAY_BUFFER,glwrap.texcoordBuffers[glwrap.curBuffer]);gl.vertexAttribPointer(s.locATex,2,gl.FLOAT,false,0,0);}}
GLBatchJob.prototype.doSetProgramParameters=function()
{var i,len,s=this.glwrap.currentShader;var gl=this.gl;if(s.locSamplerBack)
{gl.activeTexture(gl.TEXTURE1);gl.bindTexture(gl.TEXTURE_2D,this.texParam);gl.activeTexture(gl.TEXTURE0);}
if(s.locPixelWidth)
gl.uniform1f(s.locPixelWidth,this.mat4param[0]);if(s.locPixelHeight)
gl.uniform1f(s.locPixelHeight,this.mat4param[1]);if(s.locDestStart)
gl.uniform2f(s.locDestStart,this.mat4param[2],this.mat4param[3]);if(s.locDestEnd)
gl.uniform2f(s.locDestEnd,this.mat4param[4],this.mat4param[5]);if(s.locLayerScale)
gl.uniform1f(s.locLayerScale,this.mat4param[6]);if(s.locSeconds)
gl.uniform1f(s.locSeconds,cr.performance_now()/1000.0);if(s.parameters.length)
{for(i=0,len=s.parameters.length;i<len;i++)
{gl.uniform1f(s.parameters[i][1],this.shaderParams[i]);}}};GLWrap_.prototype.pushBatch=function()
{if(this.batchPtr===this.batch.length)
this.batch.push(new GLBatchJob(BATCH_NULL,this));return this.batch[this.batchPtr++];};GLWrap_.prototype.endBatch=function()
{if(this.batchPtr===0)
return;if(this.gl.isContextLost())
return;var gl=this.gl;if(this.pointPtr>0)
{gl.bindBuffer(gl.ARRAY_BUFFER,this.pointBuffer);gl.bufferData(gl.ARRAY_BUFFER,this.pointData.subarray(0,this.pointPtr),gl.STREAM_DRAW);if(s&&s.locAPos>=0&&s.name==="<point>")
gl.vertexAttribPointer(s.locAPos,4,gl.FLOAT,false,0,0);}
if(this.vertexPtr>0)
{var s=this.currentShader;gl.bindBuffer(gl.ARRAY_BUFFER,this.vertexBuffers[this.curBuffer]);gl.bufferData(gl.ARRAY_BUFFER,this.vertexData.subarray(0,this.vertexPtr),gl.STREAM_DRAW);if(s&&s.locAPos>=0&&s.name!=="<point>")
gl.vertexAttribPointer(s.locAPos,2,gl.FLOAT,false,0,0);gl.bindBuffer(gl.ARRAY_BUFFER,this.texcoordBuffers[this.curBuffer]);gl.bufferData(gl.ARRAY_BUFFER,this.texcoordData.subarray(0,this.vertexPtr),gl.STREAM_DRAW);if(s&&s.locATex>=0&&s.name!=="<point>")
gl.vertexAttribPointer(s.locATex,2,gl.FLOAT,false,0,0);}
var i,len,b;for(i=0,len=this.batchPtr;i<len;i++)
{b=this.batch[i];switch(b.type){case BATCH_QUAD:b.doQuad();break;case BATCH_SETTEXTURE:b.doSetTexture();break;case BATCH_SETOPACITY:b.doSetOpacity();break;case BATCH_SETBLEND:b.doSetBlend();break;case BATCH_UPDATEMODELVIEW:b.doUpdateModelView();break;case BATCH_RENDERTOTEXTURE:b.doRenderToTexture();break;case BATCH_CLEAR:b.doClear();break;case BATCH_POINTS:b.doPoints();break;case BATCH_SETPROGRAM:b.doSetProgram();break;case BATCH_SETPROGRAMPARAMETERS:b.doSetProgramParameters();break;}}
this.batchPtr=0;this.vertexPtr=0;this.pointPtr=0;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;this.curBuffer++;if(this.curBuffer>=MULTI_BUFFERS)
this.curBuffer=0;};GLWrap_.prototype.setOpacity=function(op)
{if(op===this.lastOpacity)
return;var b=this.pushBatch();b.type=BATCH_SETOPACITY;b.opacityParam=op;this.lastOpacity=op;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};GLWrap_.prototype.setTexture=function(tex)
{if(tex===this.lastTexture)
return;var b=this.pushBatch();b.type=BATCH_SETTEXTURE;b.texParam=tex;this.lastTexture=tex;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};GLWrap_.prototype.setBlend=function(s,d)
{if(s===this.lastSrcBlend&&d===this.lastDestBlend)
return;var b=this.pushBatch();b.type=BATCH_SETBLEND;b.startIndex=s;b.indexCount=d;this.lastSrcBlend=s;this.lastDestBlend=d;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};GLWrap_.prototype.setAlphaBlend=function()
{this.setBlend(this.gl.ONE,this.gl.ONE_MINUS_SRC_ALPHA);};var LAST_VERTEX=MAX_VERTICES*2-8;GLWrap_.prototype.quad=function(tlx,tly,trx,try_,brx,bry,blx,bly)
{if(this.vertexPtr>=LAST_VERTEX)
this.endBatch();var v=this.vertexPtr;var vd=this.vertexData;var td=this.texcoordData;if(this.hasQuadBatchTop)
{this.batch[this.batchPtr-1].indexCount+=6;}
else
{var b=this.pushBatch();b.type=BATCH_QUAD;b.startIndex=(v/4)*3;b.indexCount=6;this.hasQuadBatchTop=true;this.hasPointBatchTop=false;}
vd[v]=tlx;td[v++]=0;vd[v]=tly;td[v++]=0;vd[v]=trx;td[v++]=1;vd[v]=try_;td[v++]=0;vd[v]=brx;td[v++]=1;vd[v]=bry;td[v++]=1;vd[v]=blx;td[v++]=0;vd[v]=bly;td[v++]=1;this.vertexPtr=v;};GLWrap_.prototype.quadTex=function(tlx,tly,trx,try_,brx,bry,blx,bly,rcTex)
{if(this.vertexPtr>=LAST_VERTEX)
this.endBatch();var v=this.vertexPtr;var vd=this.vertexData;var td=this.texcoordData;if(this.hasQuadBatchTop)
{this.batch[this.batchPtr-1].indexCount+=6;}
else
{var b=this.pushBatch();b.type=BATCH_QUAD;b.startIndex=(v/4)*3;b.indexCount=6;this.hasQuadBatchTop=true;this.hasPointBatchTop=false;}
vd[v]=tlx;td[v++]=rcTex.left;vd[v]=tly;td[v++]=rcTex.top;vd[v]=trx;td[v++]=rcTex.right;vd[v]=try_;td[v++]=rcTex.top;vd[v]=brx;td[v++]=rcTex.right;vd[v]=bry;td[v++]=rcTex.bottom;vd[v]=blx;td[v++]=rcTex.left;vd[v]=bly;td[v++]=rcTex.bottom;this.vertexPtr=v;};var LAST_POINT=MAX_POINTS-4;GLWrap_.prototype.point=function(x_,y_,size_,opacity_)
{if(this.pointPtr>=LAST_POINT)
this.endBatch();var p=this.pointPtr;var pd=this.pointData;if(this.hasPointBatchTop)
{this.batch[this.batchPtr-1].indexCount++;}
else
{var b=this.pushBatch();b.type=BATCH_POINTS;b.startIndex=p;b.indexCount=1;this.hasPointBatchTop=true;this.hasQuadBatchTop=false;}
pd[p++]=x_;pd[p++]=y_;pd[p++]=size_;pd[p++]=opacity_;this.pointPtr=p;};GLWrap_.prototype.switchProgram=function(progIndex)
{if(this.lastProgram===progIndex)
return;var shaderProg=this.shaderPrograms[progIndex];if(!shaderProg)
{if(this.lastProgram===0)
return;progIndex=0;shaderProg=this.shaderPrograms[0];}
var b=this.pushBatch();b.type=BATCH_SETPROGRAM;b.startIndex=progIndex;this.lastProgram=progIndex;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};GLWrap_.prototype.programUsesDest=function(progIndex)
{var s=this.shaderPrograms[progIndex];return!!(s.locDestStart||s.locDestEnd);};GLWrap_.prototype.programUsesCrossSampling=function(progIndex)
{return this.shaderPrograms[progIndex].crossSampling;};GLWrap_.prototype.programExtendsBox=function(progIndex)
{var s=this.shaderPrograms[progIndex];return s.extendBoxHorizontal!==0||s.extendBoxVertical!==0;};GLWrap_.prototype.getProgramBoxExtendHorizontal=function(progIndex)
{return this.shaderPrograms[progIndex].extendBoxHorizontal;};GLWrap_.prototype.getProgramBoxExtendVertical=function(progIndex)
{return this.shaderPrograms[progIndex].extendBoxVertical;};GLWrap_.prototype.getProgramParameterType=function(progIndex,paramIndex)
{return this.shaderPrograms[progIndex].parameters[paramIndex][2];};GLWrap_.prototype.programIsAnimated=function(progIndex)
{return this.shaderPrograms[progIndex].animated;};GLWrap_.prototype.setProgramParameters=function(backTex,pixelWidth,pixelHeight,destStartX,destStartY,destEndX,destEndY,layerScale,params)
{var i,len,s=this.shaderPrograms[this.lastProgram];if(s.locPixelWidth||s.locPixelHeight||s.locSeconds||s.locSamplerBack||s.locDestStart||s.locDestEnd||s.locLayerScale||params.length)
{var b=this.pushBatch();b.type=BATCH_SETPROGRAMPARAMETERS;if(b.mat4param)
mat4.set(this.matMV,b.mat4param);else
b.mat4param=mat4.create();b.mat4param[0]=pixelWidth;b.mat4param[1]=pixelHeight;b.mat4param[2]=destStartX;b.mat4param[3]=destStartY;b.mat4param[4]=destEndX;b.mat4param[5]=destEndY;b.mat4param[6]=layerScale;b.texParam=backTex;if(params.length)
{b.shaderParams.length=params.length;for(i=0,len=params.length;i<len;i++)
b.shaderParams[i]=params[i];}
this.hasQuadBatchTop=false;this.hasPointBatchTop=false;}};GLWrap_.prototype.clear=function(r,g,b_,a)
{var b=this.pushBatch();b.type=BATCH_CLEAR;b.startIndex=0;if(!b.mat4param)
b.mat4param=mat4.create();b.mat4param[0]=r;b.mat4param[1]=g;b.mat4param[2]=b_;b.mat4param[3]=a;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};GLWrap_.prototype.clearRect=function(x,y,w,h)
{var b=this.pushBatch();b.type=BATCH_CLEAR;b.startIndex=1;if(!b.mat4param)
b.mat4param=mat4.create();b.mat4param[0]=x;b.mat4param[1]=y;b.mat4param[2]=w;b.mat4param[3]=h;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};GLWrap_.prototype.present=function()
{this.endBatch();this.gl.flush();};function nextHighestPowerOfTwo(x){--x;for(var i=1;i<32;i<<=1){x=x|x>>i;}
return x+1;}
var all_textures=[];var textures_by_src={};var BF_RGBA8=0;var BF_RGB8=1;var BF_RGBA4=2;var BF_RGB5_A1=3;var BF_RGB565=4;GLWrap_.prototype.loadTexture=function(img,tiling,linearsampling,pixelformat,tiletype)
{tiling=!!tiling;linearsampling=!!linearsampling;var tex_key=img.src+","+tiling+","+linearsampling+(tiling?(","+tiletype):"");var webGL_texture=null;if(typeof img.src!=="undefined"&&textures_by_src.hasOwnProperty(tex_key))
{webGL_texture=textures_by_src[tex_key];webGL_texture.c2refcount++;return webGL_texture;}
this.endBatch();;var gl=this.gl;var isPOT=(cr.isPOT(img.width)&&cr.isPOT(img.height));webGL_texture=gl.createTexture();gl.bindTexture(gl.TEXTURE_2D,webGL_texture);gl.pixelStorei(gl["UNPACK_PREMULTIPLY_ALPHA_WEBGL"],true);var internalformat=gl.RGBA;var format=gl.RGBA;var type=gl.UNSIGNED_BYTE;if(pixelformat)
{switch(pixelformat){case BF_RGB8:internalformat=gl.RGB;format=gl.RGB;break;case BF_RGBA4:type=gl.UNSIGNED_SHORT_4_4_4_4;break;case BF_RGB5_A1:type=gl.UNSIGNED_SHORT_5_5_5_1;break;case BF_RGB565:internalformat=gl.RGB;format=gl.RGB;type=gl.UNSIGNED_SHORT_5_6_5;break;}}
if(!isPOT&&tiling)
{var canvas=document.createElement("canvas");canvas.width=nextHighestPowerOfTwo(img.width);canvas.height=nextHighestPowerOfTwo(img.height);var ctx=canvas.getContext("2d");ctx.drawImage(img,0,0,img.width,img.height,0,0,canvas.width,canvas.height);gl.texImage2D(gl.TEXTURE_2D,0,internalformat,format,type,canvas);}
else
gl.texImage2D(gl.TEXTURE_2D,0,internalformat,format,type,img);if(tiling)
{if(tiletype==="repeat-x")
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_S,gl.REPEAT);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_T,gl.CLAMP_TO_EDGE);}
else if(tiletype==="repeat-y")
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_S,gl.CLAMP_TO_EDGE);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_T,gl.REPEAT);}
else
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_S,gl.REPEAT);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_T,gl.REPEAT);}}
else
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_S,gl.CLAMP_TO_EDGE);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_T,gl.CLAMP_TO_EDGE);}
if(linearsampling)
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MAG_FILTER,gl.LINEAR);if(isPOT)
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MIN_FILTER,gl.LINEAR_MIPMAP_LINEAR);gl.generateMipmap(gl.TEXTURE_2D);}
else
gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MIN_FILTER,gl.LINEAR);}
else
{gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MAG_FILTER,gl.NEAREST);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MIN_FILTER,gl.NEAREST);}
gl.bindTexture(gl.TEXTURE_2D,null);this.lastTexture=null;webGL_texture.c2width=img.width;webGL_texture.c2height=img.height;webGL_texture.c2refcount=1;webGL_texture.c2texkey=tex_key;all_textures.push(webGL_texture);textures_by_src[tex_key]=webGL_texture;return webGL_texture;};GLWrap_.prototype.createEmptyTexture=function(w,h,linearsampling,_16bit)
{this.endBatch();var gl=this.gl;var webGL_texture=gl.createTexture();gl.bindTexture(gl.TEXTURE_2D,webGL_texture);gl.texImage2D(gl.TEXTURE_2D,0,gl.RGBA,w,h,0,gl.RGBA,_16bit?gl.UNSIGNED_SHORT_4_4_4_4:gl.UNSIGNED_BYTE,null);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_S,gl.CLAMP_TO_EDGE);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_WRAP_T,gl.CLAMP_TO_EDGE);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MAG_FILTER,linearsampling?gl.LINEAR:gl.NEAREST);gl.texParameteri(gl.TEXTURE_2D,gl.TEXTURE_MIN_FILTER,linearsampling?gl.LINEAR:gl.NEAREST);gl.bindTexture(gl.TEXTURE_2D,null);this.lastTexture=null;webGL_texture.c2width=w;webGL_texture.c2height=h;all_textures.push(webGL_texture);return webGL_texture;};GLWrap_.prototype.videoToTexture=function(video_,texture_,_16bit)
{this.endBatch();var gl=this.gl;gl.bindTexture(gl.TEXTURE_2D,texture_);gl.texImage2D(gl.TEXTURE_2D,0,gl.RGBA,gl.RGBA,_16bit?gl.UNSIGNED_SHORT_4_4_4_4:gl.UNSIGNED_BYTE,video_);gl.bindTexture(gl.TEXTURE_2D,null);this.lastTexture=null;};GLWrap_.prototype.deleteTexture=function(tex)
{if(!tex)
return;if(typeof tex.c2refcount!=="undefined"&&tex.c2refcount>1)
{tex.c2refcount--;return;}
this.endBatch();this.gl.bindTexture(this.gl.TEXTURE_2D,null);this.lastTexture=null;cr.arrayFindRemove(all_textures,tex);if(typeof tex.c2texkey!=="undefined")
delete textures_by_src[tex.c2texkey];this.gl.deleteTexture(tex);};GLWrap_.prototype.estimateVRAM=function()
{var total=this.width*this.height*4*2;var i,len,t;for(i=0,len=all_textures.length;i<len;i++)
{t=all_textures[i];total+=(t.c2width*t.c2height*4);}
return total;};GLWrap_.prototype.textureCount=function()
{return all_textures.length;};GLWrap_.prototype.setRenderingToTexture=function(tex)
{if(tex===this.renderToTex)
return;var b=this.pushBatch();b.type=BATCH_RENDERTOTEXTURE;b.texParam=tex;this.renderToTex=tex;this.hasQuadBatchTop=false;this.hasPointBatchTop=false;};cr.GLWrap=GLWrap_;}());;(function()
{function Runtime(canvas)
{if(!canvas||(!canvas.getContext&&!canvas["dc"]))
return;if(canvas["c2runtime"])
return;else
canvas["c2runtime"]=this;var self=this;this.isPhoneGap=(typeof window["device"]!=="undefined"&&(typeof window["device"]["cordova"]!=="undefined"||typeof window["device"]["phonegap"]!=="undefined"));this.isDirectCanvas=!!canvas["dc"];this.isAppMobi=(typeof window["AppMobi"]!=="undefined"||this.isDirectCanvas);this.isCocoonJs=!!window["c2cocoonjs"];if(this.isCocoonJs)
{CocoonJS["App"]["onSuspended"].addEventListener(function(){self["setSuspended"](true);});CocoonJS["App"]["onActivated"].addEventListener(function(){self["setSuspended"](false);});}
this.isDomFree=this.isDirectCanvas||this.isCocoonJs;this.isTizen=/tizen/i.test(navigator.userAgent);this.isAndroid=/android/i.test(navigator.userAgent)&&!this.isTizen;this.isIE=/msie/i.test(navigator.userAgent)||/trident/i.test(navigator.userAgent);this.isiPhone=/iphone/i.test(navigator.userAgent)||/ipod/i.test(navigator.userAgent);this.isiPad=/ipad/i.test(navigator.userAgent);this.isiOS=this.isiPhone||this.isiPad;this.isChrome=/chrome/i.test(navigator.userAgent)||/chromium/i.test(navigator.userAgent);this.isSafari=!this.isChrome&&/safari/i.test(navigator.userAgent);this.isWindows=/windows/i.test(navigator.userAgent);this.isNodeWebkit=(typeof window["c2nodewebkit"]!=="undefined");this.isArcade=(typeof window["is_scirra_arcade"]!=="undefined");this.isWindows8App=!!(typeof window["c2isWindows8"]!=="undefined"&&window["c2isWindows8"]);this.isWindowsPhone8=!!(typeof window["c2isWindowsPhone8"]!=="undefined"&&window["c2isWindowsPhone8"]);this.isBlackberry10=!!(typeof window["c2isBlackberry10"]!=="undefined"&&window["c2isBlackberry10"]);this.devicePixelRatio=1;this.isMobile=(this.isPhoneGap||this.isAppMobi||this.isCocoonJs||this.isAndroid||this.isiOS||this.isWindowsPhone8||this.isBlackberry10||this.isTizen);if(!this.isMobile)
this.isMobile=/(blackberry|bb10|playbook|palm|symbian|nokia|windows\s+ce|phone|mobile|tablet)/i.test(navigator.userAgent);if(typeof cr_is_preview!=="undefined"&&!this.isNodeWebkit&&(window.location.search==="?nw"||/nodewebkit/i.test(navigator.userAgent)))
{this.isNodeWebkit=true;}
this.isDebug=(typeof cr_is_preview!=="undefined"&&window.location.search.indexOf("debug")>-1)
this.canvas=canvas;this.canvasdiv=document.getElementById("c2canvasdiv");this.gl=null;this.glwrap=null;this.ctx=null;this.canvas.oncontextmenu=function(e){if(e.preventDefault)e.preventDefault();return false;};this.canvas.onselectstart=function(e){if(e.preventDefault)e.preventDefault();return false;};if(this.isDirectCanvas)
window["c2runtime"]=this;if(this.isNodeWebkit)
{window.ondragover=function(e){e.preventDefault();return false;};window.ondrop=function(e){e.preventDefault();return false;};}
this.width=canvas.width;this.height=canvas.height;this.lastwidth=this.width;this.lastheight=this.height;this.redraw=true;this.isSuspended=false;if(!Date.now){Date.now=function now(){return+new Date();};}
this.plugins=[];this.types={};this.types_by_index=[];this.behaviors=[];this.layouts={};this.layouts_by_index=[];this.eventsheets={};this.eventsheets_by_index=[];this.wait_for_textures=[];this.triggers_to_postinit=[];this.all_global_vars=[];this.all_local_vars=[];this.deathRow=new cr.ObjectSet();this.isInClearDeathRow=false;this.isInOnDestroy=0;this.isRunningEvents=false;this.createRow=[];this.isLoadingState=false;this.saveToSlot="";this.loadFromSlot="";this.loadFromJson="";this.lastSaveJson="";this.signalledContinuousPreview=false;this.suspendDrawing=false;this.dt=0;this.dt1=0;this.logictime=0;this.cpuutilisation=0;this.zeroDtCount=0;this.timescale=1.0;this.kahanTime=new cr.KahanAdder();this.last_tick_time=0;this.measuring_dt=true;this.fps=0;this.last_fps_time=0;this.tickcount=0;this.execcount=0;this.framecount=0;this.objectcount=0;this.changelayout=null;this.destroycallbacks=[];this.event_stack=[];this.event_stack_index=-1;this.localvar_stack=[[]];this.localvar_stack_index=0;this.trigger_depth=0;this.pushEventStack(null);this.loop_stack=[];this.loop_stack_index=-1;this.next_uid=0;this.next_puid=0;this.layout_first_tick=true;this.family_count=0;this.suspend_events=[];this.raf_id=0;this.timeout_id=0;this.isloading=true;this.loadingprogress=0;this.isNodeFullscreen=false;this.stackLocalCount=0;this.had_a_click=false;this.objects_to_tick=new cr.ObjectSet();this.objects_to_tick2=new cr.ObjectSet();this.registered_collisions=[];this.temp_poly=new cr.CollisionPoly([]);this.temp_poly2=new cr.CollisionPoly([]);this.allGroups=[];this.activeGroups={};this.cndsBySid={};this.actsBySid={};this.varsBySid={};this.blocksBySid={};this.running_layout=null;this.layer_canvas=null;this.layer_ctx=null;this.layer_tex=null;this.layout_tex=null;this.is_WebGL_context_lost=false;this.uses_background_blending=false;this.fx_tex=[null,null];this.fullscreen_scaling=0;this.files_subfolder="";this.objectsByUid={};this.loaderlogo=null;this.snapshotCanvas=null;this.snapshotData="";this.load();this.isRetina=(!this.isDomFree&&this.useiOSRetina&&(this.isiOS||this.isTizen));this.devicePixelRatio=(this.isRetina?(window["devicePixelRatio"]||1):1);this.ClearDeathRow();var attribs;if(typeof jQuery!=="undefined"&&this.fullscreen_mode>0)
this["setSize"](jQuery(window).width(),jQuery(window).height());try{if(this.enableWebGL&&(this.isCocoonJs||!this.isDomFree))
{attribs={"depth":false,"antialias":!this.isMobile};var use_webgl=true;if(this.isChrome&&this.isWindows)
{var tempcanvas=document.createElement("canvas");var tempgl=(tempcanvas.getContext("webgl",attribs)||tempcanvas.getContext("experimental-webgl",attribs));if(tempgl.getSupportedExtensions().toString()==="OES_texture_float,OES_standard_derivatives,WEBKIT_WEBGL_lose_context")
{;use_webgl=false;}}
if(use_webgl)
this.gl=(canvas.getContext("webgl",attribs)||canvas.getContext("experimental-webgl",attribs));}}
catch(e){}
if(this.gl)
{;if(!this.isDomFree)
{this.overlay_canvas=document.createElement("canvas");jQuery(this.overlay_canvas).appendTo(this.canvas.parentNode);this.overlay_canvas.oncontextmenu=function(e){return false;};this.overlay_canvas.onselectstart=function(e){return false;};this.overlay_canvas.width=canvas.width;this.overlay_canvas.height=canvas.height;this.positionOverlayCanvas();this.overlay_ctx=this.overlay_canvas.getContext("2d");}
this.glwrap=new cr.GLWrap(this.gl,this.isMobile);this.glwrap.setSize(canvas.width,canvas.height);this.ctx=null;this.canvas.addEventListener("webglcontextlost",function(ev){ev.preventDefault();self.onContextLost();window["cr_setSuspended"](true);},false);this.canvas.addEventListener("webglcontextrestored",function(ev){self.glwrap.initState();self.glwrap.setSize(self.glwrap.width,self.glwrap.height,true);self.layer_tex=null;self.layout_tex=null;self.fx_tex[0]=null;self.fx_tex[1]=null;self.onContextRestored();self.redraw=true;window["cr_setSuspended"](false);},false);var i,len,j,lenj,k,lenk,t,s,l,y;for(i=0,len=this.types_by_index.length;i<len;i++)
{t=this.types_by_index[i];for(j=0,lenj=t.effect_types.length;j<lenj;j++)
{s=t.effect_types[j];s.shaderindex=this.glwrap.getShaderIndex(s.id);this.uses_background_blending=this.uses_background_blending||this.glwrap.programUsesDest(s.shaderindex);}}
for(i=0,len=this.layouts_by_index.length;i<len;i++)
{l=this.layouts_by_index[i];for(j=0,lenj=l.effect_types.length;j<lenj;j++)
{s=l.effect_types[j];s.shaderindex=this.glwrap.getShaderIndex(s.id);}
for(j=0,lenj=l.layers.length;j<lenj;j++)
{y=l.layers[j];for(k=0,lenk=y.effect_types.length;k<lenk;k++)
{s=y.effect_types[k];s.shaderindex=this.glwrap.getShaderIndex(s.id);this.uses_background_blending=this.uses_background_blending||this.glwrap.programUsesDest(s.shaderindex);}}}}
else
{if(this.fullscreen_mode>0&&this.isDirectCanvas)
{;this.canvas=null;document.oncontextmenu=function(e){return false;};document.onselectstart=function(e){return false;};this.ctx=AppMobi["canvas"]["getContext"]("2d");try{this.ctx["samplingMode"]=this.linearSampling?"smooth":"sharp";this.ctx["globalScale"]=1;this.ctx["HTML5CompatibilityMode"]=true;this.ctx["imageSmoothingEnabled"]=this.linearSampling;}catch(e){}
if(this.width!==0&&this.height!==0)
{this.ctx.width=this.width;this.ctx.height=this.height;}}
if(!this.ctx)
{;if(this.isCocoonJs)
{attribs={"antialias":!!this.linearSampling};this.ctx=canvas.getContext("2d",attribs);}
else
this.ctx=canvas.getContext("2d");this.ctx["webkitImageSmoothingEnabled"]=this.linearSampling;this.ctx["mozImageSmoothingEnabled"]=this.linearSampling;this.ctx["msImageSmoothingEnabled"]=this.linearSampling;this.ctx["imageSmoothingEnabled"]=this.linearSampling;}
this.overlay_canvas=null;this.overlay_ctx=null;}
this.tickFunc=function(){self.tick();};if(window!=window.top&&!this.isDomFree&&!this.isWindows8App)
{document.addEventListener("mousedown",function(){window.focus();},true);document.addEventListener("touchstart",function(){window.focus();},true);}
if(typeof cr_is_preview!=="undefined")
{if(this.isCocoonJs)
console.log("[Construct 2] In preview-over-wifi via CocoonJS mode");if(window.location.search.indexOf("continuous")>-1)
{cr.logexport("Reloading for continuous preview");this.loadFromSlot="__c2_continuouspreview";this.suspendDrawing=true;}
if(this.pauseOnBlur&&!this.isMobile)
{jQuery(window).focus(function()
{self["setSuspended"](false);});jQuery(window).blur(function()
{self["setSuspended"](true);});}}
this.go();this.extra={};cr.seal(this);};var webkitRepaintFlag=false;Runtime.prototype["setSize"]=function(w,h)
{var tryHideAddressBar=this.hideAddressBar&&this.isiPhone&&!navigator["standalone"]&&!this.isDomFree&&!this.isPhoneGap;var addressBarHeight=0;if(tryHideAddressBar)
{if(this.isiPhone)
addressBarHeight=60;else if(this.isAndroid)
addressBarHeight=56;h+=addressBarHeight;}
var offx=0,offy=0;var neww=0,newh=0,intscale=0;var mode=this.fullscreen_mode;var isfullscreen=(document["mozFullScreen"]||document["webkitIsFullScreen"]||!!document["msFullscreenElement"]||document["fullScreen"]||this.isNodeFullscreen);if(isfullscreen&&this.fullscreen_scaling>0)
mode=this.fullscreen_scaling;if(mode>=4)
{var orig_aspect=this.original_width/this.original_height;var cur_aspect=w/h;if(cur_aspect>orig_aspect)
{neww=h*orig_aspect;if(mode===5)
{intscale=neww/this.original_width;if(intscale>1)
intscale=Math.floor(intscale);else if(intscale<1)
intscale=1/Math.ceil(1/intscale);neww=this.original_width*intscale;newh=this.original_height*intscale;offx=(w-neww)/2;offy=(h-newh)/2;w=neww;h=newh;}
else
{offx=(w-neww)/2;w=neww;}}
else
{newh=w/orig_aspect;if(mode===5)
{intscale=newh/this.original_height;if(intscale>1)
intscale=Math.floor(intscale);else if(intscale<1)
intscale=1/Math.ceil(1/intscale);neww=this.original_width*intscale;newh=this.original_height*intscale;offx=(w-neww)/2;offy=(h-newh)/2;w=neww;h=newh;}
else
{offy=(h-newh)/2;h=newh;}}
if(isfullscreen&&!this.isNodeWebkit)
{offx=0;offy=0;}
offx=Math.floor(offx);offy=Math.floor(offy);w=Math.floor(w);h=Math.floor(h);}
else if(this.isNodeWebkit&&this.isNodeFullscreen&&this.fullscreen_mode_set===0)
{offx=Math.floor((w-this.original_width)/2);offy=Math.floor((h-this.original_height)/2);w=this.original_width;h=this.original_height;}
if(this.isRetina&&this.isiPad&&this.devicePixelRatio>1)
{if(w>=1024)
w=1023;if(h>=1024)
h=1023;}
var multiplier=this.devicePixelRatio;this.width=w*multiplier;this.height=h*multiplier;this.redraw=true;if(this.canvasdiv&&!this.isDomFree)
{jQuery(this.canvasdiv).css({"width":w+"px","height":h+"px","margin-left":offx,"margin-top":offy});if(typeof cr_is_preview!=="undefined")
{jQuery("#borderwrap").css({"width":w+"px","height":h+"px"});}}
if(this.canvas)
{this.canvas.width=w*multiplier;this.canvas.height=h*multiplier;if(this.isRetina)
{jQuery(this.canvas).css({"width":w+"px","height":h+"px"});}}
if(this.overlay_canvas)
{this.overlay_canvas.width=w;this.overlay_canvas.height=h;}
if(this.glwrap)
this.glwrap.setSize(w,h);if(this.isDirectCanvas&&this.ctx)
{this.ctx.width=w;this.ctx.height=h;}
if(this.ctx)
{this.ctx["webkitImageSmoothingEnabled"]=this.linearSampling;this.ctx["mozImageSmoothingEnabled"]=this.linearSampling;this.ctx["msImageSmoothingEnabled"]=this.linearSampling;this.ctx["imageSmoothingEnabled"]=this.linearSampling;}
if(tryHideAddressBar&&addressBarHeight>0)
{window.setTimeout(function(){window.scrollTo(0,1);},100);}};Runtime.prototype.onContextLost=function()
{this.is_WebGL_context_lost=true;var i,len,t;for(i=0,len=this.types_by_index.length;i<len;i++)
{t=this.types_by_index[i];if(t.onLostWebGLContext)
t.onLostWebGLContext();}};Runtime.prototype.onContextRestored=function()
{this.is_WebGL_context_lost=false;var i,len,t;for(i=0,len=this.types_by_index.length;i<len;i++)
{t=this.types_by_index[i];if(t.onRestoreWebGLContext)
t.onRestoreWebGLContext();}};Runtime.prototype.positionOverlayCanvas=function()
{if(this.isDomFree)
return;var isfullscreen=(document["mozFullScreen"]||document["webkitIsFullScreen"]||document["fullScreen"]||!!document["msFullscreenElement"]||this.isNodeFullscreen);var overlay_position=isfullscreen?jQuery(this.canvas).offset():jQuery(this.canvas).position();overlay_position.position="absolute";jQuery(this.overlay_canvas).css(overlay_position);};var caf=window["cancelAnimationFrame"]||window["mozCancelAnimationFrame"]||window["webkitCancelAnimationFrame"]||window["msCancelAnimationFrame"]||window["oCancelAnimationFrame"];Runtime.prototype["setSuspended"]=function(s)
{var i,len;if(s&&!this.isSuspended)
{cr.logexport("[Construct 2] Suspending");this.isSuspended=true;if(this.raf_id!==0&&caf)
caf(this.raf_id);if(this.timeout_id!==0)
clearTimeout(this.timeout_id);for(i=0,len=this.suspend_events.length;i<len;i++)
this.suspend_events[i](true);}
else if(!s&&this.isSuspended)
{cr.logexport("[Construct 2] Resuming");this.isSuspended=false;this.last_tick_time=cr.performance_now();this.last_fps_time=cr.performance_now();this.framecount=0;this.logictime=0;for(i=0,len=this.suspend_events.length;i<len;i++)
this.suspend_events[i](false);this.tick();}};Runtime.prototype.addSuspendCallback=function(f)
{this.suspend_events.push(f);};Runtime.prototype.load=function()
{;var pm=cr.getProjectModel();this.name=pm[0];this.first_layout=pm[1];this.fullscreen_mode=pm[11];this.fullscreen_mode_set=pm[11];if(this.isDomFree&&(pm[11]>=4||pm[11]===0))
{cr.logexport("[Construct 2] Letterbox scale fullscreen modes are not supported on this platform - falling back to 'Scale outer'");this.fullscreen_mode=3;this.fullscreen_mode_set=3;}
this.uses_loader_layout=pm[17];this.loaderstyle=pm[18];if(this.loaderstyle===0)
{this.loaderlogo=new Image();this.loaderlogo.src="loading-logo.png";}
this.next_uid=pm[20];this.system=new cr.system_object(this);var i,len,j,lenj,k,lenk,idstr,m,b,t,f;var plugin,plugin_ctor;for(i=0,len=pm[2].length;i<len;i++)
{m=pm[2][i];;cr.add_common_aces(m);plugin=new m[0](this);plugin.singleglobal=m[1];plugin.is_world=m[2];plugin.must_predraw=m[9];if(plugin.onCreate)
plugin.onCreate();cr.seal(plugin);this.plugins.push(plugin);}
pm=cr.getProjectModel();for(i=0,len=pm[3].length;i<len;i++)
{m=pm[3][i];plugin_ctor=m[1];;plugin=null;for(j=0,lenj=this.plugins.length;j<lenj;j++)
{if(this.plugins[j]instanceof plugin_ctor)
{plugin=this.plugins[j];break;}};;var type_inst=new plugin.Type(plugin);;type_inst.name=m[0];type_inst.is_family=m[2];type_inst.instvar_sids=m[3].slice(0);type_inst.vars_count=m[3].length;type_inst.behs_count=m[4];type_inst.fx_count=m[5];type_inst.sid=m[11];if(type_inst.is_family)
{type_inst.members=[];type_inst.family_index=this.family_count++;type_inst.families=null;}
else
{type_inst.members=null;type_inst.family_index=-1;type_inst.families=[];}
type_inst.family_var_map=null;type_inst.family_beh_map=null;type_inst.family_fx_map=null;type_inst.is_contained=false;type_inst.container=null;if(m[6])
{type_inst.texture_file=m[6][0];type_inst.texture_filesize=m[6][1];type_inst.texture_pixelformat=m[6][2];}
else
{type_inst.texture_file=null;type_inst.texture_filesize=0;type_inst.texture_pixelformat=0;}
if(m[7])
{type_inst.animations=m[7];}
else
{type_inst.animations=null;}
type_inst.index=i;type_inst.instances=[];type_inst.deadCache=[];type_inst.solstack=[new cr.selection(type_inst)];type_inst.cur_sol=0;type_inst.default_instance=null;type_inst.stale_iids=true;type_inst.updateIIDs=cr.type_updateIIDs;type_inst.getFirstPicked=cr.type_getFirstPicked;type_inst.getPairedInstance=cr.type_getPairedInstance;type_inst.getCurrentSol=cr.type_getCurrentSol;type_inst.pushCleanSol=cr.type_pushCleanSol;type_inst.pushCopySol=cr.type_pushCopySol;type_inst.popSol=cr.type_popSol;type_inst.getBehaviorByName=cr.type_getBehaviorByName;type_inst.getBehaviorIndexByName=cr.type_getBehaviorIndexByName;type_inst.getEffectIndexByName=cr.type_getEffectIndexByName;type_inst.applySolToContainer=cr.type_applySolToContainer;type_inst.extra={};type_inst.toString=cr.type_toString;type_inst.behaviors=[];for(j=0,lenj=m[8].length;j<lenj;j++)
{b=m[8][j];var behavior_ctor=b[1];var behavior_plugin=null;for(k=0,lenk=this.behaviors.length;k<lenk;k++)
{if(this.behaviors[k]instanceof behavior_ctor)
{behavior_plugin=this.behaviors[k];break;}}
if(!behavior_plugin)
{behavior_plugin=new behavior_ctor(this);behavior_plugin.my_instances=new cr.ObjectSet();if(behavior_plugin.onCreate)
behavior_plugin.onCreate();cr.seal(behavior_plugin);this.behaviors.push(behavior_plugin);}
var behavior_type=new behavior_plugin.Type(behavior_plugin,type_inst);behavior_type.name=b[0];behavior_type.sid=b[2];behavior_type.onCreate();cr.seal(behavior_type);type_inst.behaviors.push(behavior_type);}
type_inst.global=m[9];type_inst.isOnLoaderLayout=m[10];type_inst.effect_types=[];for(j=0,lenj=m[12].length;j<lenj;j++)
{type_inst.effect_types.push({id:m[12][j][0],name:m[12][j][1],shaderindex:-1,active:true,index:j});}
if(!this.uses_loader_layout||type_inst.is_family||type_inst.isOnLoaderLayout||!plugin.is_world)
{type_inst.onCreate();cr.seal(type_inst);}
if(type_inst.name)
this.types[type_inst.name]=type_inst;this.types_by_index.push(type_inst);if(plugin.singleglobal)
{var instance=new plugin.Instance(type_inst);instance.uid=this.next_uid++;instance.puid=this.next_puid++;instance.iid=0;instance.get_iid=cr.inst_get_iid;instance.toString=cr.inst_toString;instance.properties=m[13];instance.onCreate();cr.seal(instance);type_inst.instances.push(instance);this.objectsByUid[instance.uid.toString()]=instance;}}
for(i=0,len=pm[4].length;i<len;i++)
{var familydata=pm[4][i];var familytype=this.types_by_index[familydata[0]];var familymember;for(j=1,lenj=familydata.length;j<lenj;j++)
{familymember=this.types_by_index[familydata[j]];familymember.families.push(familytype);familytype.members.push(familymember);}}
for(i=0,len=pm[22].length;i<len;i++)
{var containerdata=pm[22][i];var containertypes=[];for(j=0,lenj=containerdata.length;j<lenj;j++)
containertypes.push(this.types_by_index[containerdata[j]]);for(j=0,lenj=containertypes.length;j<lenj;j++)
{containertypes[j].is_contained=true;containertypes[j].container=containertypes;}}
if(this.family_count>0)
{for(i=0,len=this.types_by_index.length;i<len;i++)
{t=this.types_by_index[i];if(t.is_family||!t.families.length)
continue;t.family_var_map=new Array(this.family_count);t.family_beh_map=new Array(this.family_count);t.family_fx_map=new Array(this.family_count);var all_fx=[];var varsum=0;var behsum=0;var fxsum=0;for(j=0,lenj=t.families.length;j<lenj;j++)
{f=t.families[j];t.family_var_map[f.family_index]=varsum;varsum+=f.vars_count;t.family_beh_map[f.family_index]=behsum;behsum+=f.behs_count;t.family_fx_map[f.family_index]=fxsum;fxsum+=f.fx_count;for(k=0,lenk=f.effect_types.length;k<lenk;k++)
all_fx.push(cr.shallowCopy({},f.effect_types[k]));}
t.effect_types=all_fx.concat(t.effect_types);for(j=0,lenj=t.effect_types.length;j<lenj;j++)
t.effect_types[j].index=j;}}
for(i=0,len=pm[5].length;i<len;i++)
{m=pm[5][i];var layout=new cr.layout(this,m);cr.seal(layout);this.layouts[layout.name]=layout;this.layouts_by_index.push(layout);}
for(i=0,len=pm[6].length;i<len;i++)
{m=pm[6][i];var sheet=new cr.eventsheet(this,m);cr.seal(sheet);this.eventsheets[sheet.name]=sheet;this.eventsheets_by_index.push(sheet);}
for(i=0,len=this.eventsheets_by_index.length;i<len;i++)
this.eventsheets_by_index[i].postInit();for(i=0,len=this.triggers_to_postinit.length;i<len;i++)
this.triggers_to_postinit[i].postInit();this.triggers_to_postinit.length=0;this.files_subfolder=pm[7];this.pixel_rounding=pm[8];this.original_width=pm[9];this.original_height=pm[10];this.aspect_scale=1.0;this.enableWebGL=pm[12];this.linearSampling=pm[13];this.clearBackground=pm[14];this.versionstr=pm[15];var iOSretina=pm[16];if(iOSretina===2)
iOSretina=(this.isiPhone?1:0);this.useiOSRetina=(iOSretina!==0);this.hideAddressBar=pm[19];this.pauseOnBlur=pm[21];this.start_time=Date.now();};Runtime.prototype.findWaitingTexture=function(src_)
{var i,len;for(i=0,len=this.wait_for_textures.length;i<len;i++)
{if(this.wait_for_textures[i].cr_src===src_)
return this.wait_for_textures[i];}
return null;};Runtime.prototype.areAllTexturesLoaded=function()
{var totalsize=0;var completedsize=0;var ret=true;var i,len;for(i=0,len=this.wait_for_textures.length;i<len;i++)
{var filesize=this.wait_for_textures[i].cr_filesize;if(!filesize||filesize<=0)
filesize=50000;totalsize+=filesize;if(this.wait_for_textures[i].complete||this.wait_for_textures[i]["loaded"])
completedsize+=filesize;else
ret=false;}
if(totalsize==0)
this.progress=0;else
this.progress=(completedsize/totalsize);return ret;};Runtime.prototype.go=function()
{if(!this.ctx&&!this.glwrap)
return;var ctx=this.ctx||this.overlay_ctx;if(this.overlay_canvas)
this.positionOverlayCanvas();this.progress=0;this.last_progress=-1;if(this.areAllTexturesLoaded())
this.go_textures_done();else
{var ms_elapsed=Date.now()-this.start_time;var multiplier=1;if(this.isTizen)
multiplier=this.devicePixelRatio;if(ctx)
{if(this.loaderstyle!==3&&ms_elapsed>=500&&this.last_progress!=this.progress)
{ctx.clearRect(0,0,this.width,this.height);var mx=this.width/(2*multiplier);var my=this.height/(2*multiplier);var haslogo=(this.loaderstyle===0&&this.loaderlogo.complete);var hlw=40;var hlh=0;var logowidth=80;if(haslogo)
{logowidth=this.loaderlogo.width;hlw=logowidth/2;hlh=this.loaderlogo.height/2;ctx.drawImage(this.loaderlogo,cr.floor(mx-hlw),cr.floor(my-hlh));}
if(this.loaderstyle<=1)
{my+=hlh+(haslogo?12:0);mx-=hlw;mx=cr.floor(mx)+0.5;my=cr.floor(my)+0.5;ctx.fillStyle="DodgerBlue";ctx.fillRect(mx,my,Math.floor(logowidth*this.progress),6);ctx.strokeStyle="black";ctx.strokeRect(mx,my,logowidth,6);ctx.strokeStyle="white";ctx.strokeRect(mx-1,my-1,logowidth+2,8);}
else if(this.loaderstyle===2)
{ctx.font="12pt Arial";ctx.fillStyle="#999";ctx.textBaseLine="middle";var percent_text=Math.round(this.progress*100)+"%";var text_dim=ctx.measureText?ctx.measureText(percent_text):null;var text_width=text_dim?text_dim.width:0;ctx.fillText(percent_text,mx-(text_width/2),my);}}
this.last_progress=this.progress;}
setTimeout((function(self){return function(){self.go();};})(this),100);}};Runtime.prototype.go_textures_done=function()
{if(this.overlay_canvas)
{this.canvas.parentNode.removeChild(this.overlay_canvas);this.overlay_ctx=null;this.overlay_canvas=null;}
this.start_time=Date.now();this.last_fps_time=cr.performance_now();var i,len,t;if(this.uses_loader_layout)
{for(i=0,len=this.types_by_index.length;i<len;i++)
{t=this.types_by_index[i];if(!t.is_family&&!t.isOnLoaderLayout&&t.plugin.is_world)
{t.onCreate();cr.seal(t);}}}
else
this.isloading=false;for(i=0,len=this.layouts_by_index.length;i<len;i++)
{this.layouts_by_index[i].createGlobalNonWorlds();}
if(this.fullscreen_mode>=2)
{var orig_aspect=this.original_width/this.original_height;var cur_aspect=this.width/this.height;if((this.fullscreen_mode!==2&&cur_aspect>orig_aspect)||(this.fullscreen_mode===2&&cur_aspect<orig_aspect))
this.aspect_scale=this.height/this.original_height;else
this.aspect_scale=this.width/this.original_width;}
if(this.first_layout)
this.layouts[this.first_layout].startRunning();else
this.layouts_by_index[0].startRunning();;if(!this.uses_loader_layout)
{this.loadingprogress=1;this.trigger(cr.system_object.prototype.cnds.OnLoadFinished,null);}
this.tick();if(this.isDirectCanvas)
AppMobi["webview"]["execute"]("onGameReady();");};var raf=window["requestAnimationFrame"]||window["mozRequestAnimationFrame"]||window["webkitRequestAnimationFrame"]||window["msRequestAnimationFrame"]||window["oRequestAnimationFrame"];Runtime.prototype.tick=function()
{if(!this.running_layout)
return;var logic_start=cr.performance_now();if(!this.isDomFree&&window!=window.top)
{var mode=this.fullscreen_mode;var isfullscreen=(document["mozFullScreen"]||document["webkitIsFullScreen"]||document["fullScreen"]||!!document["msFullscreenElement"]||this.isNodeFullscreen);if(isfullscreen&&this.fullscreen_scaling>0)
mode=this.fullscreen_scaling;if(mode>0)
{var curwidth=window.innerWidth;var curheight=window.innerHeight;if(this.lastwidth!==curwidth||this.lastheight!==curheight)
{this.lastwidth=curwidth;this.lastheight=curheight;this["setSize"](curwidth,curheight);}}}
if(this.isloading)
{var done=this.areAllTexturesLoaded();this.loadingprogress=this.progress;if(done)
{this.isloading=false;this.progress=1;this.trigger(cr.system_object.prototype.cnds.OnLoadFinished,null);}}
this.logic();if((this.redraw||this.isCocoonJs)&&!this.is_WebGL_context_lost&&!this.suspendDrawing)
{this.redraw=false;if(this.glwrap)
this.drawGL();else
this.draw();if(this.snapshotCanvas)
{if(this.canvas&&this.canvas.toDataURL)
{this.snapshotData=this.canvas.toDataURL(this.snapshotCanvas[0],this.snapshotCanvas[1]);this.trigger(cr.system_object.prototype.cnds.OnCanvasSnapshot,null);}
this.snapshotCanvas=null;}}
if(!this.hit_breakpoint)
{this.tickcount++;this.execcount++;this.framecount++;}
this.logictime+=cr.performance_now()-logic_start;if(this.isSuspended)
return;if(raf)
this.raf_id=raf(this.tickFunc,this.canvas);else
{this.timeout_id=setTimeout(this.tickFunc,this.isMobile?1:16);}};Runtime.prototype.logic=function()
{var i,leni,j,lenj,k,lenk,type,inst,binst;var cur_time=cr.performance_now();if(cur_time-this.last_fps_time>=1000)
{this.last_fps_time+=1000;this.fps=this.framecount;this.framecount=0;this.cpuutilisation=this.logictime;this.logictime=0;}
if(this.measuring_dt)
{if(this.last_tick_time!==0)
{var ms_diff=cur_time-this.last_tick_time;if(ms_diff===0&&!this.isDebug)
{this.zeroDtCount++;if(this.zeroDtCout>=10)
this.measuring_dt=false;this.dt1=1.0/60.0;}
else
{this.dt1=ms_diff/1000.0;if(this.dt1>0.5)
this.dt1=0;else if(this.dt1>0.1)
this.dt1=0.1;}}
this.last_tick_time=cur_time;}
this.dt=this.dt1*this.timescale;this.kahanTime.add(this.dt);var isfullscreen=(document["mozFullScreen"]||document["webkitIsFullScreen"]||document["fullScreen"]||!!document["msFullscreenElement"]||this.isNodeFullscreen);if(this.fullscreen_mode>=2||(isfullscreen&&this.fullscreen_scaling>0))
{var orig_aspect=this.original_width/this.original_height;var cur_aspect=this.width/this.height;var mode=this.fullscreen_mode;if(isfullscreen&&this.fullscreen_scaling>0)
mode=this.fullscreen_scaling;if((mode!==2&&cur_aspect>orig_aspect)||(mode===2&&cur_aspect<orig_aspect))
{this.aspect_scale=this.height/this.original_height;}
else
{this.aspect_scale=this.width/this.original_width;}
if(this.running_layout)
{this.running_layout.scrollToX(this.running_layout.scrollX);this.running_layout.scrollToY(this.running_layout.scrollY);}}
else
this.aspect_scale=1;this.ClearDeathRow();this.isInOnDestroy++;this.system.runWaits();this.isInOnDestroy--;this.ClearDeathRow();this.isInOnDestroy++;for(i=0,leni=this.types_by_index.length;i<leni;i++)
{type=this.types_by_index[i];if(type.is_family||(!type.behaviors.length&&!type.families.length))
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
{inst=type.instances[j];for(k=0,lenk=inst.behavior_insts.length;k<lenk;k++)
{inst.behavior_insts[k].tick();}}}
for(i=0,leni=this.types_by_index.length;i<leni;i++)
{type=this.types_by_index[i];if(type.is_family||(!type.behaviors.length&&!type.families.length))
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
{inst=type.instances[j];for(k=0,lenk=inst.behavior_insts.length;k<lenk;k++)
{binst=inst.behavior_insts[k];if(binst.posttick)
binst.posttick();}}}
var tickarr=this.objects_to_tick.valuesRef();for(i=0,leni=tickarr.length;i<leni;i++)
tickarr[i].tick();this.isInOnDestroy--;this.handleSaveLoad();i=0;while(this.changelayout&&i++<10)
{this.doChangeLayout(this.changelayout);}
for(i=0,leni=this.eventsheets_by_index.length;i<leni;i++)
this.eventsheets_by_index[i].hasRun=false;if(this.running_layout.event_sheet)
this.running_layout.event_sheet.run();this.registered_collisions.length=0;this.layout_first_tick=false;this.isInOnDestroy++;for(i=0,leni=this.types_by_index.length;i<leni;i++)
{type=this.types_by_index[i];if(type.is_family||(!type.behaviors.length&&!type.families.length))
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
{var inst=type.instances[j];for(k=0,lenk=inst.behavior_insts.length;k<lenk;k++)
{binst=inst.behavior_insts[k];if(binst.tick2)
binst.tick2();}}}
tickarr=this.objects_to_tick2.valuesRef();for(i=0,leni=tickarr.length;i<leni;i++)
tickarr[i].tick2();this.isInOnDestroy--;};Runtime.prototype.doChangeLayout=function(changeToLayout)
{;var prev_layout=this.running_layout;this.running_layout.stopRunning();var i,len,j,lenj,k,lenk,type,inst,binst;if(this.glwrap)
{for(i=0,len=this.types_by_index.length;i<len;i++)
{type=this.types_by_index[i];if(type.is_family)
continue;if(type.unloadTextures&&(!type.global||type.instances.length===0)&&changeToLayout.initial_types.indexOf(type)===-1)
{type.unloadTextures();}}}
if(prev_layout==changeToLayout)
this.system.waits.length=0;changeToLayout.startRunning();for(i=0,len=this.types_by_index.length;i<len;i++)
{type=this.types_by_index[i];if(!type.global&&!type.plugin.singleglobal)
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
{inst=type.instances[j];if(inst.onLayoutChange)
inst.onLayoutChange();if(inst.behavior_insts)
{for(k=0,lenk=inst.behavior_insts.length;k<lenk;k++)
{binst=inst.behavior_insts[k];if(binst.onLayoutChange)
binst.onLayoutChange();}}}}
this.redraw=true;this.layout_first_tick=true;this.ClearDeathRow();};Runtime.prototype.tickMe=function(inst)
{this.objects_to_tick.add(inst);};Runtime.prototype.untickMe=function(inst)
{this.objects_to_tick.remove(inst);};Runtime.prototype.tick2Me=function(inst)
{this.objects_to_tick2.add(inst);};Runtime.prototype.untick2Me=function(inst)
{this.objects_to_tick2.remove(inst);};Runtime.prototype.getDt=function(inst)
{if(!inst||inst.my_timescale===-1.0)
return this.dt;return this.dt1*inst.my_timescale;};Runtime.prototype.draw=function()
{this.running_layout.draw(this.ctx);if(this.isDirectCanvas)
this.ctx["present"]();};Runtime.prototype.drawGL=function()
{this.running_layout.drawGL(this.glwrap);this.glwrap.present();};Runtime.prototype.addDestroyCallback=function(f)
{if(f)
this.destroycallbacks.push(f);};Runtime.prototype.removeDestroyCallback=function(f)
{cr.arrayFindRemove(this.destroycallbacks,f);};Runtime.prototype.getObjectByUID=function(uid_)
{;return this.objectsByUid[uid_.toString()];};Runtime.prototype.DestroyInstance=function(inst)
{var i,len;if(!this.deathRow.contains(inst))
{this.deathRow.add(inst);if(inst.is_contained)
{for(i=0,len=inst.siblings.length;i<len;i++)
{this.DestroyInstance(inst.siblings[i]);}}
if(this.isInClearDeathRow)
this.deathRow.values_cache.push(inst);this.isInOnDestroy++;this.trigger(Object.getPrototypeOf(inst.type.plugin).cnds.OnDestroyed,inst);this.isInOnDestroy--;}};Runtime.prototype.ClearDeathRow=function()
{var inst,index,type,instances,binst;var i,j,k,leni,lenj,lenk;var w,f;this.isInClearDeathRow=true;for(i=0,leni=this.createRow.length;i<leni;i++)
{inst=this.createRow[i];type=inst.type;type.instances.push(inst);for(j=0,lenj=type.families.length;j<lenj;j++)
{type.families[j].instances.push(inst);type.families[j].stale_iids=true;}}
this.createRow.length=0;var arr=this.deathRow.valuesRef();for(i=0;i<arr.length;i++)
{inst=arr[i];type=inst.type;instances=type.instances;for(j=0,lenj=this.destroycallbacks.length;j<lenj;j++)
this.destroycallbacks[j](inst);cr.arrayFindRemove(instances,inst);if(inst.layer)
{cr.arrayRemove(inst.layer.instances,inst.get_zindex());inst.layer.zindices_stale=true;}
for(j=0,lenj=type.families.length;j<lenj;j++)
{cr.arrayFindRemove(type.families[j].instances,inst);type.families[j].stale_iids=true;}
if(inst.behavior_insts)
{for(j=0,lenj=inst.behavior_insts.length;j<lenj;j++)
{binst=inst.behavior_insts[j];if(binst.onDestroy)
binst.onDestroy();binst.behavior.my_instances.remove(inst);}}
this.objects_to_tick.remove(inst);this.objects_to_tick2.remove(inst);for(j=0,lenj=this.system.waits.length;j<lenj;j++)
{w=this.system.waits[j];if(w.sols.hasOwnProperty(type.index))
cr.arrayFindRemove(w.sols[type.index].insts,inst);if(!type.is_family)
{for(k=0,lenk=type.families.length;k<lenk;k++)
{f=type.families[k];if(w.sols.hasOwnProperty(f.index))
cr.arrayFindRemove(w.sols[f.index].insts,inst);}}}
if(inst.onDestroy)
inst.onDestroy();if(this.objectsByUid.hasOwnProperty(inst.uid.toString()))
delete this.objectsByUid[inst.uid.toString()];this.objectcount--;if(type.deadCache.length<64)
type.deadCache.push(inst);type.stale_iids=true;}
if(!this.deathRow.isEmpty())
this.redraw=true;this.deathRow.clear();this.isInClearDeathRow=false;};Runtime.prototype.createInstance=function(type,layer,sx,sy)
{if(type.is_family)
{var i=cr.floor(Math.random()*type.members.length);return this.createInstance(type.members[i],layer,sx,sy);}
if(!type.default_instance)
{return null;}
return this.createInstanceFromInit(type.default_instance,layer,false,sx,sy,false);};var all_behaviors=[];Runtime.prototype.createInstanceFromInit=function(initial_inst,layer,is_startup_instance,sx,sy,skip_siblings)
{var i,len,j,lenj,p,effect_fallback,x,y;if(!initial_inst)
return null;var type=this.types_by_index[initial_inst[1]];;;var is_world=type.plugin.is_world;;if(this.isloading&&is_world&&!type.isOnLoaderLayout)
return null;if(is_world&&!this.glwrap&&initial_inst[0][11]===11)
return null;var original_layer=layer;if(!is_world)
layer=null;var inst;if(type.deadCache.length)
{inst=type.deadCache.pop();inst.recycled=true;type.plugin.Instance.call(inst,type);}
else
{inst=new type.plugin.Instance(type);inst.recycled=false;}
if(is_startup_instance&&!skip_siblings)
inst.uid=initial_inst[2];else
inst.uid=this.next_uid++;this.objectsByUid[inst.uid.toString()]=inst;inst.puid=this.next_puid++;inst.iid=type.instances.length;for(i=0,len=this.createRow.length;i<len;++i)
{if(this.createRow[i].type===type)
inst.iid++;}
inst.get_iid=cr.inst_get_iid;var initial_vars=initial_inst[3];if(inst.recycled)
{cr.wipe(inst.extra);}
else
{inst.extra={};if(typeof cr_is_preview!=="undefined")
{inst.instance_var_names=[];inst.instance_var_names.length=initial_vars.length;for(i=0,len=initial_vars.length;i<len;i++)
inst.instance_var_names[i]=initial_vars[i][1];}
inst.instance_vars=[];inst.instance_vars.length=initial_vars.length;}
for(i=0,len=initial_vars.length;i<len;i++)
inst.instance_vars[i]=initial_vars[i][0];if(is_world)
{var wm=initial_inst[0];;inst.x=cr.is_undefined(sx)?wm[0]:sx;inst.y=cr.is_undefined(sy)?wm[1]:sy;inst.z=wm[2];inst.width=wm[3];inst.height=wm[4];inst.depth=wm[5];inst.angle=wm[6];inst.opacity=wm[7];inst.hotspotX=wm[8];inst.hotspotY=wm[9];inst.blend_mode=wm[10];effect_fallback=wm[11];if(!this.glwrap&&type.effect_types.length)
inst.blend_mode=effect_fallback;inst.compositeOp=cr.effectToCompositeOp(inst.blend_mode);if(this.gl)
cr.setGLBlend(inst,inst.blend_mode,this.gl);if(inst.recycled)
{for(i=0,len=wm[12].length;i<len;i++)
{for(j=0,lenj=wm[12][i].length;j<lenj;j++)
inst.effect_params[i][j]=wm[12][i][j];}
inst.bbox.set(0,0,0,0);inst.bquad.set_from_rect(inst.bbox);inst.bbox_changed_callbacks.length=0;}
else
{inst.effect_params=wm[12].slice(0);for(i=0,len=inst.effect_params.length;i<len;i++)
inst.effect_params[i]=wm[12][i].slice(0);inst.active_effect_types=[];inst.active_effect_flags=[];inst.active_effect_flags.length=type.effect_types.length;inst.bbox=new cr.rect(0,0,0,0);inst.bquad=new cr.quad();inst.bbox_changed_callbacks=[];inst.set_bbox_changed=cr.set_bbox_changed;inst.add_bbox_changed_callback=cr.add_bbox_changed_callback;inst.contains_pt=cr.inst_contains_pt;inst.update_bbox=cr.update_bbox;inst.get_zindex=cr.inst_get_zindex;}
for(i=0,len=type.effect_types.length;i<len;i++)
inst.active_effect_flags[i]=true;inst.updateActiveEffects=cr.inst_updateActiveEffects;inst.updateActiveEffects();inst.uses_shaders=!!inst.active_effect_types.length;inst.bbox_changed=true;inst.visible=true;inst.my_timescale=-1.0;inst.layer=layer;inst.zindex=layer.instances.length;if(typeof inst.collision_poly==="undefined")
inst.collision_poly=null;inst.collisionsEnabled=true;this.redraw=true;}
inst.toString=cr.inst_toString;var initial_props,binst;all_behaviors.length=0;for(i=0,len=type.families.length;i<len;i++)
{all_behaviors.push.apply(all_behaviors,type.families[i].behaviors);}
all_behaviors.push.apply(all_behaviors,type.behaviors);if(inst.recycled)
{for(i=0,len=all_behaviors.length;i<len;i++)
{var btype=all_behaviors[i];binst=inst.behavior_insts[i];binst.recycled=true;btype.behavior.Instance.call(binst,btype,inst);initial_props=initial_inst[4][i];for(j=0,lenj=initial_props.length;j<lenj;j++)
binst.properties[j]=initial_props[j];binst.onCreate();btype.behavior.my_instances.add(inst);}}
else
{inst.behavior_insts=[];for(i=0,len=all_behaviors.length;i<len;i++)
{var btype=all_behaviors[i];var binst=new btype.behavior.Instance(btype,inst);binst.recycled=false;binst.properties=initial_inst[4][i].slice(0);binst.onCreate();cr.seal(binst);inst.behavior_insts.push(binst);btype.behavior.my_instances.add(inst);}}
initial_props=initial_inst[5];if(inst.recycled)
{for(i=0,len=initial_props.length;i<len;i++)
inst.properties[i]=initial_props[i];}
else
inst.properties=initial_props.slice(0);this.createRow.push(inst);if(layer)
{;layer.instances.push(inst);}
this.objectcount++;if(type.is_contained)
{inst.is_contained=true;if(inst.recycled)
inst.siblings.length=0;else
inst.siblings=[];if(!is_startup_instance&&!skip_siblings)
{for(i=0,len=type.container.length;i<len;i++)
{if(type.container[i]===type)
continue;if(!type.container[i].default_instance)
{return null;}
inst.siblings.push(this.createInstanceFromInit(type.container[i].default_instance,original_layer,false,is_world?inst.x:sx,is_world?inst.y:sy,true));}
for(i=0,len=inst.siblings.length;i<len;i++)
{inst.siblings[i].siblings.push(inst);for(j=0;j<len;j++)
{if(i!==j)
inst.siblings[i].siblings.push(inst.siblings[j]);}}}}
else
{inst.is_contained=false;inst.siblings=null;}
inst.onCreate();if(!inst.recycled)
cr.seal(inst);for(i=0,len=inst.behavior_insts.length;i<len;i++)
{if(inst.behavior_insts[i].postCreate)
inst.behavior_insts[i].postCreate();}
return inst;};Runtime.prototype.getLayerByName=function(layer_name)
{var i,len;for(i=0,len=this.running_layout.layers.length;i<len;i++)
{var layer=this.running_layout.layers[i];if(cr.equals_nocase(layer.name,layer_name))
return layer;}
return null;};Runtime.prototype.getLayerByNumber=function(index)
{index=cr.floor(index);if(index<0)
index=0;if(index>=this.running_layout.layers.length)
index=this.running_layout.layers.length-1;return this.running_layout.layers[index];};Runtime.prototype.getLayer=function(l)
{if(cr.is_number(l))
return this.getLayerByNumber(l);else
return this.getLayerByName(l.toString());};Runtime.prototype.clearSol=function(solModifiers)
{var i,len;for(i=0,len=solModifiers.length;i<len;i++)
{solModifiers[i].getCurrentSol().select_all=true;}};Runtime.prototype.pushCleanSol=function(solModifiers)
{var i,len;for(i=0,len=solModifiers.length;i<len;i++)
{solModifiers[i].pushCleanSol();}};Runtime.prototype.pushCopySol=function(solModifiers)
{var i,len;for(i=0,len=solModifiers.length;i<len;i++)
{solModifiers[i].pushCopySol();}};Runtime.prototype.popSol=function(solModifiers)
{var i,len;for(i=0,len=solModifiers.length;i<len;i++)
{solModifiers[i].popSol();}};Runtime.prototype.testAndSelectCanvasPointOverlap=function(type,ptx,pty,inverted)
{var sol=type.getCurrentSol();var i,j,inst,len;var lx,ly;if(sol.select_all)
{if(!inverted)
{sol.select_all=false;sol.instances.length=0;}
for(i=0,len=type.instances.length;i<len;i++)
{inst=type.instances[i];inst.update_bbox();lx=inst.layer.canvasToLayer(ptx,pty,true);ly=inst.layer.canvasToLayer(ptx,pty,false);if(inst.contains_pt(lx,ly))
{if(inverted)
return false;else
sol.instances.push(inst);}}}
else
{j=0;for(i=0,len=sol.instances.length;i<len;i++)
{inst=sol.instances[i];inst.update_bbox();lx=inst.layer.canvasToLayer(ptx,pty,true);ly=inst.layer.canvasToLayer(ptx,pty,false);if(inst.contains_pt(lx,ly))
{if(inverted)
return false;else
{sol.instances[j]=sol.instances[i];j++;}}}
if(!inverted)
sol.instances.length=j;}
type.applySolToContainer();if(inverted)
return true;else
return sol.hasObjects();};Runtime.prototype.testOverlap=function(a,b)
{if(!a||!b||a===b||!a.collisionsEnabled||!b.collisionsEnabled)
return false;a.update_bbox();b.update_bbox();var layera=a.layer;var layerb=b.layer;var different_layers=(layera!==layerb&&(layera.parallaxX!==layerb.parallaxX||layerb.parallaxY!==layerb.parallaxY||layera.scale!==layerb.scale||layera.angle!==layerb.angle||layera.zoomRate!==layerb.zoomRate));var i,len,x,y,haspolya,haspolyb,polya,polyb;if(!different_layers)
{if(!a.bbox.intersects_rect(b.bbox))
return false;if(!a.bquad.intersects_quad(b.bquad))
return false;haspolya=(a.collision_poly&&!a.collision_poly.is_empty());haspolyb=(b.collision_poly&&!b.collision_poly.is_empty());if(!haspolya&&!haspolyb)
return true;if(haspolya)
{a.collision_poly.cache_poly(a.width,a.height,a.angle);polya=a.collision_poly;}
else
{this.temp_poly.set_from_quad(a.bquad,a.x,a.y,a.width,a.height);polya=this.temp_poly;}
if(haspolyb)
{b.collision_poly.cache_poly(b.width,b.height,b.angle);polyb=b.collision_poly;}
else
{this.temp_poly.set_from_quad(b.bquad,b.x,b.y,b.width,b.height);polyb=this.temp_poly;}
return polya.intersects_poly(polyb,b.x-a.x,b.y-a.y);}
else
{haspolya=(a.collision_poly&&!a.collision_poly.is_empty());haspolyb=(b.collision_poly&&!b.collision_poly.is_empty());if(haspolya)
{a.collision_poly.cache_poly(a.width,a.height,a.angle);this.temp_poly.set_from_poly(a.collision_poly);}
else
{this.temp_poly.set_from_quad(a.bquad,a.x,a.y,a.width,a.height);}
polya=this.temp_poly;if(haspolyb)
{b.collision_poly.cache_poly(b.width,b.height,b.angle);this.temp_poly2.set_from_poly(b.collision_poly);}
else
{this.temp_poly2.set_from_quad(b.bquad,b.x,b.y,b.width,b.height);}
polyb=this.temp_poly2;for(i=0,len=polya.pts_count;i<len;i++)
{x=polya.pts_cache[i*2];y=polya.pts_cache[i*2+1];polya.pts_cache[i*2]=layera.layerToCanvas(x+a.x,y+a.y,true);polya.pts_cache[i*2+1]=layera.layerToCanvas(x+a.x,y+a.y,false);}
for(i=0,len=polyb.pts_count;i<len;i++)
{x=polyb.pts_cache[i*2];y=polyb.pts_cache[i*2+1];polyb.pts_cache[i*2]=layerb.layerToCanvas(x+b.x,y+b.y,true);polyb.pts_cache[i*2+1]=layerb.layerToCanvas(x+b.x,y+b.y,false);}
return polya.intersects_poly(polyb,0,0);}};var tmpQuad=new cr.quad();var tmpRect=new cr.rect(0,0,0,0);Runtime.prototype.testRectOverlap=function(r,b)
{if(!b||!b.collisionsEnabled)
return false;b.update_bbox();var layerb=b.layer;var haspolyb,polyb;if(!b.bbox.intersects_rect(r))
return false;tmpQuad.set_from_rect(r);if(!b.bquad.intersects_quad(tmpQuad))
return false;haspolyb=(b.collision_poly&&!b.collision_poly.is_empty());if(!haspolyb)
return true;b.collision_poly.cache_poly(b.width,b.height,b.angle);tmpQuad.offset(-r.left,-r.top);this.temp_poly.set_from_quad(tmpQuad,0,0,1,1);return b.collision_poly.intersects_poly(this.temp_poly,r.left-b.x,r.top-b.y);};Runtime.prototype.testSegmentOverlap=function(x1,y1,x2,y2,b)
{if(!b||!b.collisionsEnabled)
return false;b.update_bbox();var layerb=b.layer;var haspolyb,polyb;tmpRect.set(cr.min(x1,x2),cr.min(y1,y2),cr.max(x1,x2),cr.max(y1,y2));if(!b.bbox.intersects_rect(tmpRect))
return false;if(!b.bquad.intersects_segment(x1,y1,x2,y2))
return false;haspolyb=(b.collision_poly&&!b.collision_poly.is_empty());if(!haspolyb)
return true;b.collision_poly.cache_poly(b.width,b.height,b.angle);return b.collision_poly.intersects_segment(b.x,b.y,x1,y1,x2,y2);};Runtime.prototype.typeHasBehavior=function(t,b)
{if(!b)
return false;var i,len,j,lenj,f;for(i=0,len=t.behaviors.length;i<len;i++)
{if(t.behaviors[i].behavior instanceof b)
return true;}
if(!t.is_family)
{for(i=0,len=t.families.length;i<len;i++)
{f=t.families[i];for(j=0,lenj=f.behaviors.length;j<lenj;j++)
{if(f.behaviors[j].behavior instanceof b)
return true;}}}
return false;};Runtime.prototype.typeHasNoSaveBehavior=function(t)
{return this.typeHasBehavior(t,cr.behaviors.NoSave);};Runtime.prototype.typeHasPersistBehavior=function(t)
{return this.typeHasBehavior(t,cr.behaviors.Persist);};Runtime.prototype.getSolidBehavior=function()
{if(!cr.behaviors.solid)
return null;var i,len;for(i=0,len=this.behaviors.length;i<len;i++)
{if(this.behaviors[i]instanceof cr.behaviors.solid)
return this.behaviors[i];}
return null;};Runtime.prototype.testOverlapSolid=function(inst)
{var solid=this.getSolidBehavior();if(!solid)
return null;var i,len,s;var solids=solid.my_instances.valuesRef();for(i=0,len=solids.length;i<len;++i)
{s=solids[i];if(!s.extra.solidEnabled)
continue;if(this.testOverlap(inst,s))
return s;}
return null;};Runtime.prototype.testRectOverlapSolid=function(r)
{var solid=this.getSolidBehavior();if(!solid)
return null;var i,len,s;var solids=solid.my_instances.valuesRef();for(i=0,len=solids.length;i<len;++i)
{s=solids[i];if(!s.extra.solidEnabled)
continue;if(this.testRectOverlap(r,s))
return s;}
return null;};var jumpthru_array_ret=[];Runtime.prototype.testOverlapJumpThru=function(inst,all)
{var jumpthru=null;var i,len,s;if(!cr.behaviors.jumpthru)
return null;for(i=0,len=this.behaviors.length;i<len;i++)
{if(this.behaviors[i]instanceof cr.behaviors.jumpthru)
{jumpthru=this.behaviors[i];break;}}
if(!jumpthru)
return null;var ret=null;if(all)
{ret=jumpthru_array_ret;ret.length=0;}
var jumpthrus=jumpthru.my_instances.valuesRef();for(i=0,len=jumpthrus.length;i<len;++i)
{s=jumpthrus[i];if(!s.extra.jumpthruEnabled)
continue;if(this.testOverlap(inst,s))
{if(all)
ret.push(s);else
return s;}}
return ret;};Runtime.prototype.pushOutSolid=function(inst,xdir,ydir,dist,include_jumpthrus,specific_jumpthru)
{var push_dist=dist||50;var oldx=inst.x
var oldy=inst.y;var i;var last_overlapped=null,secondlast_overlapped=null;for(i=0;i<push_dist;i++)
{inst.x=(oldx+(xdir*i));inst.y=(oldy+(ydir*i));inst.set_bbox_changed();if(!this.testOverlap(inst,last_overlapped))
{last_overlapped=this.testOverlapSolid(inst);if(last_overlapped)
secondlast_overlapped=last_overlapped;if(!last_overlapped)
{if(include_jumpthrus)
{if(specific_jumpthru)
last_overlapped=(this.testOverlap(inst,specific_jumpthru)?specific_jumpthru:null);else
last_overlapped=this.testOverlapJumpThru(inst);if(last_overlapped)
secondlast_overlapped=last_overlapped;}
if(!last_overlapped)
{if(secondlast_overlapped)
this.pushInFractional(inst,xdir,ydir,secondlast_overlapped,16);return true;}}}}
inst.x=oldx;inst.y=oldy;inst.set_bbox_changed();return false;};Runtime.prototype.pushOut=function(inst,xdir,ydir,dist,otherinst)
{var push_dist=dist||50;var oldx=inst.x
var oldy=inst.y;var i;for(i=0;i<push_dist;i++)
{inst.x=(oldx+(xdir*i));inst.y=(oldy+(ydir*i));inst.set_bbox_changed();if(!this.testOverlap(inst,otherinst))
return true;}
inst.x=oldx;inst.y=oldy;inst.set_bbox_changed();return false;};Runtime.prototype.pushInFractional=function(inst,xdir,ydir,obj,limit)
{var divisor=2;var frac;var forward=false;var overlapping=false;var bestx=inst.x;var besty=inst.y;while(divisor<=limit)
{frac=1/divisor;divisor*=2;inst.x+=xdir*frac*(forward?1:-1);inst.y+=ydir*frac*(forward?1:-1);inst.set_bbox_changed();if(this.testOverlap(inst,obj))
{forward=true;overlapping=true;}
else
{forward=false;overlapping=false;bestx=inst.x;besty=inst.y;}}
if(overlapping)
{inst.x=bestx;inst.y=besty;inst.set_bbox_changed();}};Runtime.prototype.pushOutSolidNearest=function(inst,max_dist_)
{var max_dist=(cr.is_undefined(max_dist_)?100:max_dist_);var dist=0;var oldx=inst.x
var oldy=inst.y;var dir=0;var dx=0,dy=0;var last_overlapped=this.testOverlapSolid(inst);if(!last_overlapped)
return true;while(dist<=max_dist)
{switch(dir){case 0:dx=0;dy=-1;dist++;break;case 1:dx=1;dy=-1;break;case 2:dx=1;dy=0;break;case 3:dx=1;dy=1;break;case 4:dx=0;dy=1;break;case 5:dx=-1;dy=1;break;case 6:dx=-1;dy=0;break;case 7:dx=-1;dy=-1;break;}
dir=(dir+1)%8;inst.x=cr.floor(oldx+(dx*dist));inst.y=cr.floor(oldy+(dy*dist));inst.set_bbox_changed();if(!this.testOverlap(inst,last_overlapped))
{last_overlapped=this.testOverlapSolid(inst);if(!last_overlapped)
return true;}}
inst.x=oldx;inst.y=oldy;inst.set_bbox_changed();return false;};Runtime.prototype.registerCollision=function(a,b)
{if(!a.collisionsEnabled||!b.collisionsEnabled)
return;this.registered_collisions.push([a,b]);};Runtime.prototype.checkRegisteredCollision=function(a,b)
{var i,len,x;for(i=0,len=this.registered_collisions.length;i<len;i++)
{x=this.registered_collisions[i];if((x[0]==a&&x[1]==b)||(x[0]==b&&x[1]==a))
return true;}
return false;};Runtime.prototype.calculateSolidBounceAngle=function(inst,startx,starty,obj)
{var objx=inst.x;var objy=inst.y;var radius=cr.max(10,cr.distanceTo(startx,starty,objx,objy));var startangle=cr.angleTo(startx,starty,objx,objy);var firstsolid=obj||this.testOverlapSolid(inst);if(!firstsolid)
return cr.clamp_angle(startangle+cr.PI);var cursolid=firstsolid;var i,curangle,anticlockwise_free_angle,clockwise_free_angle;var increment=cr.to_radians(5);for(i=1;i<36;i++)
{curangle=startangle-i*increment;inst.x=startx+Math.cos(curangle)*radius;inst.y=starty+Math.sin(curangle)*radius;inst.set_bbox_changed();if(!this.testOverlap(inst,cursolid))
{cursolid=obj?null:this.testOverlapSolid(inst);if(!cursolid)
{anticlockwise_free_angle=curangle;break;}}}
if(i===36)
anticlockwise_free_angle=cr.clamp_angle(startangle+cr.PI);var cursolid=firstsolid;for(i=1;i<36;i++)
{curangle=startangle+i*increment;inst.x=startx+Math.cos(curangle)*radius;inst.y=starty+Math.sin(curangle)*radius;inst.set_bbox_changed();if(!this.testOverlap(inst,cursolid))
{cursolid=obj?null:this.testOverlapSolid(inst);if(!cursolid)
{clockwise_free_angle=curangle;break;}}}
if(i===36)
clockwise_free_angle=cr.clamp_angle(startangle+cr.PI);inst.x=objx;inst.y=objy;inst.set_bbox_changed();if(clockwise_free_angle===anticlockwise_free_angle)
return clockwise_free_angle;var half_diff=cr.angleDiff(clockwise_free_angle,anticlockwise_free_angle)/2;var normal;if(cr.angleClockwise(clockwise_free_angle,anticlockwise_free_angle))
{normal=cr.clamp_angle(anticlockwise_free_angle+half_diff+cr.PI);}
else
{normal=cr.clamp_angle(clockwise_free_angle+half_diff);};var vx=Math.cos(startangle);var vy=Math.sin(startangle);var nx=Math.cos(normal);var ny=Math.sin(normal);var v_dot_n=vx*nx+vy*ny;var rx=vx-2*v_dot_n*nx;var ry=vy-2*v_dot_n*ny;return cr.angleTo(0,0,rx,ry);};var triggerSheetStack=[];var triggerSheetIndex=-1;Runtime.prototype.trigger=function(method,inst,value)
{;if(!this.running_layout)
return false;var sheet=this.running_layout.event_sheet;if(!sheet)
return false;triggerSheetIndex++;if(triggerSheetIndex===triggerSheetStack.length)
triggerSheetStack.push(new cr.ObjectSet());else
triggerSheetStack[triggerSheetIndex].clear();var ret=this.triggerOnSheet(method,inst,sheet,value);triggerSheetIndex--;return ret;};Runtime.prototype.triggerOnSheet=function(method,inst,sheet,value)
{var alreadyTriggeredSheets=triggerSheetStack[triggerSheetIndex];if(alreadyTriggeredSheets.contains(sheet))
return false;alreadyTriggeredSheets.add(sheet);var includes=sheet.includes.valuesRef();var ret=false;var i,leni,r;for(i=0,leni=includes.length;i<leni;i++)
{if(includes[i].isActive())
{r=this.triggerOnSheet(method,inst,includes[i].include_sheet,value);ret=ret||r;}}
if(!inst)
{r=this.triggerOnSheetForTypeName(method,inst,"system",sheet,value);ret=ret||r;}
else
{r=this.triggerOnSheetForTypeName(method,inst,inst.type.name,sheet,value);ret=ret||r;for(i=0,leni=inst.type.families.length;i<leni;i++)
{r=this.triggerOnSheetForTypeName(method,inst,inst.type.families[i].name,sheet,value);ret=ret||r;}}
return ret;};Runtime.prototype.triggerOnSheetForTypeName=function(method,inst,type_name,sheet,value)
{var i,leni;var ret=false,ret2=false;var trig,index;var fasttrigger=(typeof value!=="undefined");var triggers=(fasttrigger?sheet.fasttriggers:sheet.triggers);var obj_entry=triggers[type_name];if(!obj_entry)
return ret;var triggers_list=null;for(i=0,leni=obj_entry.length;i<leni;i++)
{if(obj_entry[i].method==method)
{triggers_list=obj_entry[i].evs;break;}}
if(!triggers_list)
return ret;var triggers_to_fire;if(fasttrigger)
{triggers_to_fire=triggers_list[value];}
else
{triggers_to_fire=triggers_list;}
if(!triggers_to_fire)
return null;for(i=0,leni=triggers_to_fire.length;i<leni;i++)
{trig=triggers_to_fire[i][0];index=triggers_to_fire[i][1];ret2=this.executeSingleTrigger(inst,type_name,trig,index);ret=ret||ret2;}
return ret;};Runtime.prototype.executeSingleTrigger=function(inst,type_name,trig,index)
{var i,leni;var ret=false;this.trigger_depth++;var current_event=this.getCurrentEventStack().current_event;if(current_event)
this.pushCleanSol(current_event.solModifiersIncludingParents);var isrecursive=(this.trigger_depth>1);this.pushCleanSol(trig.solModifiersIncludingParents);if(isrecursive)
this.pushLocalVarStack();var event_stack=this.pushEventStack(trig);event_stack.current_event=trig;if(inst)
{var sol=this.types[type_name].getCurrentSol();sol.select_all=false;sol.instances.length=1;sol.instances[0]=inst;this.types[type_name].applySolToContainer();}
var ok_to_run=true;if(trig.parent)
{var temp_parents_arr=event_stack.temp_parents_arr;var cur_parent=trig.parent;while(cur_parent)
{temp_parents_arr.push(cur_parent);cur_parent=cur_parent.parent;}
temp_parents_arr.reverse();for(i=0,leni=temp_parents_arr.length;i<leni;i++)
{if(!temp_parents_arr[i].run_pretrigger())
{ok_to_run=false;break;}}}
if(ok_to_run)
{this.execcount++;if(trig.orblock)
trig.run_orblocktrigger(index);else
trig.run();ret=ret||event_stack.last_event_true;}
this.popEventStack();if(isrecursive)
this.popLocalVarStack();this.popSol(trig.solModifiersIncludingParents);if(current_event)
this.popSol(current_event.solModifiersIncludingParents);if(this.isInOnDestroy===0&&triggerSheetIndex===0&&!this.isRunningEvents&&(!this.deathRow.isEmpty()||this.createRow.length))
{this.ClearDeathRow();}
this.trigger_depth--;return ret;};Runtime.prototype.getCurrentCondition=function()
{var evinfo=this.getCurrentEventStack();return evinfo.current_event.conditions[evinfo.cndindex];};Runtime.prototype.getCurrentAction=function()
{var evinfo=this.getCurrentEventStack();return evinfo.current_event.actions[evinfo.actindex];};Runtime.prototype.pushLocalVarStack=function()
{this.localvar_stack_index++;if(this.localvar_stack_index>=this.localvar_stack.length)
this.localvar_stack.push([]);};Runtime.prototype.popLocalVarStack=function()
{;this.localvar_stack_index--;};Runtime.prototype.getCurrentLocalVarStack=function()
{return this.localvar_stack[this.localvar_stack_index];};Runtime.prototype.pushEventStack=function(cur_event)
{this.event_stack_index++;if(this.event_stack_index>=this.event_stack.length)
this.event_stack.push(new cr.eventStackFrame());var ret=this.getCurrentEventStack();ret.reset(cur_event);return ret;};Runtime.prototype.popEventStack=function()
{;this.event_stack_index--;};Runtime.prototype.getCurrentEventStack=function()
{return this.event_stack[this.event_stack_index];};Runtime.prototype.pushLoopStack=function(name_)
{this.loop_stack_index++;if(this.loop_stack_index>=this.loop_stack.length)
{this.loop_stack.push(cr.seal({name:name_,index:0,stopped:false}));}
var ret=this.getCurrentLoop();ret.name=name_;ret.index=0;ret.stopped=false;return ret;};Runtime.prototype.popLoopStack=function()
{;this.loop_stack_index--;};Runtime.prototype.getCurrentLoop=function()
{return this.loop_stack[this.loop_stack_index];};Runtime.prototype.getEventVariableByName=function(name,scope)
{var i,leni,j,lenj,sheet,e;while(scope)
{for(i=0,leni=scope.subevents.length;i<leni;i++)
{e=scope.subevents[i];if(e instanceof cr.eventvariable&&cr.equals_nocase(name,e.name))
return e;}
scope=scope.parent;}
for(i=0,leni=this.eventsheets_by_index.length;i<leni;i++)
{sheet=this.eventsheets_by_index[i];for(j=0,lenj=sheet.events.length;j<lenj;j++)
{e=sheet.events[j];if(e instanceof cr.eventvariable&&cr.equals_nocase(name,e.name))
return e;}}
return null;};Runtime.prototype.getLayoutBySid=function(sid_)
{var i,len;for(i=0,len=this.layouts_by_index.length;i<len;i++)
{if(this.layouts_by_index[i].sid===sid_)
return this.layouts_by_index[i];}
return null;};Runtime.prototype.getObjectTypeBySid=function(sid_)
{var i,len;for(i=0,len=this.types_by_index.length;i<len;i++)
{if(this.types_by_index[i].sid===sid_)
return this.types_by_index[i];}
return null;};Runtime.prototype.getGroupBySid=function(sid_)
{var i,len;for(i=0,len=this.allGroups.length;i<len;i++)
{if(this.allGroups[i].sid===sid_)
return this.allGroups[i];}
return null;};function makeSaveDb(e)
{var db=e.target.result;db.createObjectStore("saves",{keyPath:"slot"});};function IndexedDB_WriteSlot(slot_,data_,oncomplete_,onerror_)
{var request=indexedDB.open("_C2SaveStates");request.onupgradeneeded=makeSaveDb;request.onerror=onerror_;request.onsuccess=function(e)
{var db=e.target.result;db.onerror=onerror_;var transaction=db.transaction(["saves"],"readwrite");var objectStore=transaction.objectStore("saves");var putReq=objectStore.put({"slot":slot_,"data":data_});putReq.onsuccess=oncomplete_;};};function IndexedDB_ReadSlot(slot_,oncomplete_,onerror_)
{var request=indexedDB.open("_C2SaveStates");request.onupgradeneeded=makeSaveDb;request.onerror=onerror_;request.onsuccess=function(e)
{var db=e.target.result;db.onerror=onerror_;var transaction=db.transaction(["saves"]);var objectStore=transaction.objectStore("saves");var readReq=objectStore.get(slot_);readReq.onsuccess=function(e)
{if(readReq.result)
oncomplete_(readReq.result["data"]);else
oncomplete_(null);};};};Runtime.prototype.signalContinuousPreview=function()
{this.signalledContinuousPreview=true;};function doContinuousPreviewReload()
{cr.logexport("Reloading for continuous preview");if(!!window["c2cocoonjs"])
{CocoonJS["App"]["reload"]();}
else
{if(window.location.search.indexOf("continuous")>-1)
window.location.reload(true);else
window.location=window.location+"?continuous";}};Runtime.prototype.handleSaveLoad=function()
{var self=this;var savingToSlot=this.saveToSlot;var savingJson=this.lastSaveJson;var loadingFromSlot=this.loadFromSlot;var continuous=false;if(this.signalledContinuousPreview)
{continuous=true;savingToSlot="__c2_continuouspreview";this.signalledContinuousPreview=false;}
if(savingToSlot.length)
{this.ClearDeathRow();savingJson=this.saveToJSONString();if(window.indexedDB&&!this.isCocoonJs)
{IndexedDB_WriteSlot(savingToSlot,savingJson,function()
{cr.logexport("Saved state to IndexedDB storage ("+savingJson.length+" bytes)");self.lastSaveJson=savingJson;self.trigger(cr.system_object.prototype.cnds.OnSaveComplete,null);self.lastSaveJson="";if(continuous)
doContinuousPreviewReload();},function(e)
{try{localStorage.setItem("__c2save_"+savingToSlot,savingJson);cr.logexport("Saved state to WebStorage ("+savingJson.length+" bytes)");self.lastSaveJson=savingJson;self.trigger(cr.system_object.prototype.cnds.OnSaveComplete,null);self.lastSaveJson="";if(continuous)
doContinuousPreviewReload();}
catch(f)
{cr.logexport("Failed to save game state: "+e+"; "+f);}});}
else
{try{localStorage.setItem("__c2save_"+savingToSlot,savingJson);cr.logexport("Saved state to WebStorage ("+savingJson.length+" bytes)");self.lastSaveJson=savingJson;this.trigger(cr.system_object.prototype.cnds.OnSaveComplete,null);self.lastSaveJson="";if(continuous)
doContinuousPreviewReload();}
catch(e)
{cr.logexport("Error saving to WebStorage: "+e);}}
this.saveToSlot="";this.loadFromSlot="";this.loadFromJson="";}
if(loadingFromSlot.length)
{if(window.indexedDB&&!this.isCocoonJs)
{IndexedDB_ReadSlot(loadingFromSlot,function(result_)
{if(result_)
{self.loadFromJson=result_;cr.logexport("Loaded state from IndexedDB storage ("+self.loadFromJson.length+" bytes)");}
else
{self.loadFromJson=localStorage.getItem("__c2save_"+loadingFromSlot)||"";cr.logexport("Loaded state from WebStorage ("+self.loadFromJson.length+" bytes)");}
self.suspendDrawing=false;if(!self.loadFromJson.length)
self.trigger(cr.system_object.prototype.cnds.OnLoadFailed,null);},function(e)
{self.loadFromJson=localStorage.getItem("__c2save_"+loadingFromSlot)||"";cr.logexport("Loaded state from WebStorage ("+self.loadFromJson.length+" bytes)");self.suspendDrawing=false;if(!self.loadFromJson.length)
self.trigger(cr.system_object.prototype.cnds.OnLoadFailed,null);});}
else
{this.loadFromJson=localStorage.getItem("__c2save_"+loadingFromSlot)||"";cr.logexport("Loaded state from WebStorage ("+this.loadFromJson.length+" bytes)");this.suspendDrawing=false;if(!self.loadFromJson.length)
self.trigger(cr.system_object.prototype.cnds.OnLoadFailed,null);}
this.loadFromSlot="";this.saveToSlot="";}
if(this.loadFromJson.length)
{this.ClearDeathRow();this.loadFromJSONString(this.loadFromJson);this.lastSaveJson=this.loadFromJson;this.trigger(cr.system_object.prototype.cnds.OnLoadComplete,null);this.lastSaveJson="";this.loadFromJson="";}};function CopyExtraObject(extra)
{var p,ret={};for(p in extra)
{if(extra.hasOwnProperty(p))
{if(extra[p]instanceof cr.ObjectSet)
continue;if(typeof extra[p].c2userdata!=="undefined")
continue;ret[p]=extra[p];}}
return ret;};Runtime.prototype.saveToJSONString=function()
{var i,len,j,lenj,type,layout,typeobj,g,c,a,v,p;var o={"c2save":true,"version":1,"rt":{"time":this.kahanTime.sum,"timescale":this.timescale,"tickcount":this.tickcount,"execcount":this.execcount,"next_uid":this.next_uid,"running_layout":this.running_layout.sid,"start_time_offset":(Date.now()-this.start_time)},"types":{},"layouts":{},"events":{"groups":{},"cnds":{},"acts":{},"vars":{}}};for(i=0,len=this.types_by_index.length;i<len;i++)
{type=this.types_by_index[i];if(type.is_family||this.typeHasNoSaveBehavior(type))
continue;typeobj={"instances":[]};if(cr.hasAnyOwnProperty(type.extra))
typeobj["ex"]=CopyExtraObject(type.extra);for(j=0,lenj=type.instances.length;j<lenj;j++)
{typeobj["instances"].push(this.saveInstanceToJSON(type.instances[j]));}
o["types"][type.sid.toString()]=typeobj;}
for(i=0,len=this.layouts_by_index.length;i<len;i++)
{layout=this.layouts_by_index[i];o["layouts"][layout.sid.toString()]=layout.saveToJSON();}
var ogroups=o["events"]["groups"];for(i=0,len=this.allGroups.length;i<len;i++)
{g=this.allGroups[i];ogroups[g.sid.toString()]=!!this.activeGroups[g.group_name];}
var ocnds=o["events"]["cnds"];for(p in this.cndsBySid)
{if(this.cndsBySid.hasOwnProperty(p))
{c=this.cndsBySid[p];if(cr.hasAnyOwnProperty(c.extra))
ocnds[p]={"ex":CopyExtraObject(c.extra)};}}
var oacts=o["events"]["acts"];for(p in this.actsBySid)
{if(this.actsBySid.hasOwnProperty(p))
{a=this.actsBySid[p];if(cr.hasAnyOwnProperty(a.extra))
oacts[p]={"ex":a.extra};}}
var ovars=o["events"]["vars"];for(p in this.varsBySid)
{if(this.varsBySid.hasOwnProperty(p))
{v=this.varsBySid[p];if(!v.is_constant&&(!v.parent||v.is_static))
ovars[p]=v.data;}}
o["system"]=this.system.saveToJSON();return JSON.stringify(o);};Runtime.prototype.refreshUidMap=function()
{var i,len,type,j,lenj,inst;this.objectsByUid={};for(i=0,len=this.types_by_index.length;i<len;i++)
{type=this.types_by_index[i];if(type.is_family)
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
{inst=type.instances[j];this.objectsByUid[inst.uid.toString()]=inst;}}};Runtime.prototype.loadFromJSONString=function(str)
{var o=JSON.parse(str);if(!o["c2save"])
return;if(o["version"]>1)
return;var rt=o["rt"];this.kahanTime.reset();this.kahanTime.sum=rt["time"];this.timescale=rt["timescale"];this.tickcount=rt["tickcount"];this.execcount=rt["execcount"];this.start_time=Date.now()-rt["start_time_offset"];var layout_sid=rt["running_layout"];if(layout_sid!==this.running_layout.sid)
{var changeToLayout=this.getLayoutBySid(layout_sid);if(changeToLayout)
this.doChangeLayout(changeToLayout);else
return;}
this.isLoadingState=true;var i,len,j,lenj,k,lenk,p,type,existing_insts,load_insts,inst,binst,layout,layer,g,iid,t;var otypes=o["types"];for(p in otypes)
{if(otypes.hasOwnProperty(p))
{type=this.getObjectTypeBySid(parseInt(p,10));if(!type||type.is_family||this.typeHasNoSaveBehavior(type))
continue;if(otypes[p]["ex"])
type.extra=otypes[p]["ex"];else
cr.wipe(type.extra);existing_insts=type.instances;load_insts=otypes[p]["instances"];for(i=0,len=cr.min(existing_insts.length,load_insts.length);i<len;i++)
{this.loadInstanceFromJSON(existing_insts[i],load_insts[i]);}
for(i=load_insts.length,len=existing_insts.length;i<len;i++)
this.DestroyInstance(existing_insts[i]);for(i=existing_insts.length,len=load_insts.length;i<len;i++)
{layer=null;if(type.plugin.is_world)
{layer=this.running_layout.getLayerBySid(load_insts[i]["w"]["l"]);if(!layer)
continue;}
inst=this.createInstanceFromInit(type.default_instance,layer,false,0,0,true);this.loadInstanceFromJSON(inst,load_insts[i]);}
type.stale_iids=true;}}
this.ClearDeathRow();this.refreshUidMap();var olayouts=o["layouts"];for(p in olayouts)
{if(olayouts.hasOwnProperty(p))
{layout=this.getLayoutBySid(parseInt(p,10));if(!layout)
continue;layout.loadFromJSON(olayouts[p]);}}
var ogroups=o["events"]["groups"];for(p in ogroups)
{if(ogroups.hasOwnProperty(p))
{g=this.getGroupBySid(parseInt(p,10));if(g)
this.activeGroups[g.group_name]=ogroups[p];}}
var ocnds=o["events"]["cnds"];for(p in ocnds)
{if(ocnds.hasOwnProperty(p)&&this.cndsBySid.hasOwnProperty(p))
{this.cndsBySid[p].extra=ocnds[p]["ex"];}}
var oacts=o["events"]["acts"];for(p in oacts)
{if(oacts.hasOwnProperty(p)&&this.actsBySid.hasOwnProperty(p))
{this.actsBySid[p].extra=oacts[p]["ex"];}}
var ovars=o["events"]["vars"];for(p in ovars)
{if(ovars.hasOwnProperty(p)&&this.varsBySid.hasOwnProperty(p))
{this.varsBySid[p].data=ovars[p];}}
this.next_uid=rt["next_uid"];this.isLoadingState=false;this.system.loadFromJSON(o["system"]);for(i=0,len=this.types_by_index.length;i<len;i++)
{type=this.types_by_index[i];if(type.is_family)
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
{inst=type.instances[j];if(type.is_contained)
{iid=inst.get_iid();inst.siblings.length=0;for(k=0,lenk=type.container.length;k<lenk;k++)
{t=type.container[k];if(type===t)
continue;;inst.siblings.push(t.instances[iid]);}}
if(inst.afterLoad)
inst.afterLoad();if(inst.behavior_insts)
{for(k=0,lenk=inst.behavior_insts.length;k<lenk;k++)
{binst=inst.behavior_insts[k];if(binst.afterLoad)
binst.afterLoad();}}}}
this.redraw=true;};Runtime.prototype.saveInstanceToJSON=function(inst)
{var i,len,world,behinst,et;var type=inst.type;var plugin=type.plugin;var o={"uid":inst.uid};if(cr.hasAnyOwnProperty(inst.extra))
o["ex"]=CopyExtraObject(inst.extra);if(inst.instance_vars&&inst.instance_vars.length)
{o["ivs"]={};for(i=0,len=inst.instance_vars.length;i<len;i++)
{o["ivs"][inst.type.instvar_sids[i].toString()]=inst.instance_vars[i];}}
if(plugin.is_world)
{world={"x":inst.x,"y":inst.y,"w":inst.width,"h":inst.height,"l":inst.layer.sid,"zi":inst.get_zindex()};if(inst.angle!==0)
world["a"]=inst.angle;if(inst.opacity!==1)
world["o"]=inst.opacity;if(inst.hotspotX!==0.5)
world["hX"]=inst.hotspotX;if(inst.hotspotY!==0.5)
world["hY"]=inst.hotspotY;if(inst.blend_mode!==0)
world["bm"]=inst.blend_mode;if(!inst.visible)
world["v"]=inst.visible;if(!inst.collisionsEnabled)
world["ce"]=inst.collisionsEnabled;if(inst.my_timescale!==-1)
world["mts"]=inst.my_timescale;if(type.effect_types.length)
{world["fx"]=[];for(i=0,len=type.effect_types.length;i<len;i++)
{et=type.effect_types[i];world["fx"].push({"name":et.name,"active":inst.active_effect_flags[et.index],"params":inst.effect_params[et.index]});}}
o["w"]=world;}
if(inst.behavior_insts&&inst.behavior_insts.length)
{o["behs"]={};for(i=0,len=inst.behavior_insts.length;i<len;i++)
{behinst=inst.behavior_insts[i];if(behinst.saveToJSON)
o["behs"][behinst.type.sid.toString()]=behinst.saveToJSON();}}
if(inst.saveToJSON)
o["data"]=inst.saveToJSON();return o;};Runtime.prototype.getInstanceVarIndexBySid=function(type,sid_)
{var i,len;for(i=0,len=type.instvar_sids.length;i<len;i++)
{if(type.instvar_sids[i]===sid_)
return i;}
return-1;};Runtime.prototype.getBehaviorIndexBySid=function(inst,sid_)
{var i,len;for(i=0,len=inst.behavior_insts.length;i<len;i++)
{if(inst.behavior_insts[i].type.sid===sid_)
return i;}
return-1;};Runtime.prototype.loadInstanceFromJSON=function(inst,o)
{var p,i,len,iv,oivs,world,fxindex,obehs,behindex;var oldlayer;var type=inst.type;var plugin=type.plugin;inst.uid=o["uid"];if(o["ex"])
inst.extra=o["ex"];else
cr.wipe(inst.extra);oivs=o["ivs"];if(oivs)
{for(p in oivs)
{if(oivs.hasOwnProperty(p))
{iv=this.getInstanceVarIndexBySid(type,parseInt(p,10));if(iv<0||iv>=inst.instance_vars.length)
continue;inst.instance_vars[iv]=oivs[p];}}}
if(plugin.is_world)
{world=o["w"];if(inst.layer.sid!==world["l"])
{oldlayer=inst.layer;inst.layer=this.running_layout.getLayerBySid(world["l"]);if(inst.layer)
{inst.layer.instances.push(inst);inst.layer.zindices_stale=true;cr.arrayFindRemove(oldlayer.instances,inst);oldlayer.zindices_stale=true;}
else
{inst.layer=oldlayer;this.DestroyInstance(inst);}}
inst.x=world["x"];inst.y=world["y"];inst.width=world["w"];inst.height=world["h"];inst.zindex=world["zi"];inst.angle=world.hasOwnProperty("a")?world["a"]:0;inst.opacity=world.hasOwnProperty("o")?world["o"]:1;inst.hotspotX=world.hasOwnProperty("hX")?world["hX"]:0.5;inst.hotspotY=world.hasOwnProperty("hY")?world["hY"]:0.5;inst.visible=world.hasOwnProperty("v")?world["v"]:true;inst.collisionsEnabled=world.hasOwnProperty("ce")?world["ce"]:true;inst.my_timescale=world.hasOwnProperty("mts")?world["mts"]:-1;inst.blend_mode=world.hasOwnProperty("bm")?world["bm"]:0;;inst.compositeOp=cr.effectToCompositeOp(inst.blend_mode);if(this.gl)
cr.setGLBlend(inst,inst.blend_mode,this.gl);inst.set_bbox_changed();if(world.hasOwnProperty("fx"))
{for(i=0,len=world["fx"].length;i<len;i++)
{fxindex=type.getEffectIndexByName(world["fx"][i]["name"]);if(fxindex<0)
continue;inst.active_effect_flags[fxindex]=world["fx"][i]["active"];inst.effect_params[fxindex]=world["fx"][i]["params"];}}
inst.updateActiveEffects();}
obehs=o["behs"];if(obehs)
{for(p in obehs)
{if(obehs.hasOwnProperty(p))
{behindex=this.getBehaviorIndexBySid(inst,parseInt(p,10));if(behindex<0)
continue;inst.behavior_insts[behindex].loadFromJSON(obehs[p]);}}}
if(o["data"])
inst.loadFromJSON(o["data"]);};cr.runtime=Runtime;cr.createRuntime=function(canvasid)
{return new Runtime(document.getElementById(canvasid));};cr.createDCRuntime=function(w,h)
{return new Runtime({"dc":true,"width":w,"height":h});};window["cr_createRuntime"]=cr.createRuntime;window["cr_createDCRuntime"]=cr.createDCRuntime;window["createCocoonJSRuntime"]=function()
{window["c2cocoonjs"]=true;var canvas=document.createElement("screencanvas")||document.createElement("canvas");document.body.appendChild(canvas);var rt=new Runtime(canvas);window["c2runtime"]=rt;window.addEventListener("orientationchange",function(){window["c2runtime"]["setSize"](window.innerWidth,window.innerHeight);});window["c2runtime"]["setSize"](window.innerWidth,window.innerHeight);return rt;};}());window["cr_getC2Runtime"]=function()
{var canvas=document.getElementById("c2canvas");if(canvas)
return canvas["c2runtime"];else if(window["c2runtime"])
return window["c2runtime"];else
return null;}
window["cr_sizeCanvas"]=function(w,h)
{if(w===0||h===0)
return;var runtime=window["cr_getC2Runtime"]();if(runtime)
runtime["setSize"](w,h);}
window["cr_setSuspended"]=function(s)
{var runtime=window["cr_getC2Runtime"]();if(runtime)
runtime["setSuspended"](s);};(function()
{function Layout(runtime,m)
{this.runtime=runtime;this.event_sheet=null;this.scrollX=(this.runtime.original_width/2);this.scrollY=(this.runtime.original_height/2);this.scale=1.0;this.angle=0;this.first_visit=true;this.name=m[0];this.width=m[1];this.height=m[2];this.unbounded_scrolling=m[3];this.sheetname=m[4];this.sid=m[5];var lm=m[6];var i,len;this.layers=[];this.initial_types=[];for(i=0,len=lm.length;i<len;i++)
{var layer=new cr.layer(this,lm[i]);layer.number=i;cr.seal(layer);this.layers.push(layer);}
var im=m[7];this.initial_nonworld=[];for(i=0,len=im.length;i<len;i++)
{var inst=im[i];var type=this.runtime.types_by_index[inst[1]];;if(!type.default_instance)
type.default_instance=inst;this.initial_nonworld.push(inst);if(this.initial_types.indexOf(type)===-1)
this.initial_types.push(type);}
this.effect_types=[];this.active_effect_types=[];this.effect_params=[];for(i=0,len=m[8].length;i<len;i++)
{this.effect_types.push({id:m[8][i][0],name:m[8][i][1],shaderindex:-1,active:true,index:i});this.effect_params.push(m[8][i][2].slice(0));}
this.updateActiveEffects();this.rcTex=new cr.rect(0,0,1,1);this.rcTex2=new cr.rect(0,0,1,1);this.persist_data={};};Layout.prototype.saveObjectToPersist=function(inst)
{var sidStr=inst.type.sid.toString();if(!this.persist_data.hasOwnProperty(sidStr))
this.persist_data[sidStr]=[];var type_persist=this.persist_data[sidStr];type_persist.push(this.runtime.saveInstanceToJSON(inst));};Layout.prototype.hasOpaqueBottomLayer=function()
{var layer=this.layers[0];return!layer.transparent&&layer.opacity===1.0&&!layer.forceOwnTexture&&layer.visible;};Layout.prototype.updateActiveEffects=function()
{this.active_effect_types.length=0;var i,len,et;for(i=0,len=this.effect_types.length;i<len;i++)
{et=this.effect_types[i];if(et.active)
this.active_effect_types.push(et);}};Layout.prototype.getEffectByName=function(name_)
{var i,len,et;for(i=0,len=this.effect_types.length;i<len;i++)
{et=this.effect_types[i];if(et.name===name_)
return et;}
return null;};var created_instances=[];Layout.prototype.startRunning=function()
{if(this.sheetname)
{this.event_sheet=this.runtime.eventsheets[this.sheetname];;}
this.runtime.running_layout=this;this.scrollX=(this.runtime.original_width/2);this.scrollY=(this.runtime.original_height/2);var i,k,len,lenk,type,type_instances,inst,iid,t,s,p,q,type_data,layer;for(i=0,len=this.runtime.types_by_index.length;i<len;i++)
{type=this.runtime.types_by_index[i];if(type.is_family)
continue;type_instances=type.instances;for(k=0,lenk=type_instances.length;k<lenk;k++)
{inst=type_instances[k];if(inst.layer)
{var num=inst.layer.number;if(num>=this.layers.length)
num=this.layers.length-1;inst.layer=this.layers[num];inst.layer.instances.push(inst);inst.layer.zindices_stale=true;}}}
var layer;created_instances.length=0;this.boundScrolling();for(i=0,len=this.layers.length;i<len;i++)
{layer=this.layers[i];layer.createInitialInstances();layer.disableAngle=true;var px=layer.canvasToLayer(0,0,true);var py=layer.canvasToLayer(0,0,false);layer.disableAngle=false;if(this.runtime.pixel_rounding)
{px=(px+0.5)|0;py=(py+0.5)|0;}
layer.rotateViewport(px,py,null);}
var uids_changed=false;if(!this.first_visit)
{for(p in this.persist_data)
{if(this.persist_data.hasOwnProperty(p))
{type=this.runtime.getObjectTypeBySid(parseInt(p,10));if(!type||type.is_family||!this.runtime.typeHasPersistBehavior(type))
continue;type_data=this.persist_data[p];for(i=0,len=type_data.length;i<len;i++)
{layer=null;if(type.plugin.is_world)
{layer=this.getLayerBySid(type_data[i]["w"]["l"]);if(!layer)
continue;}
inst=this.runtime.createInstanceFromInit(type.default_instance,layer,false,0,0,true);this.runtime.loadInstanceFromJSON(inst,type_data[i]);uids_changed=true;created_instances.push(inst);}
type_data.length=0;}}
for(i=0,len=this.layers.length;i<len;i++)
{this.layers[i].instances.sort(sortInstanceByZIndex);this.layers[i].zindices_stale=true;}}
if(uids_changed)
{this.runtime.ClearDeathRow();this.runtime.refreshUidMap();}
for(i=0;i<created_instances.length;i++)
{inst=created_instances[i];if(!inst.type.is_contained)
continue;iid=inst.get_iid();for(k=0,lenk=inst.type.container.length;k<lenk;k++)
{t=inst.type.container[k];if(inst.type===t)
continue;if(t.instances.length>iid)
inst.siblings.push(t.instances[iid]);else
{if(!t.default_instance)
{}
else
{s=this.runtime.createInstanceFromInit(t.default_instance,inst.layer,true,inst.x,inst.y,true);this.runtime.ClearDeathRow();t.updateIIDs();inst.siblings.push(s);created_instances.push(s);}}}}
for(i=0,len=this.initial_nonworld.length;i<len;i++)
{inst=this.runtime.createInstanceFromInit(this.initial_nonworld[i],null,true);;}
this.runtime.changelayout=null;this.runtime.ClearDeathRow();if(this.runtime.ctx&&!this.runtime.isDomFree)
{for(i=0,len=this.runtime.types_by_index.length;i<len;i++)
{t=this.runtime.types_by_index[i];if(t.is_family||!t.instances.length||!t.preloadCanvas2D)
continue;t.preloadCanvas2D(this.runtime.ctx);}}
for(i=0,len=created_instances.length;i<len;i++)
{inst=created_instances[i];this.runtime.trigger(Object.getPrototypeOf(inst.type.plugin).cnds.OnCreated,inst);}
created_instances.length=0;this.runtime.trigger(cr.system_object.prototype.cnds.OnLayoutStart,null);this.first_visit=false;};Layout.prototype.createGlobalNonWorlds=function()
{var i,k,len,initial_inst,inst,type;for(i=0,k=0,len=this.initial_nonworld.length;i<len;i++)
{initial_inst=this.initial_nonworld[i];type=this.runtime.types_by_index[initial_inst[1]];if(type.global)
inst=this.runtime.createInstanceFromInit(initial_inst,null,true);else
{this.initial_nonworld[k]=initial_inst;k++;}}
this.initial_nonworld.length=k;};Layout.prototype.stopRunning=function()
{;this.runtime.trigger(cr.system_object.prototype.cnds.OnLayoutEnd,null);this.runtime.system.waits.length=0;var i,leni,j,lenj;var layer_instances,inst,type;for(i=0,leni=this.layers.length;i<leni;i++)
{layer_instances=this.layers[i].instances;for(j=0,lenj=layer_instances.length;j<lenj;j++)
{inst=layer_instances[j];if(!inst.type.global)
{if(this.runtime.typeHasPersistBehavior(inst.type))
this.saveObjectToPersist(inst);this.runtime.DestroyInstance(inst);}}
this.runtime.ClearDeathRow();layer_instances.length=0;this.layers[i].zindices_stale=true;}
for(i=0,leni=this.runtime.types_by_index.length;i<leni;i++)
{type=this.runtime.types_by_index[i];if(type.global||type.plugin.is_world||type.plugin.singleglobal||type.is_family)
continue;for(j=0,lenj=type.instances.length;j<lenj;j++)
this.runtime.DestroyInstance(type.instances[j]);this.runtime.ClearDeathRow();}};Layout.prototype.draw=function(ctx)
{ctx.globalAlpha=1;ctx.globalCompositeOperation="source-over";if(this.runtime.clearBackground&&!this.hasOpaqueBottomLayer())
ctx.clearRect(0,0,this.runtime.width,this.runtime.height);var i,len,l;for(i=0,len=this.layers.length;i<len;i++)
{l=this.layers[i];if(l.visible&&l.opacity>0&&l.blend_mode!==11)
l.draw(ctx);}};Layout.prototype.drawGL=function(glw)
{var render_to_texture=(this.active_effect_types.length>0||this.runtime.uses_background_blending);if(render_to_texture)
{if(!this.runtime.layout_tex)
{this.runtime.layout_tex=glw.createEmptyTexture(this.runtime.width,this.runtime.height,this.runtime.linearSampling);}
if(this.runtime.layout_tex.c2width!==this.runtime.width||this.runtime.layout_tex.c2height!==this.runtime.height)
{glw.deleteTexture(this.runtime.layout_tex);this.runtime.layout_tex=glw.createEmptyTexture(this.runtime.width,this.runtime.height,this.runtime.linearSampling);}
glw.setRenderingToTexture(this.runtime.layout_tex);}
if(this.runtime.clearBackground&&!this.hasOpaqueBottomLayer())
glw.clear(0,0,0,0);var i,len;for(i=0,len=this.layers.length;i<len;i++)
{if(this.layers[i].visible&&this.layers[i].opacity>0)
this.layers[i].drawGL(glw);}
if(render_to_texture)
{if(this.active_effect_types.length<=1)
{if(this.active_effect_types.length===1)
{var etindex=this.active_effect_types[0].index;glw.switchProgram(this.active_effect_types[0].shaderindex);glw.setProgramParameters(null,1.0/this.runtime.width,1.0/this.runtime.height,0.0,0.0,1.0,1.0,this.scale,this.effect_params[etindex]);if(glw.programIsAnimated(this.active_effect_types[0].shaderindex))
this.runtime.redraw=true;}
else
glw.switchProgram(0);glw.setRenderingToTexture(null);glw.setOpacity(1);glw.setTexture(this.runtime.layout_tex);glw.setAlphaBlend();glw.resetModelView();glw.updateModelView();var halfw=this.runtime.width/2;var halfh=this.runtime.height/2;glw.quad(-halfw,halfh,halfw,halfh,halfw,-halfh,-halfw,-halfh);glw.setTexture(null);}
else
{this.renderEffectChain(glw,null,null,null);}}};Layout.prototype.getRenderTarget=function()
{return(this.active_effect_types.length>0||this.runtime.uses_background_blending)?this.runtime.layout_tex:null;};Layout.prototype.getMinLayerScale=function()
{var m=this.layers[0].getScale();var i,len,l;for(i=1,len=this.layers.length;i<len;i++)
{l=this.layers[i];if(l.parallaxX===0&&l.parallaxY===0)
continue;if(l.getScale()<m)
m=l.getScale();}
return m;};Layout.prototype.scrollToX=function(x)
{if(!this.unbounded_scrolling)
{var widthBoundary=(this.runtime.width*(1/this.getMinLayerScale())/2);if(x>this.width-widthBoundary)
x=this.width-widthBoundary;if(x<widthBoundary)
x=widthBoundary;}
if(this.scrollX!==x)
{this.scrollX=x;this.runtime.redraw=true;}};Layout.prototype.scrollToY=function(y)
{if(!this.unbounded_scrolling)
{var heightBoundary=(this.runtime.height*(1/this.getMinLayerScale())/2);if(y>this.height-heightBoundary)
y=this.height-heightBoundary;if(y<heightBoundary)
y=heightBoundary;}
if(this.scrollY!==y)
{this.scrollY=y;this.runtime.redraw=true;}};Layout.prototype.boundScrolling=function()
{this.scrollToX(this.scrollX);this.scrollToY(this.scrollY);};Layout.prototype.renderEffectChain=function(glw,layer,inst,rendertarget)
{var active_effect_types=inst?inst.active_effect_types:layer?layer.active_effect_types:this.active_effect_types;var layerScale=inst?inst.layer.getScale():layer?layer.getScale():1;var fx_tex=this.runtime.fx_tex;var i,len,last,temp,fx_index=0,other_fx_index=1;var y,h;var windowWidth=this.runtime.width;var windowHeight=this.runtime.height;var halfw=windowWidth/2;var halfh=windowHeight/2;var rcTex=layer?layer.rcTex:this.rcTex;var rcTex2=layer?layer.rcTex2:this.rcTex2;var screenleft=0,clearleft=0;var screentop=0,cleartop=0;var screenright=windowWidth,clearright=windowWidth;var screenbottom=windowHeight,clearbottom=windowHeight;var boxExtendHorizontal=0;var boxExtendVertical=0;var inst_layer_angle=inst?inst.layer.getAngle():0;if(inst)
{for(i=0,len=active_effect_types.length;i<len;i++)
{boxExtendHorizontal+=glw.getProgramBoxExtendHorizontal(active_effect_types[i].shaderindex);boxExtendVertical+=glw.getProgramBoxExtendVertical(active_effect_types[i].shaderindex);}
var bbox=inst.bbox;screenleft=layer.layerToCanvas(bbox.left,bbox.top,true);screentop=layer.layerToCanvas(bbox.left,bbox.top,false);screenright=layer.layerToCanvas(bbox.right,bbox.bottom,true);screenbottom=layer.layerToCanvas(bbox.right,bbox.bottom,false);if(inst_layer_angle!==0)
{var screentrx=layer.layerToCanvas(bbox.right,bbox.top,true);var screentry=layer.layerToCanvas(bbox.right,bbox.top,false);var screenblx=layer.layerToCanvas(bbox.left,bbox.bottom,true);var screenbly=layer.layerToCanvas(bbox.left,bbox.bottom,false);temp=Math.min(screenleft,screenright,screentrx,screenblx);screenright=Math.max(screenleft,screenright,screentrx,screenblx);screenleft=temp;temp=Math.min(screentop,screenbottom,screentry,screenbly);screenbottom=Math.max(screentop,screenbottom,screentry,screenbly);screentop=temp;}
screenleft-=boxExtendHorizontal;screentop-=boxExtendVertical;screenright+=boxExtendHorizontal;screenbottom+=boxExtendVertical;rcTex2.left=screenleft/windowWidth;rcTex2.top=1-screentop/windowHeight;rcTex2.right=screenright/windowWidth;rcTex2.bottom=1-screenbottom/windowHeight;clearleft=screenleft=Math.floor(screenleft);cleartop=screentop=Math.floor(screentop);clearright=screenright=Math.ceil(screenright);clearbottom=screenbottom=Math.ceil(screenbottom);clearleft-=boxExtendHorizontal;cleartop-=boxExtendVertical;clearright+=boxExtendHorizontal;clearbottom+=boxExtendVertical;if(screenleft<0)screenleft=0;if(screentop<0)screentop=0;if(screenright>windowWidth)screenright=windowWidth;if(screenbottom>windowHeight)screenbottom=windowHeight;if(clearleft<0)clearleft=0;if(cleartop<0)cleartop=0;if(clearright>windowWidth)clearright=windowWidth;if(clearbottom>windowHeight)clearbottom=windowHeight;rcTex.left=screenleft/windowWidth;rcTex.top=1-screentop/windowHeight;rcTex.right=screenright/windowWidth;rcTex.bottom=1-screenbottom/windowHeight;}
else
{rcTex.left=rcTex2.left=0;rcTex.top=rcTex2.top=0;rcTex.right=rcTex2.right=1;rcTex.bottom=rcTex2.bottom=1;}
var pre_draw=(inst&&(((inst.angle||inst_layer_angle)&&glw.programUsesDest(active_effect_types[0].shaderindex))||boxExtendHorizontal!==0||boxExtendVertical!==0||inst.opacity!==1||inst.type.plugin.must_predraw))||(layer&&!inst&&layer.opacity!==1);glw.setAlphaBlend();if(pre_draw)
{if(!fx_tex[fx_index])
{fx_tex[fx_index]=glw.createEmptyTexture(windowWidth,windowHeight,this.runtime.linearSampling);}
if(fx_tex[fx_index].c2width!==windowWidth||fx_tex[fx_index].c2height!==windowHeight)
{glw.deleteTexture(fx_tex[fx_index]);fx_tex[fx_index]=glw.createEmptyTexture(windowWidth,windowHeight,this.runtime.linearSampling);}
glw.switchProgram(0);glw.setRenderingToTexture(fx_tex[fx_index]);h=clearbottom-cleartop;y=(windowHeight-cleartop)-h;glw.clearRect(clearleft,y,clearright-clearleft,h);if(inst)
{inst.drawGL(glw);}
else
{glw.setTexture(this.runtime.layer_tex);glw.setOpacity(layer.opacity);glw.resetModelView();glw.translate(-halfw,-halfh);glw.updateModelView();glw.quadTex(screenleft,screenbottom,screenright,screenbottom,screenright,screentop,screenleft,screentop,rcTex);}
rcTex2.left=rcTex2.top=0;rcTex2.right=rcTex2.bottom=1;if(inst)
{temp=rcTex.top;rcTex.top=rcTex.bottom;rcTex.bottom=temp;}
fx_index=1;other_fx_index=0;}
glw.setOpacity(1);var last=active_effect_types.length-1;var post_draw=glw.programUsesCrossSampling(active_effect_types[last].shaderindex);var etindex=0;for(i=0,len=active_effect_types.length;i<len;i++)
{if(!fx_tex[fx_index])
{fx_tex[fx_index]=glw.createEmptyTexture(windowWidth,windowHeight,this.runtime.linearSampling);}
if(fx_tex[fx_index].c2width!==windowWidth||fx_tex[fx_index].c2height!==windowHeight)
{glw.deleteTexture(fx_tex[fx_index]);fx_tex[fx_index]=glw.createEmptyTexture(windowWidth,windowHeight,this.runtime.linearSampling);}
glw.switchProgram(active_effect_types[i].shaderindex);etindex=active_effect_types[i].index;if(glw.programIsAnimated(active_effect_types[i].shaderindex))
this.runtime.redraw=true;if(i==0&&!pre_draw)
{glw.setRenderingToTexture(fx_tex[fx_index]);h=clearbottom-cleartop;y=(windowHeight-cleartop)-h;glw.clearRect(clearleft,y,clearright-clearleft,h);if(inst)
{glw.setProgramParameters(rendertarget,1.0/inst.width,1.0/inst.height,rcTex2.left,rcTex2.top,rcTex2.right,rcTex2.bottom,layerScale,inst.effect_params[etindex]);inst.drawGL(glw);}
else
{glw.setProgramParameters(rendertarget,1.0/windowWidth,1.0/windowHeight,0.0,0.0,1.0,1.0,layerScale,layer?layer.effect_params[etindex]:this.effect_params[etindex]);glw.setTexture(layer?this.runtime.layer_tex:this.runtime.layout_tex);glw.resetModelView();glw.translate(-halfw,-halfh);glw.updateModelView();glw.quadTex(screenleft,screenbottom,screenright,screenbottom,screenright,screentop,screenleft,screentop,rcTex);}
rcTex2.left=rcTex2.top=0;rcTex2.right=rcTex2.bottom=1;if(inst&&!post_draw)
{temp=screenbottom;screenbottom=screentop;screentop=temp;}}
else
{glw.setProgramParameters(rendertarget,1.0/windowWidth,1.0/windowHeight,rcTex2.left,rcTex2.top,rcTex2.right,rcTex2.bottom,layerScale,inst?inst.effect_params[etindex]:layer?layer.effect_params[etindex]:this.effect_params[etindex]);if(i===last&&!post_draw)
{if(inst)
glw.setBlend(inst.srcBlend,inst.destBlend);else if(layer)
glw.setBlend(layer.srcBlend,layer.destBlend);glw.setRenderingToTexture(rendertarget);}
else
{glw.setRenderingToTexture(fx_tex[fx_index]);h=clearbottom-cleartop;y=(windowHeight-cleartop)-h;glw.clearRect(clearleft,y,clearright-clearleft,h);}
glw.setTexture(fx_tex[other_fx_index]);glw.resetModelView();glw.translate(-halfw,-halfh);glw.updateModelView();glw.quadTex(screenleft,screenbottom,screenright,screenbottom,screenright,screentop,screenleft,screentop,rcTex);if(i===last&&!post_draw)
glw.setTexture(null);}
fx_index=(fx_index===0?1:0);other_fx_index=(fx_index===0?1:0);}
if(post_draw)
{glw.switchProgram(0);if(inst)
glw.setBlend(inst.srcBlend,inst.destBlend);else if(layer)
glw.setBlend(layer.srcBlend,layer.destBlend);glw.setRenderingToTexture(rendertarget);glw.setTexture(fx_tex[other_fx_index]);glw.resetModelView();glw.translate(-halfw,-halfh);glw.updateModelView();if(inst&&active_effect_types.length===1&&!pre_draw)
glw.quadTex(screenleft,screentop,screenright,screentop,screenright,screenbottom,screenleft,screenbottom,rcTex);else
glw.quadTex(screenleft,screenbottom,screenright,screenbottom,screenright,screentop,screenleft,screentop,rcTex);glw.setTexture(null);}};Layout.prototype.getLayerBySid=function(sid_)
{var i,len;for(i=0,len=this.layers.length;i<len;i++)
{if(this.layers[i].sid===sid_)
return this.layers[i];}
return null;};Layout.prototype.saveToJSON=function()
{var i,len,layer,et;var o={"sx":this.scrollX,"sy":this.scrollY,"s":this.scale,"a":this.angle,"w":this.width,"h":this.height,"fv":this.first_visit,"persist":this.persist_data,"fx":[],"layers":{}};for(i=0,len=this.effect_types.length;i<len;i++)
{et=this.effect_types[i];o["fx"].push({"name":et.name,"active":et.active,"params":this.effect_params[et.index]});}
for(i=0,len=this.layers.length;i<len;i++)
{layer=this.layers[i];o["layers"][layer.sid.toString()]=layer.saveToJSON();}
return o;};Layout.prototype.loadFromJSON=function(o)
{var i,len,fx,p,layer;this.scrollX=o["sx"];this.scrollY=o["sy"];this.scale=o["s"];this.angle=o["a"];this.width=o["w"];this.height=o["h"];this.persist_data=o["persist"];if(typeof o["fv"]!=="undefined")
this.first_visit=o["fv"];var ofx=o["fx"];for(i=0,len=ofx.length;i<len;i++)
{fx=this.getEffectByName(ofx[i]["name"]);if(!fx)
continue;fx.active=ofx[i]["active"];this.effect_params[fx.index]=ofx[i]["params"];}
this.updateActiveEffects();var olayers=o["layers"];for(p in olayers)
{if(olayers.hasOwnProperty(p))
{layer=this.getLayerBySid(parseInt(p,10));if(!layer)
continue;layer.loadFromJSON(olayers[p]);}}};cr.layout=Layout;function Layer(layout,m)
{this.layout=layout;this.runtime=layout.runtime;this.instances=[];this.scale=1.0;this.angle=0;this.disableAngle=false;this.tmprect=new cr.rect(0,0,0,0);this.tmpquad=new cr.quad();this.viewLeft=0;this.viewRight=0;this.viewTop=0;this.viewBottom=0;this.zindices_stale=false;this.name=m[0];this.index=m[1];this.sid=m[2];this.visible=m[3];this.background_color=m[4];this.transparent=m[5];this.parallaxX=m[6];this.parallaxY=m[7];this.opacity=m[8];this.forceOwnTexture=m[9];this.zoomRate=m[10];this.blend_mode=m[11];this.effect_fallback=m[12];this.compositeOp="source-over";this.srcBlend=0;this.destBlend=0;this.render_offscreen=false;var im=m[13];var i,len;this.initial_instances=[];for(i=0,len=im.length;i<len;i++)
{var inst=im[i];var type=this.runtime.types_by_index[inst[1]];;if(!type.default_instance)
type.default_instance=inst;this.initial_instances.push(inst);if(this.layout.initial_types.indexOf(type)===-1)
this.layout.initial_types.push(type);}
this.effect_types=[];this.active_effect_types=[];this.effect_params=[];for(i=0,len=m[14].length;i<len;i++)
{this.effect_types.push({id:m[14][i][0],name:m[14][i][1],shaderindex:-1,active:true,index:i});this.effect_params.push(m[14][i][2].slice(0));}
this.updateActiveEffects();this.rcTex=new cr.rect(0,0,1,1);this.rcTex2=new cr.rect(0,0,1,1);};Layer.prototype.updateActiveEffects=function()
{this.active_effect_types.length=0;var i,len,et;for(i=0,len=this.effect_types.length;i<len;i++)
{et=this.effect_types[i];if(et.active)
this.active_effect_types.push(et);}};Layer.prototype.getEffectByName=function(name_)
{var i,len,et;for(i=0,len=this.effect_types.length;i<len;i++)
{et=this.effect_types[i];if(et.name===name_)
return et;}
return null;};Layer.prototype.createInitialInstances=function()
{var i,k,len,inst,initial_inst,type,keep,hasPersistBehavior;for(i=0,k=0,len=this.initial_instances.length;i<len;i++)
{initial_inst=this.initial_instances[i];type=this.runtime.types_by_index[initial_inst[1]];;hasPersistBehavior=this.runtime.typeHasPersistBehavior(type);keep=true;if(!hasPersistBehavior||this.layout.first_visit)
{inst=this.runtime.createInstanceFromInit(initial_inst,this,true);;created_instances.push(inst);if(inst.type.global)
keep=false;}
if(keep)
{this.initial_instances[k]=this.initial_instances[i];k++;}}
this.initial_instances.length=k;this.runtime.ClearDeathRow();if(!this.runtime.glwrap&&this.effect_types.length)
this.blend_mode=this.effect_fallback;this.compositeOp=cr.effectToCompositeOp(this.blend_mode);if(this.runtime.gl)
cr.setGLBlend(this,this.blend_mode,this.runtime.gl);};Layer.prototype.updateZIndices=function()
{if(!this.zindices_stale)
return;var i,len;for(i=0,len=this.instances.length;i<len;i++)
{;;this.instances[i].zindex=i;}
this.zindices_stale=false;};Layer.prototype.getScale=function()
{return this.getNormalScale()*this.runtime.aspect_scale;};Layer.prototype.getNormalScale=function()
{return((this.scale*this.layout.scale)-1)*this.zoomRate+1;};Layer.prototype.getAngle=function()
{if(this.disableAngle)
return 0;return cr.clamp_angle(this.layout.angle+this.angle);};Layer.prototype.draw=function(ctx)
{this.render_offscreen=(this.forceOwnTexture||this.opacity!==1.0||this.blend_mode!==0);var layer_canvas=this.runtime.canvas;var layer_ctx=ctx;ctx.globalAlpha=1;ctx.globalCompositeOperation="source-over";if(this.render_offscreen)
{if(!this.runtime.layer_canvas)
{this.runtime.layer_canvas=document.createElement("canvas");;layer_canvas=this.runtime.layer_canvas;layer_canvas.width=this.runtime.width;layer_canvas.height=this.runtime.height;this.runtime.layer_ctx=layer_canvas.getContext("2d");;}
layer_canvas=this.runtime.layer_canvas;layer_ctx=this.runtime.layer_ctx;if(layer_canvas.width!==this.runtime.width)
layer_canvas.width=this.runtime.width;if(layer_canvas.height!==this.runtime.height)
layer_canvas.height=this.runtime.height;if(this.transparent)
layer_ctx.clearRect(0,0,this.runtime.width,this.runtime.height);}
if(!this.transparent)
{layer_ctx.fillStyle="rgb("+this.background_color[0]+","+this.background_color[1]+","+this.background_color[2]+")";layer_ctx.fillRect(0,0,this.runtime.width,this.runtime.height);}
layer_ctx.save();this.disableAngle=true;var px=this.canvasToLayer(0,0,true);var py=this.canvasToLayer(0,0,false);this.disableAngle=false;if(this.runtime.pixel_rounding)
{px=(px+0.5)|0;py=(py+0.5)|0;}
this.rotateViewport(px,py,layer_ctx);var myscale=this.getScale();layer_ctx.scale(myscale,myscale);layer_ctx.translate(-px,-py);var i,len,inst,bbox;for(i=0,len=this.instances.length;i<len;i++)
{inst=this.instances[i];if(!inst.visible||inst.width===0||inst.height===0)
continue;inst.update_bbox();bbox=inst.bbox;if(bbox.right<this.viewLeft||bbox.bottom<this.viewTop||bbox.left>this.viewRight||bbox.top>this.viewBottom)
continue;layer_ctx.globalCompositeOperation=inst.compositeOp;inst.draw(layer_ctx);}
layer_ctx.restore();if(this.render_offscreen)
{ctx.globalCompositeOperation=this.compositeOp;ctx.globalAlpha=this.opacity;ctx.drawImage(layer_canvas,0,0);}};Layer.prototype.rotateViewport=function(px,py,ctx)
{var myscale=this.getScale();this.viewLeft=px;this.viewTop=py;this.viewRight=px+(this.runtime.width*(1/myscale));this.viewBottom=py+(this.runtime.height*(1/myscale));var myAngle=this.getAngle();if(myAngle!==0)
{if(ctx)
{ctx.translate(this.runtime.width/2,this.runtime.height/2);ctx.rotate(-myAngle);ctx.translate(this.runtime.width/-2,this.runtime.height/-2);}
this.tmprect.set(this.viewLeft,this.viewTop,this.viewRight,this.viewBottom);this.tmprect.offset((this.viewLeft+this.viewRight)/-2,(this.viewTop+this.viewBottom)/-2);this.tmpquad.set_from_rotated_rect(this.tmprect,myAngle);this.tmpquad.bounding_box(this.tmprect);this.tmprect.offset((this.viewLeft+this.viewRight)/2,(this.viewTop+this.viewBottom)/2);this.viewLeft=this.tmprect.left;this.viewTop=this.tmprect.top;this.viewRight=this.tmprect.right;this.viewBottom=this.tmprect.bottom;}}
Layer.prototype.drawGL=function(glw)
{var windowWidth=this.runtime.width;var windowHeight=this.runtime.height;var shaderindex=0;var etindex=0;this.render_offscreen=(this.forceOwnTexture||this.opacity!==1.0||this.active_effect_types.length>0||this.blend_mode!==0);if(this.render_offscreen)
{if(!this.runtime.layer_tex)
{this.runtime.layer_tex=glw.createEmptyTexture(this.runtime.width,this.runtime.height,this.runtime.linearSampling);}
if(this.runtime.layer_tex.c2width!==this.runtime.width||this.runtime.layer_tex.c2height!==this.runtime.height)
{glw.deleteTexture(this.runtime.layer_tex);this.runtime.layer_tex=glw.createEmptyTexture(this.runtime.width,this.runtime.height,this.runtime.linearSampling);}
glw.setRenderingToTexture(this.runtime.layer_tex);if(this.transparent)
glw.clear(0,0,0,0);}
if(!this.transparent)
{glw.clear(this.background_color[0]/255,this.background_color[1]/255,this.background_color[2]/255,1);}
this.disableAngle=true;var px=this.canvasToLayer(0,0,true);var py=this.canvasToLayer(0,0,false);this.disableAngle=false;if(this.runtime.pixel_rounding)
{px=(px+0.5)|0;py=(py+0.5)|0;}
this.rotateViewport(px,py,null);var myscale=this.getScale();glw.resetModelView();glw.scale(myscale,myscale);glw.rotateZ(-this.getAngle());glw.translate((this.viewLeft+this.viewRight)/-2,(this.viewTop+this.viewBottom)/-2);glw.updateModelView();var i,len,inst,bbox;for(i=0,len=this.instances.length;i<len;i++)
{inst=this.instances[i];if(!inst.visible||inst.width===0||inst.height===0)
continue;inst.update_bbox();bbox=inst.bbox;if(bbox.right<this.viewLeft||bbox.bottom<this.viewTop||bbox.left>this.viewRight||bbox.top>this.viewBottom)
continue;if(inst.uses_shaders)
{shaderindex=inst.active_effect_types[0].shaderindex;etindex=inst.active_effect_types[0].index;if(inst.active_effect_types.length===1&&!glw.programUsesCrossSampling(shaderindex)&&!glw.programExtendsBox(shaderindex)&&((!inst.angle&&!inst.layer.getAngle())||!glw.programUsesDest(shaderindex))&&inst.opacity===1&&!inst.type.plugin.must_predraw)
{glw.switchProgram(shaderindex);glw.setBlend(inst.srcBlend,inst.destBlend);if(glw.programIsAnimated(shaderindex))
this.runtime.redraw=true;var destStartX=0,destStartY=0,destEndX=0,destEndY=0;if(glw.programUsesDest(shaderindex))
{var bbox=inst.bbox;var screenleft=this.layerToCanvas(bbox.left,bbox.top,true);var screentop=this.layerToCanvas(bbox.left,bbox.top,false);var screenright=this.layerToCanvas(bbox.right,bbox.bottom,true);var screenbottom=this.layerToCanvas(bbox.right,bbox.bottom,false);destStartX=screenleft/windowWidth;destStartY=1-screentop/windowHeight;destEndX=screenright/windowWidth;destEndY=1-screenbottom/windowHeight;}
glw.setProgramParameters(this.render_offscreen?this.runtime.layer_tex:this.layout.getRenderTarget(),1.0/inst.width,1.0/inst.height,destStartX,destStartY,destEndX,destEndY,this.getScale(),inst.effect_params[etindex]);inst.drawGL(glw);}
else
{this.layout.renderEffectChain(glw,this,inst,this.render_offscreen?this.runtime.layer_tex:this.layout.getRenderTarget());glw.resetModelView();glw.scale(myscale,myscale);glw.rotateZ(-this.getAngle());glw.translate((this.viewLeft+this.viewRight)/-2,(this.viewTop+this.viewBottom)/-2);glw.updateModelView();}}
else
{glw.switchProgram(0);glw.setBlend(inst.srcBlend,inst.destBlend);inst.drawGL(glw);}}
if(this.render_offscreen)
{shaderindex=this.active_effect_types.length?this.active_effect_types[0].shaderindex:0;etindex=this.active_effect_types.length?this.active_effect_types[0].index:0;if(this.active_effect_types.length===0||(this.active_effect_types.length===1&&!glw.programUsesCrossSampling(shaderindex)&&this.opacity===1))
{if(this.active_effect_types.length===1)
{glw.switchProgram(shaderindex);glw.setProgramParameters(this.layout.getRenderTarget(),1.0/this.runtime.width,1.0/this.runtime.height,0.0,0.0,1.0,1.0,this.getScale(),this.effect_params[etindex]);if(glw.programIsAnimated(shaderindex))
this.runtime.redraw=true;}
else
glw.switchProgram(0);glw.setRenderingToTexture(this.layout.getRenderTarget());glw.setOpacity(this.opacity);glw.setTexture(this.runtime.layer_tex);glw.setBlend(this.srcBlend,this.destBlend);glw.resetModelView();glw.updateModelView();var halfw=this.runtime.width/2;var halfh=this.runtime.height/2;glw.quad(-halfw,halfh,halfw,halfh,halfw,-halfh,-halfw,-halfh);glw.setTexture(null);}
else
{this.layout.renderEffectChain(glw,this,null,this.layout.getRenderTarget());}}};Layer.prototype.canvasToLayer=function(ptx,pty,getx)
{var multiplier=this.runtime.devicePixelRatio;if(this.runtime.isRetina&&this.runtime.fullscreen_mode>0)
{ptx*=multiplier;pty*=multiplier;}
var ox=(this.runtime.original_width/2);var oy=(this.runtime.original_height/2);var x=((this.layout.scrollX-ox)*this.parallaxX)+ox;var y=((this.layout.scrollY-oy)*this.parallaxY)+oy;var invScale=1/this.getScale();x-=(this.runtime.width*invScale)/2;y-=(this.runtime.height*invScale)/2;x+=ptx*invScale;y+=pty*invScale;var a=this.getAngle();if(a!==0)
{x-=this.layout.scrollX;y-=this.layout.scrollY;var cosa=Math.cos(a);var sina=Math.sin(a);var x_temp=(x*cosa)-(y*sina);y=(y*cosa)+(x*sina);x=x_temp;x+=this.layout.scrollX;y+=this.layout.scrollY;}
return getx?x:y;};Layer.prototype.layerToCanvas=function(ptx,pty,getx)
{var a=this.getAngle();if(a!==0)
{ptx-=this.layout.scrollX;pty-=this.layout.scrollY;var cosa=Math.cos(-a);var sina=Math.sin(-a);var x_temp=(ptx*cosa)-(pty*sina);pty=(pty*cosa)+(ptx*sina);ptx=x_temp;ptx+=this.layout.scrollX;pty+=this.layout.scrollY;}
var ox=(this.runtime.original_width/2);var oy=(this.runtime.original_height/2);var x=((this.layout.scrollX-ox)*this.parallaxX)+ox;var y=((this.layout.scrollY-oy)*this.parallaxY)+oy;var invScale=1/this.getScale();x-=(this.runtime.width*invScale)/2;y-=(this.runtime.height*invScale)/2;x=(ptx-x)/invScale;y=(pty-y)/invScale;var multiplier=this.runtime.devicePixelRatio;if(this.runtime.isRetina&&this.runtime.fullscreen_mode>0)
{x/=multiplier;y/=multiplier;}
return getx?x:y;};Layer.prototype.rotatePt=function(x_,y_,getx)
{if(this.getAngle()===0)
return getx?x_:y_;var nx=this.layerToCanvas(x_,y_,true);var ny=this.layerToCanvas(x_,y_,false);this.disableAngle=true;var px=this.canvasToLayer(nx,ny,true);var py=this.canvasToLayer(nx,ny,true);this.disableAngle=false;return getx?px:py;};Layer.prototype.saveToJSON=function()
{var i,len,et;var o={"s":this.scale,"a":this.angle,"vl":this.viewLeft,"vt":this.viewTop,"vr":this.viewRight,"vb":this.viewBottom,"v":this.visible,"bc":this.background_color,"t":this.transparent,"px":this.parallaxX,"py":this.parallaxY,"o":this.opacity,"zr":this.zoomRate,"fx":[],"instances":[]};for(i=0,len=this.effect_types.length;i<len;i++)
{et=this.effect_types[i];o["fx"].push({"name":et.name,"active":et.active,"params":this.effect_params[et.index]});}
return o;};function sortInstanceByZIndex(a,b)
{return a.zindex-b.zindex;};Layer.prototype.loadFromJSON=function(o)
{var i,len,p,inst,fx;this.scale=o["s"];this.angle=o["a"];this.viewLeft=o["vl"];this.viewTop=o["vt"];this.viewRight=o["vr"];this.viewBottom=o["vb"];this.visible=o["v"];this.background_color=o["bc"];this.transparent=o["t"];this.parallaxX=o["px"];this.parallaxY=o["py"];this.opacity=o["o"];this.zoomRate=o["zr"];var ofx=o["fx"];for(i=0,len=ofx.length;i<len;i++)
{fx=this.getEffectByName(ofx[i]["name"]);if(!fx)
continue;fx.active=ofx[i]["active"];this.effect_params[fx.index]=ofx[i]["params"];}
this.updateActiveEffects();this.instances.sort(sortInstanceByZIndex);this.zindices_stale=true;};cr.layer=Layer;}());;(function()
{var allUniqueSolModifiers=[];function testSolsMatch(arr1,arr2)
{var i,len=arr1.length;switch(len){case 0:return true;case 1:return arr1[0]===arr2[0];case 2:return arr1[0]===arr2[0]&&arr1[1]===arr2[1];default:for(i=0;i<len;i++)
{if(arr1[i]!==arr2[i])
return false;}
return true;}};function solArraySorter(t1,t2)
{return t1.index-t2.index;};function findMatchingSolModifier(arr)
{var i,len,u,temp,subarr;if(arr.length===2)
{if(arr[0].index>arr[1].index)
{temp=arr[0];arr[0]=arr[1];arr[1]=temp;}}
else if(arr.length>2)
arr.sort(solArraySorter);if(arr.length>=allUniqueSolModifiers.length)
allUniqueSolModifiers.length=arr.length+1;if(!allUniqueSolModifiers[arr.length])
allUniqueSolModifiers[arr.length]=[];subarr=allUniqueSolModifiers[arr.length];for(i=0,len=subarr.length;i<len;i++)
{u=subarr[i];if(testSolsMatch(arr,u))
return u;}
subarr.push(arr);return arr;};function EventSheet(runtime,m)
{this.runtime=runtime;this.triggers={};this.fasttriggers={};this.hasRun=false;this.includes=new cr.ObjectSet();this.name=m[0];var em=m[1];this.events=[];var i,len;for(i=0,len=em.length;i<len;i++)
this.init_event(em[i],null,this.events);};EventSheet.prototype.toString=function()
{return this.name;};EventSheet.prototype.init_event=function(m,parent,nontriggers)
{switch(m[0]){case 0:{var block=new cr.eventblock(this,parent,m);cr.seal(block);if(block.orblock)
{nontriggers.push(block);var i,len;for(i=0,len=block.conditions.length;i<len;i++)
{if(block.conditions[i].trigger)
this.init_trigger(block,i);}}
else
{if(block.is_trigger())
this.init_trigger(block,0);else
nontriggers.push(block);}
break;}
case 1:{var v=new cr.eventvariable(this,parent,m);cr.seal(v);nontriggers.push(v);break;}
case 2:{var inc=new cr.eventinclude(this,parent,m);cr.seal(inc);nontriggers.push(inc);break;}
default:;}};EventSheet.prototype.postInit=function()
{var i,len;for(i=0,len=this.events.length;i<len;i++)
{this.events[i].postInit(i<len-1&&this.events[i+1].is_else_block);}};EventSheet.prototype.run=function(from_include)
{if(!this.runtime.resuming_breakpoint)
{this.hasRun=true;if(!from_include)
this.runtime.isRunningEvents=true;}
var i,len;for(i=0,len=this.events.length;i<len;i++)
{var ev=this.events[i];ev.run();this.runtime.clearSol(ev.solModifiers);if(!this.runtime.deathRow.isEmpty()||this.runtime.createRow.length)
this.runtime.ClearDeathRow();}
if(!from_include)
this.runtime.isRunningEvents=false;};EventSheet.prototype.init_trigger=function(trig,index)
{if(!trig.orblock)
this.runtime.triggers_to_postinit.push(trig);var i,len;var cnd=trig.conditions[index];var type_name;if(cnd.type)
type_name=cnd.type.name;else
type_name="system";var fasttrigger=cnd.fasttrigger;var triggers=(fasttrigger?this.fasttriggers:this.triggers);if(!triggers[type_name])
triggers[type_name]=[];var obj_entry=triggers[type_name];var method=cnd.func;if(fasttrigger)
{if(!cnd.parameters.length)
return;var firstparam=cnd.parameters[0];if(firstparam.type!==1||firstparam.expression.type!==2)
{return;}
var fastevs;var firstvalue=firstparam.expression.value.toLowerCase();var i,len;for(i=0,len=obj_entry.length;i<len;i++)
{if(obj_entry[i].method==method)
{fastevs=obj_entry[i].evs;if(!fastevs[firstvalue])
fastevs[firstvalue]=[[trig,index]];else
fastevs[firstvalue].push([trig,index]);return;}}
fastevs={};fastevs[firstvalue]=[[trig,index]];obj_entry.push({method:method,evs:fastevs});}
else
{for(i=0,len=obj_entry.length;i<len;i++)
{if(obj_entry[i].method==method)
{obj_entry[i].evs.push([trig,index]);return;}}
obj_entry.push({method:method,evs:[[trig,index]]});}};cr.eventsheet=EventSheet;function Selection(type)
{this.type=type;this.instances=[];this.else_instances=[];this.select_all=true;};Selection.prototype.hasObjects=function()
{if(this.select_all)
return this.type.instances.length;else
return this.instances.length;};Selection.prototype.getObjects=function()
{if(this.select_all)
return this.type.instances;else
return this.instances;};Selection.prototype.pick_one=function(inst)
{if(!inst)
return;if(inst.runtime.getCurrentEventStack().current_event.orblock)
{if(this.select_all)
{this.instances.length=0;cr.shallowAssignArray(this.else_instances,inst.type.instances);this.select_all=false;}
var i=this.else_instances.indexOf(inst);if(i!==-1)
{this.instances.push(this.else_instances[i]);this.else_instances.splice(i,1);}}
else
{this.select_all=false;this.instances.length=1;this.instances[0]=inst;}};cr.selection=Selection;function EventBlock(sheet,parent,m)
{this.sheet=sheet;this.parent=parent;this.runtime=sheet.runtime;this.solModifiers=[];this.solModifiersIncludingParents=[];this.solWriterAfterCnds=false;this.group=false;this.initially_activated=false;this.toplevelevent=false;this.toplevelgroup=false;this.has_else_block=false;;this.conditions=[];this.actions=[];this.subevents=[];if(m[1])
{this.group_name=m[1][1].toLowerCase();this.group=true;this.initially_activated=!!m[1][0];this.runtime.allGroups.push(this);this.runtime.activeGroups[(this.group_name).toLowerCase()]=this.initially_activated;}
else
{this.group_name="";this.group=false;this.initially_activated=false;}
this.orblock=m[2];this.sid=m[4];if(!this.group)
this.runtime.blocksBySid[this.sid.toString()]=this;var i,len;var cm=m[5];for(i=0,len=cm.length;i<len;i++)
{var cnd=new cr.condition(this,cm[i]);cnd.index=i;cr.seal(cnd);this.conditions.push(cnd);this.addSolModifier(cnd.type);}
var am=m[6];for(i=0,len=am.length;i<len;i++)
{var act=new cr.action(this,am[i]);act.index=i;cr.seal(act);this.actions.push(act);}
if(m.length===8)
{var em=m[7];for(i=0,len=em.length;i<len;i++)
this.sheet.init_event(em[i],this,this.subevents);}
this.is_else_block=false;if(this.conditions.length)
{this.is_else_block=(this.conditions[0].type==null&&this.conditions[0].func==cr.system_object.prototype.cnds.Else);}};EventBlock.prototype.postInit=function(hasElse)
{var i,len;var p=this.parent;if(this.group)
{this.toplevelgroup=true;while(p)
{if(!p.group)
{this.toplevelgroup=false;break;}
p=p.parent;}}
this.toplevelevent=!this.is_trigger()&&(!this.parent||(this.parent.group&&this.parent.toplevelgroup));this.has_else_block=!!hasElse;this.solModifiersIncludingParents=this.solModifiers.slice(0);p=this.parent;while(p)
{for(i=0,len=p.solModifiers.length;i<len;i++)
this.addParentSolModifier(p.solModifiers[i]);p=p.parent;}
this.solModifiers=findMatchingSolModifier(this.solModifiers);this.solModifiersIncludingParents=findMatchingSolModifier(this.solModifiersIncludingParents);var i,len;for(i=0,len=this.conditions.length;i<len;i++)
this.conditions[i].postInit();for(i=0,len=this.actions.length;i<len;i++)
this.actions[i].postInit();for(i=0,len=this.subevents.length;i<len;i++)
{this.subevents[i].postInit(i<len-1&&this.subevents[i+1].is_else_block);}}
function addSolModifierToList(type,arr)
{var i,len,t;if(!type)
return;if(arr.indexOf(type)===-1)
arr.push(type);if(type.is_contained)
{for(i=0,len=type.container.length;i<len;i++)
{t=type.container[i];if(type===t)
continue;if(arr.indexOf(t)===-1)
arr.push(t);}}};EventBlock.prototype.addSolModifier=function(type)
{addSolModifierToList(type,this.solModifiers);};EventBlock.prototype.addParentSolModifier=function(type)
{addSolModifierToList(type,this.solModifiersIncludingParents);};EventBlock.prototype.setSolWriterAfterCnds=function()
{this.solWriterAfterCnds=true;if(this.parent)
this.parent.setSolWriterAfterCnds();};EventBlock.prototype.is_trigger=function()
{if(!this.conditions.length)
return false;else
return this.conditions[0].trigger;};EventBlock.prototype.run=function()
{var i,len,any_true=false,cnd_result;var evinfo=this.runtime.getCurrentEventStack();evinfo.current_event=this;if(!this.is_else_block)
evinfo.else_branch_ran=false;if(this.orblock)
{if(this.conditions.length===0)
any_true=true;evinfo.cndindex=0
for(len=this.conditions.length;evinfo.cndindex<len;evinfo.cndindex++)
{if(this.conditions[evinfo.cndindex].trigger)
continue;cnd_result=this.conditions[evinfo.cndindex].run();if(cnd_result)
any_true=true;}
evinfo.last_event_true=any_true;if(any_true)
this.run_actions_and_subevents();}
else
{evinfo.cndindex=0
for(len=this.conditions.length;evinfo.cndindex<len;evinfo.cndindex++)
{cnd_result=this.conditions[evinfo.cndindex].run();if(!cnd_result)
{evinfo.last_event_true=false;if(this.toplevelevent&&(!this.runtime.deathRow.isEmpty()||this.runtime.createRow.length))
this.runtime.ClearDeathRow();return;}}
evinfo.last_event_true=true;this.run_actions_and_subevents();}
this.end_run(evinfo);};EventBlock.prototype.end_run=function(evinfo)
{if(evinfo.last_event_true&&this.has_else_block)
evinfo.else_branch_ran=true;if(this.toplevelevent&&(!this.runtime.deathRow.isEmpty()||this.runtime.createRow.length))
this.runtime.ClearDeathRow();};EventBlock.prototype.run_orblocktrigger=function(index)
{var evinfo=this.runtime.getCurrentEventStack();evinfo.current_event=this;if(this.conditions[index].run())
{this.run_actions_and_subevents();}};EventBlock.prototype.run_actions_and_subevents=function()
{var evinfo=this.runtime.getCurrentEventStack();var len;for(evinfo.actindex=0,len=this.actions.length;evinfo.actindex<len;evinfo.actindex++)
{if(this.actions[evinfo.actindex].run())
return;}
this.run_subevents();};EventBlock.prototype.resume_actions_and_subevents=function()
{var evinfo=this.runtime.getCurrentEventStack();var len;for(len=this.actions.length;evinfo.actindex<len;evinfo.actindex++)
{if(this.actions[evinfo.actindex].run())
return;}
this.run_subevents();};EventBlock.prototype.run_subevents=function()
{if(!this.subevents.length)
return;var i,len,subev,pushpop;var last=this.subevents.length-1;this.runtime.pushEventStack(this);if(this.solWriterAfterCnds)
{for(i=0,len=this.subevents.length;i<len;i++)
{subev=this.subevents[i];pushpop=(!this.toplevelgroup||(!this.group&&i<last));if(pushpop)
this.runtime.pushCopySol(subev.solModifiers);subev.run();if(pushpop)
this.runtime.popSol(subev.solModifiers);else
this.runtime.clearSol(subev.solModifiers);}}
else
{for(i=0,len=this.subevents.length;i<len;i++)
{this.subevents[i].run();}}
this.runtime.popEventStack();};EventBlock.prototype.run_pretrigger=function()
{var evinfo=this.runtime.getCurrentEventStack();evinfo.current_event=this;var any_true=false;var i,len;for(evinfo.cndindex=0,len=this.conditions.length;evinfo.cndindex<len;evinfo.cndindex++)
{;if(this.conditions[evinfo.cndindex].run())
any_true=true;else if(!this.orblock)
return false;}
return this.orblock?any_true:true;};EventBlock.prototype.retrigger=function()
{this.runtime.execcount++;var prevcndindex=this.runtime.getCurrentEventStack().cndindex;var len;var evinfo=this.runtime.pushEventStack(this);if(!this.orblock)
{for(evinfo.cndindex=prevcndindex+1,len=this.conditions.length;evinfo.cndindex<len;evinfo.cndindex++)
{if(!this.conditions[evinfo.cndindex].run())
{this.runtime.popEventStack();return false;}}}
this.run_actions_and_subevents();this.runtime.popEventStack();return true;};EventBlock.prototype.isFirstConditionOfType=function(cnd)
{var cndindex=cnd.index;if(cndindex===0)
return true;--cndindex;for(;cndindex>=0;--cndindex)
{if(this.conditions[cndindex].type===cnd.type)
return false;}
return true;};cr.eventblock=EventBlock;function Condition(block,m)
{this.block=block;this.sheet=block.sheet;this.runtime=block.runtime;this.parameters=[];this.results=[];this.extra={};this.index=-1;this.func=m[1];;this.trigger=(m[3]>0);this.fasttrigger=(m[3]===2);this.looping=m[4];this.inverted=m[5];this.isstatic=m[6];this.sid=m[7];this.runtime.cndsBySid[this.sid.toString()]=this;if(m[0]===-1)
{this.type=null;this.run=this.run_system;this.behaviortype=null;this.beh_index=-1;}
else
{this.type=this.runtime.types_by_index[m[0]];;if(this.isstatic)
this.run=this.run_static;else
this.run=this.run_object;if(m[2])
{this.behaviortype=this.type.getBehaviorByName(m[2]);;this.beh_index=this.type.getBehaviorIndexByName(m[2]);;}
else
{this.behaviortype=null;this.beh_index=-1;}
if(this.block.parent)
this.block.parent.setSolWriterAfterCnds();}
if(this.fasttrigger)
this.run=this.run_true;if(m.length===10)
{var i,len;var em=m[9];for(i=0,len=em.length;i<len;i++)
{var param=new cr.parameter(this,em[i]);cr.seal(param);this.parameters.push(param);}
this.results.length=em.length;}};Condition.prototype.postInit=function()
{var i,len;for(i=0,len=this.parameters.length;i<len;i++)
this.parameters[i].postInit();};Condition.prototype.run_true=function()
{return true;};Condition.prototype.run_system=function()
{var i,len;for(i=0,len=this.parameters.length;i<len;i++)
this.results[i]=this.parameters[i].get();return cr.xor(this.func.apply(this.runtime.system,this.results),this.inverted);};Condition.prototype.run_static=function()
{var i,len;for(i=0,len=this.parameters.length;i<len;i++)
this.results[i]=this.parameters[i].get(i);var ret=this.func.apply(this.behaviortype?this.behaviortype:this.type,this.results);this.type.applySolToContainer();return ret;};Condition.prototype.run_object=function()
{var i,j,leni,lenj,ret,met,inst,s,sol2;var sol=this.type.getCurrentSol();var is_orblock=this.block.orblock&&!this.trigger;var offset=0;var is_contained=this.type.is_contained;if(sol.select_all){sol.instances.length=0;sol.else_instances.length=0;for(i=0,leni=this.type.instances.length;i<leni;i++)
{inst=this.type.instances[i];;for(j=0,lenj=this.parameters.length;j<lenj;j++)
this.results[j]=this.parameters[j].get(i);if(this.beh_index>-1)
{if(this.type.is_family)
{offset=inst.type.family_beh_map[this.type.family_index];}
ret=this.func.apply(inst.behavior_insts[this.beh_index+offset],this.results);}
else
ret=this.func.apply(inst,this.results);met=cr.xor(ret,this.inverted);if(met)
sol.instances.push(inst);else if(is_orblock)
sol.else_instances.push(inst);}
if(this.type.finish)
this.type.finish(true);sol.select_all=false;this.type.applySolToContainer();return sol.hasObjects();}
else{var k=0;var using_else_instances=(is_orblock&&!this.block.isFirstConditionOfType(this));var arr=(using_else_instances?sol.else_instances:sol.instances);var any_true=false;for(i=0,leni=arr.length;i<leni;i++)
{inst=arr[i];;for(j=0,lenj=this.parameters.length;j<lenj;j++)
this.results[j]=this.parameters[j].get(i);if(this.beh_index>-1)
{if(this.type.is_family)
{offset=inst.type.family_beh_map[this.type.family_index];}
ret=this.func.apply(inst.behavior_insts[this.beh_index+offset],this.results);}
else
ret=this.func.apply(inst,this.results);if(cr.xor(ret,this.inverted))
{any_true=true;if(using_else_instances)
{sol.instances.push(inst);if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];s.type.getCurrentSol().instances.push(s);}}}
else
{arr[k]=inst;if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];s.type.getCurrentSol().instances[k]=s;}}
k++;}}
else
{if(using_else_instances)
{arr[k]=inst;if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];s.type.getCurrentSol().else_instances[k]=s;}}
k++;}
else if(is_orblock)
{sol.else_instances.push(inst);if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];s.type.getCurrentSol().else_instances.push(s);}}}}}
arr.length=k;if(is_contained)
{for(i=0,leni=this.type.container.length;i<leni;i++)
{sol2=this.type.container[i].getCurrentSol();if(using_else_instances)
sol2.else_instances.length=k;else
sol2.instances.length=k;}}
var pick_in_finish=any_true;if(using_else_instances&&!any_true)
{for(i=0,leni=sol.instances.length;i<leni;i++)
{inst=sol.instances[i];for(j=0,lenj=this.parameters.length;j<lenj;j++)
this.results[j]=this.parameters[j].get(i);if(this.beh_index>-1)
ret=this.func.apply(inst.behavior_insts[this.beh_index],this.results);else
ret=this.func.apply(inst,this.results);if(cr.xor(ret,this.inverted))
{any_true=true;break;}}}
if(this.type.finish)
this.type.finish(pick_in_finish||is_orblock);return is_orblock?any_true:sol.hasObjects();}};cr.condition=Condition;function Action(block,m)
{this.block=block;this.sheet=block.sheet;this.runtime=block.runtime;this.parameters=[];this.results=[];this.extra={};this.index=-1;this.func=m[1];;if(m[0]===-1)
{this.type=null;this.run=this.run_system;this.behaviortype=null;this.beh_index=-1;}
else
{this.type=this.runtime.types_by_index[m[0]];;this.run=this.run_object;if(m[2])
{this.behaviortype=this.type.getBehaviorByName(m[2]);;this.beh_index=this.type.getBehaviorIndexByName(m[2]);;}
else
{this.behaviortype=null;this.beh_index=-1;}}
this.sid=m[3];this.runtime.actsBySid[this.sid.toString()]=this;if(m.length===6)
{var i,len;var em=m[5];for(i=0,len=em.length;i<len;i++)
{var param=new cr.parameter(this,em[i]);cr.seal(param);this.parameters.push(param);}
this.results.length=em.length;}};Action.prototype.postInit=function()
{var i,len;for(i=0,len=this.parameters.length;i<len;i++)
this.parameters[i].postInit();};Action.prototype.run_system=function()
{var i,len;for(i=0,len=this.parameters.length;i<len;i++)
this.results[i]=this.parameters[i].get();return this.func.apply(this.runtime.system,this.results);};Action.prototype.run_object=function()
{var instances=this.type.getCurrentSol().getObjects();var i,j,leni,lenj,inst;for(i=0,leni=instances.length;i<leni;i++)
{inst=instances[i];for(j=0,lenj=this.parameters.length;j<lenj;j++)
this.results[j]=this.parameters[j].get(i);if(this.beh_index>-1)
{var offset=0;if(this.type.is_family)
{offset=inst.type.family_beh_map[this.type.family_index];}
this.func.apply(inst.behavior_insts[this.beh_index+offset],this.results);}
else
this.func.apply(inst,this.results);}
return false;};cr.action=Action;var tempValues=[];var tempValuesPtr=-1;function Parameter(owner,m)
{this.owner=owner;this.block=owner.block;this.sheet=owner.sheet;this.runtime=owner.runtime;this.type=m[0];this.expression=null;this.solindex=0;this.combosel=0;this.layout=null;this.key=0;this.object=null;this.index=0;this.varname=null;this.eventvar=null;this.fileinfo=null;this.subparams=null;this.variadicret=null;var i,len,param;switch(m[0])
{case 0:case 7:this.expression=new cr.expNode(this,m[1]);this.solindex=0;this.get=this.get_exp;break;case 1:this.expression=new cr.expNode(this,m[1]);this.solindex=0;this.get=this.get_exp_str;break;case 5:this.expression=new cr.expNode(this,m[1]);this.solindex=0;this.get=this.get_layer;break;case 3:case 8:this.combosel=m[1];this.get=this.get_combosel;break;case 6:this.layout=this.runtime.layouts[m[1]];;this.get=this.get_layout;break;case 9:this.key=m[1];this.get=this.get_key;break;case 4:this.object=this.runtime.types_by_index[m[1]];;this.get=this.get_object;this.block.addSolModifier(this.object);if(this.owner instanceof cr.action)
this.block.setSolWriterAfterCnds();else if(this.block.parent)
this.block.parent.setSolWriterAfterCnds();break;case 10:this.index=m[1];if(owner.type.is_family)
this.get=this.get_familyvar;else
this.get=this.get_instvar;break;case 11:this.varname=m[1];this.eventvar=null;this.get=this.get_eventvar;break;case 2:case 12:this.fileinfo=m[1];this.get=this.get_audiofile;break;case 13:this.get=this.get_variadic;this.subparams=[];this.variadicret=[];for(i=1,len=m.length;i<len;i++)
{param=new cr.parameter(this.owner,m[i]);cr.seal(param);this.subparams.push(param);this.variadicret.push(0);}
break;default:;}};Parameter.prototype.postInit=function()
{var i,len;if(this.type===11)
{this.eventvar=this.runtime.getEventVariableByName(this.varname,this.block.parent);;}
else if(this.type===13)
{for(i=0,len=this.subparams.length;i<len;i++)
this.subparams[i].postInit();}
if(this.expression)
this.expression.postInit();};Parameter.prototype.pushTempValue=function()
{tempValuesPtr++;if(tempValues.length===tempValuesPtr)
tempValues.push(new cr.expvalue());return tempValues[tempValuesPtr];};Parameter.prototype.popTempValue=function()
{tempValuesPtr--;};Parameter.prototype.get_exp=function(solindex)
{this.solindex=solindex||0;var temp=this.pushTempValue();this.expression.get(temp);this.popTempValue();return temp.data;};Parameter.prototype.get_exp_str=function(solindex)
{this.solindex=solindex||0;var temp=this.pushTempValue();this.expression.get(temp);this.popTempValue();if(cr.is_string(temp.data))
return temp.data;else
return"";};Parameter.prototype.get_object=function()
{return this.object;};Parameter.prototype.get_combosel=function()
{return this.combosel;};Parameter.prototype.get_layer=function(solindex)
{this.solindex=solindex||0;var temp=this.pushTempValue();this.expression.get(temp);this.popTempValue();if(temp.is_number())
return this.runtime.getLayerByNumber(temp.data);else
return this.runtime.getLayerByName(temp.data);}
Parameter.prototype.get_layout=function()
{return this.layout;};Parameter.prototype.get_key=function()
{return this.key;};Parameter.prototype.get_instvar=function()
{return this.index;};Parameter.prototype.get_familyvar=function(solindex)
{var familytype=this.owner.type;var realtype=null;var sol=familytype.getCurrentSol();var objs=sol.getObjects();if(objs.length)
realtype=objs[solindex%objs.length].type;else
{;realtype=sol.else_instances[solindex%sol.else_instances.length].type;}
return this.index+realtype.family_var_map[familytype.family_index];};Parameter.prototype.get_eventvar=function()
{return this.eventvar;};Parameter.prototype.get_audiofile=function()
{return this.fileinfo;};Parameter.prototype.get_variadic=function()
{var i,len;for(i=0,len=this.subparams.length;i<len;i++)
{this.variadicret[i]=this.subparams[i].get();}
return this.variadicret;};cr.parameter=Parameter;function EventVariable(sheet,parent,m)
{this.sheet=sheet;this.parent=parent;this.runtime=sheet.runtime;this.solModifiers=[];this.name=m[1];this.vartype=m[2];this.initial=m[3];this.is_static=!!m[4];this.is_constant=!!m[5];this.sid=m[6];this.runtime.varsBySid[this.sid.toString()]=this;this.data=this.initial;if(this.parent)
{if(this.is_static||this.is_constant)
this.localIndex=-1;else
this.localIndex=this.runtime.stackLocalCount++;this.runtime.all_local_vars.push(this);}
else
{this.localIndex=-1;this.runtime.all_global_vars.push(this);}};EventVariable.prototype.postInit=function()
{this.solModifiers=findMatchingSolModifier(this.solModifiers);};EventVariable.prototype.setValue=function(x)
{;var lvs=this.runtime.getCurrentLocalVarStack();if(!this.parent||this.is_static||!lvs)
this.data=x;else
{if(this.localIndex>=lvs.length)
lvs.length=this.localIndex+1;lvs[this.localIndex]=x;}};EventVariable.prototype.getValue=function()
{var lvs=this.runtime.getCurrentLocalVarStack();if(!this.parent||this.is_static||!lvs||this.is_constant)
return this.data;else
{if(this.localIndex>=lvs.length)
{;return this.initial;}
if(typeof lvs[this.localIndex]==="undefined")
{;return this.initial;}
return lvs[this.localIndex];}};EventVariable.prototype.run=function()
{if(this.parent&&!this.is_static&&!this.is_constant)
this.setValue(this.initial);};cr.eventvariable=EventVariable;function EventInclude(sheet,parent,m)
{this.sheet=sheet;this.parent=parent;this.runtime=sheet.runtime;this.solModifiers=[];this.include_sheet=null;this.include_sheet_name=m[1];};EventInclude.prototype.toString=function()
{return"include:"+this.include_sheet.toString();};EventInclude.prototype.postInit=function()
{this.include_sheet=this.runtime.eventsheets[this.include_sheet_name];;;this.sheet.includes.add(this);this.solModifiers=findMatchingSolModifier(this.solModifiers);};EventInclude.prototype.run=function()
{if(this.parent)
this.runtime.pushCleanSol(this.runtime.types_by_index);if(!this.include_sheet.hasRun)
this.include_sheet.run(true);if(this.parent)
this.runtime.popSol(this.runtime.types_by_index);};EventInclude.prototype.isActive=function()
{var p=this.parent;while(p)
{if(p.group)
{if(!this.runtime.activeGroups[p.group_name.toLowerCase()])
return false;}
p=p.parent;}
return true;};cr.eventinclude=EventInclude;function EventStackFrame()
{this.temp_parents_arr=[];this.reset(null);cr.seal(this);};EventStackFrame.prototype.reset=function(cur_event)
{this.current_event=cur_event;this.cndindex=0;this.actindex=0;this.temp_parents_arr.length=0;this.last_event_true=false;this.else_branch_ran=false;this.any_true_state=false;};EventStackFrame.prototype.isModifierAfterCnds=function()
{if(this.current_event.solWriterAfterCnds)
return true;if(this.cndindex<this.current_event.conditions.length-1)
return!!this.current_event.solModifiers.length;return false;};cr.eventStackFrame=EventStackFrame;}());(function()
{function ExpNode(owner_,m)
{this.owner=owner_;this.runtime=owner_.runtime;this.type=m[0];;this.get=[this.eval_int,this.eval_float,this.eval_string,this.eval_unaryminus,this.eval_add,this.eval_subtract,this.eval_multiply,this.eval_divide,this.eval_mod,this.eval_power,this.eval_and,this.eval_or,this.eval_equal,this.eval_notequal,this.eval_less,this.eval_lessequal,this.eval_greater,this.eval_greaterequal,this.eval_conditional,this.eval_system_exp,this.eval_object_behavior_exp,this.eval_instvar_exp,this.eval_object_behavior_exp,this.eval_eventvar_exp][this.type];var paramsModel=null;this.value=null;this.first=null;this.second=null;this.third=null;this.func=null;this.results=null;this.parameters=null;this.object_type=null;this.beh_index=-1;this.instance_expr=null;this.varindex=-1;this.behavior_type=null;this.varname=null;this.eventvar=null;this.return_string=false;switch(this.type){case 0:case 1:case 2:this.value=m[1];break;case 3:this.first=new cr.expNode(owner_,m[1]);break;case 18:this.first=new cr.expNode(owner_,m[1]);this.second=new cr.expNode(owner_,m[2]);this.third=new cr.expNode(owner_,m[3]);break;case 19:this.func=m[1];;this.results=[];this.parameters=[];if(m.length===3)
{paramsModel=m[2];this.results.length=paramsModel.length+1;}
else
this.results.length=1;break;case 20:this.object_type=this.runtime.types_by_index[m[1]];;this.beh_index=-1;this.func=m[2];this.return_string=m[3];if(m[4])
this.instance_expr=new cr.expNode(owner_,m[4]);else
this.instance_expr=null;this.results=[];this.parameters=[];if(m.length===6)
{paramsModel=m[5];this.results.length=paramsModel.length+1;}
else
this.results.length=1;break;case 21:this.object_type=this.runtime.types_by_index[m[1]];;this.return_string=m[2];if(m[3])
this.instance_expr=new cr.expNode(owner_,m[3]);else
this.instance_expr=null;this.varindex=m[4];break;case 22:this.object_type=this.runtime.types_by_index[m[1]];;this.behavior_type=this.object_type.getBehaviorByName(m[2]);;this.beh_index=this.object_type.getBehaviorIndexByName(m[2]);this.func=m[3];this.return_string=m[4];if(m[5])
this.instance_expr=new cr.expNode(owner_,m[5]);else
this.instance_expr=null;this.results=[];this.parameters=[];if(m.length===7)
{paramsModel=m[6];this.results.length=paramsModel.length+1;}
else
this.results.length=1;break;case 23:this.varname=m[1];this.eventvar=null;break;}
if(this.type>=4&&this.type<=17)
{this.first=new cr.expNode(owner_,m[1]);this.second=new cr.expNode(owner_,m[2]);}
if(paramsModel)
{var i,len;for(i=0,len=paramsModel.length;i<len;i++)
this.parameters.push(new cr.expNode(owner_,paramsModel[i]));}
cr.seal(this);};ExpNode.prototype.postInit=function()
{if(this.type===23)
{this.eventvar=this.owner.runtime.getEventVariableByName(this.varname,this.owner.block.parent);;}
if(this.first)
this.first.postInit();if(this.second)
this.second.postInit();if(this.third)
this.third.postInit();if(this.instance_expr)
this.instance_expr.postInit();if(this.parameters)
{var i,len;for(i=0,len=this.parameters.length;i<len;i++)
this.parameters[i].postInit();}};ExpNode.prototype.eval_system_exp=function(ret)
{this.results[0]=ret;var temp=this.owner.pushTempValue();var i,len;for(i=0,len=this.parameters.length;i<len;i++)
{this.parameters[i].get(temp);this.results[i+1]=temp.data;}
this.owner.popTempValue();this.func.apply(this.runtime.system,this.results);};ExpNode.prototype.eval_object_behavior_exp=function(ret)
{var sol=this.object_type.getCurrentSol();var instances=sol.getObjects();if(!instances.length)
{if(sol.else_instances.length)
instances=sol.else_instances;else
{if(this.return_string)
ret.set_string("");else
ret.set_int(0);return;}}
this.results[0]=ret;ret.object_class=this.object_type;var temp=this.owner.pushTempValue();var i,len;for(i=0,len=this.parameters.length;i<len;i++){this.parameters[i].get(temp);this.results[i+1]=temp.data;}
var index=this.owner.solindex;if(this.instance_expr){this.instance_expr.get(temp);if(temp.is_number()){index=temp.data;instances=this.object_type.instances;}}
this.owner.popTempValue();index%=instances.length;if(index<0)
index+=instances.length;var returned_val;var inst=instances[index];if(this.beh_index>-1)
{var offset=0;if(this.object_type.is_family)
{offset=inst.type.family_beh_map[this.object_type.family_index];}
returned_val=this.func.apply(inst.behavior_insts[this.beh_index+offset],this.results);}
else
returned_val=this.func.apply(inst,this.results);;};ExpNode.prototype.eval_instvar_exp=function(ret)
{var sol=this.object_type.getCurrentSol();var instances=sol.getObjects();if(!instances.length)
{if(sol.else_instances.length)
instances=sol.else_instances;else
{if(this.return_string)
ret.set_string("");else
ret.set_int(0);return;}}
var index=this.owner.solindex;if(this.instance_expr)
{var temp=this.owner.pushTempValue();this.instance_expr.get(temp);if(temp.is_number())
{index=temp.data;var type_instances=this.object_type.instances;index%=type_instances.length;if(index<0)
index+=type_instances.length;var to_ret=type_instances[index].instance_vars[this.varindex];if(cr.is_string(to_ret))
ret.set_string(to_ret);else
ret.set_float(to_ret);this.owner.popTempValue();return;}
this.owner.popTempValue();}
index%=instances.length;if(index<0)
index+=instances.length;var inst=instances[index];var offset=0;if(this.object_type.is_family)
{offset=inst.type.family_var_map[this.object_type.family_index];}
var to_ret=inst.instance_vars[this.varindex+offset];if(cr.is_string(to_ret))
ret.set_string(to_ret);else
ret.set_float(to_ret);};ExpNode.prototype.eval_int=function(ret)
{ret.type=cr.exptype.Integer;ret.data=this.value;};ExpNode.prototype.eval_float=function(ret)
{ret.type=cr.exptype.Float;ret.data=this.value;};ExpNode.prototype.eval_string=function(ret)
{ret.type=cr.exptype.String;ret.data=this.value;};ExpNode.prototype.eval_unaryminus=function(ret)
{this.first.get(ret);if(ret.is_number())
ret.data=-ret.data;};ExpNode.prototype.eval_add=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{ret.data+=temp.data;if(temp.is_float())
ret.make_float();}
this.owner.popTempValue();};ExpNode.prototype.eval_subtract=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{ret.data-=temp.data;if(temp.is_float())
ret.make_float();}
this.owner.popTempValue();};ExpNode.prototype.eval_multiply=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{ret.data*=temp.data;if(temp.is_float())
ret.make_float();}
this.owner.popTempValue();};ExpNode.prototype.eval_divide=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{ret.data/=temp.data;ret.make_float();}
this.owner.popTempValue();};ExpNode.prototype.eval_mod=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{ret.data%=temp.data;if(temp.is_float())
ret.make_float();}
this.owner.popTempValue();};ExpNode.prototype.eval_power=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{ret.data=Math.pow(ret.data,temp.data);if(temp.is_float())
ret.make_float();}
this.owner.popTempValue();};ExpNode.prototype.eval_and=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number())
{if(temp.is_string())
{ret.set_string(ret.data.toString()+temp.data);}
else
{if(ret.data&&temp.data)
ret.set_int(1);else
ret.set_int(0);}}
else if(ret.is_string())
{if(temp.is_string())
ret.data+=temp.data;else
{ret.data+=(Math.round(temp.data*1e10)/1e10).toString();}}
this.owner.popTempValue();};ExpNode.prototype.eval_or=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);if(ret.is_number()&&temp.is_number())
{if(ret.data||temp.data)
ret.set_int(1);else
ret.set_int(0);}
this.owner.popTempValue();};ExpNode.prototype.eval_conditional=function(ret)
{this.first.get(ret);if(ret.data)
this.second.get(ret);else
this.third.get(ret);};ExpNode.prototype.eval_equal=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);ret.set_int(ret.data===temp.data?1:0);this.owner.popTempValue();};ExpNode.prototype.eval_notequal=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);ret.set_int(ret.data!==temp.data?1:0);this.owner.popTempValue();};ExpNode.prototype.eval_less=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);ret.set_int(ret.data<temp.data?1:0);this.owner.popTempValue();};ExpNode.prototype.eval_lessequal=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);ret.set_int(ret.data<=temp.data?1:0);this.owner.popTempValue();};ExpNode.prototype.eval_greater=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);ret.set_int(ret.data>temp.data?1:0);this.owner.popTempValue();};ExpNode.prototype.eval_greaterequal=function(ret)
{this.first.get(ret);var temp=this.owner.pushTempValue();this.second.get(temp);ret.set_int(ret.data>=temp.data?1:0);this.owner.popTempValue();};ExpNode.prototype.eval_eventvar_exp=function(ret)
{var val=this.eventvar.getValue();if(cr.is_number(val))
ret.set_float(val);else
ret.set_string(val);};cr.expNode=ExpNode;function ExpValue(type,data)
{this.type=type||cr.exptype.Integer;this.data=data||0;this.object_class=null;;;;if(this.type==cr.exptype.Integer)
this.data=Math.floor(this.data);cr.seal(this);};ExpValue.prototype.is_int=function()
{return this.type===cr.exptype.Integer;};ExpValue.prototype.is_float=function()
{return this.type===cr.exptype.Float;};ExpValue.prototype.is_number=function()
{return this.type===cr.exptype.Integer||this.type===cr.exptype.Float;};ExpValue.prototype.is_string=function()
{return this.type===cr.exptype.String;};ExpValue.prototype.make_int=function()
{if(!this.is_int())
{if(this.is_float())
this.data=Math.floor(this.data);else if(this.is_string())
this.data=parseInt(this.data,10);this.type=cr.exptype.Integer;}};ExpValue.prototype.make_float=function()
{if(!this.is_float())
{if(this.is_string())
this.data=parseFloat(this.data);this.type=cr.exptype.Float;}};ExpValue.prototype.make_string=function()
{if(!this.is_string())
{this.data=this.data.toString();this.type=cr.exptype.String;}};ExpValue.prototype.set_int=function(val)
{;this.type=cr.exptype.Integer;this.data=Math.floor(val);};ExpValue.prototype.set_float=function(val)
{;this.type=cr.exptype.Float;this.data=val;};ExpValue.prototype.set_string=function(val)
{;this.type=cr.exptype.String;this.data=val;};ExpValue.prototype.set_any=function(val)
{if(cr.is_number(val))
{this.type=cr.exptype.Float;this.data=val;}
else if(cr.is_string(val))
{this.type=cr.exptype.String;this.data=val.toString();}
else
{this.type=cr.exptype.Integer;this.data=0;}};cr.expvalue=ExpValue;cr.exptype={Integer:0,Float:1,String:2};}());;cr.system_object=function(runtime)
{this.runtime=runtime;this.waits=[];};cr.system_object.prototype.saveToJSON=function()
{var o={};var i,len,j,lenj,p,w,t,sobj;o["waits"]=[];var owaits=o["waits"];var waitobj;for(i=0,len=this.waits.length;i<len;i++)
{w=this.waits[i];waitobj={"t":w.time,"ev":w.ev.sid,"sm":[],"sols":{}};if(w.ev.actions[w.actindex])
waitobj["act"]=w.ev.actions[w.actindex].sid;for(j=0,lenj=w.solModifiers.length;j<lenj;j++)
waitobj["sm"].push(w.solModifiers[j].sid);for(p in w.sols)
{if(w.sols.hasOwnProperty(p))
{t=this.runtime.types_by_index[parseInt(p,10)];;sobj={"sa":w.sols[p].sa,"insts":[]};for(j=0,lenj=w.sols[p].insts.length;j<lenj;j++)
sobj["insts"].push(w.sols[p].insts[j].uid);waitobj["sols"][t.sid.toString()]=sobj;}}
owaits.push(waitobj);}
return o;};cr.system_object.prototype.loadFromJSON=function(o)
{var owaits=o["waits"];var i,len,j,lenj,p,w,addWait,e,aindex,t,savedsol,nusol,inst;this.waits.length=0;for(i=0,len=owaits.length;i<len;i++)
{w=owaits[i];e=this.runtime.blocksBySid[w["ev"].toString()];if(!e)
continue;aindex=-1;for(j=0,lenj=e.actions.length;j<lenj;j++)
{if(e.actions[j].sid===w["act"])
{aindex=j;break;}}
if(aindex===-1)
continue;addWait={};addWait.sols={};addWait.solModifiers=[];addWait.deleteme=false;addWait.time=w["t"];addWait.ev=e;addWait.actindex=aindex;for(j=0,lenj=w["sm"].length;j<lenj;j++)
{t=this.runtime.getObjectTypeBySid(w["sm"][j]);if(t)
addWait.solModifiers.push(t);}
for(p in w["sols"])
{if(w["sols"].hasOwnProperty(p))
{t=this.runtime.getObjectTypeBySid(parseInt(p,10));if(!t)
continue;savedsol=w["sols"][p];nusol={sa:savedsol["sa"],insts:[]};for(j=0,lenj=savedsol["insts"].length;j<lenj;j++)
{inst=this.runtime.getObjectByUID(savedsol["insts"][j]);if(inst)
nusol.insts.push(inst);}
addWait.sols[t.index.toString()]=nusol;}}
this.waits.push(addWait);}};(function()
{var sysProto=cr.system_object.prototype;function SysCnds(){};SysCnds.prototype.EveryTick=function()
{return true;};SysCnds.prototype.OnLayoutStart=function()
{return true;};SysCnds.prototype.OnLayoutEnd=function()
{return true;};SysCnds.prototype.Compare=function(x,cmp,y)
{return cr.do_cmp(x,cmp,y);};SysCnds.prototype.CompareTime=function(cmp,t)
{var elapsed=this.runtime.kahanTime.sum;if(cmp===0)
{var cnd=this.runtime.getCurrentCondition();if(!cnd.extra.CompareTime_executed)
{if(elapsed>=t)
{cnd.extra.CompareTime_executed=true;return true;}}
return false;}
return cr.do_cmp(elapsed,cmp,t);};SysCnds.prototype.LayerVisible=function(layer)
{if(!layer)
return false;else
return layer.visible;};SysCnds.prototype.LayerCmpOpacity=function(layer,cmp,opacity_)
{if(!layer)
return false;return cr.do_cmp(layer.opacity*100,cmp,opacity_);};SysCnds.prototype.Repeat=function(count)
{var current_frame=this.runtime.getCurrentEventStack();var current_event=current_frame.current_event;var solModifierAfterCnds=current_frame.isModifierAfterCnds();var current_loop=this.runtime.pushLoopStack();var i;if(solModifierAfterCnds)
{for(i=0;i<count&&!current_loop.stopped;i++)
{this.runtime.pushCopySol(current_event.solModifiers);current_loop.index=i;current_event.retrigger();this.runtime.popSol(current_event.solModifiers);}}
else
{for(i=0;i<count&&!current_loop.stopped;i++)
{current_loop.index=i;current_event.retrigger();}}
this.runtime.popLoopStack();return false;};SysCnds.prototype.While=function(count)
{var current_frame=this.runtime.getCurrentEventStack();var current_event=current_frame.current_event;var solModifierAfterCnds=current_frame.isModifierAfterCnds();var current_loop=this.runtime.pushLoopStack();var i;if(solModifierAfterCnds)
{for(i=0;!current_loop.stopped;i++)
{this.runtime.pushCopySol(current_event.solModifiers);current_loop.index=i;if(!current_event.retrigger())
current_loop.stopped=true;this.runtime.popSol(current_event.solModifiers);}}
else
{for(i=0;!current_loop.stopped;i++)
{current_loop.index=i;if(!current_event.retrigger())
current_loop.stopped=true;}}
this.runtime.popLoopStack();return false;};SysCnds.prototype.For=function(name,start,end)
{var current_frame=this.runtime.getCurrentEventStack();var current_event=current_frame.current_event;var solModifierAfterCnds=current_frame.isModifierAfterCnds();var current_loop=this.runtime.pushLoopStack(name);var i;if(end<start)
{if(solModifierAfterCnds)
{for(i=start;i>=end&&!current_loop.stopped;--i)
{this.runtime.pushCopySol(current_event.solModifiers);current_loop.index=i;current_event.retrigger();this.runtime.popSol(current_event.solModifiers);}}
else
{for(i=start;i>=end&&!current_loop.stopped;--i)
{current_loop.index=i;current_event.retrigger();}}}
else
{if(solModifierAfterCnds)
{for(i=start;i<=end&&!current_loop.stopped;++i)
{this.runtime.pushCopySol(current_event.solModifiers);current_loop.index=i;current_event.retrigger();this.runtime.popSol(current_event.solModifiers);}}
else
{for(i=start;i<=end&&!current_loop.stopped;++i)
{current_loop.index=i;current_event.retrigger();}}}
this.runtime.popLoopStack();return false;};var foreach_instancestack=[];var foreach_instanceptr=-1;SysCnds.prototype.ForEach=function(obj)
{var sol=obj.getCurrentSol();foreach_instanceptr++;if(foreach_instancestack.length===foreach_instanceptr)
foreach_instancestack.push([]);var instances=foreach_instancestack[foreach_instanceptr];cr.shallowAssignArray(instances,sol.getObjects());var current_frame=this.runtime.getCurrentEventStack();var current_event=current_frame.current_event;var solModifierAfterCnds=current_frame.isModifierAfterCnds();var current_loop=this.runtime.pushLoopStack();var i,len,j,lenj,inst,s,sol2;var is_contained=obj.is_contained;if(solModifierAfterCnds)
{for(i=0,len=instances.length;i<len&&!current_loop.stopped;i++)
{this.runtime.pushCopySol(current_event.solModifiers);inst=instances[i];sol=obj.getCurrentSol();sol.select_all=false;sol.instances.length=1;sol.instances[0]=inst;if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];sol2=s.type.getCurrentSol();sol2.select_all=false;sol2.instances.length=1;sol2.instances[0]=s;}}
current_loop.index=i;current_event.retrigger();this.runtime.popSol(current_event.solModifiers);}}
else
{sol.select_all=false;sol.instances.length=1;for(i=0,len=instances.length;i<len&&!current_loop.stopped;i++)
{inst=instances[i];sol.instances[0]=inst;if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];sol2=s.type.getCurrentSol();sol2.select_all=false;sol2.instances.length=1;sol2.instances[0]=s;}}
current_loop.index=i;current_event.retrigger();}}
instances.length=0;this.runtime.popLoopStack();foreach_instanceptr--;return false;};function foreach_sortinstances(a,b)
{var va=a.extra.c2_foreachordered_val;var vb=b.extra.c2_foreachordered_val;if(cr.is_number(va)&&cr.is_number(vb))
return va-vb;else
{va=""+va;vb=""+vb;if(va<vb)
return-1;else if(va>vb)
return 1;else
return 0;}};SysCnds.prototype.ForEachOrdered=function(obj,exp,order)
{var sol=obj.getCurrentSol();foreach_instanceptr++;if(foreach_instancestack.length===foreach_instanceptr)
foreach_instancestack.push([]);var instances=foreach_instancestack[foreach_instanceptr];cr.shallowAssignArray(instances,sol.getObjects());var current_frame=this.runtime.getCurrentEventStack();var current_event=current_frame.current_event;var current_condition=this.runtime.getCurrentCondition();var solModifierAfterCnds=current_frame.isModifierAfterCnds();var current_loop=this.runtime.pushLoopStack();var i,len,j,lenj,inst,s,sol2;for(i=0,len=instances.length;i<len;i++)
{instances[i].extra.c2_foreachordered_val=current_condition.parameters[1].get(i);}
instances.sort(foreach_sortinstances);if(order===1)
instances.reverse();var is_contained=obj.is_contained;if(solModifierAfterCnds)
{for(i=0,len=instances.length;i<len&&!current_loop.stopped;i++)
{this.runtime.pushCopySol(current_event.solModifiers);inst=instances[i];sol=obj.getCurrentSol();sol.select_all=false;sol.instances.length=1;sol.instances[0]=inst;if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];sol2=s.type.getCurrentSol();sol2.select_all=false;sol2.instances.length=1;sol2.instances[0]=s;}}
current_loop.index=i;current_event.retrigger();this.runtime.popSol(current_event.solModifiers);}}
else
{sol.select_all=false;sol.instances.length=1;for(i=0,len=instances.length;i<len&&!current_loop.stopped;i++)
{inst=instances[i];sol.instances[0]=inst;if(is_contained)
{for(j=0,lenj=inst.siblings.length;j<lenj;j++)
{s=inst.siblings[j];sol2=s.type.getCurrentSol();sol2.select_all=false;sol2.instances.length=1;sol2.instances[0]=s;}}
current_loop.index=i;current_event.retrigger();}}
instances.length=0;this.runtime.popLoopStack();foreach_instanceptr--;return false;};SysCnds.prototype.PickByComparison=function(obj_,exp_,cmp_,val_)
{var i,len,k,inst;if(!obj_)
return;foreach_instanceptr++;if(foreach_instancestack.length===foreach_instanceptr)
foreach_instancestack.push([]);var tmp_instances=foreach_instancestack[foreach_instanceptr];var sol=obj_.getCurrentSol();cr.shallowAssignArray(tmp_instances,sol.getObjects());if(sol.select_all)
sol.else_instances.length=0;var current_condition=this.runtime.getCurrentCondition();for(i=0,k=0,len=tmp_instances.length;i<len;i++)
{inst=tmp_instances[i];tmp_instances[k]=inst;exp_=current_condition.parameters[1].get(i);val_=current_condition.parameters[3].get(i);if(cr.do_cmp(exp_,cmp_,val_))
{k++;}
else
{sol.else_instances.push(inst);}}
tmp_instances.length=k;sol.select_all=false;cr.shallowAssignArray(sol.instances,tmp_instances);tmp_instances.length=0;foreach_instanceptr--;obj_.applySolToContainer();return!!sol.instances.length;};SysCnds.prototype.PickByEvaluate=function(obj_,exp_)
{var i,len,k,inst;if(!obj_)
return;foreach_instanceptr++;if(foreach_instancestack.length===foreach_instanceptr)
foreach_instancestack.push([]);var tmp_instances=foreach_instancestack[foreach_instanceptr];var sol=obj_.getCurrentSol();cr.shallowAssignArray(tmp_instances,sol.getObjects());if(sol.select_all)
sol.else_instances.length=0;var current_condition=this.runtime.getCurrentCondition();for(i=0,k=0,len=tmp_instances.length;i<len;i++)
{inst=tmp_instances[i];tmp_instances[k]=inst;exp_=current_condition.parameters[1].get(i);if(exp_)
{k++;}
else
{sol.else_instances.push(inst);}}
tmp_instances.length=k;sol.select_all=false;cr.shallowAssignArray(sol.instances,tmp_instances);tmp_instances.length=0;foreach_instanceptr--;obj_.applySolToContainer();return!!sol.instances.length;};SysCnds.prototype.TriggerOnce=function()
{var cndextra=this.runtime.getCurrentCondition().extra;if(typeof cndextra.TriggerOnce_lastTick==="undefined")
cndextra.TriggerOnce_lastTick=-1;var last_tick=cndextra.TriggerOnce_lastTick;var cur_tick=this.runtime.tickcount;cndextra.TriggerOnce_lastTick=cur_tick;return this.runtime.layout_first_tick||last_tick!==cur_tick-1;};SysCnds.prototype.Every=function(seconds)
{var cnd=this.runtime.getCurrentCondition();var last_time=cnd.extra.Every_lastTime||0;var cur_time=this.runtime.kahanTime.sum;if(typeof cnd.extra.Every_seconds==="undefined")
cnd.extra.Every_seconds=seconds;var this_seconds=cnd.extra.Every_seconds;if(cur_time>=last_time+this_seconds)
{cnd.extra.Every_lastTime=last_time+this_seconds;if(cur_time>=cnd.extra.Every_lastTime+this_seconds)
cnd.extra.Every_lastTime=cur_time;cnd.extra.Every_seconds=seconds;return true;}
else
return false;};SysCnds.prototype.PickNth=function(obj,index)
{if(!obj)
return false;var sol=obj.getCurrentSol();var instances=sol.getObjects();index=cr.floor(index);if(index<0||index>=instances.length)
return false;var inst=instances[index];sol.pick_one(inst);obj.applySolToContainer();return true;};SysCnds.prototype.PickRandom=function(obj)
{if(!obj)
return false;var sol=obj.getCurrentSol();var instances=sol.getObjects();var index=cr.floor(Math.random()*instances.length);if(index>=instances.length)
return false;var inst=instances[index];sol.pick_one(inst);obj.applySolToContainer();return true;};SysCnds.prototype.CompareVar=function(v,cmp,val)
{return cr.do_cmp(v.getValue(),cmp,val);};SysCnds.prototype.IsGroupActive=function(group)
{return this.runtime.activeGroups[(group).toLowerCase()];};SysCnds.prototype.IsPreview=function()
{return typeof cr_is_preview!=="undefined";};SysCnds.prototype.PickAll=function(obj)
{if(!obj)
return false;if(!obj.instances.length)
return false;var sol=obj.getCurrentSol();sol.select_all=true;obj.applySolToContainer();return true;};SysCnds.prototype.IsMobile=function()
{return this.runtime.isMobile;};SysCnds.prototype.CompareBetween=function(x,a,b)
{return x>=a&&x<=b;};SysCnds.prototype.Else=function()
{var current_frame=this.runtime.getCurrentEventStack();if(current_frame.else_branch_ran)
return false;else
return!current_frame.last_event_true;};SysCnds.prototype.OnLoadFinished=function()
{return true;};SysCnds.prototype.OnCanvasSnapshot=function()
{return true;};SysCnds.prototype.EffectsSupported=function()
{return!!this.runtime.glwrap;};SysCnds.prototype.OnSaveComplete=function()
{return true;};SysCnds.prototype.OnLoadComplete=function()
{return true;};SysCnds.prototype.OnLoadFailed=function()
{return true;};SysCnds.prototype.ObjectUIDExists=function(u)
{return!!this.runtime.getObjectByUID(u);};SysCnds.prototype.IsOnPlatform=function(p)
{var rt=this.runtime;switch(p){case 0:return!rt.isDomFree&&!rt.isNodeWebkit&&!rt.isPhoneGap&&!rt.isWindows8App&&!rt.isWindowsPhone8&&!rt.isBlackberry10;case 1:return rt.isiOS;case 2:return rt.isAndroid;case 3:return rt.isWindows8App;case 4:return rt.isWindowsPhone8;case 5:return rt.isBlackberry10;case 6:return rt.isTizen;case 7:return rt.isNodeWebkit;case 8:return rt.isCocoonJs;case 9:return rt.isPhoneGap;case 10:return rt.isArcade;case 11:return rt.isNodeWebkit;default:return false;}};var cacheRegex=null;var lastRegex="";var lastFlags="";function getRegex(regex_,flags_)
{if(!cacheRegex||regex_!==lastRegex||flags_!==lastFlags)
{cacheRegex=new RegExp(regex_,flags_);lastRegex=regex_;lastFlags=flags_;}
cacheRegex.lastIndex=0;return cacheRegex;};SysCnds.prototype.RegexTest=function(str_,regex_,flags_)
{var regex=getRegex(regex_,flags_);return regex.test(str_);};var tmp_arr=[];SysCnds.prototype.PickOverlappingPoint=function(obj_,x_,y_)
{if(!obj_)
return false;var sol=obj_.getCurrentSol();var instances=sol.getObjects();var current_event=this.runtime.getCurrentEventStack().current_event;var orblock=current_event.orblock;var cnd=this.runtime.getCurrentCondition();var i,len,inst,pick;if(sol.select_all)
{cr.shallowAssignArray(tmp_arr,instances);sol.else_instances.length=0;sol.select_all=false;sol.instances.length=0;}
else
{if(orblock)
{cr.shallowAssignArray(tmp_arr,sol.else_instances);sol.else_instances.length=0;}
else
{cr.shallowAssignArray(tmp_arr,instances);sol.instances.length=0;}}
for(i=0,len=tmp_arr.length;i<len;++i)
{inst=tmp_arr[i];pick=cr.xor(inst.contains_pt(x_,y_),cnd.inverted);if(pick)
sol.instances.push(inst);else
sol.else_instances.push(inst);}
obj_.applySolToContainer();return cr.xor(!!sol.instances.length,cnd.inverted);};sysProto.cnds=new SysCnds();function SysActs(){};SysActs.prototype.GoToLayout=function(to)
{if(this.runtime.isloading)
return;if(this.runtime.changelayout)
return;;this.runtime.changelayout=to;};SysActs.prototype.CreateObject=function(obj,layer,x,y)
{if(!layer||!obj)
return;var inst=this.runtime.createInstance(obj,layer,x,y);if(!inst)
return;this.runtime.isInOnDestroy++;var i,len,s;this.runtime.trigger(Object.getPrototypeOf(obj.plugin).cnds.OnCreated,inst);if(inst.is_contained)
{for(i=0,len=inst.siblings.length;i<len;i++)
{s=inst.siblings[i];this.runtime.trigger(Object.getPrototypeOf(s.type.plugin).cnds.OnCreated,s);}}
this.runtime.isInOnDestroy--;var sol=obj.getCurrentSol();sol.select_all=false;sol.instances.length=1;sol.instances[0]=inst;if(inst.is_contained)
{for(i=0,len=inst.siblings.length;i<len;i++)
{s=inst.siblings[i];sol=s.type.getCurrentSol();sol.select_all=false;sol.instances.length=1;sol.instances[0]=s;}}};SysActs.prototype.SetLayerVisible=function(layer,visible_)
{if(!layer)
return;if(layer.visible!==visible_)
{layer.visible=visible_;this.runtime.redraw=true;}};SysActs.prototype.SetLayerOpacity=function(layer,opacity_)
{if(!layer)
return;opacity_=cr.clamp(opacity_/100,0,1);if(layer.opacity!==opacity_)
{layer.opacity=opacity_;this.runtime.redraw=true;}};SysActs.prototype.SetLayerScaleRate=function(layer,sr)
{if(!layer)
return;if(layer.zoomRate!==sr)
{layer.zoomRate=sr;this.runtime.redraw=true;}};SysActs.prototype.SetLayoutScale=function(s)
{if(!this.runtime.running_layout)
return;if(this.runtime.running_layout.scale!==s)
{this.runtime.running_layout.scale=s;this.runtime.running_layout.boundScrolling();this.runtime.redraw=true;}};SysActs.prototype.ScrollX=function(x)
{this.runtime.running_layout.scrollToX(x);};SysActs.prototype.ScrollY=function(y)
{this.runtime.running_layout.scrollToY(y);};SysActs.prototype.Scroll=function(x,y)
{this.runtime.running_layout.scrollToX(x);this.runtime.running_layout.scrollToY(y);};SysActs.prototype.ScrollToObject=function(obj)
{var inst=obj.getFirstPicked();if(inst)
{this.runtime.running_layout.scrollToX(inst.x);this.runtime.running_layout.scrollToY(inst.y);}};SysActs.prototype.SetVar=function(v,x)
{;if(v.vartype===0)
{if(cr.is_number(x))
v.setValue(x);else
v.setValue(parseFloat(x));}
else if(v.vartype===1)
v.setValue(x.toString());};SysActs.prototype.AddVar=function(v,x)
{;if(v.vartype===0)
{if(cr.is_number(x))
v.setValue(v.getValue()+x);else
v.setValue(v.getValue()+parseFloat(x));}
else if(v.vartype===1)
v.setValue(v.getValue()+x.toString());};SysActs.prototype.SubVar=function(v,x)
{;if(v.vartype===0)
{if(cr.is_number(x))
v.setValue(v.getValue()-x);else
v.setValue(v.getValue()-parseFloat(x));}};SysActs.prototype.SetGroupActive=function(group,active)
{var activeGroups=this.runtime.activeGroups;var groupkey=(group).toLowerCase();switch(active){case 0:activeGroups[groupkey]=false;break;case 1:activeGroups[groupkey]=true;break;case 2:activeGroups[groupkey]=!activeGroups[groupkey];break;}};SysActs.prototype.SetTimescale=function(ts_)
{var ts=ts_;if(ts<0)
ts=0;this.runtime.timescale=ts;};SysActs.prototype.SetObjectTimescale=function(obj,ts_)
{var ts=ts_;if(ts<0)
ts=0;if(!obj)
return;var sol=obj.getCurrentSol();var instances=sol.getObjects();var i,len;for(i=0,len=instances.length;i<len;i++)
{instances[i].my_timescale=ts;}};SysActs.prototype.RestoreObjectTimescale=function(obj)
{if(!obj)
return false;var sol=obj.getCurrentSol();var instances=sol.getObjects();var i,len;for(i=0,len=instances.length;i<len;i++)
{instances[i].my_timescale=-1.0;}};var waitobjrecycle=[];function allocWaitObject()
{var w;if(waitobjrecycle.length)
w=waitobjrecycle.pop();else
{w={};w.sols={};w.solModifiers=[];}
w.deleteme=false;return w;};function freeWaitObject(w)
{cr.wipe(w.sols);w.solModifiers.length=0;waitobjrecycle.push(w);};var solstateobjects=[];function allocSolStateObject()
{var s;if(solstateobjects.length)
s=solstateobjects.pop();else
{s={};s.insts=[];}
s.sa=false;return s;};function freeSolStateObject(s)
{s.insts.length=0;solstateobjects.push(s);};SysActs.prototype.Wait=function(seconds)
{if(seconds<0)
return;var i,len,s,t,ss;var evinfo=this.runtime.getCurrentEventStack();var waitobj=allocWaitObject();waitobj.time=this.runtime.kahanTime.sum+seconds;waitobj.ev=evinfo.current_event;waitobj.actindex=evinfo.actindex+1;for(i=0,len=this.runtime.types_by_index.length;i<len;i++)
{t=this.runtime.types_by_index[i];s=t.getCurrentSol();if(s.select_all&&evinfo.current_event.solModifiers.indexOf(t)===-1)
continue;waitobj.solModifiers.push(t);ss=allocSolStateObject();ss.sa=s.select_all;cr.shallowAssignArray(ss.insts,s.instances);waitobj.sols[i.toString()]=ss;}
this.waits.push(waitobj);return true;};SysActs.prototype.SetLayerScale=function(layer,scale)
{if(!layer)
return;if(layer.scale===scale)
return;layer.scale=scale;this.runtime.redraw=true;};SysActs.prototype.ResetGlobals=function()
{var i,len,g;for(i=0,len=this.runtime.all_global_vars.length;i<len;i++)
{g=this.runtime.all_global_vars[i];g.data=g.initial;}};SysActs.prototype.SetLayoutAngle=function(a)
{a=cr.to_radians(a);a=cr.clamp_angle(a);if(this.runtime.running_layout)
{if(this.runtime.running_layout.angle!==a)
{this.runtime.running_layout.angle=a;this.runtime.redraw=true;}}};SysActs.prototype.SetLayerAngle=function(layer,a)
{if(!layer)
return;a=cr.to_radians(a);a=cr.clamp_angle(a);if(layer.angle===a)
return;layer.angle=a;this.runtime.redraw=true;};SysActs.prototype.SetLayerParallax=function(layer,px,py)
{if(!layer)
return;if(layer.parallaxX===px/100&&layer.parallaxY===py/100)
return;layer.parallaxX=px/100;layer.parallaxY=py/100;this.runtime.redraw=true;};SysActs.prototype.SetLayerBackground=function(layer,c)
{if(!layer)
return;var r=cr.GetRValue(c);var g=cr.GetGValue(c);var b=cr.GetBValue(c);if(layer.background_color[0]===r&&layer.background_color[1]===g&&layer.background_color[2]===b)
return;layer.background_color[0]=r;layer.background_color[1]=g;layer.background_color[2]=b;this.runtime.redraw=true;};SysActs.prototype.SetLayerTransparent=function(layer,t)
{if(!layer)
return;if(!!t===!!layer.transparent)
return;layer.transparent=!!t;this.runtime.redraw=true;};SysActs.prototype.StopLoop=function()
{if(this.runtime.loop_stack_index<0)
return;this.runtime.getCurrentLoop().stopped=true;};SysActs.prototype.GoToLayoutByName=function(layoutname)
{if(this.runtime.isloading)
return;if(this.runtime.changelayout)
return;;var l;for(l in this.runtime.layouts)
{if(this.runtime.layouts.hasOwnProperty(l)&&cr.equals_nocase(l,layoutname))
{this.runtime.changelayout=this.runtime.layouts[l];return;}}};SysActs.prototype.RestartLayout=function(layoutname)
{if(this.runtime.isloading)
return;if(this.runtime.changelayout)
return;;if(!this.runtime.running_layout)
return;this.runtime.changelayout=this.runtime.running_layout;var i,len,g;for(i=0,len=this.runtime.allGroups.length;i<len;i++)
{g=this.runtime.allGroups[i];this.runtime.activeGroups[g.group_name.toLowerCase()]=g.initially_activated;}};SysActs.prototype.SnapshotCanvas=function(format_,quality_)
{this.runtime.snapshotCanvas=[format_===0?"image/png":"image/jpeg",quality_/100];this.runtime.redraw=true;};SysActs.prototype.SetCanvasSize=function(w,h)
{if(w<=0||h<=0)
return;this.runtime["setSize"](w,h);};SysActs.prototype.SetLayoutEffectEnabled=function(enable_,effectname_)
{if(!this.runtime.running_layout||!this.runtime.glwrap)
return;var et=this.runtime.running_layout.getEffectByName(effectname_);if(!et)
return;var enable=(enable_===1);if(et.active==enable)
return;et.active=enable;this.runtime.running_layout.updateActiveEffects();this.runtime.redraw=true;};SysActs.prototype.SetLayerEffectEnabled=function(layer,enable_,effectname_)
{if(!layer||!this.runtime.glwrap)
return;var et=layer.getEffectByName(effectname_);if(!et)
return;var enable=(enable_===1);if(et.active==enable)
return;et.active=enable;layer.updateActiveEffects();this.runtime.redraw=true;};SysActs.prototype.SetLayoutEffectParam=function(effectname_,index_,value_)
{if(!this.runtime.running_layout||!this.runtime.glwrap)
return;var et=this.runtime.running_layout.getEffectByName(effectname_);if(!et)
return;var params=this.runtime.running_layout.effect_params[et.index];index_=Math.floor(index_);if(index_<0||index_>=params.length)
return;if(this.runtime.glwrap.getProgramParameterType(et.shaderindex,index_)===1)
value_/=100.0;if(params[index_]===value_)
return;params[index_]=value_;if(et.active)
this.runtime.redraw=true;};SysActs.prototype.SetLayerEffectParam=function(layer,effectname_,index_,value_)
{if(!layer||!this.runtime.glwrap)
return;var et=layer.getEffectByName(effectname_);if(!et)
return;var params=layer.effect_params[et.index];index_=Math.floor(index_);if(index_<0||index_>=params.length)
return;if(this.runtime.glwrap.getProgramParameterType(et.shaderindex,index_)===1)
value_/=100.0;if(params[index_]===value_)
return;params[index_]=value_;if(et.active)
this.runtime.redraw=true;};SysActs.prototype.SaveState=function(slot_)
{this.runtime.saveToSlot=slot_;};SysActs.prototype.LoadState=function(slot_)
{this.runtime.loadFromSlot=slot_;};SysActs.prototype.LoadStateJSON=function(jsonstr_)
{this.runtime.loadFromJson=jsonstr_;};sysProto.acts=new SysActs();function SysExps(){};SysExps.prototype["int"]=function(ret,x)
{if(cr.is_string(x))
{ret.set_int(parseInt(x,10));if(isNaN(ret.data))
ret.data=0;}
else
ret.set_int(x);};SysExps.prototype["float"]=function(ret,x)
{if(cr.is_string(x))
{ret.set_float(parseFloat(x));if(isNaN(ret.data))
ret.data=0;}
else
ret.set_float(x);};SysExps.prototype.str=function(ret,x)
{if(cr.is_string(x))
ret.set_string(x);else
ret.set_string(x.toString());};SysExps.prototype.len=function(ret,x)
{ret.set_int(x.length||0);};SysExps.prototype.random=function(ret,a,b)
{if(b===undefined)
{ret.set_float(Math.random()*a);}
else
{ret.set_float(Math.random()*(b-a)+a);}};SysExps.prototype.sqrt=function(ret,x)
{ret.set_float(Math.sqrt(x));};SysExps.prototype.abs=function(ret,x)
{ret.set_float(Math.abs(x));};SysExps.prototype.round=function(ret,x)
{ret.set_int(Math.round(x));};SysExps.prototype.floor=function(ret,x)
{ret.set_int(Math.floor(x));};SysExps.prototype.ceil=function(ret,x)
{ret.set_int(Math.ceil(x));};SysExps.prototype.sin=function(ret,x)
{ret.set_float(Math.sin(cr.to_radians(x)));};SysExps.prototype.cos=function(ret,x)
{ret.set_float(Math.cos(cr.to_radians(x)));};SysExps.prototype.tan=function(ret,x)
{ret.set_float(Math.tan(cr.to_radians(x)));};SysExps.prototype.asin=function(ret,x)
{ret.set_float(cr.to_degrees(Math.asin(x)));};SysExps.prototype.acos=function(ret,x)
{ret.set_float(cr.to_degrees(Math.acos(x)));};SysExps.prototype.atan=function(ret,x)
{ret.set_float(cr.to_degrees(Math.atan(x)));};SysExps.prototype.exp=function(ret,x)
{ret.set_float(Math.exp(x));};SysExps.prototype.ln=function(ret,x)
{ret.set_float(Math.log(x));};SysExps.prototype.log10=function(ret,x)
{ret.set_float(Math.log(x)/Math.LN10);};SysExps.prototype.max=function(ret)
{var max_=arguments[1];var i,len;for(i=2,len=arguments.length;i<len;i++)
{if(max_<arguments[i])
max_=arguments[i];}
ret.set_float(max_);};SysExps.prototype.min=function(ret)
{var min_=arguments[1];var i,len;for(i=2,len=arguments.length;i<len;i++)
{if(min_>arguments[i])
min_=arguments[i];}
ret.set_float(min_);};SysExps.prototype.dt=function(ret)
{ret.set_float(this.runtime.dt);};SysExps.prototype.timescale=function(ret)
{ret.set_float(this.runtime.timescale);};SysExps.prototype.wallclocktime=function(ret)
{ret.set_float((Date.now()-this.runtime.start_time)/1000.0);};SysExps.prototype.time=function(ret)
{ret.set_float(this.runtime.kahanTime.sum);};SysExps.prototype.tickcount=function(ret)
{ret.set_int(this.runtime.tickcount);};SysExps.prototype.objectcount=function(ret)
{ret.set_int(this.runtime.objectcount);};SysExps.prototype.fps=function(ret)
{ret.set_int(this.runtime.fps);};SysExps.prototype.loopindex=function(ret,name_)
{var loop,i,len;if(!this.runtime.loop_stack.length)
{ret.set_int(0);return;}
if(name_)
{for(i=0,len=this.runtime.loop_stack.length;i<len;i++)
{loop=this.runtime.loop_stack[i];if(loop.name===name_)
{ret.set_int(loop.index);return;}}
ret.set_int(0);}
else
{loop=this.runtime.getCurrentLoop();ret.set_int(loop?loop.index:-1);}};SysExps.prototype.distance=function(ret,x1,y1,x2,y2)
{ret.set_float(cr.distanceTo(x1,y1,x2,y2));};SysExps.prototype.angle=function(ret,x1,y1,x2,y2)
{ret.set_float(cr.to_degrees(cr.angleTo(x1,y1,x2,y2)));};SysExps.prototype.scrollx=function(ret)
{ret.set_float(this.runtime.running_layout.scrollX);};SysExps.prototype.scrolly=function(ret)
{ret.set_float(this.runtime.running_layout.scrollY);};SysExps.prototype.newline=function(ret)
{ret.set_string("\n");};SysExps.prototype.lerp=function(ret,a,b,x)
{ret.set_float(cr.lerp(a,b,x));};SysExps.prototype.windowwidth=function(ret)
{ret.set_int(this.runtime.width);};SysExps.prototype.windowheight=function(ret)
{ret.set_int(this.runtime.height);};SysExps.prototype.uppercase=function(ret,str)
{ret.set_string(cr.is_string(str)?str.toUpperCase():"");};SysExps.prototype.lowercase=function(ret,str)
{ret.set_string(cr.is_string(str)?str.toLowerCase():"");};SysExps.prototype.clamp=function(ret,x,l,u)
{if(x<l)
ret.set_float(l);else if(x>u)
ret.set_float(u);else
ret.set_float(x);};SysExps.prototype.layerscale=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);if(!layer)
ret.set_float(0);else
ret.set_float(layer.scale);};SysExps.prototype.layeropacity=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);if(!layer)
ret.set_float(0);else
ret.set_float(layer.opacity*100);};SysExps.prototype.layerscalerate=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);if(!layer)
ret.set_float(0);else
ret.set_float(layer.zoomRate);};SysExps.prototype.layerparallaxx=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);if(!layer)
ret.set_float(0);else
ret.set_float(layer.parallaxX*100);};SysExps.prototype.layerparallaxy=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);if(!layer)
ret.set_float(0);else
ret.set_float(layer.parallaxY*100);};SysExps.prototype.layoutscale=function(ret)
{if(this.runtime.running_layout)
ret.set_float(this.runtime.running_layout.scale);else
ret.set_float(0);};SysExps.prototype.layoutangle=function(ret)
{ret.set_float(cr.to_degrees(this.runtime.running_layout.angle));};SysExps.prototype.layerangle=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);if(!layer)
ret.set_float(0);else
ret.set_float(cr.to_degrees(layer.angle));};SysExps.prototype.layoutwidth=function(ret)
{ret.set_int(this.runtime.running_layout.width);};SysExps.prototype.layoutheight=function(ret)
{ret.set_int(this.runtime.running_layout.height);};SysExps.prototype.find=function(ret,text,searchstr)
{if(cr.is_string(text)&&cr.is_string(searchstr))
ret.set_int(text.search(new RegExp(cr.regexp_escape(searchstr),"i")));else
ret.set_int(-1);};SysExps.prototype.left=function(ret,text,n)
{ret.set_string(cr.is_string(text)?text.substr(0,n):"");};SysExps.prototype.right=function(ret,text,n)
{ret.set_string(cr.is_string(text)?text.substr(text.length-n):"");};SysExps.prototype.mid=function(ret,text,index_,length_)
{ret.set_string(cr.is_string(text)?text.substr(index_,length_):"");};SysExps.prototype.tokenat=function(ret,text,index_,sep)
{if(cr.is_string(text)&&cr.is_string(sep))
{var arr=text.split(sep);var i=cr.floor(index_);if(i<0||i>=arr.length)
ret.set_string("");else
ret.set_string(arr[i]);}
else
ret.set_string("");};SysExps.prototype.tokencount=function(ret,text,sep)
{if(cr.is_string(text)&&text.length)
ret.set_int(text.split(sep).length);else
ret.set_int(0);};SysExps.prototype.replace=function(ret,text,find_,replace_)
{if(cr.is_string(text)&&cr.is_string(find_)&&cr.is_string(replace_))
ret.set_string(text.replace(new RegExp(cr.regexp_escape(find_),"gi"),replace_));else
ret.set_string(cr.is_string(text)?text:"");};SysExps.prototype.trim=function(ret,text)
{ret.set_string(cr.is_string(text)?text.trim():"");};SysExps.prototype.pi=function(ret)
{ret.set_float(cr.PI);};SysExps.prototype.layoutname=function(ret)
{if(this.runtime.running_layout)
ret.set_string(this.runtime.running_layout.name);else
ret.set_string("");};SysExps.prototype.renderer=function(ret)
{ret.set_string(this.runtime.gl?"webgl":"canvas2d");};SysExps.prototype.anglediff=function(ret,a,b)
{ret.set_float(cr.to_degrees(cr.angleDiff(cr.to_radians(a),cr.to_radians(b))));};SysExps.prototype.choose=function(ret)
{var index=cr.floor(Math.random()*(arguments.length-1));ret.set_any(arguments[index+1]);};SysExps.prototype.rgb=function(ret,r,g,b)
{ret.set_int(cr.RGB(r,g,b));};SysExps.prototype.projectversion=function(ret)
{ret.set_string(this.runtime.versionstr);};SysExps.prototype.anglelerp=function(ret,a,b,x)
{a=cr.to_radians(a);b=cr.to_radians(b);var diff=cr.angleDiff(a,b);if(cr.angleClockwise(b,a))
{ret.set_float(cr.to_clamped_degrees(a+diff*x));}
else
{ret.set_float(cr.to_clamped_degrees(a-diff*x));}};SysExps.prototype.anglerotate=function(ret,a,b,c)
{a=cr.to_radians(a);b=cr.to_radians(b);c=cr.to_radians(c);ret.set_float(cr.to_clamped_degrees(cr.angleRotate(a,b,c)));};SysExps.prototype.zeropad=function(ret,n,d)
{var s=(n<0?"-":"");if(n<0)n=-n;var zeroes=d-n.toString().length;for(var i=0;i<zeroes;i++)
s+="0";ret.set_string(s+n.toString());};SysExps.prototype.cpuutilisation=function(ret)
{ret.set_float(this.runtime.cpuutilisation/1000);};SysExps.prototype.viewportleft=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.viewLeft:0);};SysExps.prototype.viewporttop=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.viewTop:0);};SysExps.prototype.viewportright=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.viewRight:0);};SysExps.prototype.viewportbottom=function(ret,layerparam)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.viewBottom:0);};SysExps.prototype.loadingprogress=function(ret)
{ret.set_float(this.runtime.loadingprogress);};SysExps.prototype.unlerp=function(ret,a,b,y)
{ret.set_float((y-a)/(b-a));};SysExps.prototype.canvassnapshot=function(ret)
{ret.set_string(this.runtime.snapshotData);};SysExps.prototype.urlencode=function(ret,s)
{ret.set_string(encodeURIComponent(s));};SysExps.prototype.urldecode=function(ret,s)
{ret.set_string(decodeURIComponent(s));};SysExps.prototype.canvastolayerx=function(ret,layerparam,x,y)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.canvasToLayer(x,y,true):0);};SysExps.prototype.canvastolayery=function(ret,layerparam,x,y)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.canvasToLayer(x,y,false):0);};SysExps.prototype.layertocanvasx=function(ret,layerparam,x,y)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.layerToCanvas(x,y,true):0);};SysExps.prototype.layertocanvasy=function(ret,layerparam,x,y)
{var layer=this.runtime.getLayer(layerparam);ret.set_float(layer?layer.layerToCanvas(x,y,false):0);};SysExps.prototype.savestatejson=function(ret)
{ret.set_string(this.runtime.lastSaveJson);};SysExps.prototype.imagememoryusage=function(ret)
{if(this.runtime.glwrap)
ret.set_float(Math.round(100*this.runtime.glwrap.estimateVRAM()/(1024*1024))/100);else
ret.set_float(0);};SysExps.prototype.regexsearch=function(ret,str_,regex_,flags_)
{var regex=getRegex(regex_,flags_);ret.set_int(str_?str_.search(regex):-1);};SysExps.prototype.regexreplace=function(ret,str_,regex_,flags_,replace_)
{var regex=getRegex(regex_,flags_);ret.set_string(str_?str_.replace(regex,replace_):"");};var regexMatches=[];var lastMatchesStr="";var lastMatchesRegex="";var lastMatchesFlags="";function updateRegexMatches(str_,regex_,flags_)
{if(str_===lastMatchesStr&&regex_===lastMatchesRegex&&flags_===lastMatchesFlags)
return;var regex=getRegex(regex_,flags_);regexMatches=str_.match(regex);lastMatchesStr=str_;lastMatchesRegex=regex_;lastMatchesFlags=flags_;};SysExps.prototype.regexmatchcount=function(ret,str_,regex_,flags_)
{var regex=getRegex(regex_,flags_);updateRegexMatches(str_,regex_,flags_);ret.set_int(regexMatches?regexMatches.length:0);};SysExps.prototype.regexmatchat=function(ret,str_,regex_,flags_,index_)
{index_=Math.floor(index_);var regex=getRegex(regex_,flags_);updateRegexMatches(str_,regex_,flags_);if(!regexMatches||index_<0||index_>=regexMatches.length)
ret.set_string("");else
ret.set_string(regexMatches[index_]);};SysExps.prototype.infinity=function(ret)
{ret.set_float(Infinity);};sysProto.exps=new SysExps();sysProto.runWaits=function()
{var i,j,len,w,k,s,ss;var evinfo=this.runtime.getCurrentEventStack();for(i=0,len=this.waits.length;i<len;i++)
{w=this.waits[i];if(w.time>this.runtime.kahanTime.sum)
continue;evinfo.current_event=w.ev;evinfo.actindex=w.actindex;evinfo.cndindex=0;for(k in w.sols)
{if(w.sols.hasOwnProperty(k))
{s=this.runtime.types_by_index[parseInt(k,10)].getCurrentSol();ss=w.sols[k];s.select_all=ss.sa;cr.shallowAssignArray(s.instances,ss.insts);freeSolStateObject(ss);}}
w.ev.resume_actions_and_subevents();this.runtime.clearSol(w.solModifiers);w.deleteme=true;}
for(i=0,j=0,len=this.waits.length;i<len;i++)
{w=this.waits[i];this.waits[j]=w;if(w.deleteme)
freeWaitObject(w);else
j++;}
this.waits.length=j;};}());;cr.add_common_aces=function(m)
{var pluginProto=m[0].prototype;var singleglobal_=m[1];var position_aces=m[3];var size_aces=m[4];var angle_aces=m[5];var appearance_aces=m[6];var zorder_aces=m[7];var effects_aces=m[8];if(!pluginProto.cnds)
pluginProto.cnds={};if(!pluginProto.acts)
pluginProto.acts={};if(!pluginProto.exps)
pluginProto.exps={};var cnds=pluginProto.cnds;var acts=pluginProto.acts;var exps=pluginProto.exps;if(position_aces)
{cnds.CompareX=function(cmp,x)
{return cr.do_cmp(this.x,cmp,x);};cnds.CompareY=function(cmp,y)
{return cr.do_cmp(this.y,cmp,y);};cnds.IsOnScreen=function()
{var layer=this.layer;this.update_bbox();var bbox=this.bbox;return!(bbox.right<layer.viewLeft||bbox.bottom<layer.viewTop||bbox.left>layer.viewRight||bbox.top>layer.viewBottom);};cnds.IsOutsideLayout=function()
{this.update_bbox();var bbox=this.bbox;var layout=this.runtime.running_layout;return(bbox.right<0||bbox.bottom<0||bbox.left>layout.width||bbox.top>layout.height);};cnds.PickDistance=function(which,x,y)
{var sol=this.getCurrentSol();var instances=sol.getObjects();if(!instances.length)
return false;var inst=instances[0];var pickme=inst;var dist=cr.distanceTo(inst.x,inst.y,x,y);var i,len,d;for(i=1,len=instances.length;i<len;i++)
{inst=instances[i];d=cr.distanceTo(inst.x,inst.y,x,y);if((which===0&&d<dist)||(which===1&&d>dist))
{dist=d;pickme=inst;}}
sol.pick_one(pickme);return true;};acts.SetX=function(x)
{if(this.x!==x)
{this.x=x;this.set_bbox_changed();}};acts.SetY=function(y)
{if(this.y!==y)
{this.y=y;this.set_bbox_changed();}};acts.SetPos=function(x,y)
{if(this.x!==x||this.y!==y)
{this.x=x;this.y=y;this.set_bbox_changed();}};acts.SetPosToObject=function(obj,imgpt)
{var inst=obj.getPairedInstance(this);if(!inst)
return;var newx,newy;if(inst.getImagePoint)
{newx=inst.getImagePoint(imgpt,true);newy=inst.getImagePoint(imgpt,false);}
else
{newx=inst.x;newy=inst.y;}
if(this.x!==newx||this.y!==newy)
{this.x=newx;this.y=newy;this.set_bbox_changed();}};acts.MoveForward=function(dist)
{if(dist!==0)
{this.x+=Math.cos(this.angle)*dist;this.y+=Math.sin(this.angle)*dist;this.set_bbox_changed();}};acts.MoveAtAngle=function(a,dist)
{if(dist!==0)
{this.x+=Math.cos(cr.to_radians(a))*dist;this.y+=Math.sin(cr.to_radians(a))*dist;this.set_bbox_changed();}};exps.X=function(ret)
{ret.set_float(this.x);};exps.Y=function(ret)
{ret.set_float(this.y);};exps.dt=function(ret)
{ret.set_float(this.runtime.getDt(this));};}
if(size_aces)
{cnds.CompareWidth=function(cmp,w)
{return cr.do_cmp(this.width,cmp,w);};cnds.CompareHeight=function(cmp,h)
{return cr.do_cmp(this.height,cmp,h);};acts.SetWidth=function(w)
{if(this.width!==w)
{this.width=w;this.set_bbox_changed();}};acts.SetHeight=function(h)
{if(this.height!==h)
{this.height=h;this.set_bbox_changed();}};acts.SetSize=function(w,h)
{if(this.width!==w||this.height!==h)
{this.width=w;this.height=h;this.set_bbox_changed();}};exps.Width=function(ret)
{ret.set_float(this.width);};exps.Height=function(ret)
{ret.set_float(this.height);};exps.BBoxLeft=function(ret)
{this.update_bbox();ret.set_float(this.bbox.left);};exps.BBoxTop=function(ret)
{this.update_bbox();ret.set_float(this.bbox.top);};exps.BBoxRight=function(ret)
{this.update_bbox();ret.set_float(this.bbox.right);};exps.BBoxBottom=function(ret)
{this.update_bbox();ret.set_float(this.bbox.bottom);};}
if(angle_aces)
{cnds.AngleWithin=function(within,a)
{return cr.angleDiff(this.angle,cr.to_radians(a))<=cr.to_radians(within);};cnds.IsClockwiseFrom=function(a)
{return cr.angleClockwise(this.angle,cr.to_radians(a));};cnds.IsBetweenAngles=function(a,b)
{var lower=cr.to_clamped_radians(a);var upper=cr.to_clamped_radians(b);var angle=cr.clamp_angle(this.angle);var obtuse=(!cr.angleClockwise(upper,lower));if(obtuse)
return!(!cr.angleClockwise(angle,lower)&&cr.angleClockwise(angle,upper));else
return cr.angleClockwise(angle,lower)&&!cr.angleClockwise(angle,upper);};acts.SetAngle=function(a)
{var newangle=cr.to_radians(cr.clamp_angle_degrees(a));if(isNaN(newangle))
return;if(this.angle!==newangle)
{this.angle=newangle;this.set_bbox_changed();}};acts.RotateClockwise=function(a)
{if(a!==0&&!isNaN(a))
{this.angle+=cr.to_radians(a);this.angle=cr.clamp_angle(this.angle);this.set_bbox_changed();}};acts.RotateCounterclockwise=function(a)
{if(a!==0&&!isNaN(a))
{this.angle-=cr.to_radians(a);this.angle=cr.clamp_angle(this.angle);this.set_bbox_changed();}};acts.RotateTowardAngle=function(amt,target)
{var newangle=cr.angleRotate(this.angle,cr.to_radians(target),cr.to_radians(amt));if(isNaN(newangle))
return;if(this.angle!==newangle)
{this.angle=newangle;this.set_bbox_changed();}};acts.RotateTowardPosition=function(amt,x,y)
{var dx=x-this.x;var dy=y-this.y;var target=Math.atan2(dy,dx);var newangle=cr.angleRotate(this.angle,target,cr.to_radians(amt));if(isNaN(newangle))
return;if(this.angle!==newangle)
{this.angle=newangle;this.set_bbox_changed();}};acts.SetTowardPosition=function(x,y)
{var dx=x-this.x;var dy=y-this.y;var newangle=Math.atan2(dy,dx);if(isNaN(newangle))
return;if(this.angle!==newangle)
{this.angle=newangle;this.set_bbox_changed();}};exps.Angle=function(ret)
{ret.set_float(cr.to_clamped_degrees(this.angle));};}
if(!singleglobal_)
{cnds.CompareInstanceVar=function(iv,cmp,val)
{return cr.do_cmp(this.instance_vars[iv],cmp,val);};cnds.IsBoolInstanceVarSet=function(iv)
{return this.instance_vars[iv];};cnds.PickInstVarHiLow=function(which,iv)
{var sol=this.getCurrentSol();var instances=sol.getObjects();if(!instances.length)
return false;var inst=instances[0];var pickme=inst;var val=inst.instance_vars[iv];var i,len,v;for(i=1,len=instances.length;i<len;i++)
{inst=instances[i];v=inst.instance_vars[iv];if((which===0&&v<val)||(which===1&&v>val))
{val=v;pickme=inst;}}
sol.pick_one(pickme);return true;};cnds.PickByUID=function(u)
{var i,len,j,inst,families,instances,sol;var cnd=this.runtime.getCurrentCondition();if(cnd.inverted)
{sol=this.getCurrentSol();if(sol.select_all)
{sol.select_all=false;sol.instances.length=0;sol.else_instances.length=0;instances=this.instances;for(i=0,len=instances.length;i<len;i++)
{inst=instances[i];if(inst.uid===u)
sol.else_instances.push(inst);else
sol.instances.push(inst);}
return!!sol.instances.length;}
else
{for(i=0,j=0,len=sol.instances.length;i<len;i++)
{inst=sol.instances[i];sol.instances[j]=inst;if(inst.uid===u)
{sol.else_instances.push(inst);}
else
j++;}
sol.instances.length=j;return!!sol.instances.length;}}
else
{inst=this.runtime.getObjectByUID(u);if(!inst)
return false;sol=this.getCurrentSol();if(!sol.select_all&&sol.instances.indexOf(inst)===-1)
return false;if(this.is_family)
{families=inst.type.families;for(i=0,len=families.length;i<len;i++)
{if(families[i]===this)
{sol.pick_one(inst);return true;}}}
else if(inst.type===this)
{sol.pick_one(inst);return true;}
return false;}};cnds.OnCreated=function()
{return true;};cnds.OnDestroyed=function()
{return true;};acts.SetInstanceVar=function(iv,val)
{var myinstvars=this.instance_vars;if(cr.is_number(myinstvars[iv]))
{if(cr.is_number(val))
myinstvars[iv]=val;else
myinstvars[iv]=parseFloat(val);}
else if(cr.is_string(myinstvars[iv]))
{if(cr.is_string(val))
myinstvars[iv]=val;else
myinstvars[iv]=val.toString();}
else;};acts.AddInstanceVar=function(iv,val)
{var myinstvars=this.instance_vars;if(cr.is_number(myinstvars[iv]))
{if(cr.is_number(val))
myinstvars[iv]+=val;else
myinstvars[iv]+=parseFloat(val);}
else if(cr.is_string(myinstvars[iv]))
{if(cr.is_string(val))
myinstvars[iv]+=val;else
myinstvars[iv]+=val.toString();}
else;};acts.SubInstanceVar=function(iv,val)
{var myinstvars=this.instance_vars;if(cr.is_number(myinstvars[iv]))
{if(cr.is_number(val))
myinstvars[iv]-=val;else
myinstvars[iv]-=parseFloat(val);}
else;};acts.SetBoolInstanceVar=function(iv,val)
{this.instance_vars[iv]=val?1:0;};acts.ToggleBoolInstanceVar=function(iv)
{this.instance_vars[iv]=1-this.instance_vars[iv];};acts.Destroy=function()
{this.runtime.DestroyInstance(this);};exps.Count=function(ret)
{var count=ret.object_class.instances.length;var i,len,inst;for(i=0,len=this.runtime.createRow.length;i<len;i++)
{inst=this.runtime.createRow[i];if(ret.object_class.is_family)
{if(inst.type.families.indexOf(ret.object_class)>=0)
count++;}
else
{if(inst.type===ret.object_class)
count++;}}
ret.set_int(count);};exps.PickedCount=function(ret)
{ret.set_int(ret.object_class.getCurrentSol().getObjects().length);};exps.UID=function(ret)
{ret.set_int(this.uid);};exps.IID=function(ret)
{ret.set_int(this.get_iid());};}
if(appearance_aces)
{cnds.IsVisible=function()
{return this.visible;};acts.SetVisible=function(v)
{if(!v!==!this.visible)
{this.visible=v;this.runtime.redraw=true;}};cnds.CompareOpacity=function(cmp,x)
{return cr.do_cmp(cr.round6dp(this.opacity*100),cmp,x);};acts.SetOpacity=function(x)
{var new_opacity=x/100.0;if(new_opacity<0)
new_opacity=0;else if(new_opacity>1)
new_opacity=1;if(new_opacity!==this.opacity)
{this.opacity=new_opacity;this.runtime.redraw=true;}};exps.Opacity=function(ret)
{ret.set_float(cr.round6dp(this.opacity*100.0));};}
if(zorder_aces)
{cnds.IsOnLayer=function(layer_)
{if(!layer_)
return false;return this.layer===layer_;};cnds.PickTopBottom=function(which_)
{var sol=this.getCurrentSol();var instances=sol.getObjects();if(!instances.length)
return false;var inst=instances[0];var pickme=inst;var i,len;for(i=1,len=instances.length;i<len;i++)
{inst=instances[i];if(which_===0)
{if(inst.layer.index>pickme.layer.index||(inst.layer.index===pickme.layer.index&&inst.get_zindex()>pickme.get_zindex()))
{pickme=inst;}}
else
{if(inst.layer.index<pickme.layer.index||(inst.layer.index===pickme.layer.index&&inst.get_zindex()<pickme.get_zindex()))
{pickme=inst;}}}
sol.pick_one(pickme);return true;};acts.MoveToTop=function()
{var zindex=this.get_zindex();if(zindex===this.layer.instances.length-1)
return;cr.arrayRemove(this.layer.instances,zindex);this.layer.instances.push(this);this.runtime.redraw=true;this.layer.zindices_stale=true;};acts.MoveToBottom=function()
{var zindex=this.get_zindex();if(zindex===0)
return;cr.arrayRemove(this.layer.instances,zindex);this.layer.instances.unshift(this);this.runtime.redraw=true;this.layer.zindices_stale=true;};acts.MoveToLayer=function(layerMove)
{if(!layerMove||layerMove==this.layer)
return;cr.arrayRemove(this.layer.instances,this.get_zindex());this.layer.zindices_stale=true;this.layer=layerMove;this.zindex=layerMove.instances.length;layerMove.instances.push(this);this.runtime.redraw=true;};acts.ZMoveToObject=function(where_,obj_)
{var isafter=(where_===0);if(!obj_)
return;var other=obj_.getFirstPicked(this);if(!other||other.uid===this.uid)
return;if(this.layer.index!==other.layer.index)
{cr.arrayRemove(this.layer.instances,this.get_zindex());this.layer.zindices_stale=true;this.layer=other.layer;this.zindex=other.layer.instances.length;other.layer.instances.push(this);}
var myZ=this.get_zindex();var insertZ=other.get_zindex();cr.arrayRemove(this.layer.instances,myZ);if(myZ<insertZ)
insertZ--;if(isafter)
insertZ++;if(insertZ===this.layer.instances.length)
this.layer.instances.push(this);else
this.layer.instances.splice(insertZ,0,this);this.layer.zindices_stale=true;this.runtime.redraw=true;};exps.LayerNumber=function(ret)
{ret.set_int(this.layer.number);};exps.LayerName=function(ret)
{ret.set_string(this.layer.name);};exps.ZIndex=function(ret)
{ret.set_int(this.get_zindex());};}
if(effects_aces)
{acts.SetEffectEnabled=function(enable_,effectname_)
{if(!this.runtime.glwrap)
return;var i=this.type.getEffectIndexByName(effectname_);if(i<0)
return;var enable=(enable_===1);if(this.active_effect_flags[i]===enable)
return;this.active_effect_flags[i]=enable;this.updateActiveEffects();this.runtime.redraw=true;};acts.SetEffectParam=function(effectname_,index_,value_)
{if(!this.runtime.glwrap)
return;var i=this.type.getEffectIndexByName(effectname_);if(i<0)
return;var et=this.type.effect_types[i];var params=this.effect_params[i];index_=Math.floor(index_);if(index_<0||index_>=params.length)
return;if(this.runtime.glwrap.getProgramParameterType(et.shaderindex,index_)===1)
value_/=100.0;if(params[index_]===value_)
return;params[index_]=value_;if(et.active)
this.runtime.redraw=true;};}};cr.set_bbox_changed=function()
{this.bbox_changed=true;this.runtime.redraw=true;var i,len;for(i=0,len=this.bbox_changed_callbacks.length;i<len;i++)
{this.bbox_changed_callbacks[i](this);}};cr.add_bbox_changed_callback=function(f)
{if(f)
this.bbox_changed_callbacks.push(f);};cr.update_bbox=function()
{if(!this.bbox_changed)
return;this.bbox.set(this.x,this.y,this.x+this.width,this.y+this.height);this.bbox.offset(-this.hotspotX*this.width,-this.hotspotY*this.height);if(!this.angle)
{this.bquad.set_from_rect(this.bbox);}
else
{this.bbox.offset(-this.x,-this.y);this.bquad.set_from_rotated_rect(this.bbox,this.angle);this.bquad.offset(this.x,this.y);this.bquad.bounding_box(this.bbox);}
var temp=0;if(this.bbox.left>this.bbox.right)
{temp=this.bbox.left;this.bbox.left=this.bbox.right;this.bbox.right=temp;}
if(this.bbox.top>this.bbox.bottom)
{temp=this.bbox.top;this.bbox.top=this.bbox.bottom;this.bbox.bottom=temp;}
this.bbox_changed=false;};cr.inst_contains_pt=function(x,y)
{if(!this.bbox.contains_pt(x,y))
return false;if(!this.bquad.contains_pt(x,y))
return false;if(this.collision_poly&&!this.collision_poly.is_empty())
{this.collision_poly.cache_poly(this.width,this.height,this.angle);return this.collision_poly.contains_pt(x-this.x,y-this.y);}
else
return true;};cr.inst_get_iid=function()
{this.type.updateIIDs();return this.iid;};cr.inst_get_zindex=function()
{this.layer.updateZIndices();return this.zindex;};cr.inst_updateActiveEffects=function()
{this.active_effect_types.length=0;var i,len,et,inst;for(i=0,len=this.active_effect_flags.length;i<len;i++)
{if(this.active_effect_flags[i])
this.active_effect_types.push(this.type.effect_types[i]);}
this.uses_shaders=!!this.active_effect_types.length;};cr.inst_toString=function()
{return"Inst"+this.puid;};cr.type_getFirstPicked=function(frominst)
{if(frominst&&frominst.is_contained&&frominst.type!=this)
{var i,len,s;for(i=0,len=frominst.siblings.length;i<len;i++)
{s=frominst.siblings[i];if(s.type==this)
return s;}}
var instances=this.getCurrentSol().getObjects();if(instances.length)
return instances[0];else
return null;};cr.type_getPairedInstance=function(inst)
{var instances=this.getCurrentSol().getObjects();if(instances.length)
return instances[inst.get_iid()%instances.length];else
return null;};cr.type_updateIIDs=function()
{if(!this.stale_iids||this.is_family)
return;var i,len;for(i=0,len=this.instances.length;i<len;i++)
this.instances[i].iid=i;var next_iid=i;var createRow=this.runtime.createRow;for(i=0,len=createRow.length;i<len;++i)
{if(createRow[i].type===this)
createRow[i].iid=next_iid++;}
this.stale_iids=false;};cr.type_getCurrentSol=function()
{return this.solstack[this.cur_sol];};cr.type_pushCleanSol=function()
{this.cur_sol++;if(this.cur_sol===this.solstack.length)
this.solstack.push(new cr.selection(this));else
this.solstack[this.cur_sol].select_all=true;};cr.type_pushCopySol=function()
{this.cur_sol++;if(this.cur_sol===this.solstack.length)
this.solstack.push(new cr.selection(this));var clonesol=this.solstack[this.cur_sol];var prevsol=this.solstack[this.cur_sol-1];if(prevsol.select_all)
clonesol.select_all=true;else
{clonesol.select_all=false;cr.shallowAssignArray(clonesol.instances,prevsol.instances);cr.shallowAssignArray(clonesol.else_instances,prevsol.else_instances);}};cr.type_popSol=function()
{;this.cur_sol--;};cr.type_getBehaviorByName=function(behname)
{var i,len,j,lenj,f,index=0;if(!this.is_family)
{for(i=0,len=this.families.length;i<len;i++)
{f=this.families[i];for(j=0,lenj=f.behaviors.length;j<lenj;j++)
{if(behname===f.behaviors[j].name)
{this.extra.lastBehIndex=index;return f.behaviors[j];}
index++;}}}
for(i=0,len=this.behaviors.length;i<len;i++){if(behname===this.behaviors[i].name)
{this.extra.lastBehIndex=index;return this.behaviors[i];}
index++;}
return null;};cr.type_getBehaviorIndexByName=function(behname)
{var b=this.getBehaviorByName(behname);if(b)
return this.extra.lastBehIndex;else
return-1;};cr.type_getEffectIndexByName=function(name_)
{var i,len;for(i=0,len=this.effect_types.length;i<len;i++)
{if(this.effect_types[i].name===name_)
return i;}
return-1;};cr.type_applySolToContainer=function()
{if(!this.is_contained||this.is_family)
return;var i,len,j,lenj,t,sol,sol2;this.updateIIDs();sol=this.getCurrentSol();var select_all=sol.select_all;var es=this.runtime.getCurrentEventStack();var orblock=es&&es.current_event&&es.current_event.orblock;for(i=0,len=this.container.length;i<len;i++)
{t=this.container[i];if(t===this)
continue;t.updateIIDs();sol2=t.getCurrentSol();sol2.select_all=select_all;if(!select_all)
{sol2.instances.length=sol.instances.length;for(j=0,lenj=sol.instances.length;j<lenj;j++)
sol2.instances[j]=t.instances[sol.instances[j].iid];if(orblock)
{sol2.else_instances.length=sol.else_instances.length;for(j=0,lenj=sol.else_instances.length;j<lenj;j++)
sol2.else_instances[j]=t.instances[sol.else_instances[j].iid];}}}};cr.type_toString=function()
{return"Type"+this.sid;};cr.do_cmp=function(x,cmp,y)
{if(typeof x==="undefined"||typeof y==="undefined")
return false;switch(cmp)
{case 0:return x===y;case 1:return x!==y;case 2:return x<y;case 3:return x<=y;case 4:return x>y;case 5:return x>=y;default:;return false;}};cr.shaders={};;;cr.plugins_.Audio=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Audio.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};var audRuntime=null;var audInst=null;var audTag="";var appPath="";var API_HTML5=0;var API_WEBAUDIO=1;var API_PHONEGAP=2;var API_APPMOBI=3;var api=API_HTML5;var context=null;var audioBuffers=[];var audioInstances=[];var lastAudio=null;var useOgg=false;var timescale_mode=0;var silent=false;var masterVolume=1;var listenerX=0;var listenerY=0;var panningModel=1;var distanceModel=1;var refDistance=10;var maxDistance=10000;var rolloffFactor=1;var micSource=null;var micTag="";function dbToLinear(x)
{var v=dbToLinear_nocap(x);if(v<0)
v=0;if(v>1)
v=1;return v;};function linearToDb(x)
{if(x<0)
x=0;if(x>1)
x=1;return linearToDb_nocap(x);};function dbToLinear_nocap(x)
{return Math.pow(10,x/20);};function linearToDb_nocap(x)
{return(Math.log(x)/Math.log(10))*20;};var effects={};function getDestinationForTag(tag)
{tag=tag.toLowerCase();if(effects.hasOwnProperty(tag))
{if(effects[tag].length)
return effects[tag][0].getInputNode();}
return context["destination"];};function createGain()
{if(context["createGain"])
return context["createGain"]();else
return context["createGainNode"]();};function createDelay(d)
{if(context["createDelay"])
return context["createDelay"](d);else
return context["createDelayNode"](d);};function startSource(s)
{if(s["start"])
s["start"](0);else
s["noteOn"](0);};function startSourceAt(s,x,d)
{if(s["start"])
s["start"](0,x);else
s["noteGrainOn"](0,x,d-x);};function stopSource(s)
{try{if(s["stop"])
s["stop"](0);else
s["noteOff"](0);}
catch(e){}};function setAudioParam(ap,value,ramp,time)
{if(!ap)
return;ap["cancelScheduledValues"](0);if(time===0)
{ap["value"]=value;return;}
var curTime=context["currentTime"];time+=curTime;switch(ramp){case 0:ap["setValueAtTime"](value,time);break;case 1:ap["setValueAtTime"](ap["value"],curTime);ap["linearRampToValueAtTime"](value,time);break;case 2:ap["setValueAtTime"](ap["value"],curTime);ap["exponentialRampToValueAtTime"](value,time);break;}};var filterTypes=["lowpass","highpass","bandpass","lowshelf","highshelf","peaking","notch","allpass"];function FilterEffect(type,freq,detune,q,gain,mix)
{this.type="filter";this.params=[type,freq,detune,q,gain,mix];this.inputNode=createGain();this.wetNode=createGain();this.wetNode["gain"]["value"]=mix;this.dryNode=createGain();this.dryNode["gain"]["value"]=1-mix;this.filterNode=context["createBiquadFilter"]();if(typeof this.filterNode["type"]==="number")
this.filterNode["type"]=type;else
this.filterNode["type"]=filterTypes[type];this.filterNode["frequency"]["value"]=freq;if(this.filterNode["detune"])
this.filterNode["detune"]["value"]=detune;this.filterNode["Q"]["value"]=q;this.filterNode["gain"]["value"]=gain;this.inputNode["connect"](this.filterNode);this.inputNode["connect"](this.dryNode);this.filterNode["connect"](this.wetNode);};FilterEffect.prototype.connectTo=function(node)
{this.wetNode["disconnect"]();this.wetNode["connect"](node);this.dryNode["disconnect"]();this.dryNode["connect"](node);};FilterEffect.prototype.remove=function()
{this.inputNode["disconnect"]();this.filterNode["disconnect"]();this.wetNode["disconnect"]();this.dryNode["disconnect"]();};FilterEffect.prototype.getInputNode=function()
{return this.inputNode;};FilterEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[4]=value;setAudioParam(this.wetNode["gain"],value,ramp,time);setAudioParam(this.dryNode["gain"],1-value,ramp,time);break;case 1:this.params[0]=value;setAudioParam(this.filterNode["frequency"],value,ramp,time);break;case 2:this.params[1]=value;setAudioParam(this.filterNode["detune"],value,ramp,time);break;case 3:this.params[2]=value;setAudioParam(this.filterNode["Q"],value,ramp,time);break;case 4:this.params[3]=value;setAudioParam(this.filterNode["gain"],value,ramp,time);break;}};function DelayEffect(delayTime,delayGain,mix)
{this.type="delay";this.params=[delayTime,delayGain,mix];this.inputNode=createGain();this.wetNode=createGain();this.wetNode["gain"]["value"]=mix;this.dryNode=createGain();this.dryNode["gain"]["value"]=1-mix;this.mainNode=createGain();this.delayNode=createDelay(delayTime);this.delayNode["delayTime"]["value"]=delayTime;this.delayGainNode=createGain();this.delayGainNode["gain"]["value"]=delayGain;this.inputNode["connect"](this.mainNode);this.inputNode["connect"](this.dryNode);this.mainNode["connect"](this.wetNode);this.mainNode["connect"](this.delayNode);this.delayNode["connect"](this.delayGainNode);this.delayGainNode["connect"](this.mainNode);};DelayEffect.prototype.connectTo=function(node)
{this.wetNode["disconnect"]();this.wetNode["connect"](node);this.dryNode["disconnect"]();this.dryNode["connect"](node);};DelayEffect.prototype.remove=function()
{this.inputNode["disconnect"]();this.mainNode["disconnect"]();this.delayNode["disconnect"]();this.delayGainNode["disconnect"]();this.wetNode["disconnect"]();this.dryNode["disconnect"]();};DelayEffect.prototype.getInputNode=function()
{return this.inputNode;};DelayEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[2]=value;setAudioParam(this.wetNode["gain"],value,ramp,time);setAudioParam(this.dryNode["gain"],1-value,ramp,time);break;case 4:this.params[1]=dbToLinear(value);setAudioParam(this.delayGainNode["gain"],dbToLinear(value),ramp,time);break;case 5:this.params[0]=value;setAudioParam(this.delayNode["delayTime"],value,ramp,time);break;}};function ConvolveEffect(buffer,normalize,mix,src)
{this.type="convolve";this.params=[normalize,mix,src];this.inputNode=createGain();this.wetNode=createGain();this.wetNode["gain"]["value"]=mix;this.dryNode=createGain();this.dryNode["gain"]["value"]=1-mix;this.convolveNode=context["createConvolver"]();if(buffer)
{this.convolveNode["normalize"]=normalize;this.convolveNode["buffer"]=buffer;}
this.inputNode["connect"](this.convolveNode);this.inputNode["connect"](this.dryNode);this.convolveNode["connect"](this.wetNode);};ConvolveEffect.prototype.connectTo=function(node)
{this.wetNode["disconnect"]();this.wetNode["connect"](node);this.dryNode["disconnect"]();this.dryNode["connect"](node);};ConvolveEffect.prototype.remove=function()
{this.inputNode["disconnect"]();this.convolveNode["disconnect"]();this.wetNode["disconnect"]();this.dryNode["disconnect"]();};ConvolveEffect.prototype.getInputNode=function()
{return this.inputNode;};ConvolveEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[1]=value;setAudioParam(this.wetNode["gain"],value,ramp,time);setAudioParam(this.dryNode["gain"],1-value,ramp,time);break;}};function FlangerEffect(delay,modulation,freq,feedback,mix)
{this.type="flanger";this.params=[delay,modulation,freq,feedback,mix];this.inputNode=createGain();this.dryNode=createGain();this.dryNode["gain"]["value"]=1-(mix/2);this.wetNode=createGain();this.wetNode["gain"]["value"]=mix/2;this.feedbackNode=createGain();this.feedbackNode["gain"]["value"]=feedback;this.delayNode=createDelay(delay+modulation);this.delayNode["delayTime"]["value"]=delay;this.oscNode=context["createOscillator"]();this.oscNode["frequency"]["value"]=freq;this.oscGainNode=createGain();this.oscGainNode["gain"]["value"]=modulation;this.inputNode["connect"](this.delayNode);this.inputNode["connect"](this.dryNode);this.delayNode["connect"](this.wetNode);this.delayNode["connect"](this.feedbackNode);this.feedbackNode["connect"](this.delayNode);this.oscNode["connect"](this.oscGainNode);this.oscGainNode["connect"](this.delayNode["delayTime"]);startSource(this.oscNode);};FlangerEffect.prototype.connectTo=function(node)
{this.dryNode["disconnect"]();this.dryNode["connect"](node);this.wetNode["disconnect"]();this.wetNode["connect"](node);};FlangerEffect.prototype.remove=function()
{this.inputNode["disconnect"]();this.delayNode["disconnect"]();this.oscNode["disconnect"]();this.oscGainNode["disconnect"]();this.dryNode["disconnect"]();this.wetNode["disconnect"]();this.feedbackNode["disconnect"]();};FlangerEffect.prototype.getInputNode=function()
{return this.inputNode;};FlangerEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[4]=value;setAudioParam(this.wetNode["gain"],value/2,ramp,time);setAudioParam(this.dryNode["gain"],1-(value/2),ramp,time);break;case 6:this.params[1]=value/1000;setAudioParam(this.oscGainNode["gain"],value/1000,ramp,time);break;case 7:this.params[2]=value;setAudioParam(this.oscNode["frequency"],value,ramp,time);break;case 8:this.params[3]=value/100;setAudioParam(this.feedbackNode["gain"],value/100,ramp,time);break;}};function PhaserEffect(freq,detune,q,modulation,modfreq,mix)
{this.type="phaser";this.params=[freq,detune,q,modulation,modfreq,mix];this.inputNode=createGain();this.dryNode=createGain();this.dryNode["gain"]["value"]=1-(mix/2);this.wetNode=createGain();this.wetNode["gain"]["value"]=mix/2;this.filterNode=context["createBiquadFilter"]();if(typeof this.filterNode["type"]==="number")
this.filterNode["type"]=7;else
this.filterNode["type"]="allpass";this.filterNode["frequency"]["value"]=freq;if(this.filterNode["detune"])
this.filterNode["detune"]["value"]=detune;this.filterNode["Q"]["value"]=q;this.oscNode=context["createOscillator"]();this.oscNode["frequency"]["value"]=modfreq;this.oscGainNode=createGain();this.oscGainNode["gain"]["value"]=modulation;this.inputNode["connect"](this.filterNode);this.inputNode["connect"](this.dryNode);this.filterNode["connect"](this.wetNode);this.oscNode["connect"](this.oscGainNode);this.oscGainNode["connect"](this.filterNode["frequency"]);startSource(this.oscNode);};PhaserEffect.prototype.connectTo=function(node)
{this.dryNode["disconnect"]();this.dryNode["connect"](node);this.wetNode["disconnect"]();this.wetNode["connect"](node);};PhaserEffect.prototype.remove=function()
{this.inputNode["disconnect"]();this.filterNode["disconnect"]();this.oscNode["disconnect"]();this.oscGainNode["disconnect"]();this.dryNode["disconnect"]();this.wetNode["disconnect"]();};PhaserEffect.prototype.getInputNode=function()
{return this.inputNode;};PhaserEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[5]=value;setAudioParam(this.wetNode["gain"],value/2,ramp,time);setAudioParam(this.dryNode["gain"],1-(value/2),ramp,time);break;case 1:this.params[0]=value;setAudioParam(this.filterNode["frequency"],value,ramp,time);break;case 2:this.params[1]=value;setAudioParam(this.filterNode["detune"],value,ramp,time);break;case 3:this.params[2]=value;setAudioParam(this.filterNode["Q"],value,ramp,time);break;case 6:this.params[3]=value;setAudioParam(this.oscGainNode["gain"],value,ramp,time);break;case 7:this.params[4]=value;setAudioParam(this.oscNode["frequency"],value,ramp,time);break;}};function GainEffect(g)
{this.type="gain";this.params=[g];this.node=createGain();this.node["gain"]["value"]=g;};GainEffect.prototype.connectTo=function(node_)
{this.node["disconnect"]();this.node["connect"](node_);};GainEffect.prototype.remove=function()
{this.node["disconnect"]();};GainEffect.prototype.getInputNode=function()
{return this.node;};GainEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 4:this.params[0]=dbToLinear(value);setAudioParam(this.node["gain"],dbToLinear(value),ramp,time);break;}};function TremoloEffect(freq,mix)
{this.type="tremolo";this.params=[freq,mix];this.node=createGain();this.node["gain"]["value"]=1-(mix/2);this.oscNode=context["createOscillator"]();this.oscNode["frequency"]["value"]=freq;this.oscGainNode=createGain();this.oscGainNode["gain"]["value"]=mix/2;this.oscNode["connect"](this.oscGainNode);this.oscGainNode["connect"](this.node["gain"]);startSource(this.oscNode);};TremoloEffect.prototype.connectTo=function(node_)
{this.node["disconnect"]();this.node["connect"](node_);};TremoloEffect.prototype.remove=function()
{this.oscNode["disconnect"]();this.oscGainNode["disconnect"]();this.node["disconnect"]();};TremoloEffect.prototype.getInputNode=function()
{return this.node;};TremoloEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[1]=value;setAudioParam(this.node["gain"]["value"],1-(value/2),ramp,time);setAudioParam(this.oscGainNode["gain"]["value"],value/2,ramp,time);break;case 7:this.params[0]=value;setAudioParam(this.oscNode["frequency"],value,ramp,time);break;}};function RingModulatorEffect(freq,mix)
{this.type="ringmod";this.params=[freq,mix];this.inputNode=createGain();this.wetNode=createGain();this.wetNode["gain"]["value"]=mix;this.dryNode=createGain();this.dryNode["gain"]["value"]=1-mix;this.ringNode=createGain();this.ringNode["gain"]["value"]=0;this.oscNode=context["createOscillator"]();this.oscNode["frequency"]["value"]=freq;this.oscNode["connect"](this.ringNode["gain"]);startSource(this.oscNode);this.inputNode["connect"](this.ringNode);this.inputNode["connect"](this.dryNode);this.ringNode["connect"](this.wetNode);};RingModulatorEffect.prototype.connectTo=function(node_)
{this.wetNode["disconnect"]();this.wetNode["connect"](node_);this.dryNode["disconnect"]();this.dryNode["connect"](node_);};RingModulatorEffect.prototype.remove=function()
{this.oscNode["disconnect"]();this.ringNode["disconnect"]();this.inputNode["disconnect"]();this.wetNode["disconnect"]();this.dryNode["disconnect"]();};RingModulatorEffect.prototype.getInputNode=function()
{return this.inputNode;};RingModulatorEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[1]=value;setAudioParam(this.wetNode["gain"],value,ramp,time);setAudioParam(this.dryNode["gain"],1-value,ramp,time);break;case 7:this.params[0]=value;setAudioParam(this.oscNode["frequency"],value,ramp,time);break;}};function DistortionEffect(threshold,headroom,drive,makeupgain,mix)
{this.type="distortion";this.params=[threshold,headroom,drive,makeupgain,mix];this.inputNode=createGain();this.preGain=createGain();this.postGain=createGain();this.setDrive(drive,dbToLinear_nocap(makeupgain));this.wetNode=createGain();this.wetNode["gain"]["value"]=mix;this.dryNode=createGain();this.dryNode["gain"]["value"]=1-mix;this.waveShaper=context["createWaveShaper"]();this.curve=new Float32Array(65536);this.generateColortouchCurve(threshold,headroom);this.waveShaper.curve=this.curve;this.inputNode["connect"](this.preGain);this.inputNode["connect"](this.dryNode);this.preGain["connect"](this.waveShaper);this.waveShaper["connect"](this.postGain);this.postGain["connect"](this.wetNode);};DistortionEffect.prototype.setDrive=function(drive,makeupgain)
{if(drive<0.01)
drive=0.01;this.preGain["gain"]["value"]=drive;this.postGain["gain"]["value"]=Math.pow(1/drive,0.6)*makeupgain;};function e4(x,k)
{return 1.0-Math.exp(-k*x);}
DistortionEffect.prototype.shape=function(x,linearThreshold,linearHeadroom)
{var maximum=1.05*linearHeadroom*linearThreshold;var kk=(maximum-linearThreshold);var sign=x<0?-1:+1;var absx=x<0?-x:x;var shapedInput=absx<linearThreshold?absx:linearThreshold+kk*e4(absx-linearThreshold,1.0/kk);shapedInput*=sign;return shapedInput;};DistortionEffect.prototype.generateColortouchCurve=function(threshold,headroom)
{var linearThreshold=dbToLinear_nocap(threshold);var linearHeadroom=dbToLinear_nocap(headroom);var n=65536;var n2=n/2;var x=0;for(var i=0;i<n2;++i){x=i/n2;x=this.shape(x,linearThreshold,linearHeadroom);this.curve[n2+i]=x;this.curve[n2-i-1]=-x;}};DistortionEffect.prototype.connectTo=function(node)
{this.wetNode["disconnect"]();this.wetNode["connect"](node);this.dryNode["disconnect"]();this.dryNode["connect"](node);};DistortionEffect.prototype.remove=function()
{this.inputNode["disconnect"]();this.preGain["disconnect"]();this.waveShaper["disconnect"]();this.postGain["disconnect"]();this.wetNode["disconnect"]();this.dryNode["disconnect"]();};DistortionEffect.prototype.getInputNode=function()
{return this.inputNode;};DistortionEffect.prototype.setParam=function(param,value,ramp,time)
{switch(param){case 0:value=value/100;if(value<0)value=0;if(value>1)value=1;this.params[4]=value;setAudioParam(this.wetNode["gain"],value,ramp,time);setAudioParam(this.dryNode["gain"],1-value,ramp,time);break;}};function CompressorEffect(threshold,knee,ratio,attack,release)
{this.type="compressor";this.params=[threshold,knee,ratio,attack,release];this.node=context["createDynamicsCompressor"]();this.node["threshold"]["value"]=threshold;this.node["knee"]["value"]=knee;this.node["ratio"]["value"]=ratio;this.node["attack"]["value"]=attack;this.node["release"]["value"]=release;};CompressorEffect.prototype.connectTo=function(node_)
{this.node["disconnect"]();this.node["connect"](node_);};CompressorEffect.prototype.remove=function()
{this.node["disconnect"]();};CompressorEffect.prototype.getInputNode=function()
{return this.node;};CompressorEffect.prototype.setParam=function(param,value,ramp,time)
{};function AnalyserEffect(fftSize,smoothing)
{this.type="analyser";this.params=[fftSize,smoothing];this.node=context["createAnalyser"]();this.node["fftSize"]=fftSize;this.node["smoothingTimeConstant"]=smoothing;this.freqBins=new Float32Array(this.node["frequencyBinCount"]);this.signal=new Uint8Array(fftSize);this.peak=0;this.rms=0;};AnalyserEffect.prototype.tick=function()
{this.node["getFloatFrequencyData"](this.freqBins);this.node["getByteTimeDomainData"](this.signal);var fftSize=this.node["fftSize"];var i=0;this.peak=0;var rmsSquaredSum=0;var s=0;for(;i<fftSize;i++)
{s=(this.signal[i]-128)/128;if(s<0)
s=-s;if(this.peak<s)
this.peak=s;rmsSquaredSum+=s*s;}
this.peak=linearToDb(this.peak);this.rms=linearToDb(Math.sqrt(rmsSquaredSum/fftSize));};AnalyserEffect.prototype.connectTo=function(node_)
{this.node["disconnect"]();this.node["connect"](node_);};AnalyserEffect.prototype.remove=function()
{this.node["disconnect"]();};AnalyserEffect.prototype.getInputNode=function()
{return this.node;};AnalyserEffect.prototype.setParam=function(param,value,ramp,time)
{};var OT_POS_SAMPLES=4;function ObjectTracker()
{this.obj=null;this.loadUid=0;this.speeds=[];this.lastX=0;this.lastY=0;this.moveAngle=0;};ObjectTracker.prototype.setObject=function(obj_)
{this.obj=obj_;if(this.obj)
{this.lastX=this.obj.x;this.lastY=this.obj.y;}
this.speeds.length=0;};ObjectTracker.prototype.hasObject=function()
{return!!this.obj;};ObjectTracker.prototype.tick=function(dt)
{if(!this.obj)
return;this.moveAngle=cr.angleTo(this.lastX,this.lastY,this.obj.x,this.obj.y);var s=cr.distanceTo(this.lastX,this.lastY,this.obj.x,this.obj.y)/dt;if(this.speeds.length<OT_POS_SAMPLES)
this.speeds.push(s);else
{this.speeds.shift();this.speeds.push(s);}
this.lastX=this.obj.x;this.lastY=this.obj.y;};ObjectTracker.prototype.getSpeed=function()
{if(!this.speeds.length)
return 0;var i,len,sum=0;for(i=0,len=this.speeds.length;i<len;i++)
{sum+=this.speeds[i];}
return sum/this.speeds.length;};ObjectTracker.prototype.getVelocityX=function()
{return Math.cos(this.moveAngle)*this.getSpeed();};ObjectTracker.prototype.getVelocityY=function()
{return Math.sin(this.moveAngle)*this.getSpeed();};var iOShadtouch=false;function C2AudioBuffer(src_,is_music)
{this.src=src_;this.myapi=api;this.is_music=is_music;this.added_end_listener=false;var self=this;this.outNode=null;this.mediaSourceNode=null;this.panWhenReady=[];this.seekWhenReady=0;this.pauseWhenReady=false;if(api===API_WEBAUDIO&&is_music&&!(audRuntime.isMobile||audRuntime.isNodeWebkit))
{this.myapi=API_HTML5;this.outNode=createGain();}
this.bufferObject=null;this.audioData=null;var request;switch(this.myapi){case API_HTML5:this.bufferObject=new Audio();if(api===API_WEBAUDIO&&context["createMediaElementSource"])
{this.bufferObject.addEventListener("canplay",function()
{self.mediaSourceNode=context["createMediaElementSource"](self.bufferObject);self.mediaSourceNode["connect"](self.outNode);});}
this.bufferObject.autoplay=false;this.bufferObject.preload="auto";this.bufferObject.src=src_;break;case API_WEBAUDIO:request=new XMLHttpRequest();request.open("GET",src_,true);request.responseType="arraybuffer";request.onload=function(){self.audioData=request.response;self.decodeAudioBuffer();};request.send();break;case API_PHONEGAP:this.bufferObject=true;break;case API_APPMOBI:this.bufferObject=true;break;}};C2AudioBuffer.prototype.decodeAudioBuffer=function()
{if(this.bufferObject||!this.audioData)
return;var self=this;if(context["decodeAudioData"])
{context["decodeAudioData"](this.audioData,function(buffer){self.bufferObject=buffer;var p,i,len,a;if(!cr.is_undefined(self.playTagWhenReady))
{if(self.panWhenReady.length)
{for(i=0,len=self.panWhenReady.length;i<len;i++)
{p=self.panWhenReady[i];a=new C2AudioInstance(self,p.thistag);a.setPannerEnabled(true);if(typeof p.objUid!=="undefined")
{p.obj=audRuntime.getObjectByUID(p.objUid);if(!p.obj)
continue;}
if(p.obj)
{var px=cr.rotatePtAround(p.obj.x,p.obj.y,-p.obj.layer.getAngle(),listenerX,listenerY,true);var py=cr.rotatePtAround(p.obj.x,p.obj.y,-p.obj.layer.getAngle(),listenerX,listenerY,false);a.setPan(px,py,cr.to_degrees(p.obj.angle-p.obj.layer.getAngle()),p.ia,p.oa,p.og);a.setObject(p.obj);}
else
{a.setPan(p.x,p.y,p.a,p.ia,p.oa,p.og);}
a.play(self.loopWhenReady,self.volumeWhenReady,self.seekWhenReady);if(self.pauseWhenReady)
a.pause();audioInstances.push(a);}
self.panWhenReady.length=0;}
else
{a=new C2AudioInstance(self,self.playTagWhenReady);a.play(self.loopWhenReady,self.volumeWhenReady,self.seekWhenReady);if(self.pauseWhenReady)
a.pause();audioInstances.push(a);}}
else if(!cr.is_undefined(self.convolveWhenReady))
{var convolveNode=self.convolveWhenReady.convolveNode;convolveNode["normalize"]=self.normalizeWhenReady;convolveNode["buffer"]=buffer;}});}
else
{this.bufferObject=context["createBuffer"](this.audioData,false);if(!cr.is_undefined(this.playTagWhenReady))
{var a=new C2AudioInstance(this,this.playTagWhenReady);a.play(this.loopWhenReady,this.volumeWhenReady,this.seekWhenReady);if(this.pauseWhenReady)
a.pause();audioInstances.push(a);}
else if(!cr.is_undefined(this.convolveWhenReady))
{var convolveNode=this.convolveWhenReady.convolveNode;convolveNode["normalize"]=this.normalizeWhenReady;convolveNode["buffer"]=this.bufferObject;}}};C2AudioBuffer.prototype.isLoaded=function()
{switch(this.myapi){case API_HTML5:return this.bufferObject["readyState"]===4;case API_WEBAUDIO:return!!this.audioData;case API_PHONEGAP:return true;case API_APPMOBI:return true;}
return false;};function C2AudioInstance(buffer_,tag_)
{var self=this;this.tag=tag_;this.fresh=true;this.stopped=true;this.src=buffer_.src;this.buffer=buffer_;this.myapi=api;this.is_music=buffer_.is_music;this.playbackRate=1;this.pgended=true;this.resume_me=false;this.is_paused=false;this.resume_position=0;this.looping=false;this.is_muted=false;this.is_silent=false;this.volume=1;this.mutevol=1;this.startTime=audRuntime.kahanTime.sum;this.gainNode=null;this.pannerNode=null;this.pannerEnabled=false;this.objectTracker=null;this.panX=0;this.panY=0;this.panAngle=0;this.panConeInner=0;this.panConeOuter=0;this.panConeOuterGain=0;this.instanceObject=null;var add_end_listener=false;switch(this.myapi){case API_HTML5:if(this.is_music)
{this.instanceObject=buffer_.bufferObject;add_end_listener=!buffer_.added_end_listener;buffer_.added_end_listener=true;}
else
{this.instanceObject=new Audio();this.instanceObject.autoplay=false;this.instanceObject.src=buffer_.bufferObject.src;add_end_listener=true;}
if(add_end_listener)
{this.instanceObject.addEventListener('ended',function(){audTag=self.tag;self.stopped=true;audRuntime.trigger(cr.plugins_.Audio.prototype.cnds.OnEnded,audInst);});}
break;case API_WEBAUDIO:this.gainNode=createGain();this.gainNode["connect"](getDestinationForTag(tag_));if(this.buffer.myapi===API_WEBAUDIO)
{if(buffer_.bufferObject)
{this.instanceObject=context["createBufferSource"]();this.instanceObject["buffer"]=buffer_.bufferObject;this.instanceObject["connect"](this.gainNode);}}
else
{this.instanceObject=this.buffer.bufferObject;this.buffer.outNode["connect"](this.gainNode);}
break;case API_PHONEGAP:this.instanceObject=new window["Media"](appPath+this.src,null,null,function(status){if(status===window["Media"]["MEDIA_STOPPED"])
{self.pgended=true;self.stopped=true;audTag=self.tag;audRuntime.trigger(cr.plugins_.Audio.prototype.cnds.OnEnded,audInst);}});break;case API_APPMOBI:this.instanceObject=true;break;}};C2AudioInstance.prototype.hasEnded=function()
{switch(this.myapi){case API_HTML5:return this.instanceObject.ended;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
{if(!this.fresh&&!this.stopped&&this.instanceObject["loop"])
return false;if(this.is_paused)
return false;return(audRuntime.kahanTime.sum-this.startTime)>this.buffer.bufferObject["duration"];}
else
return this.instanceObject.ended;case API_PHONEGAP:return this.pgended;case API_APPMOBI:true;}
return true;};C2AudioInstance.prototype.canBeRecycled=function()
{if(this.fresh||this.stopped)
return true;return this.hasEnded();};C2AudioInstance.prototype.setPannerEnabled=function(enable_)
{if(api!==API_WEBAUDIO)
return;if(!this.pannerEnabled&&enable_)
{if(!this.pannerNode)
{this.pannerNode=context["createPanner"]();if(typeof this.pannerNode["panningModel"]==="number")
this.pannerNode["panningModel"]=panningModel;else
this.pannerNode["panningModel"]=["equalpower","HRTF","soundfield"][panningModel];if(typeof this.pannerNode["distanceModel"]==="number")
this.pannerNode["distanceModel"]=distanceModel;else
this.pannerNode["distanceModel"]=["linear","inverse","exponential"][distanceModel];this.pannerNode["refDistance"]=refDistance;this.pannerNode["maxDistance"]=maxDistance;this.pannerNode["rolloffFactor"]=rolloffFactor;}
this.gainNode["disconnect"]();this.gainNode["connect"](this.pannerNode);this.pannerNode["connect"](getDestinationForTag(this.tag));this.pannerEnabled=true;}
else if(this.pannerEnabled&&!enable_)
{this.pannerNode["disconnect"]();this.gainNode["disconnect"]();this.gainNode["connect"](getDestinationForTag(this.tag));this.pannerEnabled=false;}};C2AudioInstance.prototype.setPan=function(x,y,angle,innerangle,outerangle,outergain)
{if(!this.pannerEnabled||api!==API_WEBAUDIO)
return;this.pannerNode["setPosition"](x,y,0);this.pannerNode["setOrientation"](Math.cos(cr.to_radians(angle)),Math.sin(cr.to_radians(angle)),0);this.pannerNode["coneInnerAngle"]=innerangle;this.pannerNode["coneOuterAngle"]=outerangle;this.pannerNode["coneOuterGain"]=outergain;this.panX=x;this.panY=y;this.panAngle=angle;this.panConeInner=innerangle;this.panConeOuter=outerangle;this.panConeOuterGain=outergain;};C2AudioInstance.prototype.setObject=function(o)
{if(!this.pannerEnabled||api!==API_WEBAUDIO)
return;if(!this.objectTracker)
this.objectTracker=new ObjectTracker();this.objectTracker.setObject(o);};C2AudioInstance.prototype.tick=function(dt)
{if(!this.pannerEnabled||api!==API_WEBAUDIO||!this.objectTracker||!this.objectTracker.hasObject()||!this.isPlaying())
{return;}
this.objectTracker.tick(dt);var inst=this.objectTracker.obj;var px=cr.rotatePtAround(inst.x,inst.y,-inst.layer.getAngle(),listenerX,listenerY,true);var py=cr.rotatePtAround(inst.x,inst.y,-inst.layer.getAngle(),listenerX,listenerY,false);this.pannerNode["setPosition"](px,py,0);var a=0;if(typeof this.objectTracker.obj.angle!=="undefined")
{a=inst.angle-inst.layer.getAngle();this.pannerNode["setOrientation"](Math.cos(a),Math.sin(a),0);}
this.pannerNode["setVelocity"](this.objectTracker.getVelocityX(),this.objectTracker.getVelocityY(),0);};C2AudioInstance.prototype.play=function(looping,vol,fromPosition)
{var instobj=this.instanceObject;this.looping=looping;this.volume=vol;var seekPos=fromPosition||0;switch(this.myapi){case API_HTML5:if(instobj.playbackRate!==1.0)
instobj.playbackRate=1.0;if(instobj.volume!==vol*masterVolume)
instobj.volume=vol*masterVolume;if(instobj.loop!==looping)
instobj.loop=looping;if(instobj.muted)
instobj.muted=false;if(instobj.currentTime!==seekPos)
{try{instobj.currentTime=seekPos;}
catch(err)
{;}}
this.instanceObject.play();break;case API_WEBAUDIO:this.muted=false;this.mutevol=1;if(this.buffer.myapi===API_WEBAUDIO)
{if(!this.fresh)
{this.instanceObject=context["createBufferSource"]();this.instanceObject["buffer"]=this.buffer.bufferObject;this.instanceObject["connect"](this.gainNode);}
this.instanceObject.loop=looping;this.gainNode["gain"]["value"]=vol*masterVolume;if(seekPos===0)
startSource(this.instanceObject);else
startSourceAt(this.instanceObject,seekPos,this.getDuration());}
else
{if(instobj.playbackRate!==1.0)
instobj.playbackRate=1.0;if(instobj.loop!==looping)
instobj.loop=looping;this.gainNode["gain"]["value"]=vol*masterVolume;if(instobj.currentTime!==seekPos)
{try{instobj.currentTime=seekPos;}
catch(err)
{;}}
instobj.play();}
break;case API_PHONEGAP:if((!this.fresh&&this.stopped)||seekPos!==0)
instobj["seekTo"](seekPos);instobj["play"]();this.pgended=false;break;case API_APPMOBI:if(audRuntime.isDirectCanvas)
AppMobi["context"]["playSound"](this.src);else
AppMobi["player"]["playSound"](this.src);break;}
this.playbackRate=1;this.startTime=audRuntime.kahanTime.sum-seekPos;this.fresh=false;this.stopped=false;this.is_paused=false;};C2AudioInstance.prototype.stop=function()
{switch(this.myapi){case API_HTML5:if(!this.instanceObject.paused)
this.instanceObject.pause();break;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
stopSource(this.instanceObject);else
{if(!this.instanceObject.paused)
this.instanceObject.pause();}
break;case API_PHONEGAP:this.instanceObject["stop"]();break;case API_APPMOBI:break;}
this.stopped=true;this.is_paused=false;};C2AudioInstance.prototype.pause=function()
{if(this.fresh||this.stopped||this.hasEnded()||this.is_paused)
return;switch(this.myapi){case API_HTML5:if(!this.instanceObject.paused)
this.instanceObject.pause();break;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
{this.resume_position=this.getPlaybackTime();if(this.looping)
this.resume_position=this.resume_position%this.getDuration();stopSource(this.instanceObject);}
else
{if(!this.instanceObject.paused)
this.instanceObject.pause();}
break;case API_PHONEGAP:this.instanceObject["pause"]();break;case API_APPMOBI:break;}
this.is_paused=true;};C2AudioInstance.prototype.resume=function()
{if(this.fresh||this.stopped||this.hasEnded()||!this.is_paused)
return;switch(this.myapi){case API_HTML5:this.instanceObject.play();break;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
{this.instanceObject=context["createBufferSource"]();this.instanceObject["buffer"]=this.buffer.bufferObject;this.instanceObject["connect"](this.gainNode);this.instanceObject.loop=this.looping;this.gainNode["gain"]["value"]=masterVolume*this.volume*this.mutevol;this.startTime=audRuntime.kahanTime.sum-this.resume_position;startSourceAt(this.instanceObject,this.resume_position,this.getDuration());}
else
{this.instanceObject.play();}
break;case API_PHONEGAP:this.instanceObject["play"]();break;case API_APPMOBI:break;}
this.is_paused=false;};C2AudioInstance.prototype.seek=function(pos)
{if(this.fresh||this.stopped||this.hasEnded())
return;switch(this.myapi){case API_HTML5:try{this.instanceObject.currentTime=pos;}
catch(e){}
break;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
{if(this.is_paused)
this.resume_position=pos;else
{this.pause();this.resume_position=pos;this.resume();}}
else
{try{this.instanceObject.currentTime=pos;}
catch(e){}}
break;case API_PHONEGAP:break;case API_APPMOBI:break;}};C2AudioInstance.prototype.reconnect=function(toNode)
{if(this.myapi!==API_WEBAUDIO)
return;if(this.pannerEnabled)
{this.pannerNode["disconnect"]();this.pannerNode["connect"](toNode);}
else
{this.gainNode["disconnect"]();this.gainNode["connect"](toNode);}};C2AudioInstance.prototype.getDuration=function()
{switch(this.myapi){case API_HTML5:if(typeof this.instanceObject.duration!=="undefined")
return this.instanceObject.duration;else
return 0;case API_WEBAUDIO:return this.buffer.bufferObject["duration"];case API_PHONEGAP:return this.instanceObject["getDuration"]();case API_APPMOBI:return 0;}
return 0;};C2AudioInstance.prototype.getPlaybackTime=function()
{var duration=this.getDuration();var ret=0;switch(this.myapi){case API_HTML5:if(typeof this.instanceObject.currentTime!=="undefined")
ret=this.instanceObject.currentTime;break;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
{if(this.is_paused)
return this.resume_position;else
ret=audRuntime.kahanTime.sum-this.startTime;}
else if(typeof this.instanceObject.currentTime!=="undefined")
ret=this.instanceObject.currentTime;break;case API_PHONEGAP:break;case API_APPMOBI:break;}
if(!this.looping&&ret>duration)
ret=duration;return ret;};C2AudioInstance.prototype.isPlaying=function()
{return!this.is_paused&&!this.fresh&&!this.stopped&&!this.hasEnded();};C2AudioInstance.prototype.setVolume=function(v)
{this.volume=v;this.updateVolume();};C2AudioInstance.prototype.updateVolume=function()
{var volToSet=this.volume*masterVolume;switch(this.myapi){case API_HTML5:if(this.instanceObject.volume&&this.instanceObject.volume!==volToSet)
this.instanceObject.volume=volToSet;break;case API_WEBAUDIO:this.gainNode["gain"]["value"]=volToSet*this.mutevol;break;case API_PHONEGAP:break;case API_APPMOBI:break;}};C2AudioInstance.prototype.getVolume=function()
{return this.volume;};C2AudioInstance.prototype.doSetMuted=function(m)
{switch(this.myapi){case API_HTML5:if(this.instanceObject.muted!==!!m)
this.instanceObject.muted=!!m;break;case API_WEBAUDIO:this.mutevol=(m?0:1);this.gainNode["gain"]["value"]=masterVolume*this.volume*this.mutevol;break;case API_PHONEGAP:break;case API_APPMOBI:break;}};C2AudioInstance.prototype.setMuted=function(m)
{this.is_muted=!!m;this.doSetMuted(this.is_muted||this.is_silent);};C2AudioInstance.prototype.setSilent=function(m)
{this.is_silent=!!m;this.doSetMuted(this.is_muted||this.is_silent);};C2AudioInstance.prototype.setLooping=function(l)
{this.looping=l;switch(this.myapi){case API_HTML5:if(this.instanceObject.loop!==!!l)
this.instanceObject.loop=!!l;break;case API_WEBAUDIO:if(this.instanceObject.loop!==!!l)
this.instanceObject.loop=!!l;break;case API_PHONEGAP:break;case API_APPMOBI:break;}};C2AudioInstance.prototype.setPlaybackRate=function(r)
{this.playbackRate=r;this.updatePlaybackRate();};C2AudioInstance.prototype.updatePlaybackRate=function()
{var r=this.playbackRate;if((timescale_mode===1&&!this.is_music)||timescale_mode===2)
r*=audRuntime.timescale;switch(this.myapi){case API_HTML5:if(this.instanceObject.playbackRate!==r)
this.instanceObject.playbackRate=r;break;case API_WEBAUDIO:if(this.buffer.myapi===API_WEBAUDIO)
{if(this.instanceObject["playbackRate"]["value"]!==r)
this.instanceObject["playbackRate"]["value"]=r;}
else
{if(this.instanceObject.playbackRate!==r)
this.instanceObject.playbackRate=r;}
break;case API_PHONEGAP:break;case API_APPMOBI:break;}};C2AudioInstance.prototype.setSuspended=function(s)
{switch(this.myapi){case API_HTML5:if(s)
{if(this.isPlaying())
{this.instanceObject["pause"]();this.resume_me=true;}
else
this.resume_me=false;}
else
{if(this.resume_me)
this.instanceObject["play"]();}
break;case API_WEBAUDIO:if(s)
{if(this.isPlaying())
{if(this.buffer.myapi===API_WEBAUDIO)
{this.resume_position=this.getPlaybackTime();if(this.looping)
this.resume_position=this.resume_position%this.getDuration();stopSource(this.instanceObject);}
else
this.instanceObject["pause"]();this.resume_me=true;}
else
this.resume_me=false;}
else
{if(this.resume_me)
{if(this.buffer.myapi===API_WEBAUDIO)
{this.instanceObject=context["createBufferSource"]();this.instanceObject["buffer"]=this.buffer.bufferObject;this.instanceObject["connect"](this.gainNode);this.instanceObject.loop=this.looping;this.gainNode["gain"]["value"]=masterVolume*this.volume*this.mutevol;this.startTime=audRuntime.kahanTime.sum-this.resume_position;startSourceAt(this.instanceObject,this.resume_position,this.getDuration());}
else
{this.instanceObject["play"]();}}}
break;case API_PHONEGAP:if(s)
{if(this.isPlaying())
{this.instanceObject["pause"]();this.resume_me=true;}
else
this.resume_me=false;}
else
{if(this.resume_me)
this.instanceObject["play"]();}
break;case API_APPMOBI:break;}};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;audRuntime=this.runtime;audInst=this;this.listenerTracker=null;this.listenerZ=-600;context=null;if(typeof AudioContext!=="undefined")
{api=API_WEBAUDIO;context=new AudioContext();}
else if(typeof webkitAudioContext!=="undefined")
{api=API_WEBAUDIO;context=new webkitAudioContext();}
if(this.runtime.isiOS&&api===API_WEBAUDIO)
{document.addEventListener("touchstart",function(){if(iOShadtouch)
return;var buffer=context["createBuffer"](1,1,22050);var source=context["createBufferSource"]();source["buffer"]=buffer;source["connect"](context["destination"]);startSource(source);iOShadtouch=true;},true);}
if(api!==API_WEBAUDIO)
{if(this.runtime.isPhoneGap)
api=API_PHONEGAP;else if(this.runtime.isAppMobi)
api=API_APPMOBI;}
if(api===API_PHONEGAP)
{appPath=location.href;var i=appPath.lastIndexOf("/");if(i>-1)
appPath=appPath.substr(0,i+1);appPath=appPath.replace("file://","");}
if(this.runtime.isSafari&&this.runtime.isWindows&&typeof Audio==="undefined")
{alert("It looks like you're using Safari for Windows without Quicktime.  Audio cannot be played until Quicktime is installed.");this.runtime.DestroyInstance(this);}
else
{if(this.runtime.isDirectCanvas)
useOgg=this.runtime.isAndroid;else
{try{useOgg=!!(new Audio().canPlayType('audio/ogg; codecs="vorbis"'));}
catch(e)
{useOgg=false;}}
switch(api){case API_HTML5:;break;case API_WEBAUDIO:;break;case API_PHONEGAP:;break;case API_APPMOBI:;break;default:;}
this.runtime.tickMe(this);}};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{timescale_mode=this.properties[0];this.saveload=this.properties[1];panningModel=this.properties[2];distanceModel=this.properties[3];this.listenerZ=-this.properties[4];refDistance=this.properties[5];maxDistance=this.properties[6];rolloffFactor=this.properties[7];this.listenerTracker=new ObjectTracker();if(api===API_WEBAUDIO)
{context["listener"]["speedOfSound"]=this.properties[8];context["listener"]["dopplerFactor"]=this.properties[9];context["listener"]["setPosition"](this.runtime.width/2,this.runtime.height/2,this.listenerZ);context["listener"]["setOrientation"](0,0,1,0,-1,0);window["c2OnAudioMicStream"]=function(localMediaStream,tag)
{if(micSource)
micSource["disconnect"]();micTag=tag.toLowerCase();micSource=context["createMediaStreamSource"](localMediaStream);micSource["connect"](getDestinationForTag(micTag));};}
this.runtime.addSuspendCallback(function(s)
{audInst.onSuspend(s);});var self=this;this.runtime.addDestroyCallback(function(inst)
{self.onInstanceDestroyed(inst);});};instanceProto.onInstanceDestroyed=function(inst)
{var i,len,a;for(i=0,len=audioInstances.length;i<len;i++)
{a=audioInstances[i];if(a.objectTracker)
{if(a.objectTracker.obj===inst)
{a.objectTracker.obj=null;if(a.pannerEnabled&&a.isPlaying()&&a.looping)
a.stop();}}}
if(this.listenerTracker.obj===inst)
this.listenerTracker.obj=null;};instanceProto.saveToJSON=function()
{var o={"silent":silent,"masterVolume":masterVolume,"listenerZ":this.listenerZ,"listenerUid":this.listenerTracker.hasObject()?this.listenerTracker.obj.uid:-1,"playing":[],"effects":{}};var playingarr=o["playing"];var i,len,a,d,p,panobj,playbackTime;for(i=0,len=audioInstances.length;i<len;i++)
{a=audioInstances[i];if(!a.isPlaying())
continue;if(this.saveload===3)
continue;if(a.is_music&&this.saveload===1)
continue;if(!a.is_music&&this.saveload===2)
continue;playbackTime=a.getPlaybackTime();if(a.looping)
playbackTime=playbackTime%a.getDuration();d={"tag":a.tag,"buffersrc":a.buffer.src,"is_music":a.is_music,"playbackTime":playbackTime,"volume":a.volume,"looping":a.looping,"muted":a.is_muted,"playbackRate":a.playbackRate,"paused":a.is_paused,"resume_position":a.resume_position};if(a.pannerEnabled)
{d["pan"]={};panobj=d["pan"];if(a.objectTracker&&a.objectTracker.hasObject())
{panobj["objUid"]=a.objectTracker.obj.uid;}
else
{panobj["x"]=a.panX;panobj["y"]=a.panY;panobj["a"]=a.panAngle;}
panobj["ia"]=a.panConeInner;panobj["oa"]=a.panConeOuter;panobj["og"]=a.panConeOuterGain;}
playingarr.push(d);}
var fxobj=o["effects"];var fxarr;for(p in effects)
{if(effects.hasOwnProperty(p))
{fxarr=[];for(i=0,len=effects[p].length;i<len;i++)
{fxarr.push({"type":effects[p][i].type,"params":effects[p][i].params});}
fxobj[p]=fxarr;}}
return o;};var objectTrackerUidsToLoad=[];instanceProto.loadFromJSON=function(o)
{var setSilent=o["silent"];masterVolume=o["masterVolume"];this.listenerZ=o["listenerZ"];this.listenerTracker.setObject(null);var listenerUid=o["listenerUid"];if(listenerUid!==-1)
{this.listenerTracker.loadUid=listenerUid;objectTrackerUidsToLoad.push(this.listenerTracker);}
var playingarr=o["playing"];var i,len,d,src,is_music,tag,playbackTime,looping,vol,b,a,p,pan,panObjUid;if(this.saveload!==3)
{for(i=0,len=audioInstances.length;i<len;i++)
{a=audioInstances[i];if(a.is_music&&this.saveload===1)
continue;if(!a.is_music&&this.saveload===2)
continue;a.stop();}}
var fxarr,fxtype,fxparams,fx;for(p in effects)
{if(effects.hasOwnProperty(p))
{for(i=0,len=effects[p].length;i<len;i++)
effects[p][i].remove();}}
cr.wipe(effects);for(p in o["effects"])
{if(o["effects"].hasOwnProperty(p))
{fxarr=o["effects"][p];for(i=0,len=fxarr.length;i<len;i++)
{fxtype=fxarr[i]["type"];fxparams=fxarr[i]["params"];switch(fxtype){case"filter":addEffectForTag(p,new FilterEffect(fxparams[0],fxparams[1],fxparams[2],fxparams[3],fxparams[4],fxparams[5]));break;case"delay":addEffectForTag(p,new DelayEffect(fxparams[0],fxparams[1],fxparams[2]));break;case"convolve":src=fxparams[2];b=this.getAudioBuffer(src,false);if(b.bufferObject)
{fx=new ConvolveEffect(b.bufferObject,fxparams[0],fxparams[1],src);}
else
{fx=new ConvolveEffect(null,fxparams[0],fxparams[1],src);b.normalizeWhenReady=fxparams[0];b.convolveWhenReady=fx;}
addEffectForTag(p,fx);break;case"flanger":addEffectForTag(p,new FlangerEffect(fxparams[0],fxparams[1],fxparams[2],fxparams[3],fxparams[4]));break;case"phaser":addEffectForTag(p,new PhaserEffect(fxparams[0],fxparams[1],fxparams[2],fxparams[3],fxparams[4],fxparams[5]));break;case"gain":addEffectForTag(p,new GainEffect(fxparams[0]));break;case"tremolo":addEffectForTag(p,new TremoloEffect(fxparams[0],fxparams[1]));break;case"ringmod":addEffectForTag(p,new RingModulatorEffect(fxparams[0],fxparams[1]));break;case"distortion":addEffectForTag(p,new DistortionEffect(fxparams[0],fxparams[1],fxparams[2],fxparams[3],fxparams[4]));break;case"compressor":addEffectForTag(p,new CompressorEffect(fxparams[0],fxparams[1],fxparams[2],fxparams[3],fxparams[4]));break;case"analyser":addEffectForTag(p,new AnalyserEffect(fxparams[0],fxparams[1]));break;}}}}
for(i=0,len=playingarr.length;i<len;i++)
{if(this.saveload===3)
continue;d=playingarr[i];src=d["buffersrc"];is_music=d["is_music"];tag=d["tag"];playbackTime=d["playbackTime"];looping=d["looping"];vol=d["volume"];pan=d["pan"];panObjUid=(pan&&pan.hasOwnProperty("objUid"))?pan["objUid"]:-1;if(is_music&&this.saveload===1)
continue;if(!is_music&&this.saveload===2)
continue;a=this.getAudioInstance(src,tag,is_music,looping,vol);if(!a)
{b=this.getAudioBuffer(src,is_music);b.seekWhenReady=playbackTime;b.pauseWhenReady=d["paused"];if(pan)
{if(panObjUid!==-1)
{b.panWhenReady.push({objUid:panObjUid,ia:pan["ia"],oa:pan["oa"],og:pan["og"],thistag:tag});}
else
{b.panWhenReady.push({x:pan["x"],y:pan["y"],a:pan["a"],ia:pan["ia"],oa:pan["oa"],og:pan["og"],thistag:tag});}}
continue;}
a.resume_position=d["resume_position"];a.setPannerEnabled(!!pan);a.play(looping,vol,playbackTime);a.updatePlaybackRate();a.updateVolume();a.doSetMuted(a.is_muted||a.is_silent);if(d["paused"])
a.pause();if(d["muted"])
a.mute();if(pan)
{if(panObjUid!==-1)
{a.objectTracker=a.objectTracker||new ObjectTracker();a.objectTracker.loadUid=panObjUid;objectTrackerUidsToLoad.push(a.objectTracker);}
else
{a.setPan(pan["x"],pan["y"],pan["a"],pan["ia"],pan["oa"],pan["og"]);}}}
if(setSilent&&!silent)
{for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].setSilent(true);silent=true;}
else if(!setSilent&&silent)
{for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].setSilent(false);silent=false;}};instanceProto.afterLoad=function()
{var i,len,ot,inst;for(i=0,len=objectTrackerUidsToLoad.length;i<len;i++)
{ot=objectTrackerUidsToLoad[i];inst=this.runtime.getObjectByUID(ot.loadUid);ot.setObject(inst);ot.loadUid=-1;if(inst)
{listenerX=inst.x;listenerY=inst.y;}}
objectTrackerUidsToLoad.length=0;};instanceProto.onSuspend=function(s)
{var i,len;for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].setSuspended(s);};instanceProto.tick=function()
{var dt=this.runtime.dt;var i,len,a;for(i=0,len=audioInstances.length;i<len;i++)
{a=audioInstances[i];a.tick(dt);if(a.myapi!==API_HTML5&&a.myapi!==API_APPMOBI)
{if(!a.fresh&&!a.stopped&&a.hasEnded())
{a.stopped=true;audTag=a.tag;audRuntime.trigger(cr.plugins_.Audio.prototype.cnds.OnEnded,audInst);}}
if(timescale_mode!==0)
a.updatePlaybackRate();}
var p,arr,f;for(p in effects)
{if(effects.hasOwnProperty(p))
{arr=effects[p];for(i=0,len=arr.length;i<len;i++)
{f=arr[i];if(f.tick)
f.tick();}}}
if(api===API_WEBAUDIO&&this.listenerTracker.hasObject())
{this.listenerTracker.tick(dt);listenerX=this.listenerTracker.obj.x;listenerY=this.listenerTracker.obj.y;context["listener"]["setPosition"](this.listenerTracker.obj.x,this.listenerTracker.obj.y,this.listenerZ);context["listener"]["setVelocity"](this.listenerTracker.getVelocityX(),this.listenerTracker.getVelocityY(),0);}};instanceProto.getAudioBuffer=function(src_,is_music)
{var i,len,a,ret=null,j,k,lenj,ai;for(i=0,len=audioBuffers.length;i<len;i++)
{a=audioBuffers[i];if(a.src===src_)
{ret=a;break;}}
if(!ret)
{ret=new C2AudioBuffer(src_,is_music);audioBuffers.push(ret);}
if(ret.is_music&&(audRuntime.isMobile||audRuntime.isNodeWebkit))
{for(i=0,len=audioBuffers.length;i<len;++i)
{a=audioBuffers[i];if(a===ret||!a.is_music)
continue;a.bufferObject=null;for(j=0,k=0,lenj=audioInstances.length;j<lenj;++j)
{ai=audioInstances[j];audioInstances[k]=ai;if(ai.buffer===a&&ai.myapi===API_WEBAUDIO)
{ai.gainNode["disconnect"]();if(a.myapi===API_WEBAUDIO)
ai.instanceObject["disconnect"]();}
else
++k;}
audioInstances.length=k;}
ret.decodeAudioBuffer();}
return ret;};instanceProto.getAudioInstance=function(src_,tag,is_music,looping,vol)
{var i,len,a;for(i=0,len=audioInstances.length;i<len;i++)
{a=audioInstances[i];if(a.src===src_&&(a.canBeRecycled()||is_music))
{a.tag=tag;return a;}}
var b=this.getAudioBuffer(src_,is_music);if(!b.bufferObject)
{if(tag!=="<preload>")
{b.playTagWhenReady=tag;b.loopWhenReady=looping;b.volumeWhenReady=vol;}
return null;}
a=new C2AudioInstance(b,tag);audioInstances.push(a);return a;};var taggedAudio=[];function getAudioByTag(tag)
{taggedAudio.length=0;if(!tag.length)
{if(!lastAudio||lastAudio.hasEnded())
return;else
{taggedAudio.length=1;taggedAudio[0]=lastAudio;return;}}
var i,len,a;for(i=0,len=audioInstances.length;i<len;i++)
{a=audioInstances[i];if(cr.equals_nocase(tag,a.tag))
taggedAudio.push(a);}};function reconnectEffects(tag)
{var i,len,arr,n,toNode=context["destination"];if(effects.hasOwnProperty(tag))
{arr=effects[tag];if(arr.length)
{toNode=arr[0].getInputNode();for(i=0,len=arr.length;i<len;i++)
{n=arr[i];if(i+1===len)
n.connectTo(context["destination"]);else
n.connectTo(arr[i+1].getInputNode());}}}
getAudioByTag(tag);for(i=0,len=taggedAudio.length;i<len;i++)
taggedAudio[i].reconnect(toNode);if(micSource&&micTag===tag)
{micSource["disconnect"]();micSource["connect"](toNode);}};function addEffectForTag(tag,fx)
{if(!effects.hasOwnProperty(tag))
effects[tag]=[fx];else
effects[tag].push(fx);reconnectEffects(tag);};function Cnds(){};Cnds.prototype.OnEnded=function(t)
{return cr.equals_nocase(audTag,t);};Cnds.prototype.PreloadsComplete=function()
{var i,len;for(i=0,len=audioBuffers.length;i<len;i++)
{if(!audioBuffers[i].isLoaded())
return false;}
return true;};Cnds.prototype.AdvancedAudioSupported=function()
{return api===API_WEBAUDIO;};Cnds.prototype.IsSilent=function()
{return silent;};Cnds.prototype.IsAnyPlaying=function()
{var i,len;for(i=0,len=audioInstances.length;i<len;i++)
{if(audioInstances[i].isPlaying())
return true;}
return false;};Cnds.prototype.IsTagPlaying=function(tag)
{getAudioByTag(tag);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
{if(taggedAudio[i].isPlaying())
return true;}
return false;};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.Play=function(file,looping,vol,tag)
{if(silent)
return;var v=dbToLinear(vol);var is_music=file[1];var src=this.runtime.files_subfolder+file[0]+(useOgg?".ogg":".m4a");lastAudio=this.getAudioInstance(src,tag,is_music,looping!==0,v);if(!lastAudio)
return;lastAudio.setPannerEnabled(false);lastAudio.play(looping!==0,v);};Acts.prototype.PlayAtPosition=function(file,looping,vol,x_,y_,angle_,innerangle_,outerangle_,outergain_,tag)
{if(silent)
return;var v=dbToLinear(vol);var is_music=file[1];var src=this.runtime.files_subfolder+file[0]+(useOgg?".ogg":".m4a");lastAudio=this.getAudioInstance(src,tag,is_music,looping!==0,v);if(!lastAudio)
{var b=this.getAudioBuffer(src,is_music);b.panWhenReady.push({x:x_,y:y_,a:angle_,ia:innerangle_,oa:outerangle_,og:dbToLinear(outergain_),thistag:tag});return;}
lastAudio.setPannerEnabled(true);lastAudio.setPan(x_,y_,angle_,innerangle_,outerangle_,dbToLinear(outergain_));lastAudio.play(looping!==0,v);};Acts.prototype.PlayAtObject=function(file,looping,vol,obj,innerangle,outerangle,outergain,tag)
{if(silent||!obj)
return;var inst=obj.getFirstPicked();if(!inst)
return;var v=dbToLinear(vol);var is_music=file[1];var src=this.runtime.files_subfolder+file[0]+(useOgg?".ogg":".m4a");lastAudio=this.getAudioInstance(src,tag,is_music,looping!==0,v);if(!lastAudio)
{var b=this.getAudioBuffer(src,is_music);b.panWhenReady.push({obj:inst,ia:innerangle,oa:outerangle,og:dbToLinear(outergain),thistag:tag});return;}
lastAudio.setPannerEnabled(true);var px=cr.rotatePtAround(inst.x,inst.y,-inst.layer.getAngle(),listenerX,listenerY,true);var py=cr.rotatePtAround(inst.x,inst.y,-inst.layer.getAngle(),listenerX,listenerY,false);lastAudio.setPan(px,py,cr.to_degrees(inst.angle-inst.layer.getAngle()),innerangle,outerangle,dbToLinear(outergain));lastAudio.setObject(inst);lastAudio.play(looping!==0,v);};Acts.prototype.PlayByName=function(folder,filename,looping,vol,tag)
{if(silent)
return;var v=dbToLinear(vol);var is_music=(folder===1);var src=this.runtime.files_subfolder+filename.toLowerCase()+(useOgg?".ogg":".m4a");lastAudio=this.getAudioInstance(src,tag,is_music,looping!==0,v);if(!lastAudio)
return;lastAudio.setPannerEnabled(false);lastAudio.play(looping!==0,v);};Acts.prototype.PlayAtPositionByName=function(folder,filename,looping,vol,x_,y_,angle_,innerangle_,outerangle_,outergain_,tag)
{if(silent)
return;var v=dbToLinear(vol);var is_music=(folder===1);var src=this.runtime.files_subfolder+filename.toLowerCase()+(useOgg?".ogg":".m4a");lastAudio=this.getAudioInstance(src,tag,is_music,looping!==0,v);if(!lastAudio)
{var b=this.getAudioBuffer(src,is_music);b.panWhenReady.push({x:x_,y:y_,a:angle_,ia:innerangle_,oa:outerangle_,og:dbToLinear(outergain_),thistag:tag});return;}
lastAudio.setPannerEnabled(true);lastAudio.setPan(x_,y_,angle_,innerangle_,outerangle_,dbToLinear(outergain_));lastAudio.play(looping!==0,v);};Acts.prototype.PlayAtObjectByName=function(folder,filename,looping,vol,obj,innerangle,outerangle,outergain,tag)
{if(silent||!obj)
return;var inst=obj.getFirstPicked();if(!inst)
return;var v=dbToLinear(vol);var is_music=(folder===1);var src=this.runtime.files_subfolder+filename.toLowerCase()+(useOgg?".ogg":".m4a");lastAudio=this.getAudioInstance(src,tag,is_music,looping!==0,v);if(!lastAudio)
{var b=this.getAudioBuffer(src,is_music);b.panWhenReady.push({obj:inst,ia:innerangle,oa:outerangle,og:dbToLinear(outergain),thistag:tag});return;}
lastAudio.setPannerEnabled(true);var px=cr.rotatePtAround(inst.x,inst.y,-inst.layer.getAngle(),listenerX,listenerY,true);var py=cr.rotatePtAround(inst.x,inst.y,-inst.layer.getAngle(),listenerX,listenerY,false);lastAudio.setPan(px,py,cr.to_degrees(inst.angle-inst.layer.getAngle()),innerangle,outerangle,dbToLinear(outergain));lastAudio.setObject(inst);lastAudio.play(looping!==0,v);};Acts.prototype.SetLooping=function(tag,looping)
{getAudioByTag(tag);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
taggedAudio[i].setLooping(looping===0);};Acts.prototype.SetMuted=function(tag,muted)
{getAudioByTag(tag);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
taggedAudio[i].setMuted(muted===0);};Acts.prototype.SetVolume=function(tag,vol)
{getAudioByTag(tag);var v=dbToLinear(vol);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
taggedAudio[i].setVolume(v);};Acts.prototype.Preload=function(file)
{if(silent)
return;var is_music=file[1];var src=this.runtime.files_subfolder+file[0]+(useOgg?".ogg":".m4a");if(api===API_APPMOBI)
{if(this.runtime.isDirectCanvas)
AppMobi["context"]["loadSound"](src);else
AppMobi["player"]["loadSound"](src);return;}
else if(api===API_PHONEGAP)
{return;}
this.getAudioInstance(src,"<preload>",is_music,false);};Acts.prototype.PreloadByName=function(folder,filename)
{if(silent)
return;var is_music=(folder===1);var src=this.runtime.files_subfolder+filename.toLowerCase()+(useOgg?".ogg":".m4a");if(api===API_APPMOBI)
{if(this.runtime.isDirectCanvas)
AppMobi["context"]["loadSound"](src);else
AppMobi["player"]["loadSound"](src);return;}
else if(api===API_PHONEGAP)
{return;}
this.getAudioInstance(src,"<preload>",is_music,false);};Acts.prototype.SetPlaybackRate=function(tag,rate)
{getAudioByTag(tag);if(rate<0.0)
rate=0;var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
taggedAudio[i].setPlaybackRate(rate);};Acts.prototype.Stop=function(tag)
{getAudioByTag(tag);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
taggedAudio[i].stop();};Acts.prototype.StopAll=function()
{var i,len;for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].stop();};Acts.prototype.SetPaused=function(tag,state)
{getAudioByTag(tag);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
{if(state===0)
taggedAudio[i].pause();else
taggedAudio[i].resume();}};Acts.prototype.Seek=function(tag,pos)
{getAudioByTag(tag);var i,len;for(i=0,len=taggedAudio.length;i<len;i++)
{taggedAudio[i].seek(pos);}};Acts.prototype.SetSilent=function(s)
{var i,len;if(s===2)
s=(silent?1:0);if(s===0&&!silent)
{for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].setSilent(true);silent=true;}
else if(s===1&&silent)
{for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].setSilent(false);silent=false;}};Acts.prototype.SetMasterVolume=function(vol)
{masterVolume=dbToLinear(vol);var i,len;for(i=0,len=audioInstances.length;i<len;i++)
audioInstances[i].updateVolume();};Acts.prototype.AddFilterEffect=function(tag,type,freq,detune,q,gain,mix)
{if(api!==API_WEBAUDIO||type<0||type>=filterTypes.length)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new FilterEffect(type,freq,detune,q,gain,mix));};Acts.prototype.AddDelayEffect=function(tag,delay,gain,mix)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new DelayEffect(delay,dbToLinear(gain),mix));};Acts.prototype.AddFlangerEffect=function(tag,delay,modulation,freq,feedback,mix)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new FlangerEffect(delay/1000,modulation/1000,freq,feedback/100,mix));};Acts.prototype.AddPhaserEffect=function(tag,freq,detune,q,mod,modfreq,mix)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new PhaserEffect(freq,detune,q,mod,modfreq,mix));};Acts.prototype.AddConvolutionEffect=function(tag,file,norm,mix)
{if(api!==API_WEBAUDIO)
return;var doNormalize=(norm===0);var src=this.runtime.files_subfolder+file[0]+(useOgg?".ogg":".m4a");var b=this.getAudioBuffer(src,false);tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;var fx;if(b.bufferObject)
{fx=new ConvolveEffect(b.bufferObject,doNormalize,mix,src);}
else
{fx=new ConvolveEffect(null,doNormalize,mix,src);b.normalizeWhenReady=doNormalize;b.convolveWhenReady=fx;}
addEffectForTag(tag,fx);};Acts.prototype.AddGainEffect=function(tag,g)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();addEffectForTag(tag,new GainEffect(dbToLinear(g)));};Acts.prototype.AddMuteEffect=function(tag)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();addEffectForTag(tag,new GainEffect(0));};Acts.prototype.AddTremoloEffect=function(tag,freq,mix)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new TremoloEffect(freq,mix));};Acts.prototype.AddRingModEffect=function(tag,freq,mix)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new RingModulatorEffect(freq,mix));};Acts.prototype.AddDistortionEffect=function(tag,threshold,headroom,drive,makeupgain,mix)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();mix=mix/100;if(mix<0)mix=0;if(mix>1)mix=1;addEffectForTag(tag,new DistortionEffect(threshold,headroom,drive,makeupgain,mix));};Acts.prototype.AddCompressorEffect=function(tag,threshold,knee,ratio,attack,release)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();addEffectForTag(tag,new CompressorEffect(threshold,knee,ratio,attack/1000,release/1000));};Acts.prototype.AddAnalyserEffect=function(tag,fftSize,smoothing)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();addEffectForTag(tag,new AnalyserEffect(fftSize,smoothing));};Acts.prototype.RemoveEffects=function(tag)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();var i,len,arr;if(effects.hasOwnProperty(tag))
{arr=effects[tag];if(arr.length)
{for(i=0,len=arr.length;i<len;i++)
arr[i].remove();arr.length=0;reconnectEffects(tag);}}};Acts.prototype.SetEffectParameter=function(tag,index,param,value,ramp,time)
{if(api!==API_WEBAUDIO)
return;tag=tag.toLowerCase();index=Math.floor(index);var arr;if(!effects.hasOwnProperty(tag))
return;arr=effects[tag];if(index<0||index>=arr.length)
return;arr[index].setParam(param,value,ramp,time);};Acts.prototype.SetListenerObject=function(obj_)
{if(!obj_||api!==API_WEBAUDIO)
return;var inst=obj_.getFirstPicked();if(!inst)
return;this.listenerTracker.setObject(inst);listenerX=inst.x;listenerY=inst.y;};Acts.prototype.SetListenerZ=function(z)
{this.listenerZ=z;};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.Duration=function(ret,tag)
{getAudioByTag(tag);if(taggedAudio.length)
ret.set_float(taggedAudio[0].getDuration());else
ret.set_float(0);};Exps.prototype.PlaybackTime=function(ret,tag)
{getAudioByTag(tag);if(taggedAudio.length)
ret.set_float(taggedAudio[0].getPlaybackTime());else
ret.set_float(0);};Exps.prototype.Volume=function(ret,tag)
{getAudioByTag(tag);if(taggedAudio.length)
{var v=taggedAudio[0].getVolume();ret.set_float(linearToDb(v));}
else
ret.set_float(0);};Exps.prototype.MasterVolume=function(ret)
{ret.set_float(masterVolume);};Exps.prototype.EffectCount=function(ret,tag)
{tag=tag.toLowerCase();var arr=null;if(effects.hasOwnProperty(tag))
arr=effects[tag];ret.set_int(arr?arr.length:0);};function getAnalyser(tag,index)
{var arr=null;if(effects.hasOwnProperty(tag))
arr=effects[tag];if(arr&&index>=0&&index<arr.length&&arr[index].freqBins)
return arr[index];else
return null;};Exps.prototype.AnalyserFreqBinCount=function(ret,tag,index)
{tag=tag.toLowerCase();index=Math.floor(index);var analyser=getAnalyser(tag,index);ret.set_int(analyser?analyser.node["frequencyBinCount"]:0);};Exps.prototype.AnalyserFreqBinAt=function(ret,tag,index,bin)
{tag=tag.toLowerCase();index=Math.floor(index);bin=Math.floor(bin);var analyser=getAnalyser(tag,index);if(!analyser)
ret.set_float(0);else if(bin<0||bin>=analyser.node["frequencyBinCount"])
ret.set_float(0);else
ret.set_float(analyser.freqBins[bin]);};Exps.prototype.AnalyserPeakLevel=function(ret,tag,index)
{tag=tag.toLowerCase();index=Math.floor(index);var analyser=getAnalyser(tag,index);if(analyser)
ret.set_float(analyser.peak);else
ret.set_float(0);};Exps.prototype.AnalyserRMSLevel=function(ret,tag,index)
{tag=tag.toLowerCase();index=Math.floor(index);var analyser=getAnalyser(tag,index);if(analyser)
ret.set_float(analyser.rms);else
ret.set_float(0);};pluginProto.exps=new Exps();}());;;cr.plugins_.Browser=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Browser.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{var self=this;window.addEventListener("resize",function(){self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnResize,self);});if(typeof navigator.onLine!=="undefined")
{window.addEventListener("online",function(){self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnOnline,self);});window.addEventListener("offline",function(){self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnOffline,self);});}
if(typeof window.applicationCache!=="undefined")
{window.applicationCache.addEventListener('updateready',function(){self.runtime.loadingprogress=1;self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnUpdateReady,self);});window.applicationCache.addEventListener('progress',function(e){self.runtime.loadingprogress=e["loaded"]/e["total"];});}
if(!this.runtime.isDirectCanvas)
{document.addEventListener("appMobi.device.update.available",function(){self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnUpdateReady,self);});document.addEventListener("menubutton",function(){self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnMenuButton,self);});document.addEventListener("searchbutton",function(){self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnSearchButton,self);});document.addEventListener("tizenhwkey",function(e){var ret;switch(e["keyName"]){case"back":ret=self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnBackButton,self);if(!ret)
{if(window["tizen"])
window["tizen"]["application"]["getCurrentApplication"]()["exit"]();}
break;case"menu":ret=self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnMenuButton,self);if(!ret)
e.preventDefault();break;}});}
this.runtime.addSuspendCallback(function(s){if(s)
{self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnPageHidden,self);}
else
{self.runtime.trigger(cr.plugins_.Browser.prototype.cnds.OnPageVisible,self);}});this.is_arcade=(typeof window["is_scirra_arcade"]!=="undefined");this.fullscreenOldMarginCss="";};function Cnds(){};Cnds.prototype.CookiesEnabled=function()
{return navigator?navigator.cookieEnabled:false;};Cnds.prototype.IsOnline=function()
{return navigator?navigator.onLine:false;};Cnds.prototype.HasJava=function()
{return navigator?navigator.javaEnabled():false;};Cnds.prototype.OnOnline=function()
{return true;};Cnds.prototype.OnOffline=function()
{return true;};Cnds.prototype.IsDownloadingUpdate=function()
{if(typeof window["applicationCache"]==="undefined")
return false;else
return window["applicationCache"]["status"]===window["applicationCache"]["DOWNLOADING"];};Cnds.prototype.OnUpdateReady=function()
{return true;};Cnds.prototype.PageVisible=function()
{return!this.runtime.isSuspended;};Cnds.prototype.OnPageVisible=function()
{return true;};Cnds.prototype.OnPageHidden=function()
{return true;};Cnds.prototype.OnResize=function()
{return true;};Cnds.prototype.IsFullscreen=function()
{return!!(document["mozFullScreen"]||document["webkitIsFullScreen"]||document["fullScreen"]||this.runtime.isNodeFullscreen);};Cnds.prototype.OnBackButton=function()
{return true;};Cnds.prototype.OnMenuButton=function()
{return true;};Cnds.prototype.OnSearchButton=function()
{return true;};Cnds.prototype.IsMetered=function()
{var connection=navigator["connection"]||navigator["mozConnection"]||navigator["webkitConnection"];if(!connection)
return false;return connection["metered"];};Cnds.prototype.IsCharging=function()
{var battery=navigator["battery"]||navigator["mozBattery"]||navigator["webkitBattery"];if(!battery)
return true;return battery["charging"];};Cnds.prototype.IsPortraitLandscape=function(p)
{var current=(window.innerWidth<=window.innerHeight?0:1);return current===p;};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.Alert=function(msg)
{if(!this.runtime.isDomFree)
alert(msg.toString());};Acts.prototype.Close=function()
{if(this.runtime.isCocoonJs)
CocoonJS["App"]["forceToFinish"]();else if(!this.is_arcade&&!this.runtime.isDomFree)
window.close();};Acts.prototype.Focus=function()
{if(this.runtime.isNodeWebkit)
{var win=window["nwgui"]["Window"]["get"]();win["focus"]();}
else if(!this.is_arcade&&!this.runtime.isDomFree)
window.focus();};Acts.prototype.Blur=function()
{if(this.runtime.isNodeWebkit)
{var win=window["nwgui"]["Window"]["get"]();win["blur"]();}
else if(!this.is_arcade&&!this.runtime.isDomFree)
window.blur();};Acts.prototype.GoBack=function()
{if(!this.is_arcade&&!this.runtime.isDomFree&&window.back)
window.back();};Acts.prototype.GoForward=function()
{if(!this.is_arcade&&!this.runtime.isDomFree&&window.forward)
window.forward();};Acts.prototype.GoHome=function()
{if(!this.is_arcade&&!this.runtime.isDomFree&&window.home)
window.home();};Acts.prototype.GoToURL=function(url)
{if(this.runtime.isCocoonJs)
CocoonJS["App"]["openURL"](url);else if(!this.is_arcade&&!this.runtime.isDomFree)
window.location=url;};Acts.prototype.GoToURLWindow=function(url,tag)
{if(this.runtime.isCocoonJs)
CocoonJS["App"]["openURL"](url);else if(!this.is_arcade&&!this.runtime.isDomFree)
window.open(url,tag);};Acts.prototype.Reload=function()
{if(!this.is_arcade&&!this.runtime.isDomFree)
window.location.reload();};var firstRequestFullscreen=true;var crruntime=null;function onFullscreenError()
{if(typeof jQuery!=="undefined")
{crruntime["setSize"](jQuery(window).width(),jQuery(window).height());}};Acts.prototype.RequestFullScreen=function(stretchmode)
{if(this.runtime.isDomFree)
{cr.logexport("[Construct 2] Requesting fullscreen is not supported on this platform - the request has been ignored");return;}
if(stretchmode>=2)
stretchmode+=1;if(stretchmode===6)
stretchmode=2;if(this.runtime.isNodeWebkit)
{if(!this.runtime.isNodeFullscreen)
{window["nwgui"]["Window"]["get"]()["enterFullscreen"]();this.runtime.isNodeFullscreen=true;}}
else
{if(document["mozFullScreen"]||document["webkitIsFullScreen"]||!!document["msFullscreenElement"]||document["fullScreen"])
{return;}
this.fullscreenOldMarginCss=jQuery(this.runtime.canvasdiv).css("margin");jQuery(this.runtime.canvasdiv).css("margin","0");window["c2resizestretchmode"]=(stretchmode>0?1:0);this.runtime.fullscreen_scaling=(stretchmode>=2?stretchmode:0);var elem=this.runtime.canvasdiv||this.runtime.canvas;if(firstRequestFullscreen)
{firstRequestFullscreen=false;crruntime=this.runtime;elem.addEventListener("mozfullscreenerror",onFullscreenError);elem.addEventListener("webkitfullscreenerror",onFullscreenError);elem.addEventListener("msfullscreenerror",onFullscreenError);elem.addEventListener("fullscreenerror",onFullscreenError);}
if(!cr.is_undefined(elem["webkitRequestFullScreen"]))
{if(typeof Element!=="undefined"&&typeof Element["ALLOW_KEYBOARD_INPUT"]!=="undefined")
elem["webkitRequestFullScreen"](Element["ALLOW_KEYBOARD_INPUT"]);else
elem["webkitRequestFullScreen"]();}
else if(!cr.is_undefined(elem["mozRequestFullScreen"]))
elem["mozRequestFullScreen"]();else if(!cr.is_undefined(elem["msRequestFullscreen"]))
elem["msRequestFullscreen"]();else if(!cr.is_undefined(elem["requestFullscreen"]))
elem["requestFullscreen"]();}};Acts.prototype.CancelFullScreen=function()
{if(this.runtime.isDomFree)
{cr.logexport("[Construct 2] Exiting fullscreen is not supported on this platform - the request has been ignored");return;}
if(this.runtime.isNodeWebkit)
{if(this.runtime.isNodeFullscreen)
{window["nwgui"]["Window"]["get"]()["leaveFullscreen"]();this.runtime.isNodeFullscreen=false;}}
else
{if(!cr.is_undefined(document["webkitCancelFullScreen"]))
document["webkitCancelFullScreen"]();else if(!cr.is_undefined(document["mozCancelFullScreen"]))
document["mozCancelFullScreen"]();else if(!cr.is_undefined(document["msExitFullscreen"]))
document["msExitFullscreen"]();else if(!cr.is_undefined(document["exitFullscreen"]))
document["exitFullscreen"]();jQuery(this.runtime.canvasdiv).css("margin",this.fullscreenOldMarginCss);}};Acts.prototype.Vibrate=function(pattern_)
{try{var arr=pattern_.split(",");var i,len;for(i=0,len=arr.length;i<len;i++)
{arr[i]=parseInt(arr[i],10);}
if(navigator["vibrate"])
navigator["vibrate"](arr);else if(navigator["mozVibrate"])
navigator["mozVibrate"](arr);else if(navigator["webkitVibrate"])
navigator["webkitVibrate"](arr);}
catch(e){}};Acts.prototype.InvokeDownload=function(url_,filename_)
{var a=document.createElement("a");if(typeof a.download==="undefined")
{window.open(url_);}
else
{var body=document.getElementsByTagName("body")[0];a.textContent=filename_;a.href=url_;a.download=filename_;body.appendChild(a);var clickEvent=document.createEvent("MouseEvent");clickEvent.initMouseEvent("click",true,true,window,0,0,0,0,0,false,false,false,false,0,null);a.dispatchEvent(clickEvent);body.removeChild(a);}};Acts.prototype.ConsoleLog=function(type_,msg_)
{if(!console)
return;if(type_===0&&console.log)
console.log(msg_.toString());if(type_===1&&console.warn)
console.warn(msg_.toString());if(type_===2&&console.error)
console.error(msg_.toString());};Acts.prototype.ConsoleGroup=function(name_)
{if(console&&console.group)
console.group(name_);};Acts.prototype.ConsoleGroupEnd=function()
{if(console&&console.groupEnd)
console.groupEnd();};Acts.prototype.ExecJs=function(js_)
{if(eval)
eval(js_);};var orientations=["portrait","landscape","portrait-primary","portrait-secondary","landscape-primary","landscape-secondary"];Acts.prototype.LockOrientation=function(o)
{o=Math.floor(o);if(o<0||o>=orientations.length)
return;var orientation=orientations[o];if(screen["lockOrientation"])
screen["lockOrientation"](orientation);else if(screen["webkitLockOrientation"])
screen["webkitLockOrientation"](orientation);else if(screen["mozLockOrientation"])
screen["mozLockOrientation"](orientation);else if(screen["msLockOrientation"])
screen["msLockOrientation"](orientation);};Acts.prototype.UnlockOrientation=function()
{if(screen["unlockOrientation"])
screen["unlockOrientation"]();else if(screen["webkitUnlockOrientation"])
screen["webkitUnlockOrientation"]();else if(screen["mozUnlockOrientation"])
screen["mozUnlockOrientation"]();else if(screen["msUnlockOrientation"])
screen["msUnlockOrientation"]();};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.URL=function(ret)
{ret.set_string(this.runtime.isDomFree?"":window.location.toString());};Exps.prototype.Protocol=function(ret)
{ret.set_string(this.runtime.isDomFree?"":window.location.protocol);};Exps.prototype.Domain=function(ret)
{ret.set_string(this.runtime.isDomFree?"":window.location.hostname);};Exps.prototype.PathName=function(ret)
{ret.set_string(this.runtime.isDomFree?"":window.location.pathname);};Exps.prototype.Hash=function(ret)
{ret.set_string(this.runtime.isDomFree?"":window.location.hash);};Exps.prototype.Referrer=function(ret)
{ret.set_string(this.runtime.isDomFree?"":document.referrer);};Exps.prototype.Title=function(ret)
{ret.set_string(this.runtime.isDomFree?"":document.title);};Exps.prototype.Name=function(ret)
{ret.set_string(this.runtime.isDomFree?"":navigator.appName);};Exps.prototype.Version=function(ret)
{ret.set_string(this.runtime.isDomFree?"":navigator.appVersion);};Exps.prototype.Language=function(ret)
{if(navigator&&navigator.language)
ret.set_string(navigator.language);else
ret.set_string("");};Exps.prototype.Platform=function(ret)
{ret.set_string(this.runtime.isDomFree?"":navigator.platform);};Exps.prototype.Product=function(ret)
{if(navigator&&navigator.product)
ret.set_string(navigator.product);else
ret.set_string("");};Exps.prototype.Vendor=function(ret)
{if(navigator&&navigator.vendor)
ret.set_string(navigator.vendor);else
ret.set_string("");};Exps.prototype.UserAgent=function(ret)
{ret.set_string(this.runtime.isDomFree?"":navigator.userAgent);};Exps.prototype.QueryString=function(ret)
{ret.set_string(this.runtime.isDomFree?"":window.location.search);};Exps.prototype.QueryParam=function(ret,paramname)
{if(this.runtime.isDomFree)
{ret.set_string("");return;}
var match=RegExp('[?&]'+paramname+'=([^&]*)').exec(window.location.search);if(match)
ret.set_string(decodeURIComponent(match[1].replace(/\+/g,' ')));else
ret.set_string("");};Exps.prototype.Bandwidth=function(ret)
{var connection=navigator["connection"]||navigator["mozConnection"]||navigator["webkitConnection"];if(!connection)
ret.set_float(Number.POSITIVE_INFINITY);else
ret.set_float(connection["bandwidth"]);};Exps.prototype.BatteryLevel=function(ret)
{var battery=navigator["battery"]||navigator["mozBattery"]||navigator["webkitBattery"];if(!battery)
ret.set_float(1);else
ret.set_float(battery["level"]);};Exps.prototype.BatteryTimeLeft=function(ret)
{var battery=navigator["battery"]||navigator["mozBattery"]||navigator["webkitBattery"];if(!battery)
ret.set_float(Number.POSITIVE_INFINITY);else
ret.set_float(battery["dischargingTime"]);};Exps.prototype.ExecJS=function(ret,js_)
{if(!eval)
{ret.set_any(0);return;}
var result=eval(js_);if(typeof result==="number")
ret.set_any(result);else if(typeof result==="string")
ret.set_any(result);else if(typeof result==="boolean")
ret.set_any(result?1:0);else
ret.set_any(0);};Exps.prototype.ScreenWidth=function(ret)
{ret.set_int(screen.width);};Exps.prototype.ScreenHeight=function(ret)
{ret.set_int(screen.height);};Exps.prototype.DevicePixelRatio=function(ret)
{ret.set_float(this.runtime.devicePixelRatio);};pluginProto.exps=new Exps();}());;;cr.plugins_.Dictionary=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Dictionary.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{this.dictionary={};this.cur_key="";this.key_count=0;};instanceProto.saveToJSON=function()
{return this.dictionary;};instanceProto.loadFromJSON=function(o)
{this.dictionary=o;this.key_count=0;for(var p in this.dictionary)
{if(this.dictionary.hasOwnProperty(p))
this.key_count++;}};function Cnds(){};Cnds.prototype.CompareValue=function(key_,cmp_,value_)
{return cr.do_cmp(this.dictionary[key_],cmp_,value_);};Cnds.prototype.ForEachKey=function()
{var current_event=this.runtime.getCurrentEventStack().current_event;for(var p in this.dictionary)
{if(this.dictionary.hasOwnProperty(p))
{this.cur_key=p;this.runtime.pushCopySol(current_event.solModifiers);current_event.retrigger();this.runtime.popSol(current_event.solModifiers);}}
this.cur_key="";return false;};Cnds.prototype.CompareCurrentValue=function(cmp_,value_)
{return cr.do_cmp(this.dictionary[this.cur_key],cmp_,value_);};Cnds.prototype.HasKey=function(key_)
{return this.dictionary.hasOwnProperty(key_);};Cnds.prototype.IsEmpty=function()
{return this.key_count===0;};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.AddKey=function(key_,value_)
{if(!this.dictionary.hasOwnProperty(key_))
this.key_count++;this.dictionary[key_]=value_;};Acts.prototype.SetKey=function(key_,value_)
{if(this.dictionary.hasOwnProperty(key_))
this.dictionary[key_]=value_;};Acts.prototype.DeleteKey=function(key_)
{if(this.dictionary.hasOwnProperty(key_))
{delete this.dictionary[key_];this.key_count--;}};Acts.prototype.Clear=function()
{cr.wipe(this.dictionary);this.key_count=0;};Acts.prototype.JSONLoad=function(json_)
{var o;try{o=JSON.parse(json_);}
catch(e){return;}
if(!o["c2dictionary"])
return;this.dictionary=o["data"];this.key_count=0;for(var p in this.dictionary)
{if(this.dictionary.hasOwnProperty(p))
this.key_count++;}};Acts.prototype.JSONDownload=function(filename)
{var a=document.createElement("a");if(typeof a.download==="undefined")
{var str='data:text/html,'+encodeURIComponent("<p><a download='data.json' href=\"data:application/json,"+encodeURIComponent(JSON.stringify({"c2dictionary":true,"data":this.dictionary}))+"\">Download link</a></p>");window.open(str);}
else
{var body=document.getElementsByTagName("body")[0];a.textContent=filename;a.href="data:application/json,"+encodeURIComponent(JSON.stringify({"c2dictionary":true,"data":this.dictionary}));a.download=filename;body.appendChild(a);var clickEvent=document.createEvent("MouseEvent");clickEvent.initMouseEvent("click",true,true,window,0,0,0,0,0,false,false,false,false,0,null);a.dispatchEvent(clickEvent);body.removeChild(a);}};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.Get=function(ret,key_)
{if(this.dictionary.hasOwnProperty(key_))
ret.set_any(this.dictionary[key_]);else
ret.set_int(0);};Exps.prototype.KeyCount=function(ret)
{ret.set_int(this.key_count);};Exps.prototype.CurrentKey=function(ret)
{ret.set_string(this.cur_key);};Exps.prototype.CurrentValue=function(ret)
{if(this.dictionary.hasOwnProperty(this.cur_key))
ret.set_any(this.dictionary[this.cur_key]);else
ret.set_int(0);};Exps.prototype.AsJSON=function(ret)
{ret.set_string(JSON.stringify({"c2dictionary":true,"data":this.dictionary}));};pluginProto.exps=new Exps();}());;;cr.plugins_.Function=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Function.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;var funcStack=[];var funcStackPtr=-1;var isInPreview=false;function FuncStackEntry()
{this.name="";this.retVal=0;this.params=[];};function pushFuncStack()
{funcStackPtr++;if(funcStackPtr===funcStack.length)
funcStack.push(new FuncStackEntry());return funcStack[funcStackPtr];};function getCurrentFuncStack()
{if(funcStackPtr<0)
return null;return funcStack[funcStackPtr];};function getOneAboveFuncStack()
{if(!funcStack.length)
return null;var i=funcStackPtr+1;if(i>=funcStack.length)
i=funcStack.length-1;return funcStack[i];};function popFuncStack()
{;funcStackPtr--;};instanceProto.onCreate=function()
{isInPreview=(typeof cr_is_preview!=="undefined");};function Cnds(){};Cnds.prototype.OnFunction=function(name_)
{var fs=getCurrentFuncStack();if(!fs)
return false;return cr.equals_nocase(name_,fs.name);};Cnds.prototype.CompareParam=function(index_,cmp_,value_)
{var fs=getCurrentFuncStack();if(!fs)
return false;index_=cr.floor(index_);if(index_<0||index_>=fs.params.length)
return false;return cr.do_cmp(fs.params[index_],cmp_,value_);};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.CallFunction=function(name_,params_)
{var fs=pushFuncStack();fs.name=name_.toLowerCase();fs.retVal=0;cr.shallowAssignArray(fs.params,params_);var ran=this.runtime.trigger(cr.plugins_.Function.prototype.cnds.OnFunction,this,fs.name);if(isInPreview&&!ran)
{;}
popFuncStack();};Acts.prototype.SetReturnValue=function(value_)
{var fs=getCurrentFuncStack();if(fs)
fs.retVal=value_;else;};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.ReturnValue=function(ret)
{var fs=getOneAboveFuncStack();if(fs)
ret.set_any(fs.retVal);else
ret.set_int(0);};Exps.prototype.ParamCount=function(ret)
{var fs=getCurrentFuncStack();if(fs)
ret.set_int(fs.params.length);else
{;ret.set_int(0);}};Exps.prototype.Param=function(ret,index_)
{index_=cr.floor(index_);var fs=getCurrentFuncStack();if(fs)
{if(index_>=0&&index_<fs.params.length)
{ret.set_any(fs.params[index_]);}
else
{;ret.set_int(0);}}
else
{;ret.set_int(0);}};Exps.prototype.Call=function(ret,name_)
{var fs=pushFuncStack();fs.name=name_.toLowerCase();fs.retVal=0;fs.params.length=0;var i,len;for(i=2,len=arguments.length;i<len;i++)
fs.params.push(arguments[i]);var ran=this.runtime.trigger(cr.plugins_.Function.prototype.cnds.OnFunction,this,fs.name);if(isInPreview&&!ran)
{;}
popFuncStack();ret.set_any(fs.retVal);};pluginProto.exps=new Exps();}());;;cr.plugins_.JSON=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.JSON.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;var ROOT_KEY="root";instanceProto.onCreate=function()
{this.data={};this.curKey="";this.curValue=undefined;this.curPath=[];};instanceProto.onDestroy=function()
{this.data=null;this.curKey=null;this.curPath=null;this.curValue=null;};instanceProto.saveToJSON=function()
{return this.data[ROOT_KEY];};instanceProto.loadFromJSON=function(o)
{this.data[ROOT_KEY]=o;};instanceProto.getValueFromPath=function(from_current,path){if(from_current){return this.getValueFromPath(false,this.curPath.concat(path));}else{var path_=[ROOT_KEY].concat(path);var value=this.data;for(var i=0;i<path_.length;i++){if(value===undefined){;break;}else if(value===null){if(i<path_.length-1){;value=undefined;}
break;}else{value=value[path_[i]];}}
return value;}};instanceProto.setValueFromPath=function(from_current,path,value){if(from_current){value=this.setValueFromPath(false,this.curPath.concat(path),value);}else{var path_=[ROOT_KEY].concat(path);var obj=this.data;for(var i=0;i<path_.length;i++){if(type(obj)==="array"||type(obj)==="object"){if(i<path_.length-1){obj=obj[path_[i]];}else{obj[path_[i]]=value;}}else{;return;}}}};function type(value){if(value===undefined){return"undefined";}else if(value===null){return"null";}else if(value===!!value){return"boolean";}else if(Object.prototype.toString.call(value)==="[object Number]"){return"number";}else if(Object.prototype.toString.call(value)==="[object String]"){return"string";}else if(Object.prototype.toString.call(value)==="[object Array]"){return"array";}else if(Object.prototype.toString.call(value)==="[object Object]"){return"object";}}
function Cnds(){}
Cnds.prototype.IsObject=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return type(value)==="object";};Cnds.prototype.IsArray=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return type(value)==="array";};Cnds.prototype.IsBoolean=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return type(value)==="boolean";};Cnds.prototype.IsNumber=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return type(value)==="number";};Cnds.prototype.IsString=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return type(value)==="string";};Cnds.prototype.IsNull=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return type(value)==="null";};Cnds.prototype.IsUndefined=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);return value===undefined;};Cnds.prototype.IsEmpty=function(from_current,path)
{var value=this.getValueFromPath(from_current===1,path);var t=type(value);if(t==="array"){return value.length===0;}else if(t==="object"){for(var p in value){if(Object.prototype.hasOwnProperty.call(value,p)){return false;}}
return true;}else{return value===undefined;}};Cnds.prototype.ForEachProperty=function(from_current,path)
{var current_frame=this.runtime.getCurrentEventStack();var current_event=current_frame.current_event;var solModifierAfterCnds=current_frame.isModifierAfterCnds();var current_loop=this.runtime.pushLoopStack();var lastPath=this.curPath;var path_;if(from_current===1){path_=this.curPath.concat(path);}else{path_=path;}
var obj=this.getValueFromPath(false,path_);var p;if(solModifierAfterCnds){for(p in obj){if(Object.prototype.hasOwnProperty.call(obj,p)){this.curPath=path_.concat(p);this.curKey=p;this.curValue=obj[p];this.runtime.pushCopySol(current_event.solModifiers);current_event.retrigger();this.runtime.popSol(current_event.solModifiers);if(current_loop.stopped){break;}}}}else{for(p in obj){if(Object.prototype.hasOwnProperty.call(obj,p)){this.curPath=path_.concat(p);this.curKey=p;this.curValue=obj[p];current_event.retrigger();if(current_loop.stopped){break;}}}}
this.curPath=lastPath;this.curKey="";this.curValue=undefined;this.runtime.popLoopStack();return false;};pluginProto.cnds=new Cnds();function Acts(){}
Acts.prototype.NewObject=function(from_current,path)
{this.setValueFromPath(from_current,path,{});};Acts.prototype.NewArray=function(from_current,path)
{this.setValueFromPath(from_current,path,[]);};Acts.prototype.SetValue=function(value,from_current,path)
{this.setValueFromPath(from_current,path,value);};Acts.prototype.SetBoolean=function(value,from_current,path)
{this.setValueFromPath(from_current,path,value===0);};Acts.prototype.SetNull=function(from_current,path)
{this.setValueFromPath(from_current,path,null);};Acts.prototype.Delete=function(from_current,path)
{var path_;if(from_current){path_=this.curPath.concat(path);}else{path_=path;}
function deleteIfValid(obj,prop){if(obj!==undefined&&obj!==null&&(typeof obj==="object")&&obj[prop]!==undefined){delete obj[prop];}else{;}}
if(path_.length===0){deleteIfValid(this.data,ROOT_KEY);}else{deleteIfValid(this.getValueFromPath(false,path_.slice(0,path.length-1)),path_.slice(-1));}};Acts.prototype.Clear=function(from_current,path)
{var path_;if(from_current){path_=this.curPath.concat(path);}else{path_=path;}
function clearIfValid(obj,prop){if(obj!==undefined&&obj!==null&&(typeof obj==="object")&&obj[prop]!==undefined){var t=type(obj[prop]);if(t==="array"){obj[prop].length=0;}else if(t==="object"){for(var p in obj[prop]){if(Object.prototype.hasOwnProperty.call(obj[prop],p)){delete obj[prop][p];}}}else{delete obj[prop];}}else{;}}
if(path_.length===0){clearIfValid(this.data,ROOT_KEY);}else{clearIfValid(this.getValueFromPath(false,path_.slice(0,path.length-1)),path_.slice(-1));}};Acts.prototype.LoadJSON=function(json,from_current,path)
{this.setValueFromPath(from_current,path,JSON.parse(json));};Acts.prototype.LogData=function()
{if(console.groupCollapsed!==undefined&&console.groupEnd!==undefined){console.groupCollapsed(ROOT_KEY+":");console.log(JSON.stringify(this.data[ROOT_KEY],null,2));console.groupEnd();}else{console.log(JSON.stringify(this.data[ROOT_KEY],null,2));}
console.log("Current Path:",JSON.stringify(this.curPath));};Acts.prototype.SetCurrentPath=function(from_current,path){if(from_current){this.curPath=this.curPath.concat(path);}else{this.curPath=path.slice();}};pluginProto.acts=new Acts();function Exps(){}
Exps.prototype.Length=function(ret)
{var path=Array.prototype.slice.call(arguments);path.shift();var from_current=path.shift();var value=this.getValueFromPath(from_current===1,path);if(type(value)==="array"){ret.set_int(value.length);}else{ret.set_int(0);}};Exps.prototype.Size=function(ret)
{var path=Array.prototype.slice.call(arguments);path.shift();var from_current=path.shift();var value=this.getValueFromPath(from_current===1,path);var t=type(value);if(t==="array"){ret.set_int(value.length);}else if(t==="object"){var size=0;for(var p in value)
{if(Object.prototype.hasOwnProperty.call(value,p)){size++;}}
ret.set_int(size);}else{ret.set_int(-1);}};Exps.prototype.Value=function(ret)
{var path=Array.prototype.slice.call(arguments);path.shift();var from_current=path.shift();var value=this.getValueFromPath(from_current===1,path);var t=type(value);if(t==="number"||t==="string"){ret.set_any(value);}else if(t==="boolean"){ret.set_any((value)?1:0);}else{ret.set_any(t);}};Exps.prototype.ToJson=function(ret)
{var path=Array.prototype.slice.call(arguments);path.shift();var from_current=path.shift();var value=this.getValueFromPath(from_current===1,path);var t=type(value);if(t==="undefined"){ret.set_string(t);}else{ret.set_string(JSON.stringify(value));}};Exps.prototype.AsJson=function(ret)
{var path=Array.prototype.slice.call(arguments);path.shift();var from_current=path.shift();var value=this.getValueFromPath(from_current===1,path);var t=type(value);if(t==="undefined"){ret.set_string(t);}else{ret.set_string(JSON.stringify(value));}};Exps.prototype.TypeOf=function(ret)
{var path=Array.prototype.slice.call(arguments);path.shift();var from_current=path.shift();var value=this.getValueFromPath(from_current===1,path);ret.set_string(type(value));};Exps.prototype.CurrentKey=function(ret)
{ret.set_string(this.curKey);};Exps.prototype.CurrentValue=function(ret)
{var value=this.curValue;var t=type(value);if(t==="number"||t==="string"){ret.set_any(value);}else if(t==="boolean"){ret.set_any((value)?1:0);}else{ret.set_any(t);}};pluginProto.exps=new Exps();}());;;cr.plugins_.Keyboard=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Keyboard.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;this.keyMap=new Array(256);this.usedKeys=new Array(256);this.triggerKey=0;};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{var self=this;if(!this.runtime.isDomFree)
{jQuery(document).keydown(function(info){self.onKeyDown(info);});jQuery(document).keyup(function(info){self.onKeyUp(info);});}};var keysToBlockWhenFramed=[32,33,34,35,36,37,38,39,40,44];instanceProto.onKeyDown=function(info)
{var alreadyPreventedDefault=false;if(window!=window.top&&keysToBlockWhenFramed.indexOf(info.which)>-1)
{info.preventDefault();alreadyPreventedDefault=true;info.stopPropagation();}
if(this.keyMap[info.which])
{if(this.usedKeys[info.which]&&!alreadyPreventedDefault)
info.preventDefault();return;}
this.keyMap[info.which]=true;this.triggerKey=info.which;this.runtime.trigger(cr.plugins_.Keyboard.prototype.cnds.OnAnyKey,this);var eventRan=this.runtime.trigger(cr.plugins_.Keyboard.prototype.cnds.OnKey,this);var eventRan2=this.runtime.trigger(cr.plugins_.Keyboard.prototype.cnds.OnKeyCode,this);if(eventRan||eventRan2)
{this.usedKeys[info.which]=true;if(!alreadyPreventedDefault)
info.preventDefault();}};instanceProto.onKeyUp=function(info)
{this.keyMap[info.which]=false;this.triggerKey=info.which;this.runtime.trigger(cr.plugins_.Keyboard.prototype.cnds.OnAnyKeyReleased,this);var eventRan=this.runtime.trigger(cr.plugins_.Keyboard.prototype.cnds.OnKeyReleased,this);var eventRan2=this.runtime.trigger(cr.plugins_.Keyboard.prototype.cnds.OnKeyCodeReleased,this);if(eventRan||eventRan2||this.usedKeys[info.which])
{this.usedKeys[info.which]=true;info.preventDefault();}};instanceProto.saveToJSON=function()
{return{"triggerKey":this.triggerKey};};instanceProto.loadFromJSON=function(o)
{this.triggerKey=o["triggerKey"];};function Cnds(){};Cnds.prototype.IsKeyDown=function(key)
{return this.keyMap[key];};Cnds.prototype.OnKey=function(key)
{return(key===this.triggerKey);};Cnds.prototype.OnAnyKey=function(key)
{return true;};Cnds.prototype.OnAnyKeyReleased=function(key)
{return true;};Cnds.prototype.OnKeyReleased=function(key)
{return(key===this.triggerKey);};Cnds.prototype.IsKeyCodeDown=function(key)
{key=Math.floor(key);if(key<0||key>=this.keyMap.length)
return false;return this.keyMap[key];};Cnds.prototype.OnKeyCode=function(key)
{return(key===this.triggerKey);};Cnds.prototype.OnKeyCodeReleased=function(key)
{return(key===this.triggerKey);};pluginProto.cnds=new Cnds();function Acts(){};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.LastKeyCode=function(ret)
{ret.set_int(this.triggerKey);};function fixedStringFromCharCode(kc)
{kc=Math.floor(kc);switch(kc){case 8:return"backspace";case 9:return"tab";case 13:return"enter";case 16:return"shift";case 17:return"control";case 18:return"alt";case 19:return"pause";case 20:return"capslock";case 27:return"esc";case 33:return"pageup";case 34:return"pagedown";case 35:return"end";case 36:return"home";case 37:return"←";case 38:return"↑";case 39:return"→";case 40:return"↓";case 45:return"insert";case 46:return"del";case 91:return"left window key";case 92:return"right window key";case 93:return"select";case 96:return"numpad 0";case 97:return"numpad 1";case 98:return"numpad 2";case 99:return"numpad 3";case 100:return"numpad 4";case 101:return"numpad 5";case 102:return"numpad 6";case 103:return"numpad 7";case 104:return"numpad 8";case 105:return"numpad 9";case 106:return"numpad *";case 107:return"numpad +";case 109:return"numpad -";case 110:return"numpad .";case 111:return"numpad /";case 112:return"F1";case 113:return"F2";case 114:return"F3";case 115:return"F4";case 116:return"F5";case 117:return"F6";case 118:return"F7";case 119:return"F8";case 120:return"F9";case 121:return"F10";case 122:return"F11";case 123:return"F12";case 144:return"numlock";case 145:return"scroll lock";case 186:return";";case 187:return"=";case 188:return",";case 189:return"-";case 190:return".";case 191:return"/";case 192:return"'";case 219:return"[";case 220:return"\\";case 221:return"]";case 222:return"#";case 223:return"`";default:return String.fromCharCode(kc);}};Exps.prototype.StringFromKeyCode=function(ret,kc)
{ret.set_string(fixedStringFromCharCode(kc));};pluginProto.exps=new Exps();}());;;cr.plugins_.Rex_Nickname=function(runtime)
{this.runtime=runtime;};cr.plugins_.Rex_Nickname.nickname2objtype={};cr.plugins_.Rex_Nickname.sid2nickname={};cr.plugins_.Rex_Nickname.AddNickname=function(nickname,objtype)
{cr.plugins_.Rex_Nickname.nickname2objtype[nickname]={sid:objtype.sid,index:-1};cr.plugins_.Rex_Nickname.sid2nickname[objtype.sid.toString()]=nickname;};(function()
{var pluginProto=cr.plugins_.Rex_Nickname.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{this.nickname2objtype=cr.plugins_.Rex_Nickname.nickname2objtype;this.sid2nickname=cr.plugins_.Rex_Nickname.sid2nickname;this.ActCreateInstance=cr.system_object.prototype.acts.CreateObject;};instanceProto.Nickname2Type=function(nickname)
{var sid_info=this.nickname2objtype[nickname];if(sid_info==null)
return null;var sid=sid_info.sid;var objtypes=this.runtime.types_by_index;var t=objtypes[sid_info.index];if((t!=null)&&(t.sid===sid))
return t;var i,len=objtypes.length;for(i=0;i<len;i++)
{t=objtypes[i];if(t.sid===sid)
{sid_info.index=i;return t;}}
return null;};instanceProto.CreateInst=function(nickname,x,y,_layer)
{var objtype=(typeof(nickname)=="string")?this.Nickname2Type(nickname):nickname;if(objtype==null)
return null;var layer=(typeof _layer=="number")?this.runtime.getLayerByNumber(_layer):(typeof _layer=="string")?this.runtime.getLayerByName(_layer):_layer;this.ActCreateInstance.call(this.runtime.system,objtype,layer,x,y);return objtype.getFirstPicked();};instanceProto.PickAll=function(nickname,family_objtype)
{if(!family_objtype.is_family)
return false;var sol_family=family_objtype.getCurrentSol();sol_family.select_all=false;sol_family.instances.length=0;var objtype=this.Nickname2Type(nickname);if((!objtype)||(family_objtype.members.indexOf(objtype)==-1))
{return false;}
else
{var sol=objtype.getCurrentSol();var sol_save=sol.select_all;sol.select_all=true;var all_insts=sol.getObjects();sol_family.instances=all_insts.slice();sol_family.select_all=false;sol.select_all=sol_save;}
return true;};instanceProto.PickMatched=function(_substring,family_objtype)
{if(!family_objtype.is_family)
return false;var sol_family=family_objtype.getCurrentSol();sol_family.select_all=false;var sol_family_insts=sol_family.instances;sol_family_insts.length=0;var nickname;var objtype,sol,sol_save;for(nickname in this.nickname2objtype)
{if(nickname.match(_substring)==null)
continue;objtype=this.Nickname2Type(nickname);if((!objtype)||(family_objtype.members.indexOf(objtype)==-1))
continue;sol=objtype.getCurrentSol();sol_save=sol.select_all;sol_family_insts.push.apply(sol_family_insts,sol.getObjects());sol.select_all=sol_save;}
return(sol_family_insts.length>0);};instanceProto.saveToJSON=function()
{return{"sid2name":this.sid2nickname,};};instanceProto.loadFromJSON=function(o)
{var sid2name=o["sid2name"];this.sid2nickname=sid2name;var sid,name,objtype;for(sid in sid2name)
{name=sid2name[sid];this.nickname2objtype[name]={sid:parseInt(sid,10),index:-1};}};function Cnds(){};pluginProto.cnds=new Cnds();Cnds.prototype.IsNicknameValid=function(nickname)
{return(this.nickname2objtype[nickname]!=null);};Cnds.prototype.Pick=function(nickname,family_objtype)
{return this.PickAll(nickname,family_objtype);};Cnds.prototype.PickMatched=function(_substring,family_objtype)
{return this.PickMatched(_substring,family_objtype);};function Acts(){};pluginProto.acts=new Acts();Acts.prototype.AssignNickname=function(nickname,objtype)
{if(objtype==null)
return;cr.plugins_.Rex_Nickname.AddNickname(nickname,objtype);};Acts.prototype.CreateInst=function(nickname,x,y,_layer,family_objtype)
{var inst=this.CreateInst(nickname,x,y,_layer);if(!family_objtype)
return;if((inst==null)||(family_objtype.members.indexOf(inst.type)==-1))
{var sol=family_objtype.getCurrentSol();sol.select_all=false;sol.instances.length=0;}
else
{family_objtype.getCurrentSol().pick_one(inst);family_objtype.applySolToContainer();}};Acts.prototype.Pick=function(nickname,family_objtype)
{this.PickAll(nickname,family_objtype);};Acts.prototype.PickMatched=function(_substring,family_objtype)
{this.PickMatched(_substring,family_objtype);};function Exps(){};pluginProto.exps=new Exps();}());;;cr.plugins_.Sprite=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Sprite.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;function frame_getDataUri()
{if(this.datauri.length===0)
{var tmpcanvas=document.createElement("canvas");tmpcanvas.width=this.width;tmpcanvas.height=this.height;var tmpctx=tmpcanvas.getContext("2d");if(this.spritesheeted)
{tmpctx.drawImage(this.texture_img,this.offx,this.offy,this.width,this.height,0,0,this.width,this.height);}
else
{tmpctx.drawImage(this.texture_img,0,0,this.width,this.height);}
this.datauri=tmpcanvas.toDataURL("image/png");}
return this.datauri;};typeProto.onCreate=function()
{if(this.is_family)
return;var i,leni,j,lenj;var anim,frame,animobj,frameobj,wt,uv;this.all_frames=[];this.has_loaded_textures=false;for(i=0,leni=this.animations.length;i<leni;i++)
{anim=this.animations[i];animobj={};animobj.name=anim[0];animobj.speed=anim[1];animobj.loop=anim[2];animobj.repeatcount=anim[3];animobj.repeatto=anim[4];animobj.pingpong=anim[5];animobj.sid=anim[6];animobj.frames=[];for(j=0,lenj=anim[7].length;j<lenj;j++)
{frame=anim[7][j];frameobj={};frameobj.texture_file=frame[0];frameobj.texture_filesize=frame[1];frameobj.offx=frame[2];frameobj.offy=frame[3];frameobj.width=frame[4];frameobj.height=frame[5];frameobj.duration=frame[6];frameobj.hotspotX=frame[7];frameobj.hotspotY=frame[8];frameobj.image_points=frame[9];frameobj.poly_pts=frame[10];frameobj.pixelformat=frame[11];frameobj.spritesheeted=(frameobj.width!==0);frameobj.datauri="";frameobj.getDataUri=frame_getDataUri;uv={};uv.left=0;uv.top=0;uv.right=1;uv.bottom=1;frameobj.sheetTex=uv;frameobj.webGL_texture=null;wt=this.runtime.findWaitingTexture(frame[0]);if(wt)
{frameobj.texture_img=wt;}
else
{frameobj.texture_img=new Image();frameobj.texture_img["idtkLoadDisposed"]=true;frameobj.texture_img.src=frame[0];frameobj.texture_img.cr_src=frame[0];frameobj.texture_img.cr_filesize=frame[1];frameobj.texture_img.c2webGL_texture=null;this.runtime.wait_for_textures.push(frameobj.texture_img);}
cr.seal(frameobj);animobj.frames.push(frameobj);this.all_frames.push(frameobj);}
cr.seal(animobj);this.animations[i]=animobj;}};typeProto.updateAllCurrentTexture=function()
{var i,len,inst;for(i=0,len=this.instances.length;i<len;i++)
{inst=this.instances[i];inst.curWebGLTexture=inst.curFrame.webGL_texture;}};typeProto.onLostWebGLContext=function()
{if(this.is_family)
return;var i,len,frame;for(i=0,len=this.all_frames.length;i<len;++i)
{frame=this.all_frames[i];frame.texture_img.c2webGL_texture=null;frame.webGL_texture=null;}};typeProto.onRestoreWebGLContext=function()
{if(this.is_family||!this.instances.length)
return;var i,len,frame;for(i=0,len=this.all_frames.length;i<len;++i)
{frame=this.all_frames[i];frame.webGL_texture=this.runtime.glwrap.loadTexture(frame.texture_img,false,this.runtime.linearSampling,frame.pixelformat);}
this.updateAllCurrentTexture();};typeProto.loadTextures=function()
{if(this.is_family||this.has_loaded_textures||!this.runtime.glwrap)
return;var i,len,frame;for(i=0,len=this.all_frames.length;i<len;++i)
{frame=this.all_frames[i];frame.webGL_texture=this.runtime.glwrap.loadTexture(frame.texture_img,false,this.runtime.linearSampling,frame.pixelformat);}
this.has_loaded_textures=true;};typeProto.unloadTextures=function()
{if(this.is_family||this.instances.length||!this.has_loaded_textures)
return;var i,len,frame;for(i=0,len=this.all_frames.length;i<len;++i)
{frame=this.all_frames[i];this.runtime.glwrap.deleteTexture(frame.webGL_texture);}
this.has_loaded_textures=false;};var already_drawn_images=[];typeProto.preloadCanvas2D=function(ctx)
{var i,len,frameimg;already_drawn_images.length=0;for(i=0,len=this.all_frames.length;i<len;++i)
{frameimg=this.all_frames[i].texture_img;if(already_drawn_images.indexOf(frameimg)!==-1)
continue;ctx.drawImage(frameimg,0,0);already_drawn_images.push(frameimg);}};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;var poly_pts=this.type.animations[0].frames[0].poly_pts;if(this.recycled)
this.collision_poly.set_pts(poly_pts);else
this.collision_poly=new cr.CollisionPoly(poly_pts);};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{this.visible=(this.properties[0]===0);this.isTicking=false;this.inAnimTrigger=false;this.collisionsEnabled=(this.properties[3]!==0);if(!(this.type.animations.length===1&&this.type.animations[0].frames.length===1)&&this.type.animations[0].speed!==0)
{this.runtime.tickMe(this);this.isTicking=true;}
this.cur_animation=this.getAnimationByName(this.properties[1])||this.type.animations[0];this.cur_frame=this.properties[2];if(this.cur_frame<0)
this.cur_frame=0;if(this.cur_frame>=this.cur_animation.frames.length)
this.cur_frame=this.cur_animation.frames.length-1;var curanimframe=this.cur_animation.frames[this.cur_frame];this.collision_poly.set_pts(curanimframe.poly_pts);this.hotspotX=curanimframe.hotspotX;this.hotspotY=curanimframe.hotspotY;this.cur_anim_speed=this.cur_animation.speed;if(this.recycled)
this.animTimer.reset();else
this.animTimer=new cr.KahanAdder();this.frameStart=this.getNowTime();this.animPlaying=true;this.animRepeats=0;this.animForwards=true;this.animTriggerName="";this.changeAnimName="";this.changeAnimFrom=0;this.changeAnimFrame=-1;this.type.loadTextures();var i,leni,j,lenj;var anim,frame,uv,maintex;for(i=0,leni=this.type.animations.length;i<leni;i++)
{anim=this.type.animations[i];for(j=0,lenj=anim.frames.length;j<lenj;j++)
{frame=anim.frames[j];if(frame.width===0)
{frame.width=frame.texture_img.width;frame.height=frame.texture_img.height;}
if(frame.spritesheeted)
{maintex=frame.texture_img;uv=frame.sheetTex;uv.left=frame.offx/maintex.width;uv.top=frame.offy/maintex.height;uv.right=(frame.offx+frame.width)/maintex.width;uv.bottom=(frame.offy+frame.height)/maintex.height;if(frame.offx===0&&frame.offy===0&&frame.width===maintex.width&&frame.height===maintex.height)
{frame.spritesheeted=false;}}}}
this.curFrame=this.cur_animation.frames[this.cur_frame];this.curWebGLTexture=this.curFrame.webGL_texture;};instanceProto.saveToJSON=function()
{var o={"a":this.cur_animation.sid,"f":this.cur_frame,"cas":this.cur_anim_speed,"fs":this.frameStart,"ar":this.animRepeats,"at":this.animTimer.sum};if(!this.animPlaying)
o["ap"]=this.animPlaying;if(!this.animForwards)
o["af"]=this.animForwards;return o;};instanceProto.loadFromJSON=function(o)
{var anim=this.getAnimationBySid(o["a"]);if(anim)
this.cur_animation=anim;this.cur_frame=o["f"];if(this.cur_frame<0)
this.cur_frame=0;if(this.cur_frame>=this.cur_animation.frames.length)
this.cur_frame=this.cur_animation.frames.length-1;this.cur_anim_speed=o["cas"];this.frameStart=o["fs"];this.animRepeats=o["ar"];this.animTimer.reset();this.animTimer.sum=o["at"];this.animPlaying=o.hasOwnProperty("ap")?o["ap"]:true;this.animForwards=o.hasOwnProperty("af")?o["af"]:true;this.curFrame=this.cur_animation.frames[this.cur_frame];this.curWebGLTexture=this.curFrame.webGL_texture;this.collision_poly.set_pts(this.curFrame.poly_pts);this.hotspotX=this.curFrame.hotspotX;this.hotspotY=this.curFrame.hotspotY;};instanceProto.animationFinish=function(reverse)
{this.cur_frame=reverse?0:this.cur_animation.frames.length-1;this.animPlaying=false;this.animTriggerName=this.cur_animation.name;this.inAnimTrigger=true;this.runtime.trigger(cr.plugins_.Sprite.prototype.cnds.OnAnyAnimFinished,this);this.runtime.trigger(cr.plugins_.Sprite.prototype.cnds.OnAnimFinished,this);this.inAnimTrigger=false;this.animRepeats=0;};instanceProto.getNowTime=function()
{return this.animTimer.sum;};instanceProto.tick=function()
{this.animTimer.add(this.runtime.getDt(this));if(this.changeAnimName.length)
this.doChangeAnim();if(this.changeAnimFrame>=0)
this.doChangeAnimFrame();var now=this.getNowTime();var cur_animation=this.cur_animation;var prev_frame=cur_animation.frames[this.cur_frame];var next_frame;var cur_frame_time=prev_frame.duration/this.cur_anim_speed;if(this.animPlaying&&now>=this.frameStart+cur_frame_time)
{if(this.animForwards)
{this.cur_frame++;}
else
{this.cur_frame--;}
this.frameStart+=cur_frame_time;if(this.cur_frame>=cur_animation.frames.length)
{if(cur_animation.pingpong)
{this.animForwards=false;this.cur_frame=cur_animation.frames.length-2;}
else if(cur_animation.loop)
{this.cur_frame=cur_animation.repeatto;}
else
{this.animRepeats++;if(this.animRepeats>=cur_animation.repeatcount)
{this.animationFinish(false);}
else
{this.cur_frame=cur_animation.repeatto;}}}
if(this.cur_frame<0)
{if(cur_animation.pingpong)
{this.cur_frame=1;this.animForwards=true;if(!cur_animation.loop)
{this.animRepeats++;if(this.animRepeats>=cur_animation.repeatcount)
{this.animationFinish(true);}}}
else
{if(cur_animation.loop)
{this.cur_frame=cur_animation.repeatto;}
else
{this.animRepeats++;if(this.animRepeats>=cur_animation.repeatcount)
{this.animationFinish(true);}
else
{this.cur_frame=cur_animation.repeatto;}}}}
if(this.cur_frame<0)
this.cur_frame=0;else if(this.cur_frame>=cur_animation.frames.length)
this.cur_frame=cur_animation.frames.length-1;if(now>this.frameStart+(cur_animation.frames[this.cur_frame].duration/this.cur_anim_speed))
{this.frameStart=now;}
next_frame=cur_animation.frames[this.cur_frame];this.OnFrameChanged(prev_frame,next_frame);this.runtime.redraw=true;}};instanceProto.getAnimationByName=function(name_)
{var i,len,a;for(i=0,len=this.type.animations.length;i<len;i++)
{a=this.type.animations[i];if(cr.equals_nocase(a.name,name_))
return a;}
return null;};instanceProto.getAnimationBySid=function(sid_)
{var i,len,a;for(i=0,len=this.type.animations.length;i<len;i++)
{a=this.type.animations[i];if(a.sid===sid_)
return a;}
return null;};instanceProto.doChangeAnim=function()
{var prev_frame=this.cur_animation.frames[this.cur_frame];var anim=this.getAnimationByName(this.changeAnimName);this.changeAnimName="";if(!anim)
return;if(cr.equals_nocase(anim.name,this.cur_animation.name)&&this.animPlaying)
return;this.cur_animation=anim;this.cur_anim_speed=anim.speed;if(this.cur_frame<0)
this.cur_frame=0;if(this.cur_frame>=this.cur_animation.frames.length)
this.cur_frame=this.cur_animation.frames.length-1;if(this.changeAnimFrom===1)
this.cur_frame=0;this.animPlaying=true;this.frameStart=this.getNowTime();this.animForwards=true;this.OnFrameChanged(prev_frame,this.cur_animation.frames[this.cur_frame]);this.runtime.redraw=true;};instanceProto.doChangeAnimFrame=function()
{var prev_frame=this.cur_animation.frames[this.cur_frame];var prev_frame_number=this.cur_frame;this.cur_frame=cr.floor(this.changeAnimFrame);if(this.cur_frame<0)
this.cur_frame=0;if(this.cur_frame>=this.cur_animation.frames.length)
this.cur_frame=this.cur_animation.frames.length-1;if(prev_frame_number!==this.cur_frame)
{this.OnFrameChanged(prev_frame,this.cur_animation.frames[this.cur_frame]);this.frameStart=this.getNowTime();this.runtime.redraw=true;}
this.changeAnimFrame=-1;};instanceProto.OnFrameChanged=function(prev_frame,next_frame)
{var oldw=prev_frame.width;var oldh=prev_frame.height;var neww=next_frame.width;var newh=next_frame.height;if(oldw!=neww)
this.width*=(neww/oldw);if(oldh!=newh)
this.height*=(newh/oldh);this.hotspotX=next_frame.hotspotX;this.hotspotY=next_frame.hotspotY;this.collision_poly.set_pts(next_frame.poly_pts);this.set_bbox_changed();this.curFrame=next_frame;this.curWebGLTexture=next_frame.webGL_texture;var i,len,b;for(i=0,len=this.behavior_insts.length;i<len;i++)
{b=this.behavior_insts[i];if(b.onSpriteFrameChanged)
b.onSpriteFrameChanged(prev_frame,next_frame);}
this.runtime.trigger(cr.plugins_.Sprite.prototype.cnds.OnFrameChanged,this);};instanceProto.draw=function(ctx)
{ctx.globalAlpha=this.opacity;var cur_frame=this.curFrame;var spritesheeted=cur_frame.spritesheeted;var cur_image=cur_frame.texture_img;var myx=this.x;var myy=this.y;var w=this.width;var h=this.height;if(this.angle===0&&w>=0&&h>=0)
{myx-=this.hotspotX*w;myy-=this.hotspotY*h;if(this.runtime.pixel_rounding)
{myx=(myx+0.5)|0;myy=(myy+0.5)|0;}
if(spritesheeted)
{ctx.drawImage(cur_image,cur_frame.offx,cur_frame.offy,cur_frame.width,cur_frame.height,myx,myy,w,h);}
else
{ctx.drawImage(cur_image,myx,myy,w,h);}}
else
{if(this.runtime.pixel_rounding)
{myx=(myx+0.5)|0;myy=(myy+0.5)|0;}
ctx.save();var widthfactor=w>0?1:-1;var heightfactor=h>0?1:-1;ctx.translate(myx,myy);if(widthfactor!==1||heightfactor!==1)
ctx.scale(widthfactor,heightfactor);ctx.rotate(this.angle*widthfactor*heightfactor);var drawx=0-(this.hotspotX*cr.abs(w))
var drawy=0-(this.hotspotY*cr.abs(h));if(spritesheeted)
{ctx.drawImage(cur_image,cur_frame.offx,cur_frame.offy,cur_frame.width,cur_frame.height,drawx,drawy,cr.abs(w),cr.abs(h));}
else
{ctx.drawImage(cur_image,drawx,drawy,cr.abs(w),cr.abs(h));}
ctx.restore();}};instanceProto.drawGL=function(glw)
{glw.setTexture(this.curWebGLTexture);glw.setOpacity(this.opacity);var cur_frame=this.curFrame;var q=this.bquad;if(this.runtime.pixel_rounding)
{var ox=((this.x+0.5)|0)-this.x;var oy=((this.y+0.5)|0)-this.y;if(cur_frame.spritesheeted)
glw.quadTex(q.tlx+ox,q.tly+oy,q.trx+ox,q.try_+oy,q.brx+ox,q.bry+oy,q.blx+ox,q.bly+oy,cur_frame.sheetTex);else
glw.quad(q.tlx+ox,q.tly+oy,q.trx+ox,q.try_+oy,q.brx+ox,q.bry+oy,q.blx+ox,q.bly+oy);}
else
{if(cur_frame.spritesheeted)
glw.quadTex(q.tlx,q.tly,q.trx,q.try_,q.brx,q.bry,q.blx,q.bly,cur_frame.sheetTex);else
glw.quad(q.tlx,q.tly,q.trx,q.try_,q.brx,q.bry,q.blx,q.bly);}};instanceProto.getImagePointIndexByName=function(name_)
{var cur_frame=this.curFrame;var i,len;for(i=0,len=cur_frame.image_points.length;i<len;i++)
{if(cr.equals_nocase(name_,cur_frame.image_points[i][0]))
return i;}
return-1;};instanceProto.getImagePoint=function(imgpt,getX)
{var cur_frame=this.curFrame;var image_points=cur_frame.image_points;var index;if(cr.is_string(imgpt))
index=this.getImagePointIndexByName(imgpt);else
index=imgpt-1;index=cr.floor(index);if(index<0||index>=image_points.length)
return getX?this.x:this.y;var x=(image_points[index][1]-cur_frame.hotspotX)*this.width;var y=image_points[index][2];y=(y-cur_frame.hotspotY)*this.height;var cosa=Math.cos(this.angle);var sina=Math.sin(this.angle);var x_temp=(x*cosa)-(y*sina);y=(y*cosa)+(x*sina);x=x_temp;x+=this.x;y+=this.y;return getX?x:y;};function Cnds(){};var arrCache=[];function allocArr()
{if(arrCache.length)
return arrCache.pop();else
return[0,0];};function freeArr(a)
{a[0]=0;a[1]=0;arrCache.push(a);};function collmemory_add(collmemory,a,b)
{var arr=allocArr();arr[0]=a.uid;arr[1]=b.uid;collmemory.push(arr);};function collmemory_remove(collmemory,a,b)
{;var a_uid=a.uid;var b_uid=b.uid;var i,j=0,len,entry;for(i=0,len=collmemory.length;i<len;i++)
{entry=collmemory[i];if(!((entry[0]===a_uid&&entry[1]===b_uid)||(entry[0]===b_uid&&entry[1]===a_uid)))
{collmemory[j][0]=collmemory[i][0];collmemory[j][1]=collmemory[i][1];j++;}}
for(i=j;i<len;i++)
freeArr(collmemory[i]);collmemory.length=j;};function collmemory_removeInstance(collmemory,inst)
{;var i,j=0,len,entry,uid=inst.uid;for(i=0,len=collmemory.length;i<len;i++)
{entry=collmemory[i];if(entry[0]!==uid&&entry[1]!==uid)
{collmemory[j][0]=collmemory[i][0];collmemory[j][1]=collmemory[i][1];j++;}}
for(i=j;i<len;i++)
freeArr(collmemory[i]);collmemory.length=j;};function collmemory_has(collmemory,a,b)
{var a_uid=a.uid;var b_uid=b.uid;var i,len,entry;for(i=0,len=collmemory.length;i<len;i++)
{entry=collmemory[i];if((entry[0]===a_uid&&entry[1]===b_uid)||(entry[0]===b_uid&&entry[1]===a_uid))
return true;}
return false;};Cnds.prototype.OnCollision=function(rtype)
{if(!rtype)
return false;var runtime=this.runtime;var cnd=runtime.getCurrentCondition();var ltype=cnd.type;if(!cnd.extra.collmemory)
{cnd.extra.collmemory=[];runtime.addDestroyCallback((function(collmemory){return function(inst){collmemory_removeInstance(collmemory,inst);};})(cnd.extra.collmemory));}
var lsol=ltype.getCurrentSol();var rsol=rtype.getCurrentSol();var linstances=lsol.getObjects();var rinstances=rsol.getObjects();var l,linst,r,rinst;var curlsol,currsol;var current_event=runtime.getCurrentEventStack().current_event;var orblock=current_event.orblock;for(l=0;l<linstances.length;l++)
{linst=linstances[l];for(r=0;r<rinstances.length;r++)
{rinst=rinstances[r];if(runtime.testOverlap(linst,rinst)||runtime.checkRegisteredCollision(linst,rinst))
{if(!collmemory_has(cnd.extra.collmemory,linst,rinst))
{collmemory_add(cnd.extra.collmemory,linst,rinst);runtime.pushCopySol(current_event.solModifiers);curlsol=ltype.getCurrentSol();currsol=rtype.getCurrentSol();curlsol.select_all=false;currsol.select_all=false;if(ltype===rtype)
{curlsol.instances.length=2;curlsol.instances[0]=linst;curlsol.instances[1]=rinst;ltype.applySolToContainer();}
else
{curlsol.instances.length=1;currsol.instances.length=1;curlsol.instances[0]=linst;currsol.instances[0]=rinst;ltype.applySolToContainer();rtype.applySolToContainer();}
current_event.retrigger();runtime.popSol(current_event.solModifiers);}}
else
{collmemory_remove(cnd.extra.collmemory,linst,rinst);}}}
return false;};var rpicktype=null;var rtopick=new cr.ObjectSet();var needscollisionfinish=false;function DoOverlapCondition(rtype,offx,offy)
{if(!rtype)
return false;var do_offset=(offx!==0||offy!==0);var oldx,oldy,ret=false,r,lenr,rinst;var cnd=this.runtime.getCurrentCondition();var ltype=cnd.type;var inverted=cnd.inverted;var rsol=rtype.getCurrentSol();var orblock=this.runtime.getCurrentEventStack().current_event.orblock;var rinstances;if(rsol.select_all)
rinstances=rsol.type.instances;else if(orblock)
rinstances=rsol.else_instances;else
rinstances=rsol.instances;rpicktype=rtype;needscollisionfinish=(ltype!==rtype&&!inverted);if(do_offset)
{oldx=this.x;oldy=this.y;this.x+=offx;this.y+=offy;this.set_bbox_changed();}
for(r=0,lenr=rinstances.length;r<lenr;r++)
{rinst=rinstances[r];if(this.runtime.testOverlap(this,rinst))
{ret=true;if(inverted)
break;if(ltype!==rtype)
rtopick.add(rinst);}}
if(do_offset)
{this.x=oldx;this.y=oldy;this.set_bbox_changed();}
return ret;};typeProto.finish=function(do_pick)
{if(!needscollisionfinish)
return;if(do_pick)
{var orblock=this.runtime.getCurrentEventStack().current_event.orblock;var sol=rpicktype.getCurrentSol();var topick=rtopick.valuesRef();var i,len,inst;if(sol.select_all)
{sol.select_all=false;sol.instances.length=topick.length;for(i=0,len=topick.length;i<len;i++)
{sol.instances[i]=topick[i];}
if(orblock)
{sol.else_instances.length=0;for(i=0,len=rpicktype.instances.length;i<len;i++)
{inst=rpicktype.instances[i];if(!rtopick.contains(inst))
sol.else_instances.push(inst);}}}
else
{var initsize=sol.instances.length;sol.instances.length=initsize+topick.length;for(i=0,len=topick.length;i<len;i++)
{sol.instances[initsize+i]=topick[i];if(orblock)
cr.arrayFindRemove(sol.else_instances,topick[i]);}}
rpicktype.applySolToContainer();}
rtopick.clear();needscollisionfinish=false;};Cnds.prototype.IsOverlapping=function(rtype)
{return DoOverlapCondition.call(this,rtype,0,0);};Cnds.prototype.IsOverlappingOffset=function(rtype,offx,offy)
{return DoOverlapCondition.call(this,rtype,offx,offy);};Cnds.prototype.IsAnimPlaying=function(animname)
{if(this.changeAnimName.length)
return cr.equals_nocase(this.changeAnimName,animname);else
return cr.equals_nocase(this.cur_animation.name,animname);};Cnds.prototype.CompareFrame=function(cmp,framenum)
{return cr.do_cmp(this.cur_frame,cmp,framenum);};Cnds.prototype.OnAnimFinished=function(animname)
{return cr.equals_nocase(this.animTriggerName,animname);};Cnds.prototype.OnAnyAnimFinished=function()
{return true;};Cnds.prototype.OnFrameChanged=function()
{return true;};Cnds.prototype.IsMirrored=function()
{return this.width<0;};Cnds.prototype.IsFlipped=function()
{return this.height<0;};Cnds.prototype.OnURLLoaded=function()
{return true;};Cnds.prototype.IsCollisionEnabled=function()
{return this.collisionsEnabled;};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.Spawn=function(obj,layer,imgpt)
{if(!obj||!layer)
return;var inst=this.runtime.createInstance(obj,layer,this.getImagePoint(imgpt,true),this.getImagePoint(imgpt,false));if(!inst)
return;if(typeof inst.angle!=="undefined")
{inst.angle=this.angle;inst.set_bbox_changed();}
this.runtime.isInOnDestroy++;var i,len,s;this.runtime.trigger(Object.getPrototypeOf(obj.plugin).cnds.OnCreated,inst);if(inst.is_contained)
{for(i=0,len=inst.siblings.length;i<len;i++)
{s=inst.siblings[i];this.runtime.trigger(Object.getPrototypeOf(s.type.plugin).cnds.OnCreated,s);}}
this.runtime.isInOnDestroy--;var cur_act=this.runtime.getCurrentAction();var reset_sol=false;if(cr.is_undefined(cur_act.extra.Spawn_LastExec)||cur_act.extra.Spawn_LastExec<this.runtime.execcount)
{reset_sol=true;cur_act.extra.Spawn_LastExec=this.runtime.execcount;}
var sol;if(obj!=this.type)
{sol=obj.getCurrentSol();sol.select_all=false;if(reset_sol)
{sol.instances.length=1;sol.instances[0]=inst;}
else
sol.instances.push(inst);if(inst.is_contained)
{for(i=0,len=inst.siblings.length;i<len;i++)
{s=inst.siblings[i];sol=s.type.getCurrentSol();sol.select_all=false;if(reset_sol)
{sol.instances.length=1;sol.instances[0]=s;}
else
sol.instances.push(s);}}}};Acts.prototype.SetEffect=function(effect)
{this.compositeOp=cr.effectToCompositeOp(effect);cr.setGLBlend(this,effect,this.runtime.gl);this.runtime.redraw=true;};Acts.prototype.StopAnim=function()
{this.animPlaying=false;};Acts.prototype.StartAnim=function(from)
{this.animPlaying=true;this.frameStart=this.getNowTime();if(from===1&&this.cur_frame!==0)
{this.changeAnimFrame=0;if(!this.inAnimTrigger)
this.doChangeAnimFrame();}
if(!this.isTicking)
{this.runtime.tickMe(this);this.isTicking=true;}};Acts.prototype.SetAnim=function(animname,from)
{this.changeAnimName=animname;this.changeAnimFrom=from;if(!this.isTicking)
{this.runtime.tickMe(this);this.isTicking=true;}
if(!this.inAnimTrigger)
this.doChangeAnim();};Acts.prototype.SetAnimFrame=function(framenumber)
{this.changeAnimFrame=framenumber;if(!this.isTicking)
{this.runtime.tickMe(this);this.isTicking=true;}
if(!this.inAnimTrigger)
this.doChangeAnimFrame();};Acts.prototype.SetAnimSpeed=function(s)
{this.cur_anim_speed=cr.abs(s);this.animForwards=(s>=0);if(!this.isTicking)
{this.runtime.tickMe(this);this.isTicking=true;}};Acts.prototype.SetMirrored=function(m)
{var neww=cr.abs(this.width)*(m===0?-1:1);if(this.width===neww)
return;this.width=neww;this.set_bbox_changed();};Acts.prototype.SetFlipped=function(f)
{var newh=cr.abs(this.height)*(f===0?-1:1);if(this.height===newh)
return;this.height=newh;this.set_bbox_changed();};Acts.prototype.SetScale=function(s)
{var cur_frame=this.curFrame;var mirror_factor=(this.width<0?-1:1);var flip_factor=(this.height<0?-1:1);var new_width=cur_frame.width*s*mirror_factor;var new_height=cur_frame.height*s*flip_factor;if(this.width!==new_width||this.height!==new_height)
{this.width=new_width;this.height=new_height;this.set_bbox_changed();}};Acts.prototype.LoadURL=function(url_,resize_)
{var img=new Image();var self=this;var curFrame_=this.curFrame;img.onload=function()
{if(curFrame_.texture_img.src===img.src)
{if(self.runtime.glwrap&&self.curFrame===curFrame_)
self.curWebGLTexture=curFrame_.webGL_texture;self.runtime.redraw=true;self.runtime.trigger(cr.plugins_.Sprite.prototype.cnds.OnURLLoaded,self);return;}
curFrame_.texture_img=img;curFrame_.offx=0;curFrame_.offy=0;curFrame_.width=img.width;curFrame_.height=img.height;curFrame_.spritesheeted=false;curFrame_.datauri="";if(self.runtime.glwrap)
{if(curFrame_.webGL_texture)
self.runtime.glwrap.deleteTexture(curFrame_.webGL_texture);curFrame_.webGL_texture=self.runtime.glwrap.loadTexture(img,false,self.runtime.linearSampling);if(self.curFrame===curFrame_)
self.curWebGLTexture=curFrame_.webGL_texture;self.type.updateAllCurrentTexture();}
if(resize_===0)
{self.width=img.width;self.height=img.height;self.set_bbox_changed();}
self.runtime.redraw=true;self.runtime.trigger(cr.plugins_.Sprite.prototype.cnds.OnURLLoaded,self);};if(url_.substr(0,5)!=="data:")
img.crossOrigin='anonymous';img.src=url_;};Acts.prototype.SetCollisions=function(set_)
{this.collisionsEnabled=(set_!==0);};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.AnimationFrame=function(ret)
{ret.set_int(this.cur_frame);};Exps.prototype.AnimationFrameCount=function(ret)
{ret.set_int(this.cur_animation.frames.length);};Exps.prototype.AnimationName=function(ret)
{ret.set_string(this.cur_animation.name);};Exps.prototype.AnimationSpeed=function(ret)
{ret.set_float(this.cur_anim_speed);};Exps.prototype.ImagePointX=function(ret,imgpt)
{ret.set_float(this.getImagePoint(imgpt,true));};Exps.prototype.ImagePointY=function(ret,imgpt)
{ret.set_float(this.getImagePoint(imgpt,false));};Exps.prototype.ImagePointCount=function(ret)
{ret.set_int(this.curFrame.image_points.length);};Exps.prototype.ImageWidth=function(ret)
{ret.set_float(this.curFrame.width);};Exps.prototype.ImageHeight=function(ret)
{ret.set_float(this.curFrame.height);};pluginProto.exps=new Exps();}());;;cr.plugins_.Spritefont2=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Spritefont2.prototype;pluginProto.onCreate=function()
{};pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{if(this.is_family)
return;this.texture_img=new Image();this.texture_img["idtkLoadDisposed"]=true;this.texture_img.src=this.texture_file;this.runtime.wait_for_textures.push(this.texture_img);this.webGL_texture=null;};typeProto.onLostWebGLContext=function()
{if(this.is_family)
return;this.webGL_texture=null;};typeProto.onRestoreWebGLContext=function()
{if(this.is_family||!this.instances.length)
return;if(!this.webGL_texture)
{this.webGL_texture=this.runtime.glwrap.loadTexture(this.texture_img,false,this.runtime.linearSampling,this.texture_pixelformat);}
var i,len;for(i=0,len=this.instances.length;i<len;i++)
this.instances[i].webGL_texture=this.webGL_texture;};typeProto.unloadTextures=function()
{if(this.is_family||this.instances.length||!this.webGL_texture)
return;this.runtime.glwrap.deleteTexture(this.webGL_texture);this.webGL_texture=null;};typeProto.preloadCanvas2D=function(ctx)
{ctx.drawImage(this.texture_img,0,0);};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;instanceProto.onDestroy=function()
{freeAllLines(this.lines);freeAllClip(this.clipList);freeAllClipUV(this.clipUV);cr.wipe(this.characterWidthList);};instanceProto.onCreate=function()
{this.texture_img=this.type.texture_img;this.characterWidth=this.properties[0];this.characterHeight=this.properties[1];this.characterSet=this.properties[2];this.text=this.properties[3];this.characterScale=this.properties[4];this.visible=(this.properties[5]===0);this.halign=this.properties[6]/2.0;this.valign=this.properties[7]/2.0;this.wrapbyword=(this.properties[9]===0);this.characterSpacing=this.properties[10];this.lineHeight=this.properties[11];this.textWidth=0;this.textHeight=0;if(this.recycled)
{this.lines.length=0;cr.wipe(this.clipList);cr.wipe(this.clipUV);cr.wipe(this.characterWidthList);}
else
{this.lines=[];this.clipList={};this.clipUV={};this.characterWidthList={};}
this.text_changed=true;this.lastwrapwidth=this.width;if(this.runtime.glwrap)
{if(!this.type.webGL_texture)
{this.type.webGL_texture=this.runtime.glwrap.loadTexture(this.type.texture_img,false,this.runtime.linearSampling,this.type.texture_pixelformat);}
this.webGL_texture=this.type.webGL_texture;}
this.SplitSheet();};instanceProto.saveToJSON=function()
{var save={"t":this.text,"csc":this.characterScale,"csp":this.characterSpacing,"lh":this.lineHeight,"tw":this.textWidth,"th":this.textHeight,"lrt":this.last_render_tick,"cw":{}};for(var ch in this.characterWidthList)
save["cw"][ch]=this.characterWidthList[ch];return save;};instanceProto.loadFromJSON=function(o)
{this.text=o["t"];this.characterScale=o["csc"];this.characterSpacing=o["csp"];this.lineHeight=o["lh"];this.textWidth=o["tw"];this.textHeight=o["th"];this.last_render_tick=o["lrt"];for(var ch in o["cw"])
this.characterWidthList[ch]=o["cw"][ch];this.text_changed=true;this.lastwrapwidth=this.width;};function trimRight(text)
{return text.replace(/\s\s*$/,'');}
var MAX_CACHE_SIZE=1000;function alloc(cache,Constructor)
{if(cache.length)
return cache.pop();else
return new Constructor();}
function free(cache,data)
{if(cache.length<MAX_CACHE_SIZE)
{cache.push(data);}}
function freeAll(cache,dataList,isArray)
{if(isArray){var i,len;for(i=0,len=dataList.length;i<len;i++)
{free(cache,dataList[i]);}
dataList.length=0;}else{var prop;for(prop in dataList){if(Object.prototype.hasOwnProperty.call(dataList,prop)){free(cache,dataList[prop]);delete dataList[prop];}}}}
function addLine(inst,lineIndex,cur_line){var lines=inst.lines;var line;cur_line=trimRight(cur_line);if(lineIndex>=lines.length)
lines.push(allocLine());line=lines[lineIndex];line.text=cur_line;line.width=inst.measureWidth(cur_line);inst.textWidth=cr.max(inst.textWidth,line.width);}
var linesCache=[];function allocLine(){return alloc(linesCache,Object);}
function freeLine(l){free(linesCache,l);}
function freeAllLines(arr){freeAll(linesCache,arr,true);}
function addClip(obj,property,x,y,w,h){if(obj[property]===undefined){obj[property]=alloc(clipCache,Object);}
obj[property].x=x;obj[property].y=y;obj[property].w=w;obj[property].h=h;}
var clipCache=[];function allocClip(){return alloc(clipCache,Object);}
function freeAllClip(obj){freeAll(clipCache,obj,false);}
function addClipUV(obj,property,left,top,right,bottom){if(obj[property]===undefined){obj[property]=alloc(clipUVCache,cr.rect);}
obj[property].left=left;obj[property].top=top;obj[property].right=right;obj[property].bottom=bottom;}
var clipUVCache=[];function allocClipUV(){return alloc(clipUVCache,cr.rect);}
function freeAllClipUV(obj){freeAll(clipUVCache,obj,false);}
instanceProto.SplitSheet=function(){var texture=this.texture_img;var texWidth=texture.width;var texHeight=texture.height;var charWidth=this.characterWidth;var charHeight=this.characterHeight;var charU=charWidth/texWidth;var charV=charHeight/texHeight;var charSet=this.characterSet;var cols=Math.floor(texWidth/charWidth);var rows=Math.floor(texHeight/charHeight);for(var c=0;c<charSet.length;c++){if(c>=cols*rows)break;var x=c%cols;var y=Math.floor(c/cols);var letter=charSet.charAt(c);if(this.runtime.glwrap){addClipUV(this.clipUV,letter,x*charU,y*charV,(x+1)*charU,(y+1)*charV);}else{addClip(this.clipList,letter,x*charWidth,y*charHeight,charWidth,charHeight);}}};var wordsCache=[];pluginProto.TokeniseWords=function(text)
{wordsCache.length=0;var cur_word="";var ch;var i=0;while(i<text.length)
{ch=text.charAt(i);if(ch==="\n")
{if(cur_word.length)
{wordsCache.push(cur_word);cur_word="";}
wordsCache.push("\n");++i;}
else if(ch===" "||ch==="\t"||ch==="-")
{do{cur_word+=text.charAt(i);i++;}
while(i<text.length&&(text.charAt(i)===" "||text.charAt(i)==="\t"));wordsCache.push(cur_word);cur_word="";}
else if(i<text.length)
{cur_word+=ch;i++;}}
if(cur_word.length)
wordsCache.push(cur_word);};pluginProto.WordWrap=function(inst)
{var text=inst.text;var lines=inst.lines;if(!text||!text.length)
{freeAllLines(lines);return;}
var width=inst.width;if(width<=2.0)
{freeAllLines(lines);return;}
var charWidth=inst.characterWidth;var charScale=inst.characterScale;var charSpacing=inst.characterSpacing;if((text.length*(charWidth*charScale+charSpacing)-charSpacing)<=width&&text.indexOf("\n")===-1)
{var all_width=inst.measureWidth(text);if(all_width<=width)
{freeAllLines(lines);lines.push(allocLine());lines[0].text=text;lines[0].width=all_width;inst.textWidth=all_width;inst.textHeight=inst.characterHeight*charScale+inst.lineHeight;return;}}
var wrapbyword=inst.wrapbyword;this.WrapText(inst);inst.textHeight=lines.length*(inst.characterHeight*charScale+inst.lineHeight);};pluginProto.WrapText=function(inst)
{var wrapbyword=inst.wrapbyword;var text=inst.text;var lines=inst.lines;var width=inst.width;var wordArray;if(wrapbyword){this.TokeniseWords(text);wordArray=wordsCache;}else{wordArray=text;}
var cur_line="";var prev_line;var line_width;var i;var lineIndex=0;var line;var ignore_newline=false;for(i=0;i<wordArray.length;i++)
{if(wordArray[i]==="\n")
{if(ignore_newline===true){ignore_newline=false;}else{addLine(inst,lineIndex,cur_line);lineIndex++;}
cur_line="";continue;}
ignore_newline=false;prev_line=cur_line;cur_line+=wordArray[i];line_width=inst.measureWidth(trimRight(cur_line));if(line_width>width)
{if(prev_line===""){addLine(inst,lineIndex,cur_line);cur_line="";ignore_newline=true;}else{addLine(inst,lineIndex,prev_line);cur_line=wordArray[i];}
lineIndex++;if(!wrapbyword&&cur_line===" ")
cur_line="";}}
if(trimRight(cur_line).length)
{addLine(inst,lineIndex,cur_line);lineIndex++;}
for(i=lineIndex;i<lines.length;i++)
freeLine(lines[i]);lines.length=lineIndex;};instanceProto.measureWidth=function(text){var spacing=this.characterSpacing;var len=text.length;var width=0;for(var i=0;i<len;i++){width+=this.getCharacterWidth(text.charAt(i))*this.characterScale+spacing;}
width-=(width>0)?spacing:0;return width;};instanceProto.getCharacterWidth=function(character){var widthList=this.characterWidthList;if(widthList[character]!==undefined){return widthList[character];}else{return this.characterWidth;}};instanceProto.rebuildText=function(){if(this.text_changed||this.width!==this.lastwrapwidth){this.textWidth=0;this.textHeight=0;this.type.plugin.WordWrap(this);this.text_changed=false;this.lastwrapwidth=this.width;}};var EPSILON=0.00001;instanceProto.draw=function(ctx,glmode)
{var texture=this.texture_img;if(this.text!==""&&texture!=null){this.rebuildText();if(this.height<this.characterHeight*this.characterScale+this.lineHeight){return;}
ctx.globalAlpha=this.opacity;var myx=this.x;var myy=this.y;if(this.runtime.pixel_rounding)
{myx=(myx+0.5)|0;myy=(myy+0.5)|0;}
ctx.save();ctx.translate(myx,myy);ctx.rotate(this.angle);var ha=this.halign;var va=this.valign;var scale=this.characterScale;var charHeight=this.characterHeight*scale;var lineHeight=this.lineHeight;var charSpace=this.characterSpacing;var lines=this.lines;var textHeight=this.textHeight;var halign;var valign=va*cr.max(0,(this.height-textHeight));var offx=-(this.hotspotX*this.width);var offy=-(this.hotspotY*this.height);offy+=valign;var drawX;var drawY=offy;for(var i=0;i<lines.length;i++){var line=lines[i].text;var len=lines[i].width;halign=ha*cr.max(0,this.width-len);drawX=offx+halign;drawY+=lineHeight;for(var j=0;j<line.length;j++){var letter=line.charAt(j);var clip=this.clipList[letter];if(drawX+this.getCharacterWidth(letter)*scale>this.width+EPSILON){break;}
if(clip!==undefined){ctx.drawImage(this.texture_img,clip.x,clip.y,clip.w,clip.h,Math.round(drawX),Math.round(drawY),clip.w*scale,clip.h*scale);}
drawX+=this.getCharacterWidth(letter)*scale+charSpace;}
drawY+=charHeight;if(drawY+charHeight+lineHeight>this.height){break;}}
ctx.restore();}};var dQuad=new cr.quad();function rotateQuad(quad,cosa,sina){var x_temp;x_temp=(quad.tlx*cosa)-(quad.tly*sina);quad.tly=(quad.tly*cosa)+(quad.tlx*sina);quad.tlx=x_temp;x_temp=(quad.trx*cosa)-(quad.try_*sina);quad.try_=(quad.try_*cosa)+(quad.trx*sina);quad.trx=x_temp;x_temp=(quad.blx*cosa)-(quad.bly*sina);quad.bly=(quad.bly*cosa)+(quad.blx*sina);quad.blx=x_temp;x_temp=(quad.brx*cosa)-(quad.bry*sina);quad.bry=(quad.bry*cosa)+(quad.brx*sina);quad.brx=x_temp;}
instanceProto.drawGL=function(glw)
{glw.setTexture(this.webGL_texture);glw.setOpacity(this.opacity);if(this.text!==""){this.rebuildText();if(this.height<this.characterHeight*this.characterScale+this.lineHeight){return;}
this.update_bbox();var q=this.bquad;var ox=0;var oy=0;if(this.runtime.pixel_rounding)
{ox=((this.x+0.5)|0)-this.x;oy=((this.y+0.5)|0)-this.y;}
var angle=this.angle;var ha=this.halign;var va=this.valign;var scale=this.characterScale;var charHeight=this.characterHeight*scale;var lineHeight=this.lineHeight;var charSpace=this.characterSpacing;var lines=this.lines;var textHeight=this.textHeight;var cosa,sina;if(angle!==0)
{cosa=Math.cos(angle);sina=Math.sin(angle);}
var halign;var valign=va*cr.max(0,(this.height-textHeight));var offx=q.tlx+ox;var offy=q.tly+oy;var drawX;var drawY=valign;for(var i=0;i<lines.length;i++){var line=lines[i].text;var lineWidth=lines[i].width;halign=ha*cr.max(0,this.width-lineWidth);drawX=halign;drawY+=lineHeight;for(var j=0;j<line.length;j++){var letter=line.charAt(j);var clipUV=this.clipUV[letter];if(drawX+this.getCharacterWidth(letter)*scale>this.width+EPSILON){break;}
if(clipUV!==undefined){var clipWidth=this.characterWidth*scale;var clipHeight=this.characterHeight*scale;dQuad.tlx=drawX;dQuad.tly=drawY;dQuad.trx=drawX+clipWidth;dQuad.try_=drawY;dQuad.blx=drawX;dQuad.bly=drawY+clipHeight;dQuad.brx=drawX+clipWidth;dQuad.bry=drawY+clipHeight;if(angle!==0)
{rotateQuad(dQuad,cosa,sina);}
dQuad.offset(offx,offy);glw.quadTex(dQuad.tlx,dQuad.tly,dQuad.trx,dQuad.try_,dQuad.brx,dQuad.bry,dQuad.blx,dQuad.bly,clipUV);}
drawX+=this.getCharacterWidth(letter)*scale+charSpace;}
drawY+=charHeight;if(drawY+charHeight+lineHeight>this.height){break;}}}};function Cnds(){}
Cnds.prototype.CompareText=function(text_to_compare,case_sensitive)
{if(case_sensitive)
return this.text==text_to_compare;else
return cr.equals_nocase(this.text,text_to_compare);};pluginProto.cnds=new Cnds();function Acts(){}
Acts.prototype.SetText=function(param)
{if(cr.is_number(param)&&param<1e9)
param=Math.round(param*1e10)/1e10;var text_to_set=param.toString();if(this.text!==text_to_set)
{this.text=text_to_set;this.text_changed=true;this.runtime.redraw=true;}};Acts.prototype.AppendText=function(param)
{if(cr.is_number(param))
param=Math.round(param*1e10)/1e10;var text_to_append=param.toString();if(text_to_append)
{this.text+=text_to_append;this.text_changed=true;this.runtime.redraw=true;}};Acts.prototype.SetScale=function(param)
{if(param!==this.characterScale){this.characterScale=param;this.text_changed=true;this.runtime.redraw=true;}};Acts.prototype.SetCharacterSpacing=function(param)
{if(param!==this.CharacterSpacing){this.characterSpacing=param;this.text_changed=true;this.runtime.redraw=true;}};Acts.prototype.SetLineHeight=function(param)
{if(param!==this.lineHeight){this.lineHeight=param;this.text_changed=true;this.runtime.redraw=true;}};instanceProto.SetCharWidth=function(character,width){var w=parseInt(width,10);if(this.characterWidthList[character]!==w){this.characterWidthList[character]=w;this.text_changed=true;this.runtime.redraw=true;}};Acts.prototype.SetCharacterWidth=function(characterSet,width)
{if(characterSet!==""){for(var c=0;c<characterSet.length;c++){this.SetCharWidth(characterSet.charAt(c),width);}}};Acts.prototype.SetEffect=function(effect)
{this.compositeOp=cr.effectToCompositeOp(effect);cr.setGLBlend(this,effect,this.runtime.gl);this.runtime.redraw=true;};pluginProto.acts=new Acts();function Exps(){}
Exps.prototype.CharacterWidth=function(ret,character)
{ret.set_int(this.getCharacterWidth(character));};Exps.prototype.CharacterHeight=function(ret)
{ret.set_int(this.characterHeight);};Exps.prototype.CharacterScale=function(ret)
{ret.set_float(this.characterScale);};Exps.prototype.CharacterSpacing=function(ret)
{ret.set_int(this.characterSpacing);};Exps.prototype.LineHeight=function(ret)
{ret.set_int(this.lineHeight);};Exps.prototype.Text=function(ret)
{ret.set_string(this.text);};Exps.prototype.TextWidth=function(ret)
{this.rebuildText();ret.set_float(this.textWidth);};Exps.prototype.TextHeight=function(ret)
{this.rebuildText();ret.set_float(this.textHeight);};pluginProto.exps=new Exps();}());;;cr.plugins_.TiledBg=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.TiledBg.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{if(this.is_family)
return;this.texture_img=new Image();this.texture_img["idtkLoadDisposed"]=true;this.texture_img.src=this.texture_file;this.texture_img.cr_filesize=this.texture_filesize;this.runtime.wait_for_textures.push(this.texture_img);this.pattern=null;this.webGL_texture=null;};typeProto.onLostWebGLContext=function()
{if(this.is_family)
return;this.webGL_texture=null;};typeProto.onRestoreWebGLContext=function()
{if(this.is_family||!this.instances.length)
return;if(!this.webGL_texture)
{this.webGL_texture=this.runtime.glwrap.loadTexture(this.texture_img,true,this.runtime.linearSampling,this.texture_pixelformat);}
var i,len;for(i=0,len=this.instances.length;i<len;i++)
this.instances[i].webGL_texture=this.webGL_texture;};typeProto.loadTextures=function()
{if(this.is_family||this.webGL_texture||!this.runtime.glwrap)
return;this.webGL_texture=this.runtime.glwrap.loadTexture(this.texture_img,true,this.runtime.linearSampling,this.texture_pixelformat);};typeProto.unloadTextures=function()
{if(this.is_family||this.instances.length||!this.webGL_texture)
return;this.runtime.glwrap.deleteTexture(this.webGL_texture);this.webGL_texture=null;};typeProto.preloadCanvas2D=function(ctx)
{ctx.drawImage(this.texture_img,0,0);};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;instanceProto.onCreate=function()
{this.visible=(this.properties[0]===0);this.rcTex=new cr.rect(0,0,0,0);this.has_own_texture=false;this.texture_img=this.type.texture_img;if(this.runtime.glwrap)
{this.type.loadTextures();this.webGL_texture=this.type.webGL_texture;}
else
{if(!this.type.pattern)
this.type.pattern=this.runtime.ctx.createPattern(this.type.texture_img,"repeat");this.pattern=this.type.pattern;}};instanceProto.afterLoad=function()
{this.has_own_texture=false;this.texture_img=this.type.texture_img;};instanceProto.onDestroy=function()
{if(this.runtime.glwrap&&this.has_own_texture&&this.webGL_texture)
{this.runtime.glwrap.deleteTexture(this.webGL_texture);this.webGL_texture=null;}};instanceProto.draw=function(ctx)
{ctx.globalAlpha=this.opacity;ctx.save();ctx.fillStyle=this.pattern;var myx=this.x;var myy=this.y;if(this.runtime.pixel_rounding)
{myx=(myx+0.5)|0;myy=(myy+0.5)|0;}
var drawX=-(this.hotspotX*this.width);var drawY=-(this.hotspotY*this.height);var offX=drawX%this.texture_img.width;var offY=drawY%this.texture_img.height;if(offX<0)
offX+=this.texture_img.width;if(offY<0)
offY+=this.texture_img.height;ctx.translate(myx,myy);ctx.rotate(this.angle);ctx.translate(offX,offY);ctx.fillRect(drawX-offX,drawY-offY,this.width,this.height);ctx.restore();};instanceProto.drawGL=function(glw)
{glw.setTexture(this.webGL_texture);glw.setOpacity(this.opacity);var rcTex=this.rcTex;rcTex.right=this.width/this.texture_img.width;rcTex.bottom=this.height/this.texture_img.height;var q=this.bquad;if(this.runtime.pixel_rounding)
{var ox=((this.x+0.5)|0)-this.x;var oy=((this.y+0.5)|0)-this.y;glw.quadTex(q.tlx+ox,q.tly+oy,q.trx+ox,q.try_+oy,q.brx+ox,q.bry+oy,q.blx+ox,q.bly+oy,rcTex);}
else
glw.quadTex(q.tlx,q.tly,q.trx,q.try_,q.brx,q.bry,q.blx,q.bly,rcTex);};function Cnds(){};Cnds.prototype.OnURLLoaded=function()
{return true;};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.SetEffect=function(effect)
{this.compositeOp=cr.effectToCompositeOp(effect);cr.setGLBlend(this,effect,this.runtime.gl);this.runtime.redraw=true;};Acts.prototype.LoadURL=function(url_)
{var img=new Image();var self=this;img.onload=function()
{self.texture_img=img;if(self.runtime.glwrap)
{if(self.has_own_texture&&self.webGL_texture)
self.runtime.glwrap.deleteTexture(self.webGL_texture);self.webGL_texture=self.runtime.glwrap.loadTexture(img,true,self.runtime.linearSampling);}
else
{self.pattern=self.runtime.ctx.createPattern(img,"repeat");}
self.has_own_texture=true;self.runtime.redraw=true;self.runtime.trigger(cr.plugins_.TiledBg.prototype.cnds.OnURLLoaded,self);};if(url_.substr(0,5)!=="data:")
img.crossOrigin='anonymous';img.src=url_;};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.ImageWidth=function(ret)
{ret.set_float(this.texture_img.width);};Exps.prototype.ImageHeight=function(ret)
{ret.set_float(this.texture_img.height);};pluginProto.exps=new Exps();}());;;cr.plugins_.Touch=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.Touch.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;this.touches=[];this.mouseDown=false;};var instanceProto=pluginProto.Instance.prototype;var dummyoffset={left:0,top:0};instanceProto.findTouch=function(id)
{var i,len;for(i=0,len=this.touches.length;i<len;i++)
{if(this.touches[i]["id"]===id)
return i;}
return-1;};var appmobi_accx=0;var appmobi_accy=0;var appmobi_accz=0;function AppMobiGetAcceleration(evt)
{appmobi_accx=evt.x;appmobi_accy=evt.y;appmobi_accz=evt.z;};var pg_accx=0;var pg_accy=0;var pg_accz=0;function PhoneGapGetAcceleration(evt)
{pg_accx=evt.x;pg_accy=evt.y;pg_accz=evt.z;};var theInstance=null;instanceProto.onCreate=function()
{theInstance=this;this.isWindows8=!!(typeof window["c2isWindows8"]!=="undefined"&&window["c2isWindows8"]);this.orient_alpha=0;this.orient_beta=0;this.orient_gamma=0;this.acc_g_x=0;this.acc_g_y=0;this.acc_g_z=0;this.acc_x=0;this.acc_y=0;this.acc_z=0;this.curTouchX=0;this.curTouchY=0;this.trigger_index=0;this.trigger_id=0;this.useMouseInput=(this.properties[0]!==0);var elem=(this.runtime.fullscreen_mode>0)?document:this.runtime.canvas;var elem2=document;if(this.runtime.isDirectCanvas)
elem2=elem=window["Canvas"];else if(this.runtime.isCocoonJs)
elem2=elem=window;var self=this;if(window.navigator["msPointerEnabled"])
{elem.addEventListener("MSPointerDown",function(info){self.onPointerStart(info);},false);elem.addEventListener("MSPointerMove",function(info){self.onPointerMove(info);},false);elem2.addEventListener("MSPointerUp",function(info){self.onPointerEnd(info);},false);elem2.addEventListener("MSPointerCancel",function(info){self.onPointerEnd(info);},false);if(this.runtime.canvas)
{this.runtime.canvas.addEventListener("MSGestureHold",function(e){e.preventDefault();},false);document.addEventListener("MSGestureHold",function(e){e.preventDefault();},false);}}
else
{elem.addEventListener("touchstart",function(info){self.onTouchStart(info);},false);elem.addEventListener("touchmove",function(info){self.onTouchMove(info);},false);elem2.addEventListener("touchend",function(info){self.onTouchEnd(info);},false);elem2.addEventListener("touchcancel",function(info){self.onTouchEnd(info);},false);}
if(this.isWindows8)
{var win8accelerometerFn=function(e){var reading=e["reading"];self.acc_x=reading["accelerationX"];self.acc_y=reading["accelerationY"];self.acc_z=reading["accelerationZ"];};var win8inclinometerFn=function(e){var reading=e["reading"];self.orient_alpha=reading["yawDegrees"];self.orient_beta=reading["pitchDegrees"];self.orient_gamma=reading["rollDegrees"];};var accelerometer=Windows["Devices"]["Sensors"]["Accelerometer"]["getDefault"]();if(accelerometer)
{accelerometer["reportInterval"]=Math.max(accelerometer["minimumReportInterval"],16);accelerometer.addEventListener("readingchanged",win8accelerometerFn);}
var inclinometer=Windows["Devices"]["Sensors"]["Inclinometer"]["getDefault"]();if(inclinometer)
{inclinometer["reportInterval"]=Math.max(inclinometer["minimumReportInterval"],16);inclinometer.addEventListener("readingchanged",win8inclinometerFn);}
document.addEventListener("visibilitychange",function(e){if(document["hidden"]||document["msHidden"])
{if(accelerometer)
accelerometer.removeEventListener("readingchanged",win8accelerometerFn);if(inclinometer)
inclinometer.removeEventListener("readingchanged",win8inclinometerFn);}
else
{if(accelerometer)
accelerometer.addEventListener("readingchanged",win8accelerometerFn);if(inclinometer)
inclinometer.addEventListener("readingchanged",win8inclinometerFn);}},false);}
else
{window.addEventListener("deviceorientation",function(eventData){self.orient_alpha=eventData["alpha"]||0;self.orient_beta=eventData["beta"]||0;self.orient_gamma=eventData["gamma"]||0;},false);window.addEventListener("devicemotion",function(eventData){if(eventData["accelerationIncludingGravity"])
{self.acc_g_x=eventData["accelerationIncludingGravity"]["x"];self.acc_g_y=eventData["accelerationIncludingGravity"]["y"];self.acc_g_z=eventData["accelerationIncludingGravity"]["z"];}
if(eventData["acceleration"])
{self.acc_x=eventData["acceleration"]["x"];self.acc_y=eventData["acceleration"]["y"];self.acc_z=eventData["acceleration"]["z"];}},false);}
if(this.useMouseInput&&!this.runtime.isDomFree)
{jQuery(document).mousemove(function(info){self.onMouseMove(info);});jQuery(document).mousedown(function(info){self.onMouseDown(info);});jQuery(document).mouseup(function(info){self.onMouseUp(info);});}
if(this.runtime.isAppMobi&&!this.runtime.isDirectCanvas)
{AppMobi["accelerometer"]["watchAcceleration"](AppMobiGetAcceleration,{"frequency":40,"adjustForRotation":true});}
if(this.runtime.isPhoneGap)
{navigator["accelerometer"]["watchAcceleration"](PhoneGapGetAcceleration,null,{"frequency":40});}
this.runtime.tick2Me(this);};instanceProto.onPointerMove=function(info)
{if(info["pointerType"]===info["MSPOINTER_TYPE_MOUSE"])
return;if(info.preventDefault)
info.preventDefault();var i=this.findTouch(info["pointerId"]);var nowtime=cr.performance_now();if(i>=0)
{var offset=this.runtime.isDomFree?dummyoffset:jQuery(this.runtime.canvas).offset();var t=this.touches[i];if(nowtime-t.time<2)
return;t.lasttime=t.time;t.lastx=t.x;t.lasty=t.y;t.time=nowtime;t.x=info.pageX-offset.left;t.y=info.pageY-offset.top;}};instanceProto.onPointerStart=function(info)
{if(info["pointerType"]===info["MSPOINTER_TYPE_MOUSE"])
return;if(info.preventDefault)
info.preventDefault();var offset=this.runtime.isDomFree?dummyoffset:jQuery(this.runtime.canvas).offset();var touchx=info.pageX-offset.left;var touchy=info.pageY-offset.top;var nowtime=cr.performance_now();this.trigger_index=this.touches.length;this.trigger_id=info["pointerId"];this.touches.push({time:nowtime,x:touchx,y:touchy,lasttime:nowtime,lastx:touchx,lasty:touchy,"id":info["pointerId"],startindex:this.trigger_index});this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnNthTouchStart,this);this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnTouchStart,this);this.curTouchX=touchx;this.curTouchY=touchy;this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnTouchObject,this);};instanceProto.onPointerEnd=function(info)
{if(info["pointerType"]===info["MSPOINTER_TYPE_MOUSE"])
return;if(info.preventDefault)
info.preventDefault();var i=this.findTouch(info["pointerId"]);this.trigger_index=(i>=0?this.touches[i].startindex:-1);this.trigger_id=(i>=0?this.touches[i]["id"]:-1);this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnNthTouchEnd,this);this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnTouchEnd,this);if(i>=0)
{this.touches.splice(i,1);}};instanceProto.onTouchMove=function(info)
{if(info.preventDefault)
info.preventDefault();var nowtime=cr.performance_now();var i,len,t,u;for(i=0,len=info.changedTouches.length;i<len;i++)
{t=info.changedTouches[i];var j=this.findTouch(t["identifier"]);if(j>=0)
{var offset=this.runtime.isDomFree?dummyoffset:jQuery(this.runtime.canvas).offset();u=this.touches[j];if(nowtime-u.time<2)
continue;u.lasttime=u.time;u.lastx=u.x;u.lasty=u.y;u.time=nowtime;u.x=t.pageX-offset.left;u.y=t.pageY-offset.top;}}};instanceProto.onTouchStart=function(info)
{if(info.preventDefault)
info.preventDefault();var offset=this.runtime.isDomFree?dummyoffset:jQuery(this.runtime.canvas).offset();var nowtime=cr.performance_now();var i,len,t,j;for(i=0,len=info.changedTouches.length;i<len;i++)
{t=info.changedTouches[i];j=this.findTouch(t["identifier"]);if(j!==-1)
continue;var touchx=t.pageX-offset.left;var touchy=t.pageY-offset.top;this.trigger_index=this.touches.length;this.trigger_id=t["identifier"];this.touches.push({time:nowtime,x:touchx,y:touchy,lasttime:nowtime,lastx:touchx,lasty:touchy,"id":t["identifier"],startindex:this.trigger_index});this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnNthTouchStart,this);this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnTouchStart,this);this.curTouchX=touchx;this.curTouchY=touchy;this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnTouchObject,this);}};instanceProto.onTouchEnd=function(info)
{if(info.preventDefault)
info.preventDefault();var i,len,t,j;for(i=0,len=info.changedTouches.length;i<len;i++)
{t=info.changedTouches[i];j=this.findTouch(t["identifier"]);if(j>=0)
{this.trigger_index=this.touches[j].startindex;this.trigger_id=this.touches[j]["id"];this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnNthTouchEnd,this);this.runtime.trigger(cr.plugins_.Touch.prototype.cnds.OnTouchEnd,this);this.touches.splice(j,1);}}};instanceProto.getAlpha=function()
{if(this.runtime.isAppMobi&&this.orient_alpha===0&&appmobi_accz!==0)
return appmobi_accz*90;else if(this.runtime.isPhoneGap&&this.orient_alpha===0&&pg_accz!==0)
return pg_accz*90;else
return this.orient_alpha;};instanceProto.getBeta=function()
{if(this.runtime.isAppMobi&&this.orient_beta===0&&appmobi_accy!==0)
return appmobi_accy*-90;else if(this.runtime.isPhoneGap&&this.orient_beta===0&&pg_accy!==0)
return pg_accy*-90;else
return this.orient_beta;};instanceProto.getGamma=function()
{if(this.runtime.isAppMobi&&this.orient_gamma===0&&appmobi_accx!==0)
return appmobi_accx*90;else if(this.runtime.isPhoneGap&&this.orient_gamma===0&&pg_accx!==0)
return pg_accx*90;else
return this.orient_gamma;};var noop_func=function(){};instanceProto.onMouseDown=function(info)
{if(info.preventDefault&&this.runtime.had_a_click)
info.preventDefault();var t={pageX:info.pageX,pageY:info.pageY,"identifier":0};var fakeinfo={changedTouches:[t]};this.onTouchStart(fakeinfo);this.mouseDown=true;};instanceProto.onMouseMove=function(info)
{if(info.preventDefault&&this.runtime.had_a_click)
info.preventDefault();if(!this.mouseDown)
return;var t={pageX:info.pageX,pageY:info.pageY,"identifier":0};var fakeinfo={changedTouches:[t]};this.onTouchMove(fakeinfo);};instanceProto.onMouseUp=function(info)
{if(info.preventDefault&&this.runtime.had_a_click)
info.preventDefault();this.runtime.had_a_click=true;var t={pageX:info.pageX,pageY:info.pageY,"identifier":0};var fakeinfo={changedTouches:[t]};this.onTouchEnd(fakeinfo);this.mouseDown=false;};instanceProto.tick2=function()
{var i,len,t;var nowtime=cr.performance_now();for(i=0,len=this.touches.length;i<len;i++)
{t=this.touches[i];if(t.time<=nowtime-50)
t.lasttime=nowtime;}};function Cnds(){};Cnds.prototype.OnTouchStart=function()
{return true;};Cnds.prototype.OnTouchEnd=function()
{return true;};Cnds.prototype.IsInTouch=function()
{return this.touches.length;};Cnds.prototype.OnTouchObject=function(type)
{if(!type)
return false;return this.runtime.testAndSelectCanvasPointOverlap(type,this.curTouchX,this.curTouchY,false);};Cnds.prototype.IsTouchingObject=function(type)
{if(!type)
return false;var sol=type.getCurrentSol();var instances=sol.getObjects();var px,py;var touching=[];var i,leni,j,lenj;for(i=0,leni=instances.length;i<leni;i++)
{var inst=instances[i];inst.update_bbox();for(j=0,lenj=this.touches.length;j<lenj;j++)
{var touch=this.touches[j];px=inst.layer.canvasToLayer(touch.x,touch.y,true);py=inst.layer.canvasToLayer(touch.x,touch.y,false);if(inst.contains_pt(px,py))
{touching.push(inst);break;}}}
if(touching.length)
{sol.select_all=false;sol.instances=touching;return true;}
else
return false;};Cnds.prototype.CompareTouchSpeed=function(index,cmp,s)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
return false;var t=this.touches[index];var dist=cr.distanceTo(t.x,t.y,t.lastx,t.lasty);var timediff=(t.time-t.lasttime)/1000;var speed=0;if(timediff>0)
speed=dist/timediff;return cr.do_cmp(speed,cmp,s);};Cnds.prototype.OrientationSupported=function()
{return typeof window["DeviceOrientationEvent"]!=="undefined";};Cnds.prototype.MotionSupported=function()
{return typeof window["DeviceMotionEvent"]!=="undefined";};Cnds.prototype.CompareOrientation=function(orientation_,cmp_,angle_)
{var v=0;if(orientation_===0)
v=this.getAlpha();else if(orientation_===1)
v=this.getBeta();else
v=this.getGamma();return cr.do_cmp(v,cmp_,angle_);};Cnds.prototype.CompareAcceleration=function(acceleration_,cmp_,angle_)
{var v=0;if(acceleration_===0)
v=this.acc_g_x;else if(acceleration_===1)
v=this.acc_g_y;else if(acceleration_===2)
v=this.acc_g_z;else if(acceleration_===3)
v=this.acc_x;else if(acceleration_===4)
v=this.acc_y;else if(acceleration_===5)
v=this.acc_z;return cr.do_cmp(v,cmp_,angle_);};Cnds.prototype.OnNthTouchStart=function(touch_)
{touch_=Math.floor(touch_);return touch_===this.trigger_index;};Cnds.prototype.OnNthTouchEnd=function(touch_)
{touch_=Math.floor(touch_);return touch_===this.trigger_index;};Cnds.prototype.HasNthTouch=function(touch_)
{touch_=Math.floor(touch_);return this.touches.length>=touch_+1;};pluginProto.cnds=new Cnds();function Exps(){};Exps.prototype.TouchCount=function(ret)
{ret.set_int(this.touches.length);};Exps.prototype.X=function(ret,layerparam)
{if(this.touches.length)
{var layer,oldScale,oldZoomRate,oldParallaxX,oldAngle;if(cr.is_undefined(layerparam))
{layer=this.runtime.getLayerByNumber(0);oldScale=layer.scale;oldZoomRate=layer.zoomRate;oldParallaxX=layer.parallaxX;oldAngle=layer.angle;layer.scale=this.runtime.running_layout.scale;layer.zoomRate=1.0;layer.parallaxX=1.0;layer.angle=this.runtime.running_layout.angle;ret.set_float(layer.canvasToLayer(this.touches[0].x,this.touches[0].y,true));layer.scale=oldScale;layer.zoomRate=oldZoomRate;layer.parallaxX=oldParallaxX;layer.angle=oldAngle;}
else
{if(cr.is_number(layerparam))
layer=this.runtime.getLayerByNumber(layerparam);else
layer=this.runtime.getLayerByName(layerparam);if(layer)
ret.set_float(layer.canvasToLayer(this.touches[0].x,this.touches[0].y,true));else
ret.set_float(0);}}
else
ret.set_float(0);};Exps.prototype.XAt=function(ret,index,layerparam)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
{ret.set_float(0);return;}
var layer,oldScale,oldZoomRate,oldParallaxX,oldAngle;if(cr.is_undefined(layerparam))
{layer=this.runtime.getLayerByNumber(0);oldScale=layer.scale;oldZoomRate=layer.zoomRate;oldParallaxX=layer.parallaxX;oldAngle=layer.angle;layer.scale=this.runtime.running_layout.scale;layer.zoomRate=1.0;layer.parallaxX=1.0;layer.angle=this.runtime.running_layout.angle;ret.set_float(layer.canvasToLayer(this.touches[index].x,this.touches[index].y,true));layer.scale=oldScale;layer.zoomRate=oldZoomRate;layer.parallaxX=oldParallaxX;layer.angle=oldAngle;}
else
{if(cr.is_number(layerparam))
layer=this.runtime.getLayerByNumber(layerparam);else
layer=this.runtime.getLayerByName(layerparam);if(layer)
ret.set_float(layer.canvasToLayer(this.touches[index].x,this.touches[index].y,true));else
ret.set_float(0);}};Exps.prototype.XForID=function(ret,id,layerparam)
{var index=this.findTouch(id);if(index<0)
{ret.set_float(0);return;}
var touch=this.touches[index];var layer,oldScale,oldZoomRate,oldParallaxX,oldAngle;if(cr.is_undefined(layerparam))
{layer=this.runtime.getLayerByNumber(0);oldScale=layer.scale;oldZoomRate=layer.zoomRate;oldParallaxX=layer.parallaxX;oldAngle=layer.angle;layer.scale=this.runtime.running_layout.scale;layer.zoomRate=1.0;layer.parallaxX=1.0;layer.angle=this.runtime.running_layout.angle;ret.set_float(layer.canvasToLayer(touch.x,touch.y,true));layer.scale=oldScale;layer.zoomRate=oldZoomRate;layer.parallaxX=oldParallaxX;layer.angle=oldAngle;}
else
{if(cr.is_number(layerparam))
layer=this.runtime.getLayerByNumber(layerparam);else
layer=this.runtime.getLayerByName(layerparam);if(layer)
ret.set_float(layer.canvasToLayer(touch.x,touch.y,true));else
ret.set_float(0);}};Exps.prototype.Y=function(ret,layerparam)
{if(this.touches.length)
{var layer,oldScale,oldZoomRate,oldParallaxY,oldAngle;if(cr.is_undefined(layerparam))
{layer=this.runtime.getLayerByNumber(0);oldScale=layer.scale;oldZoomRate=layer.zoomRate;oldParallaxY=layer.parallaxY;oldAngle=layer.angle;layer.scale=this.runtime.running_layout.scale;layer.zoomRate=1.0;layer.parallaxY=1.0;layer.angle=this.runtime.running_layout.angle;ret.set_float(layer.canvasToLayer(this.touches[0].x,this.touches[0].y,false));layer.scale=oldScale;layer.zoomRate=oldZoomRate;layer.parallaxY=oldParallaxY;layer.angle=oldAngle;}
else
{if(cr.is_number(layerparam))
layer=this.runtime.getLayerByNumber(layerparam);else
layer=this.runtime.getLayerByName(layerparam);if(layer)
ret.set_float(layer.canvasToLayer(this.touches[0].x,this.touches[0].y,false));else
ret.set_float(0);}}
else
ret.set_float(0);};Exps.prototype.YAt=function(ret,index,layerparam)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
{ret.set_float(0);return;}
var layer,oldScale,oldZoomRate,oldParallaxY,oldAngle;if(cr.is_undefined(layerparam))
{layer=this.runtime.getLayerByNumber(0);oldScale=layer.scale;oldZoomRate=layer.zoomRate;oldParallaxY=layer.parallaxY;oldAngle=layer.angle;layer.scale=this.runtime.running_layout.scale;layer.zoomRate=1.0;layer.parallaxY=1.0;layer.angle=this.runtime.running_layout.angle;ret.set_float(layer.canvasToLayer(this.touches[index].x,this.touches[index].y,false));layer.scale=oldScale;layer.zoomRate=oldZoomRate;layer.parallaxY=oldParallaxY;layer.angle=oldAngle;}
else
{if(cr.is_number(layerparam))
layer=this.runtime.getLayerByNumber(layerparam);else
layer=this.runtime.getLayerByName(layerparam);if(layer)
ret.set_float(layer.canvasToLayer(this.touches[index].x,this.touches[index].y,false));else
ret.set_float(0);}};Exps.prototype.YForID=function(ret,id,layerparam)
{var index=this.findTouch(id);if(index<0)
{ret.set_float(0);return;}
var touch=this.touches[index];var layer,oldScale,oldZoomRate,oldParallaxY,oldAngle;if(cr.is_undefined(layerparam))
{layer=this.runtime.getLayerByNumber(0);oldScale=layer.scale;oldZoomRate=layer.zoomRate;oldParallaxY=layer.parallaxY;oldAngle=layer.angle;layer.scale=this.runtime.running_layout.scale;layer.zoomRate=1.0;layer.parallaxY=1.0;layer.angle=this.runtime.running_layout.angle;ret.set_float(layer.canvasToLayer(touch.x,touch.y,false));layer.scale=oldScale;layer.zoomRate=oldZoomRate;layer.parallaxY=oldParallaxY;layer.angle=oldAngle;}
else
{if(cr.is_number(layerparam))
layer=this.runtime.getLayerByNumber(layerparam);else
layer=this.runtime.getLayerByName(layerparam);if(layer)
ret.set_float(layer.canvasToLayer(touch.x,touch.y,false));else
ret.set_float(0);}};Exps.prototype.AbsoluteX=function(ret)
{if(this.touches.length)
ret.set_float(this.touches[0].x);else
ret.set_float(0);};Exps.prototype.AbsoluteXAt=function(ret,index)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
{ret.set_float(0);return;}
ret.set_float(this.touches[index].x);};Exps.prototype.AbsoluteXForID=function(ret,id)
{var index=this.findTouch(id);if(index<0)
{ret.set_float(0);return;}
var touch=this.touches[index];ret.set_float(touch.x);};Exps.prototype.AbsoluteY=function(ret)
{if(this.touches.length)
ret.set_float(this.touches[0].y);else
ret.set_float(0);};Exps.prototype.AbsoluteYAt=function(ret,index)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
{ret.set_float(0);return;}
ret.set_float(this.touches[index].y);};Exps.prototype.AbsoluteYForID=function(ret,id)
{var index=this.findTouch(id);if(index<0)
{ret.set_float(0);return;}
var touch=this.touches[index];ret.set_float(touch.y);};Exps.prototype.SpeedAt=function(ret,index)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
{ret.set_float(0);return;}
var t=this.touches[index];var dist=cr.distanceTo(t.x,t.y,t.lastx,t.lasty);var timediff=(t.time-t.lasttime)/1000;if(timediff===0)
ret.set_float(0);else
ret.set_float(dist/timediff);};Exps.prototype.SpeedForID=function(ret,id)
{var index=this.findTouch(id);if(index<0)
{ret.set_float(0);return;}
var touch=this.touches[index];var dist=cr.distanceTo(touch.x,touch.y,touch.lastx,touch.lasty);var timediff=(touch.time-touch.lasttime)/1000;if(timediff===0)
ret.set_float(0);else
ret.set_float(dist/timediff);};Exps.prototype.AngleAt=function(ret,index)
{index=Math.floor(index);if(index<0||index>=this.touches.length)
{ret.set_float(0);return;}
var t=this.touches[index];ret.set_float(cr.to_degrees(cr.angleTo(t.lastx,t.lasty,t.x,t.y)));};Exps.prototype.AngleForID=function(ret,id)
{var index=this.findTouch(id);if(index<0)
{ret.set_float(0);return;}
var touch=this.touches[index];ret.set_float(cr.to_degrees(cr.angleTo(touch.lastx,touch.lasty,touch.x,touch.y)));};Exps.prototype.Alpha=function(ret)
{ret.set_float(this.getAlpha());};Exps.prototype.Beta=function(ret)
{ret.set_float(this.getBeta());};Exps.prototype.Gamma=function(ret)
{ret.set_float(this.getGamma());};Exps.prototype.AccelerationXWithG=function(ret)
{ret.set_float(this.acc_g_x);};Exps.prototype.AccelerationYWithG=function(ret)
{ret.set_float(this.acc_g_y);};Exps.prototype.AccelerationZWithG=function(ret)
{ret.set_float(this.acc_g_z);};Exps.prototype.AccelerationX=function(ret)
{ret.set_float(this.acc_x);};Exps.prototype.AccelerationY=function(ret)
{ret.set_float(this.acc_y);};Exps.prototype.AccelerationZ=function(ret)
{ret.set_float(this.acc_z);};Exps.prototype.TouchIndex=function(ret)
{ret.set_int(this.trigger_index);};Exps.prototype.TouchID=function(ret)
{ret.set_float(this.trigger_id);};pluginProto.exps=new Exps();}());;;cr.plugins_.WebStorage=function(runtime)
{this.runtime=runtime;};(function()
{var pluginProto=cr.plugins_.WebStorage.prototype;pluginProto.Type=function(plugin)
{this.plugin=plugin;this.runtime=plugin.runtime;};var typeProto=pluginProto.Type.prototype;typeProto.onCreate=function()
{};pluginProto.Instance=function(type)
{this.type=type;this.runtime=type.runtime;};var instanceProto=pluginProto.Instance.prototype;var prefix="";var is_arcade=(typeof window["is_scirra_arcade"]!=="undefined");if(is_arcade)
prefix="arcade"+window["scirra_arcade_id"];var logged_sessionnotsupported=false;function LogSessionNotSupported()
{if(logged_sessionnotsupported)
return;cr.logexport("[Construct 2] Webstorage plugin: session storage is not supported on this platform. Try using local storage or global variables instead.");logged_sessionnotsupported=true;};instanceProto.onCreate=function()
{};function Cnds(){};Cnds.prototype.LocalStorageEnabled=function()
{return true;};Cnds.prototype.SessionStorageEnabled=function()
{return true;};Cnds.prototype.LocalStorageExists=function(key)
{return localStorage.getItem(prefix+key)!=null;};Cnds.prototype.SessionStorageExists=function(key)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();return false;}
return sessionStorage.getItem(prefix+key)!=null;};Cnds.prototype.OnQuotaExceeded=function()
{return true;};Cnds.prototype.CompareKeyText=function(key,text_to_compare,case_sensitive)
{var value=localStorage.getItem(prefix+key)||"";if(case_sensitive)
return value==text_to_compare;else
return cr.equals_nocase(value,text_to_compare);};Cnds.prototype.CompareKeyNumber=function(key,cmp,x)
{var value=localStorage.getItem(prefix+key)||"";return cr.do_cmp(parseFloat(value),cmp,x);};pluginProto.cnds=new Cnds();function Acts(){};Acts.prototype.StoreLocal=function(key,data)
{try{localStorage.setItem(prefix+key,data);}
catch(e)
{this.runtime.trigger(cr.plugins_.WebStorage.prototype.cnds.OnQuotaExceeded,this);}};Acts.prototype.StoreSession=function(key,data)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();return;}
try{sessionStorage.setItem(prefix+key,data);}
catch(e)
{this.runtime.trigger(cr.plugins_.WebStorage.prototype.cnds.OnQuotaExceeded,this);}};Acts.prototype.RemoveLocal=function(key)
{localStorage.removeItem(prefix+key);};Acts.prototype.RemoveSession=function(key)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();return;}
sessionStorage.removeItem(prefix+key);};Acts.prototype.ClearLocal=function()
{if(!is_arcade)
localStorage.clear();};Acts.prototype.ClearSession=function()
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();return;}
if(!is_arcade)
sessionStorage.clear();};Acts.prototype.JSONLoad=function(json_,mode_)
{var d;try{d=JSON.parse(json_);}
catch(e){return;}
if(!d["c2dictionary"])
return;var o=d["data"];if(mode_===0&&!is_arcade)
localStorage.clear();var p;for(p in o)
{if(o.hasOwnProperty(p))
{try{localStorage.setItem(prefix+p,o[p]);}
catch(e)
{this.runtime.trigger(cr.plugins_.WebStorage.prototype.cnds.OnQuotaExceeded,this);return;}}}};pluginProto.acts=new Acts();function Exps(){};Exps.prototype.LocalValue=function(ret,key)
{ret.set_string(localStorage.getItem(prefix+key)||"");};Exps.prototype.SessionValue=function(ret,key)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();ret.set_string("");return;}
ret.set_string(sessionStorage.getItem(prefix+key)||"");};Exps.prototype.LocalCount=function(ret)
{ret.set_int(is_arcade?0:localStorage.length);};Exps.prototype.SessionCount=function(ret)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();ret.set_int(0);return;}
ret.set_int(is_arcade?0:sessionStorage.length);};Exps.prototype.LocalAt=function(ret,n)
{if(is_arcade)
ret.set_string("");else
ret.set_string(localStorage.getItem(localStorage.key(n))||"");};Exps.prototype.SessionAt=function(ret,n)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();ret.set_string("");return;}
if(is_arcade)
ret.set_string("");else
ret.set_string(sessionStorage.getItem(sessionStorage.key(n))||"");};Exps.prototype.LocalKeyAt=function(ret,n)
{if(is_arcade)
ret.set_string("");else
ret.set_string(localStorage.key(n)||"");};Exps.prototype.SessionKeyAt=function(ret,n)
{if(this.runtime.isCocoonJs||!sessionStorage)
{LogSessionNotSupported();ret.set_string("");return;}
if(is_arcade)
ret.set_string("");else
ret.set_string(sessionStorage.key(n)||"");};Exps.prototype.AsJSON=function(ret)
{var o={},i,len,k;for(i=0,len=localStorage.length;i<len;i++)
{k=localStorage.key(i);if(is_arcade)
{if(k.substr(0,prefix.length)===prefix)
{o[k.substr(prefix.length)]=localStorage.getItem(k);}}
else
o[k]=localStorage.getItem(k);}
ret.set_string(JSON.stringify({"c2dictionary":true,"data":o}));};pluginProto.exps=new Exps();}());;;cr.behaviors.Anchor=function(runtime)
{this.runtime=runtime;};(function()
{var behaviorProto=cr.behaviors.Anchor.prototype;behaviorProto.Type=function(behavior,objtype)
{this.behavior=behavior;this.objtype=objtype;this.runtime=behavior.runtime;};var behtypeProto=behaviorProto.Type.prototype;behtypeProto.onCreate=function()
{};behaviorProto.Instance=function(type,inst)
{this.type=type;this.behavior=type.behavior;this.inst=inst;this.runtime=type.runtime;};var behinstProto=behaviorProto.Instance.prototype;behinstProto.onCreate=function()
{this.anch_left=this.properties[0];this.anch_top=this.properties[1];this.anch_right=this.properties[2];this.anch_bottom=this.properties[3];this.inst.update_bbox();this.xleft=this.inst.bbox.left;this.ytop=this.inst.bbox.top;this.xright=this.runtime.original_width-this.inst.bbox.left;this.ybottom=this.runtime.original_height-this.inst.bbox.top;this.rdiff=this.runtime.original_width-this.inst.bbox.right;this.bdiff=this.runtime.original_height-this.inst.bbox.bottom;this.enabled=(this.properties[4]!==0);};behinstProto.saveToJSON=function()
{return{"xleft":this.xleft,"ytop":this.ytop,"xright":this.xright,"ybottom":this.ybottom,"rdiff":this.rdiff,"bdiff":this.bdiff,"enabled":this.enabled};};behinstProto.loadFromJSON=function(o)
{this.xleft=o["xleft"];this.ytop=o["ytop"];this.xright=o["xright"];this.ybottom=o["ybottom"];this.rdiff=o["rdiff"];this.bdiff=o["bdiff"];this.enabled=o["enabled"];};behinstProto.tick=function()
{if(!this.enabled)
return;var n;var layer=this.inst.layer;var inst=this.inst;var bbox=this.inst.bbox;if(this.anch_left===0)
{inst.update_bbox();n=(layer.viewLeft+this.xleft)-bbox.left;if(n!==0)
{inst.x+=n;inst.set_bbox_changed();}}
else if(this.anch_left===1)
{inst.update_bbox();n=(layer.viewRight-this.xright)-bbox.left;if(n!==0)
{inst.x+=n;inst.set_bbox_changed();}}
if(this.anch_top===0)
{inst.update_bbox();n=(layer.viewTop+this.ytop)-bbox.top;if(n!==0)
{inst.y+=n;inst.set_bbox_changed();}}
else if(this.anch_top===1)
{inst.update_bbox();n=(layer.viewBottom-this.ybottom)-bbox.top;if(n!==0)
{inst.y+=n;inst.set_bbox_changed();}}
if(this.anch_right===1)
{inst.update_bbox();n=(layer.viewRight-this.rdiff)-bbox.right;if(n!==0)
{inst.width+=n;if(inst.width<0)
inst.width=0;inst.set_bbox_changed();}}
if(this.anch_bottom===1)
{inst.update_bbox();n=(layer.viewBottom-this.bdiff)-bbox.bottom;if(n!==0)
{inst.height+=n;if(inst.height<0)
inst.height=0;inst.set_bbox_changed();}}};function Cnds(){};behaviorProto.cnds=new Cnds();function Acts(){};Acts.prototype.SetEnabled=function(e)
{if(this.enabled&&e===0)
this.enabled=false;else if(!this.enabled&&e!==0)
{this.inst.update_bbox();this.xleft=this.inst.bbox.left;this.ytop=this.inst.bbox.top;this.xright=this.runtime.original_width-this.inst.bbox.left;this.ybottom=this.runtime.original_height-this.inst.bbox.top;this.rdiff=this.runtime.original_width-this.inst.bbox.right;this.bdiff=this.runtime.original_height-this.inst.bbox.bottom;this.enabled=true;}};behaviorProto.acts=new Acts();function Exps(){};behaviorProto.exps=new Exps();}());;;cr.behaviors.Pin=function(runtime)
{this.runtime=runtime;};(function()
{var behaviorProto=cr.behaviors.Pin.prototype;behaviorProto.Type=function(behavior,objtype)
{this.behavior=behavior;this.objtype=objtype;this.runtime=behavior.runtime;};var behtypeProto=behaviorProto.Type.prototype;behtypeProto.onCreate=function()
{};behaviorProto.Instance=function(type,inst)
{this.type=type;this.behavior=type.behavior;this.inst=inst;this.runtime=type.runtime;};var behinstProto=behaviorProto.Instance.prototype;behinstProto.onCreate=function()
{this.pinObject=null;this.pinObjectUid=-1;this.pinAngle=0;this.pinDist=0;this.myStartAngle=0;this.theirStartAngle=0;this.lastKnownAngle=0;this.mode=0;var self=this;if(!this.recycled)
{this.myDestroyCallback=(function(inst){self.onInstanceDestroyed(inst);});}
this.runtime.addDestroyCallback(this.myDestroyCallback);};behinstProto.saveToJSON=function()
{return{"uid":this.pinObject?this.pinObject.uid:-1,"pa":this.pinAngle,"pd":this.pinDist,"msa":this.myStartAngle,"tsa":this.theirStartAngle,"lka":this.lastKnownAngle,"m":this.mode};};behinstProto.loadFromJSON=function(o)
{this.pinObjectUid=o["uid"];this.pinAngle=o["pa"];this.pinDist=o["pd"];this.myStartAngle=o["msa"];this.theirStartAngle=o["tsa"];this.lastKnownAngle=o["lka"];this.mode=o["m"];};behinstProto.afterLoad=function()
{if(this.pinObjectUid===-1)
this.pinObject=null;else
{this.pinObject=this.runtime.getObjectByUID(this.pinObjectUid);;}
this.pinObjectUid=-1;};behinstProto.onInstanceDestroyed=function(inst)
{if(this.pinObject==inst)
this.pinObject=null;};behinstProto.onDestroy=function()
{this.pinObject=null;this.runtime.removeDestroyCallback(this.myDestroyCallback);};behinstProto.tick=function()
{};behinstProto.tick2=function()
{if(!this.pinObject)
return;if(this.lastKnownAngle!==this.inst.angle)
this.myStartAngle=cr.clamp_angle(this.myStartAngle+(this.inst.angle-this.lastKnownAngle));var newx=this.inst.x;var newy=this.inst.y;if(this.mode===3||this.mode===4)
{var dist=cr.distanceTo(this.inst.x,this.inst.y,this.pinObject.x,this.pinObject.y);if((dist>this.pinDist)||(this.mode===4&&dist<this.pinDist))
{var a=cr.angleTo(this.pinObject.x,this.pinObject.y,this.inst.x,this.inst.y);newx=this.pinObject.x+Math.cos(a)*this.pinDist;newy=this.pinObject.y+Math.sin(a)*this.pinDist;}}
else
{newx=this.pinObject.x+Math.cos(this.pinObject.angle+this.pinAngle)*this.pinDist;newy=this.pinObject.y+Math.sin(this.pinObject.angle+this.pinAngle)*this.pinDist;}
var newangle=cr.clamp_angle(this.myStartAngle+(this.pinObject.angle-this.theirStartAngle));this.lastKnownAngle=newangle;if((this.mode===0||this.mode===1||this.mode===3||this.mode===4)&&(this.inst.x!==newx||this.inst.y!==newy))
{this.inst.x=newx;this.inst.y=newy;this.inst.set_bbox_changed();}
if((this.mode===0||this.mode===2)&&(this.inst.angle!==newangle))
{this.inst.angle=newangle;this.inst.set_bbox_changed();}};function Cnds(){};Cnds.prototype.IsPinned=function()
{return!!this.pinObject;};behaviorProto.cnds=new Cnds();function Acts(){};Acts.prototype.Pin=function(obj,mode_)
{if(!obj)
return;var otherinst=obj.getFirstPicked(this.inst);if(!otherinst)
return;this.pinObject=otherinst;this.pinAngle=cr.angleTo(otherinst.x,otherinst.y,this.inst.x,this.inst.y)-otherinst.angle;this.pinDist=cr.distanceTo(otherinst.x,otherinst.y,this.inst.x,this.inst.y);this.myStartAngle=this.inst.angle;this.lastKnownAngle=this.inst.angle;this.theirStartAngle=otherinst.angle;this.mode=mode_;};Acts.prototype.Unpin=function()
{this.pinObject=null;};behaviorProto.acts=new Acts();function Exps(){};Exps.prototype.PinnedUID=function(ret)
{ret.set_int(this.pinObject?this.pinObject.uid:-1);};behaviorProto.exps=new Exps();}());;;cr.behaviors.Rex_MoveTo=function(runtime)
{this.runtime=runtime;};(function()
{var behaviorProto=cr.behaviors.Rex_MoveTo.prototype;behaviorProto.Type=function(behavior,objtype)
{this.behavior=behavior;this.objtype=objtype;this.runtime=behavior.runtime;};var behtypeProto=behaviorProto.Type.prototype;behtypeProto.onCreate=function()
{};behaviorProto.Instance=function(type,inst)
{this.type=type;this.behavior=type.behavior;this.inst=inst;this.runtime=type.runtime;};var behinstProto=behaviorProto.Instance.prototype;behinstProto.onCreate=function()
{this.enabled=(this.properties[0]==1);this.move={"max":this.properties[1],"acc":this.properties[2],"dec":this.properties[3]};this.target={"x":0,"y":0,"a":0};this.is_moving=false;this.current_speed=0;this.remain_distance=0;this.is_hit_target=false;this._pre_pos={"x":0,"y":0};this._moving_angle_info={"x":0,"y":0,"a":(-1)};this._last_tick=null;this.is_my_call=false;};behinstProto.tick=function()
{if(this.is_hit_target)
{if((this.inst.x==this.target["x"])&&(this.inst.y==this.target["y"]))
{this.is_my_call=true;this.runtime.trigger(cr.behaviors.Rex_MoveTo.prototype.cnds.OnHitTarget,this.inst);this.is_my_call=false;}
this.is_hit_target=false;}
if((!this.enabled)||(!this.is_moving))
{return;}
var dt=this.runtime.getDt(this.inst);if(dt==0)
return;if((this._pre_pos["x"]!=this.inst.x)||(this._pre_pos["y"]!=this.inst.y))
this._reset_current_pos();var is_slow_down=false;if(this.move["dec"]!=0)
{var _speed=this.current_speed;var _distance=(_speed*_speed)/(2*this.move["dec"]);is_slow_down=(_distance>=this.remain_distance);}
var acc=(is_slow_down)?(-this.move["dec"]):this.move["acc"];if(acc!=0)
{this.SetCurrentSpeed(this.current_speed+(acc*dt));}
var distance=this.current_speed*dt;this.remain_distance-=distance;if((this.remain_distance<=0)||(this.current_speed<=0))
{this.is_moving=false;this.inst.x=this.target["x"];this.inst.y=this.target["y"];this.SetCurrentSpeed(0);this.moving_angle_get();this.is_hit_target=true;}
else
{var angle=this.target["a"];this.inst.x+=(distance*Math.cos(angle));this.inst.y+=(distance*Math.sin(angle));}
this.inst.set_bbox_changed();this._pre_pos["x"]=this.inst.x;this._pre_pos["y"]=this.inst.y;};behinstProto.tick2=function()
{this._moving_angle_info["x"]=this.inst.x;this._moving_angle_info["y"]=this.inst.y;};behinstProto.SetCurrentSpeed=function(speed)
{if(speed!=null)
{this.current_speed=(speed>this.move["max"])?this.move["max"]:speed;}
else if(this.move["acc"]==0)
{this.current_speed=this.move["max"];}};behinstProto._reset_current_pos=function()
{var dx=this.target["x"]-this.inst.x;var dy=this.target["y"]-this.inst.y;this.target["a"]=Math.atan2(dy,dx);this.remain_distance=Math.sqrt((dx*dx)+(dy*dy));this._pre_pos["x"]=this.inst.x;this._pre_pos["y"]=this.inst.y;};behinstProto.SetTargetPos=function(_x,_y)
{this.is_moving=true;this.target["x"]=_x;this.target["y"]=_y;this._reset_current_pos();this.SetCurrentSpeed(null);this._moving_angle_info["x"]=this.inst.x;this._moving_angle_info["y"]=this.inst.y;};behinstProto.is_tick_changed=function()
{var cur_tick=this.runtime.tickcount;var tick_changed=(this._last_tick!=cur_tick);this._last_tick=cur_tick;return tick_changed;};behinstProto.moving_angle_get=function(ret)
{if(this.is_tick_changed())
{var dx=this.inst.x-this._moving_angle_info["x"];var dy=this.inst.y-this._moving_angle_info["y"];if((dx!=0)||(dy!=0))
this._moving_angle_info["a"]=cr.to_clamped_degrees(Math.atan2(dy,dx));}
return this._moving_angle_info["a"];};behinstProto.saveToJSON=function()
{return{"en":this.enabled,"v":this.move,"t":this.target,"is_m":this.is_moving,"c_spd":this.current_speed,"rd":this.remain_distance,"is_ht":this.is_hit_target,"pp":this._pre_pos,"ma":this._moving_angle_info,"lt":this._last_tick,};};behinstProto.loadFromJSON=function(o)
{this.enabled=o["en"];this.move=o["v"];this.target=o["t"];this.is_moving=o["is_m"];this.current_speed=o["c_spd"];this.remain_distance=o["rd"];this.is_hit_target=o["is_ht"];this._pre_pos=o["pp"];this._moving_angle_info=o["ma"];this._last_tick=o["lt"];};function Cnds(){};behaviorProto.cnds=new Cnds();Cnds.prototype.OnHitTarget=function()
{return(this.is_my_call);};Cnds.prototype.CompareSpeed=function(cmp,s)
{return cr.do_cmp(this.current_speed,cmp,s);};Cnds.prototype.OnMoving=function()
{return false;};Cnds.prototype.IsMoving=function()
{return(this.enabled&&this.is_moving);};Cnds.prototype.CompareMovingAngle=function(cmp,s)
{var angle=this.moving_angle_get();if(angle!=(-1))
return cr.do_cmp(this.moving_angle_get(),cmp,s);else
return false;};function Acts(){};behaviorProto.acts=new Acts();Acts.prototype.SetEnabled=function(en)
{this.enabled=(en===1);};Acts.prototype.SetMaxSpeed=function(s)
{this.move["max"]=s;this.SetCurrentSpeed(null);};Acts.prototype.SetAcceleration=function(a)
{this.move["acc"]=a;this.SetCurrentSpeed(null);};Acts.prototype.SetDeceleration=function(a)
{this.move["dec"]=a;};Acts.prototype.SetTargetPos=function(_x,_y)
{this.SetTargetPos(_x,_y)};Acts.prototype.SetCurrentSpeed=function(s)
{this.SetCurrentSpeed(s);};Acts.prototype.SetTargetPosOnObject=function(objtype)
{if(!objtype)
return;var inst=objtype.getFirstPicked();if(inst!=null)
this.SetTargetPos(inst.x,inst.y);};Acts.prototype.SetTargetPosByDeltaXY=function(dx,dy)
{this.SetTargetPos(this.inst.x+dx,this.inst.y+dy);};Acts.prototype.SetTargetPosByDistanceAngle=function(distance,angle)
{var a=cr.to_clamped_radians(angle);var dx=distance*Math.cos(a);var dy=distance*Math.sin(a);this.SetTargetPos(this.inst.x+dx,this.inst.y+dy);};Acts.prototype.Stop=function()
{this.is_moving=false;};function Exps(){};behaviorProto.exps=new Exps();Exps.prototype.Activated=function(ret)
{ret.set_int((this.enabled)?1:0);};Exps.prototype.Speed=function(ret)
{ret.set_float(this.current_speed);};Exps.prototype.MaxSpeed=function(ret)
{ret.set_float(this.move["max"]);};Exps.prototype.Acc=function(ret)
{ret.set_float(this.move["acc"]);};Exps.prototype.Dec=function(ret)
{ret.set_float(this.move["dec"]);};Exps.prototype.TargetX=function(ret)
{ret.set_float(this.target["x"]);};Exps.prototype.TargetY=function(ret)
{ret.set_float(this.target["y"]);};Exps.prototype.MovingAngle=function(ret)
{ret.set_float(this.moving_angle_get());};}());;;cr.behaviors.Sin=function(runtime)
{this.runtime=runtime;};(function()
{var behaviorProto=cr.behaviors.Sin.prototype;behaviorProto.Type=function(behavior,objtype)
{this.behavior=behavior;this.objtype=objtype;this.runtime=behavior.runtime;};var behtypeProto=behaviorProto.Type.prototype;behtypeProto.onCreate=function()
{};behaviorProto.Instance=function(type,inst)
{this.type=type;this.behavior=type.behavior;this.inst=inst;this.runtime=type.runtime;this.i=0;};var behinstProto=behaviorProto.Instance.prototype;var _2pi=2*Math.PI;var _pi_2=Math.PI/2;var _3pi_2=(3*Math.PI)/2;behinstProto.onCreate=function()
{this.active=(this.properties[0]===1);this.movement=this.properties[1];this.wave=this.properties[2];this.period=this.properties[3];this.period+=Math.random()*this.properties[4];if(this.period===0)
this.i=0;else
{this.i=(this.properties[5]/this.period)*_2pi;this.i+=((Math.random()*this.properties[6])/this.period)*_2pi;}
this.mag=this.properties[7];this.mag+=Math.random()*this.properties[8];this.initialValue=0;this.initialValue2=0;this.ratio=0;this.init();};behinstProto.saveToJSON=function()
{return{"i":this.i,"a":this.active,"mv":this.movement,"w":this.wave,"p":this.period,"mag":this.mag,"iv":this.initialValue,"iv2":this.initialValue2,"r":this.ratio,"lkv":this.lastKnownValue,"lkv2":this.lastKnownValue2};};behinstProto.loadFromJSON=function(o)
{this.i=o["i"];this.active=o["a"];this.movement=o["mv"];this.wave=o["w"];this.period=o["p"];this.mag=o["mag"];this.initialValue=o["iv"];this.initialValue2=o["iv2"]||0;this.ratio=o["r"];this.lastKnownValue=o["lkv"];this.lastKnownValue2=o["lkv2"]||0;};behinstProto.init=function()
{switch(this.movement){case 0:this.initialValue=this.inst.x;break;case 1:this.initialValue=this.inst.y;break;case 2:this.initialValue=this.inst.width;this.ratio=this.inst.height/this.inst.width;break;case 3:this.initialValue=this.inst.width;break;case 4:this.initialValue=this.inst.height;break;case 5:this.initialValue=this.inst.angle;this.mag=cr.to_radians(this.mag);break;case 6:this.initialValue=this.inst.opacity;break;case 7:this.initialValue=0;break;case 8:this.initialValue=this.inst.x;this.initialValue2=this.inst.y;break;default:;}
this.lastKnownValue=this.initialValue;this.lastKnownValue2=this.initialValue2;};behinstProto.waveFunc=function(x)
{x=x%_2pi;switch(this.wave){case 0:return Math.sin(x);case 1:if(x<=_pi_2)
return x/_pi_2;else if(x<=_3pi_2)
return 1-(2*(x-_pi_2)/Math.PI);else
return(x-_3pi_2)/_pi_2-1;case 2:return 2*x/_2pi-1;case 3:return-2*x/_2pi+1;case 4:return x<Math.PI?-1:1;};return 0;};behinstProto.tick=function()
{var dt=this.runtime.getDt(this.inst);if(!this.active||dt===0)
return;if(this.period===0)
this.i=0;else
{this.i+=(dt/this.period)*_2pi;this.i=this.i%_2pi;}
switch(this.movement){case 0:if(this.inst.x!==this.lastKnownValue)
this.initialValue+=this.inst.x-this.lastKnownValue;this.inst.x=this.initialValue+this.waveFunc(this.i)*this.mag;this.lastKnownValue=this.inst.x;break;case 1:if(this.inst.y!==this.lastKnownValue)
this.initialValue+=this.inst.y-this.lastKnownValue;this.inst.y=this.initialValue+this.waveFunc(this.i)*this.mag;this.lastKnownValue=this.inst.y;break;case 2:this.inst.width=this.initialValue+this.waveFunc(this.i)*this.mag;this.inst.height=this.inst.width*this.ratio;break;case 3:this.inst.width=this.initialValue+this.waveFunc(this.i)*this.mag;break;case 4:this.inst.height=this.initialValue+this.waveFunc(this.i)*this.mag;break;case 5:if(this.inst.angle!==this.lastKnownValue)
this.initialValue=cr.clamp_angle(this.initialValue+(this.inst.angle-this.lastKnownValue));this.inst.angle=cr.clamp_angle(this.initialValue+this.waveFunc(this.i)*this.mag);this.lastKnownValue=this.inst.angle;break;case 6:this.inst.opacity=this.initialValue+(this.waveFunc(this.i)*this.mag)/100;if(this.inst.opacity<0)
this.inst.opacity=0;else if(this.inst.opacity>1)
this.inst.opacity=1;break;case 8:if(this.inst.x!==this.lastKnownValue)
this.initialValue+=this.inst.x-this.lastKnownValue;if(this.inst.y!==this.lastKnownValue2)
this.initialValue2+=this.inst.y-this.lastKnownValue2;this.inst.x=this.initialValue+Math.cos(this.inst.angle)*this.waveFunc(this.i)*this.mag;this.inst.y=this.initialValue2+Math.sin(this.inst.angle)*this.waveFunc(this.i)*this.mag;this.lastKnownValue=this.inst.x;this.lastKnownValue2=this.inst.y;break;}
this.inst.set_bbox_changed();};behinstProto.onSpriteFrameChanged=function(prev_frame,next_frame)
{switch(this.movement){case 2:this.initialValue*=(next_frame.width/prev_frame.width);this.ratio=next_frame.height/next_frame.width;break;case 3:this.initialValue*=(next_frame.width/prev_frame.width);break;case 4:this.initialValue*=(next_frame.height/prev_frame.height);break;}};function Cnds(){};Cnds.prototype.IsActive=function()
{return this.active;};Cnds.prototype.CompareMovement=function(m)
{return this.movement===m;};Cnds.prototype.ComparePeriod=function(cmp,v)
{return cr.do_cmp(this.period,cmp,v);};Cnds.prototype.CompareMagnitude=function(cmp,v)
{if(this.movement===5)
return cr.do_cmp(this.mag,cmp,cr.to_radians(v));else
return cr.do_cmp(this.mag,cmp,v);};Cnds.prototype.CompareWave=function(w)
{return this.wave===w;};behaviorProto.cnds=new Cnds();function Acts(){};Acts.prototype.SetActive=function(a)
{this.active=(a===1);};Acts.prototype.SetPeriod=function(x)
{this.period=x;};Acts.prototype.SetMagnitude=function(x)
{this.mag=x;if(this.movement===5)
this.mag=cr.to_radians(this.mag);};Acts.prototype.SetMovement=function(m)
{if(this.movement===5)
this.mag=cr.to_degrees(this.mag);this.movement=m;this.init();};Acts.prototype.SetWave=function(w)
{this.wave=w;};behaviorProto.acts=new Acts();function Exps(){};Exps.prototype.CyclePosition=function(ret)
{ret.set_float(this.i/_2pi);};Exps.prototype.Period=function(ret)
{ret.set_float(this.period);};Exps.prototype.Magnitude=function(ret)
{if(this.movement===5)
ret.set_float(cr.to_degrees(this.mag));else
ret.set_float(this.mag);};Exps.prototype.Value=function(ret)
{ret.set_float(this.waveFunc(this.i)*this.mag);};behaviorProto.exps=new Exps();}());var easeOutBounceArray=[];var easeInElasticArray=[];var easeOutElasticArray=[];var easeInOutElasticArray=[];var easeInCircle=[];var easeOutCircle=[];var easeInOutCircle=[];var easeOutBack=[];var easeInOutBack=[];var litetween_precision=10000;var updateLimit=0;function easeOutBounce(t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b;}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;}}
function integerize(t,d)
{return Math.round(t/d*litetween_precision);}
function easeFunc(easing,t,b,c,d,flip)
{var ret_ease=0;switch(easing){case 0:ret_ease=c*t/d+b;break;case 1:ret_ease=c*(t/=d)*t+b;break;case 2:ret_ease=-c*(t/=d)*(t-2)+b;break;case 3:if((t/=d/2)<1)
ret_ease=c/2*t*t+b
else
ret_ease=-c/2*((--t)*(t-2)-1)+b;break;case 4:ret_ease=c*(t/=d)*t*t+b;break;case 5:ret_ease=c*((t=t/d-1)*t*t+1)+b;break;case 6:if((t/=d/2)<1)
ret_ease=c/2*t*t*t+b
else
ret_ease=c/2*((t-=2)*t*t+2)+b;break;case 7:ret_ease=c*(t/=d)*t*t*t+b;break;case 8:ret_ease=-c*((t=t/d-1)*t*t*t-1)+b;break;case 9:if((t/=d/2)<1)
ret_ease=c/2*t*t*t*t+b
else
ret_ease=-c/2*((t-=2)*t*t*t-2)+b;break;case 10:ret_ease=c*(t/=d)*t*t*t*t+b;break;case 11:ret_ease=c*((t=t/d-1)*t*t*t*t+1)+b;break;case 12:if((t/=d/2)<1)
ret_ease=c/2*t*t*t*t*t+b
else
ret_ease=c/2*((t-=2)*t*t*t*t+2)+b;break;case 13:ret_ease=easeInCircle[integerize(t,d)];break;case 14:ret_ease=easeOutCircle[integerize(t,d)];break;case 15:ret_ease=easeInOutCircle[integerize(t,d)];break;case 16:var s=0;if(s==0)s=1.70158;ret_ease=c*(t/=d)*t*((s+1)*t-s)+b;break;case 17:ret_ease=easeOutBack[integerize(t,d)];break;case 18:ret_ease=easeInOutBack[integerize(t,d)];break;case 19:ret_ease=easeInElasticArray[integerize(t,d)];break;case 20:ret_ease=easeOutElasticArray[integerize(t,d)];break;case 21:ret_ease=easeInOutElasticArray[integerize(t,d)];break;case 22:ret_ease=c-easeOutBounceArray[integerize(d-t,d)]+b;break;case 23:ret_ease=easeOutBounceArray[integerize(t,d)];break;case 24:if(t<d/2)
ret_ease=(c-easeOutBounceArray[integerize(d-(t*2),d)]+b)*0.5+b;else
ret_ease=easeOutBounceArray[integerize(t*2-d,d)]*.5+c*.5+b;break;case 25:var mt=(t/d)/2;ret_ease=(2*(mt*mt*(3-2*mt)));break;case 26:var mt=((t/d)+1)/2;ret_ease=((2*(mt*mt*(3-2*mt)))-1);break;case 27:var mt=(t/d);ret_ease=(mt*mt*(3-2*mt));break;};if(flip)
return(c-b)-ret_ease
else
return ret_ease;};(function preCalculateArray(){var d=1.0;var b=0.0;var c=1.0;var result=0.0;var a=0;var p=0;var t=0;var s=0;for(var ti=0;ti<=litetween_precision;ti++){t=ti/litetween_precision;if((t/=d)<(1/2.75)){result=c*(7.5625*t*t)+b;}else if(t<(2/2.75)){result=c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;}else if(t<(2.5/2.75)){result=c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;}else{result=c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;}
easeOutBounceArray[ti]=easeOutBounce(ti/litetween_precision,b,c,d);t=ti/litetween_precision;a=0;p=0;if(t==0)result=b;if((t/=d)==1)result=b+c;if(p==0)p=d*.3;if(a==0||a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);result=-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;easeInElasticArray[ti]=result;t=ti/litetween_precision;a=0;p=0;if(t==0)result=b;if((t/=d)==1)result=b+c;if(p==0)p=d*.3;if(a==0||a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);result=(a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b);easeOutElasticArray[ti]=result;t=ti/litetween_precision;a=0;p=0;if(t==0)result=b;if((t/=d/2)==2)result=b+c;if(p==0)p=d*(.3*1.5);if(a==0||a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)
result=-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b
else
result=a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;easeInOutElasticArray[ti]=result;t=ti/litetween_precision;easeInCircle[ti]=-(Math.sqrt(1-t*t)-1);t=ti/litetween_precision;easeOutCircle[ti]=Math.sqrt(1-((t-1)*(t-1)));t=ti/litetween_precision;if((t/=d/2)<1)result=-c/2*(Math.sqrt(1-t*t)-1)+b
else result=c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;easeInOutCircle[ti]=result;t=ti/litetween_precision;s=0;if(s==0)s=1.70158;result=c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;easeOutBack[ti]=result;t=ti/litetween_precision;s=0;if(s==0)s=1.70158;if((t/=d/2)<1)
result=c/2*(t*t*(((s*=(1.525))+1)*t-s))+b
else
result=c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;easeInOutBack[ti]=result;}}())
var TweenObject=function()
{var constructor=function(tname,tweened,easefunc,initial,target,duration,enforce)
{this.name=tname;this.value=0;this.setInitial(initial);this.setTarget(target);this.easefunc=easefunc;this.tweened=tweened;this.duration=duration;this.progress=0;this.state=0;this.onStart=false;this.onEnd=false;this.onReverseStart=false;this.onReverseEnd=false;this.lastKnownValue=0;this.lastKnownValue2=0;this.enforce=enforce;this.pingpong=1.0;this.flipEase=false;}
return constructor;}();(function(){TweenObject.prototype={};TweenObject.prototype.flipTarget=function()
{var x1=this.initialparam1;var x2=this.initialparam2;this.initialparam1=this.targetparam1;this.initialparam2=this.targetparam2;this.targetparam1=x1;this.targetparam2=x2;this.lastKnownValue=0;this.lastKnownValue2=0;}
TweenObject.prototype.setInitial=function(initial)
{this.initialparam1=parseFloat(initial.split(",")[0]);this.initialparam2=parseFloat(initial.split(",")[1]);this.lastKnownValue=0;this.lastKnownValue2=0;}
TweenObject.prototype.setTarget=function(target)
{this.targetparam1=parseFloat(target.split(",")[0]);this.targetparam2=parseFloat(target.split(",")[1]);if(isNaN(this.targetparam2))this.targetparam2=this.targetparam1;}
TweenObject.prototype.OnTick=function(dt)
{if(this.state===0)return-1.0;if(this.state===1)
this.progress+=dt;if(this.state===2)
this.progress-=dt;if(this.state===3){this.state=0;}
if((this.state===4)||(this.state===6)){this.progress+=dt*this.pingpong;}
if(this.state===5){this.progress+=dt*this.pingpong;}
if(this.progress<0){this.progress=0;if(this.state===4){this.pingpong=1;}else if(this.state===6){this.pingpong=1;this.flipEase=false;}else{this.state=0;}
this.onReverseEnd=true;return 0.0;}else if(this.progress>this.duration){this.progress=this.duration;if(this.state===4){this.pingpong=-1;}else if(this.state===6){this.pingpong=-1;this.flipEase=true;}else if(this.state===5){this.progress=0.0;}else{this.state=0;}
this.onEnd=true;return 1.0;}else{if(this.flipEase){var factor=easeFunc(this.easefunc,this.duration-this.progress,0,1,this.duration,this.flipEase);}else{var factor=easeFunc(this.easefunc,this.progress,0,1,this.duration,this.flipEase);}
return factor;}};}());;;function trim(str){return str.replace(/^\s\s*/,'').replace(/\s\s*$/,'');}
cr.behaviors.lunarray_LiteTween=function(runtime)
{this.runtime=runtime;};(function()
{var behaviorProto=cr.behaviors.lunarray_LiteTween.prototype;behaviorProto.Type=function(behavior,objtype)
{this.behavior=behavior;this.objtype=objtype;this.runtime=behavior.runtime;};var behtypeProto=behaviorProto.Type.prototype;behtypeProto.onCreate=function()
{};behaviorProto.Instance=function(type,inst)
{this.type=type;this.behavior=type.behavior;this.inst=inst;this.runtime=type.runtime;this.i=0;};var behinstProto=behaviorProto.Instance.prototype;behinstProto.onCreate=function()
{this.playmode=this.properties[0];this.active=(this.playmode==1)||(this.playmode==2)||(this.playmode==3)||(this.playmode==4);this.tweened=this.properties[1];this.easing=this.properties[2];this.target=this.properties[3];this.targetmode=this.properties[4];if(this.targetmode===1)this.target="relative("+this.target+")";this.duration=this.properties[5];this.enforce=(this.properties[6]===1);this.value=0;this.tween_list={};this.addToTweenList("default",this.tweened,this.easing,"current",this.target,this.duration,this.enforce);if(this.properties[0]===1)this.startTween(0)
if(this.properties[0]===2)this.startTween(2)
if(this.properties[0]===3)this.startTween(3)
if(this.properties[0]===4)this.startTween(4)};behinstProto.parseCurrent=function(tweened,parseText)
{if(parseText===undefined)parseText="current";var parsed=trim(parseText);parseText=trim(parseText);var value=this.value;if(parseText==="current"){switch(tweened){case 0:parsed=this.inst.x+","+this.inst.y;break;case 1:parsed=this.inst.width+","+this.inst.height;break;case 2:parsed=this.inst.width+","+this.inst.height;break;case 3:parsed=this.inst.width+","+this.inst.height;break;case 4:parsed=cr.to_degrees(this.inst.angle)+","+cr.to_degrees(this.inst.angle);break;case 5:parsed=(this.inst.opacity*100)+","+(this.inst.opacity*100);break;case 6:parsed=value+","+value;break;case 7:parsed=this.inst.x+","+this.inst.y;break;case 8:parsed=this.inst.x+","+this.inst.y;break;case 9:if(this.inst.curFrame!==undefined)
parsed=(this.inst.width/this.inst.curFrame.width)+","+(this.inst.height/this.inst.curFrame.height)
else
parsed="1,1";break;default:break;}}
if(parseText.substring(0,8)==="relative"){var param1=parseText.match(/\((.*?)\)/);if(param1){var relativex=parseFloat(param1[1].split(",")[0]);var relativey=parseFloat(param1[1].split(",")[1]);}
if(isNaN(relativex))relativex=0;if(isNaN(relativey))relativey=0;switch(tweened){case 0:parsed=(this.inst.x+relativex)+","+(this.inst.y+relativey);break;case 1:parsed=(this.inst.width+relativex)+","+(this.inst.height+relativey);break;case 2:parsed=(this.inst.width+relativex)+","+(this.inst.height+relativey);break;case 3:parsed=(this.inst.width+relativex)+","+(this.inst.height+relativey);break;case 4:parsed=(cr.to_degrees(this.inst.angle)+relativex)+","+(cr.to_degrees(this.inst.angle)+relativey);break;case 5:parsed=(this.inst.opacity*100+relativex)+","+(this.inst.opacity*100+relativey);break;case 6:parsed=value+relativex+","+value+relativex;break;case 7:parsed=(this.inst.x+relativex)+","+(this.inst.y);break;case 8:parsed=(this.inst.x)+","+(this.inst.y+relativex);break;case 9:parsed=(relativex)+","+(relativey);break;default:break;}}
return parsed;};behinstProto.addToTweenList=function(tname,tweened,easing,init,targ,duration,enforce)
{init=this.parseCurrent(tweened,init);targ=this.parseCurrent(tweened,targ);if(this.tween_list[tname]!==undefined){delete this.tween_list[tname]}
this.tween_list[tname]=new TweenObject(tname,tweened,easing,init,targ,duration,enforce);this.tween_list[tname].dt=0;};behinstProto.saveToJSON=function()
{};behinstProto.loadFromJSON=function(o)
{};behinstProto.setProgressTo=function(mark)
{if(mark>1.0)mark=1.0;if(mark<0.0)mark=0.0;for(var i in this.tween_list){var inst=this.tween_list[i];inst.lastKnownValue=0;inst.lastKnownValue2=0;inst.state=3;inst.progress=mark*inst.duration;var factor=inst.OnTick(0);this.updateTween(inst,factor);}}
behinstProto.startTween=function(startMode)
{for(var i in this.tween_list){var inst=this.tween_list[i];if(startMode===0){inst.progress=0.000001;inst.lastKnownValue=0;inst.lastKnownValue2=0;inst.onStart=true;inst.state=1;}
if(startMode===1){inst.state=1;}
if((startMode===2)||(startMode===4)){inst.progress=0.000001;inst.lastKnownValue=0;inst.lastKnownValue2=0;inst.onStart=true;if(startMode==2)inst.state=4;if(startMode==4)inst.state=6;}
if(startMode===3){inst.progress=0.000001;inst.lastKnownValue=0;inst.lastKnownValue2=0;inst.onStart=true;inst.state=5;}}}
behinstProto.stopTween=function(stopMode)
{for(var i in this.tween_list){var inst=this.tween_list[i];if(stopMode===1)inst.progress=0.0;if(stopMode===2)inst.progress=inst.duration;inst.state=3;var factor=inst.OnTick(0);this.updateTween(inst,factor);}}
behinstProto.reverseTween=function(reverseMode)
{for(var i in this.tween_list){var inst=this.tween_list[i];if(reverseMode===1){inst.progress=inst.duration;inst.lastKnownValue=0;inst.lastKnownValue2=0;inst.onReverseStart=true;}
inst.state=2;}}
behinstProto.updateTween=function(inst,factor)
{if(inst.tweened===0){if(inst.enforce){this.inst.x=inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor;this.inst.y=inst.initialparam2+(inst.targetparam2-inst.initialparam2)*factor;}else{this.inst.x+=((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue;this.inst.y+=((inst.targetparam2-inst.initialparam2)*factor)-inst.lastKnownValue2;inst.lastKnownValue=((inst.targetparam1-inst.initialparam1)*factor);inst.lastKnownValue2=((inst.targetparam2-inst.initialparam2)*factor);}}else if(inst.tweened===1){if(inst.enforce){this.inst.width=inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor;this.inst.height=inst.initialparam2+(inst.targetparam2-inst.initialparam2)*factor;}else{this.inst.width+=((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue;this.inst.height+=((inst.targetparam2-inst.initialparam2)*factor)-inst.lastKnownValue2;inst.lastKnownValue=((inst.targetparam1-inst.initialparam1)*factor);inst.lastKnownValue2=((inst.targetparam2-inst.initialparam2)*factor);}}else if(inst.tweened===2){if(inst.enforce){this.inst.width=inst.initialparam1+((inst.targetparam1-inst.initialparam1)*factor);}else{this.inst.width+=((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue;inst.lastKnownValue=((inst.targetparam1-inst.initialparam1)*factor);}}else if(inst.tweened===3){if(inst.enforce){this.inst.height=inst.initialparam2+((inst.targetparam2-inst.initialparam2)*factor);}else{this.inst.height+=((inst.targetparam2-inst.initialparam2)*factor)-inst.lastKnownValue2;inst.lastKnownValue2=((inst.targetparam2-inst.initialparam2)*factor);}}else if(inst.tweened===4){if(inst.enforce){var tangle=inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor;this.inst.angle=cr.clamp_angle(cr.to_radians(tangle));}else{var tangle=((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue;this.inst.angle=cr.clamp_angle(this.inst.angle+cr.to_radians(tangle));inst.lastKnownValue=(inst.targetparam1-inst.initialparam1)*factor;}}else if(inst.tweened===5){if(inst.enforce){this.inst.opacity=(inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor)/100;}else{this.inst.opacity+=(((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue)/100;inst.lastKnownValue=((inst.targetparam1-inst.initialparam1)*factor);}}else if(inst.tweened===6){if(inst.enforce){this.value=(inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor);}else{this.value+=(((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue);inst.lastKnownValue=((inst.targetparam1-inst.initialparam1)*factor);}}else if(inst.tweened===7){if(inst.enforce){this.inst.x=inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor;}else{this.inst.x+=((inst.targetparam1-inst.initialparam1)*factor)-inst.lastKnownValue;inst.lastKnownValue=((inst.targetparam1-inst.initialparam1)*factor);}}else if(inst.tweened===8){if(inst.enforce){this.inst.y=inst.initialparam2+(inst.targetparam2-inst.initialparam2)*factor;}else{this.inst.y+=((inst.targetparam2-inst.initialparam2)*factor)-inst.lastKnownValue2;inst.lastKnownValue2=((inst.targetparam2-inst.initialparam2)*factor);}}else if(inst.tweened===9){var scalex=inst.initialparam1+(inst.targetparam1-inst.initialparam1)*factor;var scaley=inst.initialparam2+(inst.targetparam2-inst.initialparam2)*factor;if(inst.enforce){this.inst.width=this.inst.curFrame.width*scalex;this.inst.height=this.inst.curFrame.height*scaley;}else{this.inst.width=scalex*(this.inst.width/(1+inst.lastKnownValue));this.inst.height=scaley*(this.inst.height/(1+inst.lastKnownValue2));inst.lastKnownValue=scalex-1;inst.lastKnownValue2=scaley-1;}}
this.inst.set_bbox_changed();}
behinstProto.tick=function()
{var dt=this.runtime.getDt(this.inst);var inst=this.tween_list["default"];if(inst.state!==0){if(inst.onStart){this.runtime.trigger(cr.behaviors.lunarray_LiteTween.prototype.cnds.OnStart,this.inst);inst.onStart=false;}
if(inst.onReverseStart){this.runtime.trigger(cr.behaviors.lunarray_LiteTween.prototype.cnds.OnReverseStart,this.inst);inst.onReverseStart=false;}
this.active=(inst.state==1)||(inst.state==2)||(inst.state==4)||(inst.state==5)||(inst.state==6);var factor=inst.OnTick(dt);this.updateTween(inst,factor);if(inst.onEnd){this.runtime.trigger(cr.behaviors.lunarray_LiteTween.prototype.cnds.OnEnd,this.inst);inst.onEnd=false;}
if(inst.onReverseEnd){this.runtime.trigger(cr.behaviors.lunarray_LiteTween.prototype.cnds.OnReverseEnd,this.inst);inst.onReverseEnd=false;}}};behaviorProto.cnds={};var cnds=behaviorProto.cnds;cnds.IsActive=function()
{return(this.tween_list["default"].state!==0);};cnds.CompareProgress=function(cmp,v)
{var inst=this.tween_list["default"];return cr.do_cmp((inst.progress/inst.duration),cmp,v);};cnds.OnStart=function()
{if(this.tween_list["default"]===undefined)
return false;return this.tween_list["default"].onStart;};cnds.OnReverseStart=function()
{if(this.tween_list["default"]===undefined)
return false;return this.tween_list["default"].onReverseStart;};cnds.OnEnd=function()
{if(this.tween_list["default"]===undefined)
return false;return this.tween_list["default"].onEnd;};cnds.OnReverseEnd=function()
{if(this.tween_list["default"]===undefined)
return false;return this.tween_list["default"].onReverseEnd;};behaviorProto.acts={};var acts=behaviorProto.acts;acts.Start=function(startmode)
{this.startTween(startmode);};acts.Stop=function(stopmode)
{this.stopTween(stopmode);};acts.Reverse=function(revMode)
{this.reverseTween(revMode);};acts.ProgressTo=function(progress)
{this.setProgressTo(progress);};acts.SetDuration=function(x)
{if(isNaN(x))return;if(x<0)return;if(this.tween_list["default"]===undefined)return;this.tween_list["default"].duration=x;};acts.SetEnforce=function(x)
{if(this.tween_list["default"]===undefined)return;this.tween_list["default"].enforce=(x===1);};acts.SetInitial=function(x)
{if(this.tween_list["default"]===undefined)return;var init=this.parseCurrent(this.tween_list["default"].tweened,x);this.tween_list["default"].setInitial(init);};acts.SetTarget=function(targettype,absrel,x)
{if(this.tween_list["default"]===undefined)return;if(isNaN(x))return;var parsed=x+"";var inst=this.tween_list["default"];this.targetmode=absrel;if(absrel===1){switch(targettype){case 0:parsed=(this.inst.x+x)+","+inst.targetparam2;break;case 1:parsed=inst.targetparam1+","+(this.inst.y+x);break;case 2:parsed=""+cr.to_degrees(this.inst.angle+cr.to_radians(x));break;case 3:parsed=""+(this.inst.opacity*100)+x;break;case 4:parsed=(this.inst.width+x)+","+inst.targetparam2;break;case 5:parsed=inst.targetparam1+","+(this.inst.height+x);break;case 6:parsed=x+","+x;break;default:break;}}else{switch(targettype){case 0:parsed=x+","+inst.targetparam2;break;case 1:parsed=inst.targetparam1+","+x;break;case 2:parsed=x+","+x;break;case 3:parsed=x+","+x;break;case 4:parsed=x+","+inst.targetparam2;break;case 5:parsed=inst.targetparam1+","+x;break;case 6:parsed=x+","+x;break;default:break;}}
var init=this.parseCurrent(this.tween_list["default"].tweened,"current");var targ=this.parseCurrent(this.tween_list["default"].tweened,parsed);inst.setInitial(init);inst.setTarget(targ);};acts.SetTweenedProperty=function(x)
{if(this.tween_list["default"]===undefined)return;this.tween_list["default"].tweened=x;};acts.SetEasing=function(x)
{if(this.tween_list["default"]===undefined)return;this.tween_list["default"].easefunc=x;};acts.SetValue=function(x)
{var inst=this.tween_list["default"];this.value=x;if(inst.tweened===6)
inst.setInitial(this.parseCurrent(inst.tweened,"current"));};acts.SetParameter=function(tweened,easefunction,target,duration,enforce)
{if(this.tween_list["default"]===undefined){this.addToTweenList("default",tweened,easefunction,initial,target,duration,enforce);}else{var inst=this.tween_list["default"];inst.tweened=tweened;inst.easefunc=easefunction;inst.setInitial(this.parseCurrent(tweened,"current"));inst.setTarget(this.parseCurrent(tweened,target));inst.duration=duration;inst.enforce=(enforce===1);}};behaviorProto.exps={};var exps=behaviorProto.exps;exps.Progress=function(ret)
{var progress=this.tween_list["default"].progress/this.tween_list["default"].duration;ret.set_float(progress);};exps.Duration=function(ret)
{ret.set_float(this.tween_list["default"].duration);};exps.Target=function(ret)
{var inst=this.tween_list["default"];var parsed="N/A";switch(inst.tweened){case 0:parsed=inst.targetparam1;break;case 1:parsed=inst.targetparam2;break;case 2:parsed=inst.targetparam1;break;case 3:parsed=inst.targetparam1;break;case 4:parsed=inst.targetparam1;break;case 5:parsed=inst.targetparam2;break;case 6:parsed=inst.targetparam1;break;default:break;}
ret.set_float(parsed);};exps.Value=function(ret)
{var tval=this.value;ret.set_float(tval);};}());cr.getProjectModel=function(){return[null,"PreloaderScreen",[[cr.plugins_.Dictionary,false,false,false,false,false,false,false,false,false],[cr.plugins_.Function,true,false,false,false,false,false,false,false,false],[cr.plugins_.JSON,false,false,false,false,false,false,false,false,false],[cr.plugins_.Keyboard,true,false,false,false,false,false,false,false,false],[cr.plugins_.Audio,true,false,false,false,false,false,false,false,false],[cr.plugins_.Browser,true,false,false,false,false,false,false,false,false],[cr.plugins_.Rex_Nickname,true,false,false,false,false,false,false,false,false],[cr.plugins_.Sprite,false,true,true,true,true,true,true,true,false],[cr.plugins_.Spritefont2,false,true,true,true,true,true,true,true,true],[cr.plugins_.TiledBg,false,true,true,true,true,true,true,true,true],[cr.plugins_.Touch,true,false,false,false,false,false,false,false,false],[cr.plugins_.WebStorage,true,false,false,false,false,false,false,false,false]],[["t0",cr.plugins_.Spritefont2,false,[9714961281485797],0,0,["images/preloaderfont.png",1158,0],null,[],false,true,5613928274165753,[]],["t1",cr.plugins_.Spritefont2,false,[9714961281485797,8740403892708753],1,0,["images/mediumwhite.png",1158,0],null,[["Pin",cr.behaviors.Pin,2595455380070529]],false,false,4289563087884527,[]],["t2",cr.plugins_.Spritefont2,false,[9714961281485797],0,0,["images/smallwhite.png",783,0],null,[],false,false,245023928216869,[]],["t3",cr.plugins_.Spritefont2,false,[9714961281485797],0,0,["images/largewhite.png",1400,0],null,[],false,false,4771684592376578,[]],["t4",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8613722006203454,[["images/btnsoundmute-sheet0.png",888,0,0,93,84,1,0.516129,0.5,[],[-0.462366,-0.440476,-0.021505,-0.5,0.387097,-0.392857,0.462366,0,0.44086,0.452381,-0.021505,0.5,-0.462366,0.440476,-0.516129,0],0],["images/btnsoundmute-sheet1.png",888,0,0,93,84,1,0.505376,0.5,[],[-0.451613,-0.440476,-0.0107524,-0.5,0.39785,-0.392857,0.473119,0,0.451613,0.452381,-0.0107524,0.5,-0.451613,0.440476,-0.505376,0],0]]]],[],false,false,1223747399349943,[]],["t5",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4281433287220185,[["images/btnsoundunmute-sheet0.png",1248,0,0,93,84,1,0.516129,0.5,[],[-0.462366,-0.440476,-0.021505,-0.5,0.387097,-0.392857,0.462366,0,0.44086,0.452381,-0.021505,0.5,-0.462366,0.440476,-0.516129,0],0],["images/btnsoundunmute-sheet1.png",1248,0,0,93,84,1,0.505376,0.5,[],[-0.451613,-0.440476,-0.0107524,-0.5,0.39785,-0.392857,0.473119,0,0.451613,0.452381,-0.0107524,0.5,-0.451613,0.440476,-0.505376,0],0]]]],[],false,false,6348073276492111,[]],["t6",cr.plugins_.TiledBg,false,[],0,0,["images/rotatescreenbg.png",104,1],null,[],false,false,7438859030103262,[]],["t7",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,3307013689127087,[["images/pleaserotatescreensprite-sheet0.png",4477,0,0,300,300,1,0.5,0.5,[],[-0.47,-0.47,0,-0.49,0.463333,-0.463333,0.483333,0,0.443333,0.443333,0,0.476667,-0.47,0.47],0]]]],[],false,false,8391249008951693,[]],["t8",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4292713431978564,[["images/pausedlabel-sheet0.png",2050,0,0,266,95,1,0.5,0.505263,[],[-0.484962,-0.463158,0,0.326316,0.462406,-0.4,0.481203,0.442105,0,0.452632,-0.477444,0.431579],0]]]],[],false,false,3213259284027981,[]],["t9",cr.plugins_.Sprite,false,[],1,0,null,[["Default",5,false,1,0,false,6188936494224653,[["images/pausecurtain-sheet0.png",117,0,0,100,100,1,0.5,0.5,[],[],0]]]],[["Anchor",cr.behaviors.Anchor,3782774560922733]],false,false,6688922505369317,[]],["t10",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1214254706730251,[["images/btnpause-sheet0.png",763,0,0,84,86,1,0.5,0.5,[],[-0.452381,-0.453488,0,-0.5,0.464286,-0.465116,0.5,0,0.464286,0.465116,0,0.5,-0.440476,0.44186,-0.5,0],0],["images/btnpause-sheet1.png",763,0,0,84,86,1,0.5,0.5,[],[-0.452381,-0.453488,0,-0.5,0.464286,-0.465116,0.5,0,0.464286,0.465116,0,0.5,-0.440476,0.44186,-0.5,0],0]]]],[],false,false,5385429357801449,[]],["t11",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,807186389101536,[["images/util_centerobject_decoy-sheet0.png",168,0,0,250,250,1,0.5,0.5,[],[],3]]]],[],false,false,6801874694109801,[]],["t12",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,8910888783386258,[["images/util_animation_decoy-sheet0.png",5668,1,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,16,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,31,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,46,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,61,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,76,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,91,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,106,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,121,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,136,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,151,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,166,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,181,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,196,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,211,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,226,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,241,1,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,1,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,16,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,31,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,46,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,61,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,76,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,91,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,106,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,121,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,136,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,151,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,166,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,181,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,196,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,211,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,226,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,241,40,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,1,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,16,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,31,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,46,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,61,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,76,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,91,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,106,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,121,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,136,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,151,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,166,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,181,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,196,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,211,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,226,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,241,79,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,1,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,16,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,31,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,46,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,61,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,76,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,91,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,106,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,121,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,136,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,151,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,166,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,181,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,196,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,211,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,226,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,241,118,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,1,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,16,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,31,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,46,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,61,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,76,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,91,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,106,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,121,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,136,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,151,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,166,157,14,38,1,0.5,0.5,[],[],0],["images/util_animation_decoy-sheet0.png",5668,181,157,14,38,1,0.5,0.5,[],[],0]]]],[],false,false,3377947378233011,[]],["t13",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716],1,0,null,[["Default",5,false,1,0,false,9690868128632893,[["images/util_buttons_decoy-sheet0.png",13261,1,79,246,76,1,0.50813,0.5,[],[-0.402439,-0.157895,-0.00813007,-0.486842,0.487805,-0.486842,0.430894,0,0.390244,0.171053,-0.00813007,0.486842,-0.5,0.473684,-0.455285,0],0],["images/util_buttons_decoy-sheet0.png",13261,1,1,246,77,1,0.50813,0.506494,[],[-0.402439,-0.168831,-0.00813007,-0.493507,0.487805,-0.493507,0.430894,-0.0129875,0.390244,0.168831,-0.00813007,0.467533,-0.495935,0.454545,-0.455285,-0.0129875],0]]]],[["Anchor",cr.behaviors.Anchor,3791460156306353]],false,false,5320186984190545,[]],["t14",cr.plugins_.Sprite,false,[3674361129285071,4313779060058721,5154948893554254],0,0,null,[["Default",5,false,1,0,false,9225427450841236,[["images/util_centerobject_decoy-sheet0.png",168,0,0,250,250,1,0.5,0.5,[],[],3]]]],[],false,false,6722652205222937,[]],["t15",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7245327600921718,[["images/cover_logo-sheet0.png",4927,0,0,131,80,1,0.503817,0.5,[],[-0.473282,-0.45,-0.00763378,-0.4875,0.458015,-0.4375,0.480916,0,0.450381,0.425,-0.00763378,0.5,-0.465649,0.4375,-0.503817,0],0]]]],[],false,true,7492537799473597,[]],["t16",cr.plugins_.Sprite,false,[8739444328997736],3,0,null,[["Default",5,false,1,0,false,4410519625338145,[["images/flashscreen-sheet0.png",99,0,0,100,50,1,0.5,1,[],[],4]]]],[["Anchor",cr.behaviors.Anchor,3418881468305448],["LiteTweenOut",cr.behaviors.lunarray_LiteTween,1562730918128704],["LiteTweenIn",cr.behaviors.lunarray_LiteTween,3446002251069675]],false,false,6169403400942716,[]],["t17",cr.plugins_.Browser,false,[],0,0,null,null,[],false,false,2899195549151124,[],[]],["t18",cr.plugins_.Audio,false,[],0,0,null,null,[],false,false,6757747833358751,[],[0,0,1,1,600,600,10000,1,5000,1]],["t19",cr.plugins_.Keyboard,false,[],0,0,null,null,[],false,false,7662387439103809,[],[]],["t20",cr.plugins_.WebStorage,false,[],0,0,null,null,[],false,false,7509138865086223,[],[]],["t21",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7888962879334937,[["images/btnpause2-sheet0.png",5893,1,1,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0],["images/btnpause2-sheet0.png",5893,1,81,356,79,1,0.5,0.506329,[],[-0.485955,-0.443038,0,-0.468354,0.485955,-0.443038,0.5,-0.0126581,0.480337,0.405063,0,0.481013,-0.480337,0.405063,-0.494382,-0.0126581],0]]]],[],false,false,7151894326916676,[]],["t22",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,248675962443357,[["images/btnpause3-sheet0.png",6201,1,1,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0],["images/btnpause3-sheet0.png",6201,1,81,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0]]]],[],false,false,6213723355555477,[]],["t23",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2081545307040381,[["images/sprite10-sheet0.png",5138,0,0,204,228,1,0.5,0.5,[],[-0.431372,-0.438596,0,-0.469298,0.421569,-0.429825,0.338235,0,0.411765,0.421053,0,0.460526,-0.446078,0.451754,-0.495098,0],0]]]],[],false,false,8438694897074719,[]],["t24",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2670958527385689,[["images/sprite8-sheet0.png",1933,0,0,155,62,1,0.503226,0.516129,[],[-0.43871,-0.354839,-0.00645182,-0.370968,0.432258,-0.354839,0.496774,-0.016129,0.425806,0.306452,-0.43871,0.322581,-0.503226,-0.016129],0]]]],[],false,false,9778650060979566,[]],["t25",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5244849366783891,[["images/sprite9-sheet0.png",23224,0,0,321,247,1,0.501558,0.502024,[],[-0.46729,-0.45749,-0.00311565,-0.0809713,0.454828,-0.445344,0.482866,-0.00404829,0.448598,0.433199,-0.00311565,0.477733,-0.439252,0.417004,-0.0218067,-0.00404829],0]]]],[],false,false,3644088865516432,[]],["t26",cr.plugins_.Dictionary,false,[2778294440449733,5123590086345178,2533218197284081,2077296176545694],0,0,null,null,[],true,false,2734480879482589,[]],["t27",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2993048102240939,[["images/sprite13-sheet0.png",1255,0,0,193,78,1,0.502591,0.512821,[],[-0.476684,-0.448718,-0.00518167,-0.5,0.471502,-0.448718,0.487046,-0.0128205,0.46114,0.397435,-0.00518167,0.461538,-0.481865,0.435897,-0.502591,-0.0128205],0]]]],[],false,false,3990147634651597,[]],["t28",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5631930823926414,[["images/sprite16-sheet0.png",1526,0,0,193,78,1,0.502591,0.512821,[],[-0.466321,-0.423077,-0.00518167,-0.48718,0.476684,-0.461538,0.497409,-0.0128205,0.471502,0.423076,-0.00518167,0.474358,-0.476684,0.423076,-0.492228,-0.0128205],0]]]],[],false,false,2801327527308323,[]],["t29",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5603010668941636,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.522388,[],[-0.412903,-0.313433,0.406451,-0.313433,0.490322,-0.029851,0.425806,0.313433,-0.43871,0.328358,-0.503226,-0.029851],0]]]],[],false,false,832554881814654,[]],["t30",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1710505076955246,[["images/sprite19-sheet0.png",31794,0,0,440,296,1,0.502273,0.503378,[],[-0.338637,-0.260135,-0.00227273,-0.18581,0.415909,-0.381756,0.479545,-0.00337839,0.3,0.202703,-0.00227273,0.429054,-0.452273,0.422298,-0.393182,-0.00337839],0]]]],[],false,false,6496788527052898,[]],["t31",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7138132807727649,[["images/cover_btnplay-sheet0.png",6794,1,1,483,108,1,0.501035,0.509259,[],[-0.478261,-0.407407,-0.00207022,-0.453704,0.447205,-0.277778,0.494824,-0.00925928,0.393375,0.0185187,-0.00207022,0.416667,-0.476191,0.37963,-0.501035,-0.00925928],0],["images/cover_btnplay-sheet0.png",6794,1,110,483,108,1,0.505176,0.509259,[],[-0.482402,-0.407407,-0.00621101,-0.453704,0.443064,-0.277778,0.490683,-0.00925928,0.389234,0.0185187,-0.00621101,0.416667,-0.480331,0.37963,-0.505176,-0.00925928],0]]]],[],false,false,8462044956855535,[]],["t32",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5865970106949175,[["images/btnpause3-sheet0.png",6201,1,1,356,79,1,0.505618,0.506329,[],[-0.491573,-0.443038,-0.00561798,-0.468354,0.480337,-0.443038,0.494382,-0.0126581,0.474719,0.405063,-0.00561798,0.481013,-0.485955,0.405063,-0.5,-0.0126581],0],["images/btnpause3-sheet0.png",6201,1,81,356,79,1,0.505618,0.518987,[],[-0.491573,-0.455696,-0.00561798,-0.481013,0.480337,-0.455696,0.494382,-0.0253164,0.474719,0.392405,-0.00561798,0.468355,-0.485955,0.392405,-0.5,-0.0253164],0]]]],[],false,false,144567679413351,[]],["t33",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716],1,0,null,[["Default",5,false,1,0,false,2447385807263947,[["images/btncontinue-sheet0.png",6834,1,1,406,78,1,0.507389,0.5,[],[-0.44335,-0.166667,-0.00738919,-0.5,0.460591,-0.333333,0.41133,0.076923,-0.00738919,0.461538,-0.497537,0.448718,-0.477832,0],0],["images/btncontinue-sheet0.png",6834,1,80,406,78,1,0.507389,0.512821,[],[-0.44335,-0.179488,-0.00738919,-0.512821,0.460591,-0.346154,0.41133,0.0641025,-0.00738919,0.448717,-0.497537,0.435897,-0.477832,-0.0128205],0]]]],[["Anchor",cr.behaviors.Anchor,3642226237773181]],false,false,9796329092535467,[]],["t34",cr.plugins_.Sprite,false,[],1,0,null,[["Default",5,false,1,0,false,1822729743847035,[["images/sprite14-sheet0.png",1678,0,0,1020,600,1,0.5,0.5,[],[],1]]]],[["Anchor",cr.behaviors.Anchor,5741012112725984]],false,false,6513033064280945,[]],["t35",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8387028287530226,[["images/cover_title-sheet0.png",8431,0,0,308,304,1,0.5,0.503289,[],[-0.48052,-0.483553,0,-0.401315,0.386364,-0.388157,0.402597,-0.00328946,0.298701,0.292764,0,0.476974,-0.298701,0.292764,-0.457792,-0.00328946],0]]]],[],false,false,2738869731002585,[]],["t36",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1059545856278956,[["images/cover_scorepanel-sheet0.png",2026,0,0,384,77,1,0.5,0.506494,[],[-0.486979,-0.441558,0,-0.493507,0.479167,-0.402598,0.497396,-0.0129875,0.473958,0.363636,0,0.454545,-0.476563,0.376624,-0.497396,-0.0129875],0]]]],[],false,false,9338659696213177,[]],["t37",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7778105743811055,[["images/cover_highscore-sheet0.png",2839,0,0,266,63,1,0.5,0.507937,[],[-0.458647,-0.333334,0,-0.428571,0.447368,-0.285715,0.5,-0.0158736,0.473684,0.380952,0,0.444444,-0.477444,0.396825,-0.5,-0.0158736],0]]]],[],false,false,6134836344131816,[]],["t38",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8243056852094314,[["images/cover_btnplay2-sheet0.png",51407,1,1,400,150,1,0.5,0.5,[],[-0.480392,-0.446309,0,-0.479866,0.463235,-0.399329,0.490196,-0.00335601,0.463235,0.399329,0,0.473154,-0.458333,0.385906,-0.497549,-0.00335601],0],["images/cover_btnplay2-sheet0.png",51407,1,152,400,150,1,0.505,0.513333,[],[-0.485392,-0.459642,-0.005,-0.493199,0.458235,-0.412662,0.485196,-0.0166893,0.458235,0.385996,-0.005,0.459821,-0.463333,0.372573,-0.502549,-0.0166893],0]]]],[],false,false,4813953707161797,[]],["t39",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,223285165919488,[["images/btnpause3-sheet0.png",6201,1,1,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0],["images/btnpause3-sheet0.png",6201,1,81,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0]]]],[],false,false,7426159057785754,[]],["t40",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3036680869009507,[["images/levelselection_level_1-sheet0.png",5930,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_1-sheet0.png",5930,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,8544986194209668,[]],["t41",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,584632735931801,[["images/levelselection_level_2-sheet0.png",6138,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_2-sheet0.png",6138,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,9557349109033093,[]],["t42",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,465051925059644,[["images/levelselection_level_3-sheet0.png",6220,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_3-sheet0.png",6220,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,615613335915804,[]],["t43",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3980962924173743,[["images/levelselection_level_4-sheet0.png",5800,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_4-sheet0.png",5800,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,5155598762152839,[]],["t44",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2255254139846644,[["images/levelselection_level_5-sheet0.png",6130,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_5-sheet0.png",6130,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,6092286269727432,[]],["t45",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5086501934745095,[["images/levelselection_level_6-sheet0.png",6367,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_6-sheet0.png",6367,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,696819767511607,[]],["t46",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4981692387147596,[["images/levelselection_level_7-sheet0.png",6179,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_7-sheet0.png",6179,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,6262148727484239,[]],["t47",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4622616931599044,[["images/levelselection_level_8-sheet0.png",6506,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_8-sheet0.png",6506,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,1322941272738081,[]],["t48",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2008055665719057,[["images/levelselection_level_9-sheet0.png",6316,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_9-sheet0.png",6316,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,2794218078104283,[]],["t49",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,9354978111270673,[["images/levelselection_level_10-sheet0.png",6619,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_10-sheet0.png",6619,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,8955649674982739,[]],["t50",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,692151449121219,[["images/levelselection_level_11-sheet0.png",6645,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_11-sheet0.png",6645,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,7414175300376323,[]],["t51",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3791022812156791,[["images/levelselection_level_12-sheet0.png",6981,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_12-sheet0.png",6981,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,4059636184652096,[]],["t52",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1611544559926101,[["images/levelselection_level_13-sheet0.png",6852,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_13-sheet0.png",6852,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,1082529202384983,[]],["t53",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4471839867306153,[["images/levelselection_level_14-sheet0.png",6493,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_14-sheet0.png",6493,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,1791447853747512,[]],["t54",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,6874993057891492,[["images/levelselection_level_15-sheet0.png",6787,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_15-sheet0.png",6787,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,1988389248581421,[]],["t55",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1614149074758099,[["images/levelselection_level_16-sheet0.png",6951,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_16-sheet0.png",6951,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,5097664409136416,[]],["t56",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8557127860182935,[["images/levelselection_level_17-sheet0.png",6740,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_17-sheet0.png",6740,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,854423541577006,[]],["t57",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,6893367146296248,[["images/levelselection_level_18-sheet0.png",6995,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_18-sheet0.png",6995,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,200094184686714,[]],["t58",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8639816346401539,[["images/levelselection_level_19-sheet0.png",7104,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_19-sheet0.png",7104,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,3138336107327386,[]],["t59",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1754030583836547,[["images/levelselection_level_20-sheet0.png",6912,1,1,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0],["images/levelselection_level_20-sheet0.png",6912,1,107,132,105,1,0.507576,0.504762,[],[-0.454545,-0.438095,-0.00757575,-0.495238,0.409091,-0.4,0.484848,-0.00952393,0.431818,0.419048,-0.00757575,0.495238,-0.431818,0.4,-0.507576,-0.00952393],0]]]],[],false,false,7226950310411169,[]],["t60",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3661639346793317,[["images/btnugrades-sheet0.png",12498,1,1,297,112,1,0.508417,0.508929,[],[-0.484848,-0.446429,-0.0101015,-0.491071,0.457913,-0.419643,0.491583,-0.0089286,0.457913,0.401785,-0.0101015,0.491071,-0.468013,0.383928,-0.50505,-0.0089286],0],["images/btnugrades-sheet0.png",12498,1,114,297,112,1,0.508417,0.508929,[],[-0.484848,-0.446429,-0.0101015,-0.491071,0.457913,-0.419643,0.491583,-0.0089286,0.457913,0.401785,-0.0101015,0.491071,-0.468013,0.383928,-0.50505,-0.0089286],0]]]],[],false,false,1874620314913611,[]],["t61",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7337754502993468,[["images/btnlevels-sheet0.png",10535,1,1,265,100,1,0.509434,0.51,[],[-0.486792,-0.45,-0.011321,-0.5,0.456604,-0.42,0.490566,-0.00999999,0.456604,0.4,-0.011321,0.49,-0.467925,0.38,-0.50566,-0.00999999],0],["images/btnlevels-sheet0.png",10535,1,102,265,100,1,0.509434,0.51,[],[-0.486792,-0.45,-0.011321,-0.5,0.456604,-0.42,0.490566,-0.00999999,0.456604,0.4,-0.011321,0.49,-0.467925,0.38,-0.50566,-0.00999999],0]]]],[],false,false,2559650222515407,[]],["t62",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2846724944200724,[["images/btnupgrade_1-sheet0.png",9346,1,1,247,102,1,0.510121,0.509804,[],[-0.48583,-0.45098,-0.0121455,-0.5,0.453442,-0.421569,0.489879,-0.00980395,0.453442,0.401961,-0.0121455,0.490196,-0.465587,0.382353,-0.510121,-0.00980395],0],["images/btnupgrade_1-sheet0.png",9346,1,104,247,102,1,0.510121,0.509804,[],[-0.48583,-0.45098,-0.0121455,-0.5,0.453442,-0.421569,0.489879,-0.00980395,0.453442,0.401961,-0.0121455,0.490196,-0.465587,0.382353,-0.510121,-0.00980395],0]]]],[],false,false,250849469471208,[]],["t63",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5065823656743437,[["images/btnupgrade_1-sheet0.png",9346,1,1,247,102,1,0.510121,0.509804,[],[-0.48583,-0.45098,-0.0121455,-0.5,0.453442,-0.421569,0.489879,-0.00980395,0.453442,0.401961,-0.0121455,0.490196,-0.465587,0.382353,-0.510121,-0.00980395],0],["images/btnupgrade_1-sheet0.png",9346,1,104,247,102,1,0.510121,0.509804,[],[-0.48583,-0.45098,-0.0121455,-0.5,0.453442,-0.421569,0.489879,-0.00980395,0.453442,0.401961,-0.0121455,0.490196,-0.465587,0.382353,-0.510121,-0.00980395],0]]]],[],false,false,4066410845641105,[]],["t64",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3046851445017366,[["images/btnupgrade_1-sheet0.png",9346,1,1,247,102,1,0.510121,0.509804,[],[-0.48583,-0.45098,-0.0121455,-0.5,0.453442,-0.421569,0.489879,-0.00980395,0.453442,0.401961,-0.0121455,0.490196,-0.465587,0.382353,-0.510121,-0.00980395],0],["images/btnupgrade_1-sheet0.png",9346,1,104,247,102,1,0.510121,0.509804,[],[-0.48583,-0.45098,-0.0121455,-0.5,0.453442,-0.421569,0.489879,-0.00980395,0.453442,0.401961,-0.0121455,0.490196,-0.465587,0.382353,-0.510121,-0.00980395],0]]]],[],false,false,1291238565167945,[]],["t65",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4249463794017411,[["images/cover_btnmoregames3-sheet0.png",4262,1,1,248,79,1,0.504032,0.506329,[],[-0.483871,-0.443038,-0.00403225,-0.468354,0.479839,-0.455696,0.495968,-0.0126581,0.471774,0.417722,-0.00403225,0.481013,-0.479839,0.417722,-0.495968,-0.0126581],0],["images/cover_btnmoregames3-sheet0.png",4262,1,81,248,79,1,0.504032,0.518987,[],[-0.483871,-0.455696,-0.00403225,-0.481013,0.479839,-0.468354,0.495968,-0.0253164,0.471774,0.405064,-0.00403225,0.468355,-0.479839,0.405064,-0.495968,-0.0253164],0]]]],[],false,false,6127281389077622,[]],["t66",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1660372452609494,[["images/btnpause3-sheet0.png",6201,1,1,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0],["images/btnpause3-sheet0.png",6201,1,81,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0]]]],[],false,false,8158684563952824,[]],["t67",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3222346541757621,[["images/cover_btnmoregames5-sheet0.png",6860,1,1,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0],["images/cover_btnmoregames5-sheet0.png",6860,1,81,356,79,1,0.508427,0.506329,[],[-0.494382,-0.443038,-0.00842696,-0.468354,0.477528,-0.443038,0.491573,-0.0126581,0.47191,0.405063,-0.00842696,0.481013,-0.488764,0.405063,-0.502809,-0.0126581],0]]]],[],false,false,184574966017551,[]],["t68",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2525478675043962,[["images/btnunlockplane-sheet0.png",2957,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnunlockplane-sheet0.png",2957,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,6562129922409878,[]],["t69",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,6218008416184823,[["images/btnunlockplane-sheet0.png",2957,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnunlockplane-sheet0.png",2957,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,160810926722204,[]],["t70",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1689415142209533,[["images/btnunlockplane-sheet0.png",2957,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnunlockplane-sheet0.png",2957,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,5672850888468308,[]],["t71",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2513533681030641,[["images/btnunlockplane-sheet0.png",2957,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnunlockplane-sheet0.png",2957,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,3441824774835394,[]],["t72",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,264294052777941,[["images/btnunlockplane-sheet0.png",2957,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnunlockplane-sheet0.png",2957,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,334268849098812,[]],["t73",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8971507494968789,[["images/btnunlockplane-sheet0.png",2957,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnunlockplane-sheet0.png",2957,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,9438915040386786,[]],["t74",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,773116041554856,[["images/btnchoose_1-sheet0.png",3199,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnchoose_1-sheet0.png",3199,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,4695835693797508,[]],["t75",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,6793246745763196,[["images/btnchoose_1-sheet0.png",3199,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnchoose_1-sheet0.png",3199,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,6723152146383247,[]],["t76",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3919734684790628,[["images/btnchoose_1-sheet0.png",3199,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnchoose_1-sheet0.png",3199,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,5914245137930478,[]],["t77",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,462812047242106,[["images/btnchoose_1-sheet0.png",3199,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnchoose_1-sheet0.png",3199,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,3715268047235199,[]],["t78",cr.plugins_.Sprite,false,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716,3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,9921015164531047,[["images/btnchoose_1-sheet0.png",3199,1,1,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0],["images/btnchoose_1-sheet0.png",3199,1,64,144,62,1,0.506944,0.5,[],[-0.486111,-0.451613,-0.00694442,-0.467742,0.472223,-0.451613,0.493056,0,0.465278,0.435484,-0.00694442,0.483871,-0.479167,0.435484,-0.5,0],0]]]],[],false,false,1160710733768843,[]],["t79",cr.plugins_.Function,false,[],0,0,null,null,[],false,false,1236788108482981,[],[]],["t80",cr.plugins_.Touch,false,[],0,0,null,null,[],false,false,4630770957691812,[],[1]],["t81",cr.plugins_.Dictionary,false,[7672347243602926,5497935351671193],0,0,null,null,[],true,false,1057324368298158,[]],["t82",cr.plugins_.Dictionary,false,[8593974314687131,4274399378938448,4533139054493387,6050693622359569,466937185587631],0,0,null,null,[],true,false,7753786924575843,[]],["t83",cr.plugins_.Sprite,false,[4603661432638704,2764187202086331,1581123671887364,4697032625800116],0,0,null,[["Default",5,false,1,0,false,6223988076024034,[["images/sprite-sheet0.png",8139,0,0,94,79,1,0.5,0.506329,[],[-0.382979,-0.367088,0,-0.506329,0.361702,-0.341772,0.457447,-0.0126581,0.361702,0.329114,0,0.481013,-0.37234,0.341772,-0.5,-0.0126581],0]]]],[],false,false,6974820092094676,[]],["t84",cr.plugins_.Sprite,false,[4603661432638704,2764187202086331,1581123671887364,4697032625800116],0,0,null,[["Default",5,false,1,0,false,7953666643817611,[["images/sprite2-sheet0.png",7403,0,0,90,78,1,0.5,0.5,[],[-0.366667,-0.346154,0,-0.5,0.377778,-0.358974,0.5,0,0.377778,0.358974,0,0.5,-0.366667,0.346154,-0.5,0],0]]]],[],false,false,9651585013765913,[]],["t85",cr.plugins_.Sprite,false,[4603661432638704,2764187202086331,1581123671887364,4697032625800116],0,0,null,[["Default",5,false,1,0,false,9958838174316497,[["images/sprite3-sheet0.png",8121,0,0,95,78,1,0.505263,0.5,[],[-0.378947,-0.346154,-0.0105262,-0.5,0.357895,-0.333333,0.452632,0,0.347369,0.320513,-0.0105262,0.5,-0.378947,0.346154,-0.505263,0],0]]]],[],false,false,8184047183890061,[]],["t86",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,2705699821621893,[["images/donutbg-sheet0.png",598,0,0,112,94,1,0.5,0.5,[],[-0.366071,-0.340426,0,-0.5,0.375,-0.351064,0.5,0,0.383929,0.361702,0,0.5,-0.383929,0.361702,-0.5,0],0]]]],[],false,false,1864246410373179,[]],["t87",cr.plugins_.Dictionary,false,[],0,0,null,null,[],true,false,5530006079166831,[]],["t88",cr.plugins_.Rex_Nickname,false,[],0,0,null,null,[],false,false,3290010250192949,[],[]],["t89",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,9586200452615976,[["images/sprite4-sheet0.png",39456,0,0,407,497,1,0.501229,0.501006,[],[-0.248158,-0.293763,-0.0024575,-0.470825,0.329238,-0.362173,0.351351,-0.00201201,0.2629,0.305835,-0.0024575,0.354125,-0.312039,0.344064,-0.368551,-0.00201201],0]]]],[],false,false,4579086549052067,[]],["t90",cr.plugins_.Sprite,false,[],0,0,null,[["Default",15,true,1,0,false,7126119349459962,[["images/player1-sheet0.png",39270,1,1,107,97,1,0.504673,0.505155,[],[-0.261682,-0.237114,-0.00934589,-0.463917,0.214953,-0.195877,0.392523,-0.0103096,0.364486,0.350515,-0.00934589,0.412371,-0.280374,0.247422,-0.457944,-0.0103096],0],["images/player1-sheet0.png",39270,109,1,107,97,1,0.504673,0.505155,[],[],0],["images/player1-sheet0.png",39270,1,99,107,97,1,0.504673,0.505155,[],[],0],["images/player1-sheet0.png",39270,109,99,107,97,1,0.504673,0.505155,[],[],0]]]],[],false,false,4937064525131548,[]],["t91",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3491276472533461,[["images/barrier_right-sheet0.png",105,0,0,10,1000,1,0.5,0.5,[],[],1]]]],[],false,false,7164740788716075,[]],["t92",cr.plugins_.Sprite,false,[],1,0,null,[["Default",5,false,1,0,false,706742354473559,[["images/sprite7-sheet0.png",92,0,0,10,10,1,0.5,0.5,[],[],1]]]],[["Pin",cr.behaviors.Pin,8562402778495757]],false,false,4069211645125559,[]],["t93",cr.plugins_.Sprite,false,[],0,0,null,[["Default",20,true,1,0,false,7828796961371951,[["images/sprite5-sheet0.png",13116,1,1,50,69,1,0.5,0.507246,[],[-0.32,-0.376811,0,-0.449275,0.28,-0.347826,0.4,-0.0144924,0.18,0.26087,0,0.42029,-0.22,0.289855,-0.48,-0.0144924],0],["images/sprite5-sheet0.png",13116,52,1,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,103,1,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,154,1,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,205,1,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,1,71,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,52,71,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,103,71,50,69,1,0.5,0.507246,[],[],0],["images/sprite5-sheet0.png",13116,154,71,50,69,1,0.5,0.507246,[],[],0]]]],[],false,false,6111994392861881,[]],["t94",cr.plugins_.Sprite,false,[9988306626688898,9437832569001818,9078864713250516,5831809232646265,4511013556503246],0,0,null,[["Default",20,true,1,0,false,4112944713312364,[["images/cloud_1-sheet0.png",15107,1,1,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet0.png",15107,1,77,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet0.png",15107,1,153,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet1.png",9348,1,1,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet1.png",9348,1,77,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet1.png",9348,1,153,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet2.png",9703,1,1,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet2.png",9703,1,77,127,75,1,0.503937,0.506667,[],[],0],["images/cloud_1-sheet2.png",9703,1,153,127,75,1,0.503937,0.506667,[],[],0]]]],[],false,false,1767835945767894,[]],["t95",cr.plugins_.Sprite,false,[9202856530964154,3505427288371663,6727260944382472],0,0,null,[["Default",5,false,1,0,false,7047288827503097,[["images/sprite11-sheet0.png",92,0,0,10,10,1,0.5,0.5,[],[],1]]]],[],false,false,2985723301635882,[]],["t96",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,1056724981147048,[["images/barrier_right-sheet0.png",105,0,0,10,1000,1,0.5,0.5,[],[],1]]]],[],false,false,404319439368458,[]],["t97",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7124527287796028,[["images/barrier_right-sheet0.png",105,0,0,10,1000,1,0.5,0.5,[],[],1]]]],[],false,false,4546819910171849,[]],["t98",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,8831210207393775,[["images/barrier_right-sheet0.png",105,0,0,10,1000,1,0.5,0.5,[],[],1]]]],[],false,false,9587894001128226,[]],["t99",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,6372369941991841,[["images/sprite6-sheet0.png",6983,0,0,295,152,1,0.501695,0.5,[],[-0.328814,-0.164474,-0.00338992,-0.5,0.328813,-0.171053,0.359322,0,0.383051,0.276316,-0.00338992,0.480263,-0.149153,-0.184211,-0.162712,0],0]]]],[],false,false,9230018220594426,[]],["t100",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,9825393949867166,[["images/sprite8-sheet0.png",1933,0,0,155,62,1,0.503226,0.5,[],[-0.43871,-0.33871,-0.00645182,-0.354839,0.432258,-0.33871,0.496774,0,0.425806,0.322581,-0.43871,0.33871,-0.503226,0],0]]]],[],false,false,4781627506016852,[]],["t101",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,6470142081749702,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,1297305377888471,[]],["t102",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,5671934612896934,[["images/sprite17-sheet0.png",1008,0,0,107,48,1,0.504673,0.5,[],[-0.476635,-0.4375,-0.00934589,-0.458333,0.429906,-0.354167,0.485981,0,0.476635,0.458333,-0.46729,0.416667,-0.429906,0],0]]]],[],false,false,9453235703625187,[]],["t103",cr.plugins_.Sprite,false,[],0,0,null,[["Default",20,false,1,0,false,305271261377885,[["images/explosion-sheet0.png",6485,1,1,103,98,1,0.504854,0.5,[],[-0.106796,-0.081633,-0.00970837,-0.132653,0.0776696,-0.061224,0.116505,0,0.0873786,0.071429,-0.00970837,0.122449,-0.116504,0.091837,-0.155339,0],0],["images/explosion-sheet0.png",6485,105,1,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet0.png",6485,1,100,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet0.png",6485,105,100,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet1.png",19669,1,1,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet1.png",19669,105,1,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet1.png",19669,1,100,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet1.png",19669,105,100,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet2.png",20673,1,1,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet2.png",20673,105,1,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet2.png",20673,1,100,103,98,1,0.504854,0.5,[],[],0],["images/explosion-sheet2.png",20673,105,100,103,98,1,0.504854,0.5,[],[],0]]]],[],false,false,1960732743416156,[]],["t104",cr.plugins_.Sprite,false,[],0,0,null,[["Default",25,false,1,0,false,1227778715377941,[["images/smoke-sheet0.png",8518,1,1,36,35,1,0.5,0.514286,[],[-0.305556,-0.314286,0,-0.457143,0.361111,-0.371429,0.5,-0.0285718,0.361111,0.342857,0,0.428571,-0.333333,0.314285,-0.5,-0.0285718],0],["images/smoke-sheet0.png",8518,38,1,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,75,1,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,1,37,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,38,37,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,75,37,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,1,73,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,38,73,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet0.png",8518,75,73,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet1.png",411,1,1,36,35,1,0.5,0.514286,[],[],0],["images/smoke-sheet1.png",411,38,1,36,35,1,0.5,0.514286,[],[],0]]]],[],false,false,4820417230207774,[]],["t105",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,2158040043383228,[["images/sprite20-sheet0.png",1179,0,0,109,49,1,0.504587,0.510204,[],[-0.449541,-0.387755,-0.00917417,-0.489796,0.449541,-0.408163,0.495413,-0.0204081,0.458716,0.408163,-0.00917417,0.469388,-0.458716,0.387755,-0.504587,-0.0204081],0]]]],[],false,false,1686210312475444,[]],["t106",cr.plugins_.Sprite,false,[],0,0,null,[["Default",20,true,1,0,false,8888237469524092,[["images/warning-sheet0.png",5376,1,1,69,63,1,0.507246,0.507937,[],[-0.449275,-0.444444,-0.0144924,-0.507937,0.449276,-0.460318,0.376812,-0.0158736,0.26087,0.238095,-0.0144924,0.492063,-0.289855,0.253968,-0.405797,-0.0158736],0],["images/warning-sheet0.png",5376,71,1,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,141,1,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,1,65,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,71,65,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,141,65,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,1,129,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,71,129,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet0.png",5376,141,129,69,63,1,0.507246,0.507937,[],[],0],["images/warning-sheet1.png",863,0,0,69,63,1,0.507246,0.507937,[],[],0]]]],[],false,false,1047341843024091,[]],["t107",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,845355177422634,[["images/bgcloud_1-sheet0.png",1212,0,0,374,142,1,0.5,0.5,[],[-0.312834,-0.00704199,0,-0.478873,0.40107,-0.239437,0.489305,0,0.446524,0.359155,0,0.5,-0.5,0.5,-0.360963,0],0]]]],[],false,false,8844415168594758,[]],["t108",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,1525650602057138,[["images/bgcloud_2-sheet0.png",733,0,0,217,68,1,0.502304,0.5,[],[-0.304147,0.132353,-0.00460812,-0.294118,0.359447,-0.058824,0.419355,0,0.43318,0.294118,-0.00460812,0.5,-0.502304,0.5,-0.138249,0],0]]]],[],false,false,7979117437373233,[]],["t109",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,6541707196859419,[["images/bgcloud_3-sheet0.png",592,0,0,168,80,1,0.5,0.5,[],[-0.416667,-0.325,0,-0.2375,0.357143,-0.2,0.458333,0,0.47619,0.45,0,0.5,-0.446429,0.3875,-0.494048,0],0]]]],[],false,false,9047250901067805,[]],["t110",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,9424943189700517,[["images/bgcloud_4-sheet0.png",684,0,0,179,75,1,0.502793,0.506667,[],[-0.351955,-0.146667,-0.00558633,-0.426667,0.229051,0.133333,0.441341,-0.0133336,0.480447,0.453333,-0.00558633,0.493333,-0.47486,0.426666,-0.284916,-0.0133336],0]]]],[],false,false,8632079651557724,[]],["t111",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,2973985421956412,[["images/bgcloud_5-sheet0.png",1474,0,0,466,194,1,0.502146,0.505155,[],[-0.128755,0.391752,-0.00214595,-0.134021,0.39485,-0.257732,0.448498,-0.00515461,0.457081,0.396907,-0.00214595,0.479381,-0.465665,0.407216,-0.100858,-0.00515461],0]]]],[],false,false,1159019236165071,[]],["t112",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,7623018139521707,[["images/bgcloud_6-sheet0.png",581,0,0,211,60,1,0.50237,0.5,[],[-0.407583,-0.166667,-0.00473964,-0.383333,0.383886,-0.1,0.431279,0,0.49763,0.5,-0.50237,0.5,-0.464455,0],0]]]],[],false,false,6494582889876017,[]],["t113",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,678063892642277,[["images/bgcloud_7-sheet0.png",676,0,0,160,87,1,0.5,0.505747,[],[0,-0.448276,0.3,-0.137931,0.40625,-0.0114941,0.4125,0.333333,0,0.436782,-0.44375,0.390805,-0.4625,-0.0114941],0]]]],[],false,false,4133299150113802,[]],["t114",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,9284179695984402,[["images/bgcloud_8-sheet0.png",664,0,0,217,100,1,0.502304,0.51,[],[-0.40553,-0.3,-0.00460812,-0.45,0.354839,-0.2,0.493088,-0.00999999,0.437788,0.36,-0.00460812,0.49,-0.460829,0.4,-0.493088,-0.00999999],0]]]],[],false,false,4841897213954815,[]],["t115",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,3108898448805196,[["images/bgcloud_9-sheet0.png",823,0,0,293,113,1,0.501706,0.513274,[],[-0.3686,-0.168141,-0.00341249,-0.460177,0.433448,-0.345132,0.49488,-0.0176993,0.47099,0.41593,-0.00341249,0.486726,-0.498294,0.477876,-0.389078,-0.0176993],0]]]],[],false,false,409671189238989,[]],["t116",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,6963322979743205,[["images/bgcloud_10-sheet0.png",628,0,0,138,75,1,0.5,0.506667,[],[-0.376812,-0.28,0,-0.493333,0.275362,-0.0933337,0.355072,-0.0133336,0.5,0.493333,0,0.493333,-0.434783,0.373333,-0.485507,-0.0133336],0]]]],[],false,false,8285826057385178,[]],["t117",cr.plugins_.Sprite,false,[9988306626688898,9437832569001818,9078864713250516,5831809232646265,4511013556503246],0,0,null,[["Default",20,true,1,0,false,8650288445093115,[["images/cloud_2-sheet0.png",23376,1,1,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet0.png",23376,90,1,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet0.png",23376,1,75,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet0.png",23376,90,75,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet0.png",23376,1,149,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet0.png",23376,90,149,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet1.png",13008,1,1,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet1.png",13008,90,1,88,73,1,0.5,0.506849,[],[],0],["images/cloud_2-sheet1.png",13008,1,75,88,73,1,0.5,0.506849,[],[],0]]]],[],false,false,7849687344705877,[]],["t118",cr.plugins_.Sprite,false,[9705734196106096,3615383870469982],1,0,null,[["Default",5,false,1,0,false,9060494314818906,[["images/star-sheet0.png",4187,1,1,58,58,1,0.5,0.5,[],[-0.189655,-0.189655,0,-0.431035,0.206897,-0.206897,0.344828,0,0.37931,0.37931,0,0.293103,-0.258621,0.258621,-0.448276,0],0],["images/star-sheet0.png",4187,60,1,58,58,1,0.5,0.5,[],[],0],["images/star-sheet0.png",4187,1,60,58,58,1,0.5,0.5,[],[],0],["images/star-sheet0.png",4187,60,60,58,58,1,0.5,0.5,[],[],0],["images/star-sheet1.png",3343,1,1,58,58,1,0.5,0.5,[],[],0],["images/star-sheet1.png",3343,60,1,58,58,1,0.5,0.5,[],[],0],["images/star-sheet1.png",3343,1,60,58,58,1,0.5,0.5,[],[],0]]]],[["VerticalSine",cr.behaviors.Sin,5787141130783449]],false,false,8125671004815707,[]],["t119",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,253476805731959,[["images/tutorial-sheet0.png",2488,0,0,138,138,1,0.5,0.5,[],[-0.456522,-0.456522,0,-0.492754,0.449275,-0.449275,0.442029,0,0.369565,0.369565,0,0.492754,-0.369565,0.369565,-0.456522,0],0]]]],[],false,false,9650785001711022,[]],["t120",cr.plugins_.JSON,false,[],0,0,null,null,[],true,false,27871314808789,[]],["t121",cr.plugins_.Sprite,false,[],0,0,null,[["Default",15,true,1,0,false,9050793272986657,[["images/player2-sheet0.png",26568,1,1,100,84,1,0.5,0.5,[],[],0],["images/player2-sheet0.png",26568,102,1,100,84,1,0.5,0.5,[],[],0],["images/player2-sheet0.png",26568,1,86,100,84,1,0.5,0.5,[],[],0],["images/player2-sheet0.png",26568,102,86,100,84,1,0.5,0.5,[],[],0]]]],[],false,false,5589743541297258,[]],["t122",cr.plugins_.Sprite,false,[],0,0,null,[["Default",15,true,1,0,false,1908446746349673,[["images/player3-sheet0.png",30116,1,1,105,89,1,0.504762,0.505618,[],[],0],["images/player3-sheet0.png",30116,107,1,105,89,1,0.504762,0.505618,[],[],0],["images/player3-sheet0.png",30116,1,91,105,89,1,0.504762,0.505618,[],[],0],["images/player3-sheet0.png",30116,107,91,105,89,1,0.504762,0.505618,[],[],0]]]],[],false,false,7353979043697382,[]],["t123",cr.plugins_.Sprite,false,[],0,0,null,[["Default",15,true,1,0,false,686908272721462,[["images/player4-sheet0.png",26906,1,1,100,84,1,0.5,0.5,[],[],0],["images/player4-sheet0.png",26906,102,1,100,84,1,0.5,0.5,[],[],0],["images/player4-sheet0.png",26906,1,86,100,84,1,0.5,0.5,[],[],0],["images/player4-sheet0.png",26906,102,86,100,84,1,0.5,0.5,[],[],0]]]],[],false,false,3488566441395278,[]],["t124",cr.plugins_.Sprite,false,[],0,0,null,[["Default",15,true,1,0,false,7496083082834432,[["images/player5-sheet0.png",36162,1,1,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,117,1,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,1,76,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,117,76,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,1,151,115,74,1,0.504348,0.5,[],[],0]]]],[],false,false,3597495393205249,[]],["t125",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,9258489861852709,[["images/sprite17-sheet0.png",1008,0,0,107,48,1,0.504673,0.5,[],[-0.476635,-0.4375,-0.00934589,-0.458333,0.429906,-0.354167,0.485981,0,0.476635,0.458333,-0.46729,0.416667,-0.429906,0],0]]]],[],false,false,5607694083838331,[]],["t126",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",15,true,1,0,false,3173335331994642,[["images/player2-sheet0.png",26568,1,1,100,84,1,0.5,0.5,[],[],0],["images/player2-sheet0.png",26568,102,86,100,84,1,0.5,0.5,[],[],0],["images/player2-sheet0.png",26568,1,86,100,84,1,0.5,0.5,[],[],0],["images/player2-sheet0.png",26568,102,86,100,84,1,0.5,0.5,[],[],0]]]],[],false,false,2343696828295921,[]],["t127",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",15,true,1,0,false,876687384339801,[["images/player3-sheet0.png",30116,1,1,105,89,1,0.504762,0.505618,[],[],0],["images/player3-sheet0.png",30116,107,91,105,89,1,0.504762,0.505618,[],[],0],["images/player3-sheet0.png",30116,1,91,105,89,1,0.504762,0.505618,[],[],0],["images/player3-sheet0.png",30116,107,91,105,89,1,0.504762,0.505618,[],[],0]]]],[],false,false,5479333605194151,[]],["t128",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",15,true,1,0,false,8574500569624304,[["images/player4-sheet0.png",26906,1,1,100,84,1,0.5,0.5,[],[],0],["images/player4-sheet0.png",26906,102,1,100,84,1,0.5,0.5,[],[],0],["images/player4-sheet0.png",26906,1,86,100,84,1,0.5,0.5,[],[],0],["images/player4-sheet0.png",26906,102,86,100,84,1,0.5,0.5,[],[],0]]]],[],false,false,153459666027902,[]],["t129",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",15,true,1,0,false,8427811196995244,[["images/player5-sheet0.png",36162,1,1,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,117,1,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,1,76,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,117,76,115,74,1,0.504348,0.5,[],[],0],["images/player5-sheet0.png",36162,1,151,115,74,1,0.504348,0.5,[],[],0]]]],[],false,false,2038078367369571,[]],["t130",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",15,true,1,0,false,6664567171395121,[["images/player1-sheet0.png",39270,1,1,107,97,1,0.504673,0.505155,[],[-0.261682,-0.237114,-0.00934589,-0.463917,0.214953,-0.195877,0.392523,-0.0103096,0.364486,0.350515,-0.00934589,0.412371,-0.280374,0.247422,-0.457944,-0.0103096],0],["images/player1-sheet0.png",39270,109,1,107,97,1,0.504673,0.505155,[],[],0],["images/player1-sheet0.png",39270,1,99,107,97,1,0.504673,0.505155,[],[],0],["images/player1-sheet0.png",39270,109,99,107,97,1,0.504673,0.505155,[],[],0]]]],[],false,false,192211886780129,[]],["t131",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,4934983216376255,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,137128255733219,[]],["t132",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,2471901471697996,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,7061628691969608,[]],["t133",cr.plugins_.Sprite,false,[],0,0,null,[["Default",5,false,1,0,false,424226998029392,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,260459413563276,[]],["t134",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,5934303196187786,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,8951908631846071,[]],["t135",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,9835138053652573,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,5802109462429963,[]],["t136",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,7308211652384361,[["images/sprite18-sheet0.png",2219,0,0,155,67,1,0.503226,0.507463,[],[-0.412903,-0.298508,0.406451,-0.298508,0.490322,-0.0149257,0.425806,0.328358,-0.43871,0.343283,-0.503226,-0.0149257],0]]]],[],false,false,8422120815759567,[]],["t137",cr.plugins_.Sprite,false,[],1,0,null,[["Default",5,false,1,0,false,73910969885196,[["images/currentmarker-sheet0.png",2371,0,0,174,104,1,0.5,0.5,[],[-0.45977,-0.432692,0,-0.490385,0.442529,-0.403846,0.45977,0,0,0.5,-0.494253,0],0]]]],[["Pin",cr.behaviors.Pin,841496582561547]],false,false,2723929307756218,[]],["t138",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,3559880010521308,[["images/cantafford_2-sheet0.png",1344,0,0,148,65,1,0.5,0.507692,[],[-0.47973,-0.461539,0,-0.476923,0.466216,-0.430769,0.472973,-0.0153843,0.445946,0.369231,0,0.43077,-0.466216,0.415385,-0.493243,-0.0153843],0]]]],[],false,false,8633446267461682,[]],["t139",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,9091716316018545,[["images/cantafford_2-sheet0.png",1344,0,0,148,65,1,0.5,0.507692,[],[-0.47973,-0.461539,0,-0.476923,0.466216,-0.430769,0.472973,-0.0153843,0.445946,0.369231,0,0.43077,-0.466216,0.415385,-0.493243,-0.0153843],0]]]],[],false,false,5290838521561962,[]],["t140",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,2776823396406553,[["images/cantafford_2-sheet0.png",1344,0,0,148,65,1,0.5,0.507692,[],[-0.47973,-0.461539,0,-0.476923,0.466216,-0.430769,0.472973,-0.0153843,0.445946,0.369231,0,0.43077,-0.466216,0.415385,-0.493243,-0.0153843],0]]]],[],false,false,3785580238635254,[]],["t141",cr.plugins_.Sprite,false,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],0,0,null,[["Default",5,false,1,0,false,6817993665082206,[["images/cantafford_2-sheet0.png",1344,0,0,148,65,1,0.5,0.507692,[],[-0.47973,-0.461539,0,-0.476923,0.466216,-0.430769,0.472973,-0.0153843,0.445946,0.369231,0,0.43077,-0.466216,0.415385,-0.493243,-0.0153843],0]]]],[],false,false,3027854085818517,[]],["t142",cr.plugins_.Sprite,true,[9202822253816884,7215559115446081,5727133561223713,7600745407467351,2704670672347368,9830143538308716],0,0,null,null,[],false,false,2298337239809099,[]],["t143",cr.plugins_.Sprite,true,[3424750628396449,8186917311232831,4056528128998139,5008687766888514,7326230885008049,6199618871820906,8343141118149926,7909766330260861,6798752063292545],2,0,null,null,[["TweenIn",cr.behaviors.lunarray_LiteTween,6734825355694775],["TweenOut",cr.behaviors.lunarray_LiteTween,843200696012745]],false,false,3127975835470516,[]],["t144",cr.plugins_.Spritefont2,true,[9714961281485797],0,0,null,null,[],false,false,6126330058012022,[]],["t145",cr.plugins_.Sprite,true,[],0,0,null,null,[],false,false,2230796142280988,[]],["t146",cr.plugins_.Sprite,true,[3674361129285071,4313779060058721,5154948893554254],0,0,null,null,[],false,false,661990604994063,[]],["t147",cr.plugins_.Spritefont2,true,[],0,0,null,null,[],false,false,5783048666266202,[]],["t148",cr.plugins_.Sprite,true,[4603661432638704,2764187202086331,1581123671887364,4697032625800116],1,0,null,null,[["MoveTo",cr.behaviors.Rex_MoveTo,9368141896177171]],false,false,9573847540582974,[]],["t149",cr.plugins_.Sprite,true,[9988306626688898,9437832569001818,9078864713250516,5831809232646265,4511013556503246],0,0,null,null,[],false,false,2771431975454813,[]],["t150",cr.plugins_.Sprite,true,[],0,0,null,null,[],false,false,5292479701620556,[]],["t151",cr.plugins_.Sprite,true,[],0,0,null,null,[],false,false,4677846668475262,[]]],[[142,74,75,76,77,78,33,61,10,21,22,4,5,60,68,69,70,71,72,73,62,63,64,32,39,65,66,67,31,38,40,49,50,51,52,53,54,55,56,57,58,41,59,42,43,44,45,46,47,48,13],[143,97,96,91,98,74,75,76,77,78,61,10,21,22,4,5,60,68,69,70,71,72,73,62,63,64,138,139,140,141,32,39,65,66,67,31,38,37,15,36,35,40,49,50,51,52,53,54,55,56,57,58,41,59,42,43,44,45,46,47,48,8,130,126,127,128,129,131,134,135,136,125,23,27,28,29,30,99,24,25,11],[144,3,1,0,2],[145,12],[146,14],[147,3,1,0,2],[148,83,84,85],[149,94,117],[150,107,116,108,109,110,111,112,113,114,115],[151,90,121,122,123,124]],[["PreloaderScreen",1003,590,true,"PreloaderSheet",239069000006803,[["Layer 0",0,1970971971653387,true,[0,51,103],false,1,1,1,false,1,0,0,[[[350,254,0,290,55,0,0,1,0,0,0,0,[]],0,27,[[""]],[],[20,27,"1234567890%","1",1,0,1,1,0,0,0,0]],[[489,367,0,131,80,0,0,1,0.503817,0.5,0,0,[]],15,69,[[1],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]]],[[null,81,49,[["onShowLayer"],["onHideLayer"]],[],[]],[null,82,66,[[-1],[-1],[-1],[1],["TommyThePilot"]],[],[]],[null,26,30,[[15],[16],[17],[18]],[],[]],[null,87,14,[],[],[]],[null,120,135,[],[],[]]],[]],["GameplayScreen",1003,590,true,"GameplaySheet",5757841340989451,[["Layer 0",0,3260714125193635,true,[255,255,255],false,0,0,1,false,1,0,0,[[[498,294,0,1020,600,0,0,1,0.5,0.5,0,0,[]],34,5,[],[[0,0,1,1,1]],[0,"Default",0,1]]],[]],["Layer 1",1,1565056696323973,true,[255,255,255],true,1,1,1,false,1,0,0,[[[160.357,168.32,0,374,142,0,0,1,0.5,0.5,0,0,[]],107,101,[],[],[0,"Default",0,1]],[[498.655,172.759,0,217,68,0,0,1,0.502304,0.5,0,0,[]],108,102,[],[],[0,"Default",0,1]],[[488.888,9.38364,0,168,80,0,0,1,0.5,0.5,0,0,[]],109,103,[],[],[0,"Default",0,1]],[[159.47,368.991,0,179,75,0,0,1,0.502793,0.506667,0,0,[]],110,104,[],[],[0,"Default",0,1]],[[776.572,584.754,0,466,194,0,0,1,0.502146,0.505155,0,0,[]],111,105,[],[],[0,"Default",0,1]],[[799.656,369.876,0,211,60,0,0,1,0.50237,0.5,0,0,[]],112,106,[],[],[0,"Default",0,1]],[[29.8365,579.426,0,160,87,0,0,1,0.5,0.505747,0,0,[]],113,107,[],[],[0,"Default",0,1]],[[359.252,581.202,0,217,100,0,0,1,0.502304,0.51,0,0,[]],114,108,[],[],[0,"Default",0,1]],[[825.407,187.854,0,293,113,0,0,1,0.501706,0.513274,0,0,[]],115,109,[],[],[0,"Default",0,1]],[[494.216,369.878,0,138,75,0,0,1,0.5,0.506667,0,0,[]],116,110,[],[],[0,"Default",0,1]],[[-294,-602,0,138,138,0,0,1,0.5,0.5,0,0,[]],119,123,[],[],[0,"Default",0,1]]],[]],["Layer 2",2,3410277526982711,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 3",3,1179508299948218,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 4",4,1261958742120508,true,[255,255,255],true,1,1,1,false,1,0,0,[[[622,-1,0,10,2295,0,1.5708,1,0.5,0.5,0,0,[]],98,38,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[1,"Default",0,1]]],[]],["Layer 5",5,9326386245967086,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 6",6,8531873117900306,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 7",7,3403046131553173,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 8",8,6091818384739041,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 9",9,897893871429904,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 10",10,6866799990339874,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 11",11,88663962588537,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 12",12,6536773748789747,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 13",13,3486055770734422,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 14",14,561884340406588,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 15",15,1271340789274667,false,[255,255,255],true,1,1,1,false,1,0,0,[[[518,201,0,302.595,232.838,0,0,1,0.501558,0.502024,0,0,[]],25,53,[[2],[2],[0],[0],[0],[""],["Top"],[0.7],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[525,492,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],21,54,[["onRestart"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],["Bottom"],[0.7],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[520,381,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],22,55,[["onMoreGames"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],["Bottom"],[0.85],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[-310,-252,0,204,228,0,0,1,0.5,0.5,0,0,[]],23,56,[[1],[3],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[89,102,0,107,48,0,0,1,0.504673,0.5,0,0,[]],125,154,[[1],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[1,"Default",0,1]]],[]],["Layer 16",16,4204343207883533,false,[255,255,255],true,1,1,1,false,1,0,0,[[[549,172,0,440,296,0,0,1,0.502273,0.503378,0,0,[]],30,92,[[2],[2],[0],[0],[0],[""],["Top"],[0.7],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[789,380,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],22,93,[["onMoreGames"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],["Right"],[0.85],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[526,490,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],21,94,[["onNextLevel"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],["Bottom"],[0.7],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[195,381,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],67,96,[["onBackToMain"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],["Left"],[0.85],[1]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 17",17,8912359349233249,true,[255,255,255],true,1,1,1,false,1,0,0,[[[1004,318,0,10,1000,0,0,1,0.5,0.5,0,0,[]],91,12,[[3],[3],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[1,"Default",0,1]],[[225,154,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,16,[[1],[1],[0]],[],[1,"Default",0,1]],[[225,229,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,17,[[1],[2],[0]],[],[1,"Default",0,1]],[[225,304,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,18,[[1],[3],[0]],[],[1,"Default",0,1]],[[225,379,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,19,[[1],[4],[0]],[],[1,"Default",0,1]],[[225,454,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,20,[[1],[5],[0]],[],[1,"Default",0,1]],[[225,529,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,25,[[1],[6],[0]],[],[1,"Default",0,1]],[[355,154,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,21,[[2],[1],[0]],[],[1,"Default",0,1]],[[355,229,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,26,[[2],[2],[0]],[],[1,"Default",0,1]],[[355,304,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,31,[[2],[3],[0]],[],[1,"Default",0,1]],[[355,379,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,32,[[2],[4],[0]],[],[1,"Default",0,1]],[[355,454,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,36,[[2],[5],[0]],[],[1,"Default",0,1]],[[355,529,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,37,[[2],[6],[0]],[],[1,"Default",0,1]],[[485,154,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,39,[[3],[1],[0]],[],[1,"Default",0,1]],[[485,229,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,40,[[3],[2],[0]],[],[1,"Default",0,1]],[[485,304,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,45,[[3],[3],[0]],[],[1,"Default",0,1]],[[485,379,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,46,[[3],[4],[0]],[],[1,"Default",0,1]],[[485,454,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,47,[[3],[5],[0]],[],[1,"Default",0,1]],[[485,529,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,48,[[3],[6],[0]],[],[1,"Default",0,1]],[[615,154,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,57,[[4],[1],[0]],[],[1,"Default",0,1]],[[615,229,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,59,[[4],[2],[0]],[],[1,"Default",0,1]],[[615,304,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,60,[[4],[3],[0]],[],[1,"Default",0,1]],[[615,379,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,61,[[4],[4],[0]],[],[1,"Default",0,1]],[[615,454,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,62,[[4],[5],[0]],[],[1,"Default",0,1]],[[615,529,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,65,[[4],[6],[0]],[],[1,"Default",0,1]],[[745,154,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,67,[[5],[1],[0]],[],[1,"Default",0,1]],[[745,229,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,68,[[5],[2],[0]],[],[1,"Default",0,1]],[[745,304,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,73,[[5],[3],[0]],[],[1,"Default",0,1]],[[745,379,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,75,[[5],[4],[0]],[],[1,"Default",0,1]],[[745,454,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,76,[[5],[5],[0]],[],[1,"Default",0,1]],[[745,529,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,77,[[5],[6],[0]],[],[1,"Default",0,1]],[[875,154,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,78,[[6],[1],[0]],[],[1,"Default",0,1]],[[875,229,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,79,[[6],[2],[0]],[],[1,"Default",0,1]],[[875,304,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,80,[[6],[3],[0]],[],[1,"Default",0,1]],[[875,379,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,83,[[6],[4],[0]],[],[1,"Default",0,1]],[[875,454,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,84,[[6],[5],[0]],[],[1,"Default",0,1]],[[875,529,0,10,10,0,0,1,0.5,0.5,0,0,[]],95,85,[[6],[6],[0]],[],[1,"Default",0,1]],[[0,326,0,10,1000,0,0,1,0.5,0.5,0,0,[]],96,28,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[1,"Default",0,1]],[[532,590,0,10,1981,0,1.5708,1,0.5,0.5,0,0,[]],97,29,[[3],[3],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[1,"Default",0,1]]],[]],["Layer 18",18,9883759599486326,true,[255,255,255],true,1,1,1,false,1,0,0,[[[941,57,0,96.6832,87.4639,0,0,1,0.516129,0.5,0,0,[]],5,72,[[""],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[837,58,0,84,86,0,0,1,0.5,0.5,0,0,[]],10,70,[["onPause"],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[944,57,0,96.6832,87.4639,0,0,1,0.516129,0.5,0,0,[]],4,71,[[""],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[261,43,0,155,67,0,0,1,0.503226,0.522388,0,0,[]],29,91,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[87,43,0,155,62,0,0,1,0.503226,0.516129,0,0,[]],24,52,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[121,42,0,79.0766,28,0,0,1,0.5,0.5,0,0,[]],1,81,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,1,0,0,0]],[[298,45,0,79.0766,28,0,0,1,0.5,0.5,0,0,[]],1,122,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,1,0,0,0]],[[-732,-286,0,107,97,0,0,1,0.504673,0.505155,0,0,[]],90,11,[],[],[0,"Default",0,1]],[[-1005,-540,0,100,84,0,0,1,0.5,0.5,0,0,[]],121,166,[],[],[0,"Default",0,1]],[[-808,-600,0,105,89,0,0,1,0.504762,0.505618,0,0,[]],122,167,[],[],[0,"Default",0,1]],[[-856,-498,0,100,84,0,0,1,0.5,0.5,0,0,[]],123,168,[],[],[0,"Default",0,1]],[[-702,-643,0,115,74,0,0,1,0.504348,0.5,0,0,[]],124,169,[],[],[0,"Default",0,1]],[[66.7538,279.24,0,14.4783,14.4783,0,0,1,0.5,0.5,0,0,[]],92,13,[],[[]],[1,"Default",0,1]]],[]],["Layer 19",19,3305091300644772,false,[255,255,255],true,1,1,1,false,1,0,0,[[[504,293,0,1024,608,0,0,1,0.5,0.5,0,0,[]],9,58,[],[[0,0,1,1,1]],[0,"Default",0,1]],[[492,196,0,266,95,0,0,1,0.5,0.505263,0,0,[]],8,63,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[799,462,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],21,64,[["onUnpause"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[507,335,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],39,82,[["onMoreGames"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[245,464,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],67,95,[["onBackToMain"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 20",20,74772902588385,true,[255,255,255],true,1,1,1,false,1,0,0,[[[501,596,0,1011,601,0,0,1,0.5,1,0,0,[]],16,51,[[""]],[[0,0,1,1,1],[0,5,0,"100",0,0.7,1],[0,5,0,"0",0,0.1,1]],[1,"Default",0,1]]],[]]],[],[]],["MainScreen",1003,590,false,"MainScreenSheet",8143042809741539,[["Layer 0",0,6484780173933682,true,[255,255,255],false,1,1,1,false,1,0,0,[[[501,295,0,1020,600,0,0,1,0.5,0.5,0,0,[]],34,23,[],[[0,0,1,1,1]],[0,"Default",0,1]]],[]],["Layer 1",1,3756073900459116,true,[255,255,255],true,1,1,1,false,1,0,0,[[[180,114,0,374,142,0,0,1,0.5,0.5,0,0,[]],107,111,[],[],[0,"Default",0,1]],[[519,119,0,217,68,0,0,1,0.502304,0.5,0,0,[]],108,112,[],[],[0,"Default",0,1]],[[509,-45,0,168,80,0,0,1,0.5,0.5,0,0,[]],109,113,[],[],[0,"Default",0,1]],[[179,315,0,179,75,0,0,1,0.502793,0.506667,0,0,[]],110,114,[],[],[0,"Default",0,1]],[[797,531,0,466,194,0,0,1,0.502146,0.505155,0,0,[]],111,115,[],[],[0,"Default",0,1]],[[820,316,0,211,60,0,0,1,0.50237,0.5,0,0,[]],112,116,[],[],[0,"Default",0,1]],[[50,525,0,160,87,0,0,1,0.5,0.505747,0,0,[]],113,117,[],[],[0,"Default",0,1]],[[379,527,0,217,100,0,0,1,0.502304,0.51,0,0,[]],114,118,[],[],[0,"Default",0,1]],[[845,134,0,293,113,0,0,1,0.501706,0.513274,0,0,[]],115,119,[],[],[0,"Default",0,1]],[[514,316,0,138,75,0,0,1,0.5,0.506667,0,0,[]],116,120,[],[],[0,"Default",0,1]],[[154,412,0,407,497,0,0,1,0.501229,0.501006,0,0,[]],89,6,[],[],[0,"Default",0,1]],[[87.3894,96.6462,0,107,48,0,0,1,0.504673,0.5,0,0,[]],125,90,[[1],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 2",2,5057948148140254,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 3",3,4227181549285552,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 4",4,7626777269034614,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 5",5,134271773777909,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 6",6,1185140079555472,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 7",7,3548628580672147,true,[255,255,255],true,1,1,1,false,1,0,0,[[[509,177,0,308,304,0,0,1,0.5,0.503289,0,0,[]],35,41,[[2],[2],[0],[0],[0],[""],["Top"],[0.7],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 8",8,1176196453732024,true,[255,255,255],true,1,1,1,false,1,0,0,[[[721,391,0,483,108,0,0,1,0.501035,0.509259,0,0,[]],31,7,[["onGotoGameplay"],[0],[""],[0],[0],[0],[3],[3],[0],[0],[0],[""],["Bottom"],[0.7],[1]],[[0,0,17,"100,100",0,2.5,0],[0,5,23,"0",0,2.5,0]],[0,"Default",0,1]],[[538,509,0,356,79,0,0,1,0.505618,0.506329,0,0,[]],32,8,[[""],[0],[""],[0],[0],[0],[3],[3],[0],[0],[0],[""],["Bottom"],[0.85],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[833,225,0,295,152,0,0,1,0.501695,0.5,0,0,[]],99,86,[[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[86,37,0,155,62,0,0,1,0.503226,0.5,0,0,[]],100,87,[],[],[0,"Default",0,1]],[[250,32,0,155,67,0,0,1,0.503226,0.507463,0,0,[]],101,88,[],[],[0,"Default",0,1]],[[855,510,0,248,79,0,0,1,0.504032,0.506329,0,0,[]],65,89,[["onShowPlanes"],[0],[""],[0],[0],[0],[3],[3],[0],[0],[0],[""],["Bottom"],[0.85],[1]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 9",9,9302255715797256,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 10",10,14175710743292,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 11",11,2211695430234104,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 12",12,3295434323308595,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 13",13,8154126705288467,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 14",14,6993746270366453,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 15",15,7754953040250624,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 16",16,6395235542323266,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 17",17,6549452528700351,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 18",18,5576168525749163,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 19",19,6587274175455264,true,[255,255,255],true,1,1,1,false,1,0,0,[[[949,52,0,93,84,0,0,1,0.516129,0.5,0,0,[]],5,10,[[""],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[950,52,0,93,84,0,0,1,0.516129,0.5,0,0,[]],4,9,[[""],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[-344,-428,0,384,77,0,0,1,0.5,0.506494,0,0,[]],36,42,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[-393,-354,0,266,63,0,0,1,0.5,0.507937,0,0,[]],37,43,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[85,22,0,63,28,0,0,1,0,0,0,0,[]],1,44,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,0,0,0,0]],[[823,53,0,131,80,0,0,1,0.503817,0.5,0,0,[]],15,74,[[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[251.791,21.2483,0,63,28,0,0,1,0,0,0,0,[]],1,151,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,0,0,0,0]]],[]],["Layer 20",20,933635810356866,true,[255,255,255],true,1,1,1,false,1,0,0,[[[502.136,597.182,0,1011,601,0,0,1,0.5,1,0,0,[]],16,50,[[""]],[[0,0,1,1,1],[0,5,0,"100",0,0.7,1],[0,5,0,"0",0,0.3,1]],[1,"Default",0,1]]],[]]],[],[]],["PlanesShopScreen",1003,590,false,"PlanesShop",6508813205982273,[["Layer 0",0,9861972467769381,true,[255,255,255],false,1,1,1,false,1,0,0,[[[501,295,0,1020,600,0,0,1,0.5,0.5,0,0,[]],34,124,[],[[0,0,1,1,1]],[0,"Default",0,1]]],[]],["Layer 1",1,6000784220261307,true,[255,255,255],true,1,1,1,false,1,0,0,[[[180,114,0,374,142,0,0,1,0.5,0.5,0,0,[]],107,125,[],[],[0,"Default",0,1]],[[519,119,0,217,68,0,0,1,0.502304,0.5,0,0,[]],108,126,[],[],[0,"Default",0,1]],[[509,-45,0,168,80,0,0,1,0.5,0.5,0,0,[]],109,127,[],[],[0,"Default",0,1]],[[179,315,0,179,75,0,0,1,0.502793,0.506667,0,0,[]],110,128,[],[],[0,"Default",0,1]],[[797,531,0,466,194,0,0,1,0.502146,0.505155,0,0,[]],111,129,[],[],[0,"Default",0,1]],[[820,316,0,211,60,0,0,1,0.50237,0.5,0,0,[]],112,130,[],[],[0,"Default",0,1]],[[50,525,0,160,87,0,0,1,0.5,0.505747,0,0,[]],113,131,[],[],[0,"Default",0,1]],[[379,527,0,217,100,0,0,1,0.502304,0.51,0,0,[]],114,132,[],[],[0,"Default",0,1]],[[845,134,0,293,113,0,0,1,0.501706,0.513274,0,0,[]],115,133,[],[],[0,"Default",0,1]],[[514,316,0,138,75,0,0,1,0.5,0.506667,0,0,[]],116,134,[],[],[0,"Default",0,1]]],[]],["Layer 2",2,193757457320299,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 3",3,1158408632041689,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 4",4,3931511162185409,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 5",5,1842256675753217,true,[255,255,255],true,1,1,1,false,1,0,0,[[[189,542,0,356,79,0,0,1,0.508427,0.506329,0,0,[]],67,143,[["onBackToMain"],[0],[""],[0],[0],[0],[1],[3],[0],[0],[0],[""],["Left"],[0.85],[1]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[87,98,0,107,48,0,0,1,0.504673,0.5,0,0,[]],125,156,[[1],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[331,445,0,144,62,0,0,1,0.506944,0.5,0,0,[]],69,158,[["unlockPlane_2"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[511,446,0,144,62,0,0,1,0.506944,0.5,0,0,[]],70,159,[["unlockPlane_3"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[680,448,0,144,62,0,0,1,0.506944,0.5,0,0,[]],71,160,[["unlockPlane_4"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[850,448,0,144,62,0,0,1,0.506944,0.5,0,0,[]],72,161,[["unlockPlane_5"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[337,293,0,100,84,0,0,1,0.5,0.5,0,0,[]],126,157,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[509,294,0,105,89,0,0,1,0.504762,0.505618,0,0,[]],127,162,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[668,293,0,100,84,0,0,1,0.5,0.5,0,0,[]],128,163,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[836,293,0,115,74,0,0,1,0.504348,0.5,0,0,[]],129,164,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[181,297,0,107,97,0,0,1,0.504673,0.505155,0,0,[]],130,137,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[177,207,0,144,62,0,0,1,0.506944,0.5,0,0,[]],74,170,[["onSelected_1"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[337,207,0,144,62,0,0,1,0.506944,0.5,0,0,[]],75,171,[["onSelected_2"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[510,206,0,144,62,0,0,1,0.506944,0.5,0,0,[]],76,172,[["onSelected_3"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[674,205,0,144,62,0,0,1,0.506944,0.5,0,0,[]],77,173,[["onSelected_4"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[843,204,0,144,62,0,0,1,0.506944,0.5,0,0,[]],78,174,[["onSelected_5"],[0],[""],[0],[0],[0],[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,23,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[334,369,0,155,67,0,0,1,0.503226,0.507463,0,0,[]],131,175,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[508,370,0,155,67,0,0,1,0.503226,0.507463,0,0,[]],134,176,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[678,371,0,155,67,0,0,1,0.503226,0.507463,0,0,[]],135,177,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[849,372,0,155,67,0,0,1,0.503226,0.507463,0,0,[]],136,178,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[183,174,0,174,104,0,0,1,0.5,0.5,0,0,[]],137,179,[],[[]],[0,"Default",0,1]],[[333,359,0,72,28,0,0,1,0,0,0,0,[]],1,180,[[""],[""]],[[]],[20,27,"1234567890","10",1,0,0,0,0,0,0,0]],[[505,358,0,73,28,0,0,1,0,0,0,0,[]],1,181,[[""],[""]],[[]],[20,27,"1234567890","25",1,0,0,0,0,0,0,0]],[[673,359,0,75,28,0,0,1,0,0,0,0,[]],1,182,[[""],[""]],[[]],[20,27,"1234567890","50",1,0,0,0,0,0,0,0]],[[843,361,0,74,28,0,0,1,0,0,0,0,[]],1,183,[[""],[""]],[[]],[20,27,"1234567890","100",1,0,0,0,0,0,0,0]],[[333,447,0,148,65,0,0,1,0.5,0.507692,0,0,[]],138,184,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[512,448,0,148,65,0,0,1,0.5,0.507692,0,0,[]],139,185,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[681.194,450.211,0,148,65,0,0,1,0.5,0.507692,0,0,[]],140,186,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[851.265,450.211,0,148,65,0,0,1,0.5,0.507692,0,0,[]],141,187,[[2],[2],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 6",6,8135748632742906,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 7",7,8915018340257714,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 8",8,1816514712547665,true,[255,255,255],true,1,1,1,false,1,0,0,[[[86,37,0,155,62,0,0,1,0.503226,0.5,0,0,[]],100,140,[],[],[0,"Default",0,1]],[[250,32,0,155,67,0,0,1,0.503226,0.507463,0,0,[]],101,141,[],[],[0,"Default",0,1]]],[]],["Layer 9",9,1628783685665485,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 10",10,7230585468138898,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 11",11,790204609314629,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 12",12,3546090149714036,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 13",13,3564465493743238,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 14",14,6730976836697263,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 15",15,7564532524993831,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 16",16,7731306594211486,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 17",17,7336543378371561,true,[255,255,255],true,1,1,1,false,1,0,0,[],[]],["Layer 18",18,8028820476663756,true,[255,255,255],true,1,1,1,false,1,0,0,[[[86,22,0,63,28,0,0,1,0,0,0,0,[]],1,152,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,0,0,0,0]],[[252,20,0,63,28,0,0,1,0,0,0,0,[]],1,153,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,0,0,0,0]]],[]],["Layer 19",19,9912344360856113,true,[255,255,255],true,1,1,1,false,1,0,0,[[[949,52,0,93,84,0,0,1,0.516129,0.5,0,0,[]],5,144,[[""],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[950,52,0,93,84,0,0,1,0.516129,0.5,0,0,[]],4,145,[[""],[0],[""],[0],[0],[0],[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[-344,-428,0,384,77,0,0,1,0.5,0.506494,0,0,[]],36,146,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[-393,-354,0,266,63,0,0,1,0.5,0.507937,0,0,[]],37,147,[[1],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]],[[-393,-438,0,141,28,0,0,1,0,0,0,0,[]],1,148,[[""],[""]],[[]],[20,27,"1234567890","0",1,0,0,0,0,0,0,0]],[[823,53,0,131,80,0,0,1,0.503817,0.5,0,0,[]],15,149,[[3],[1],[0],[0],[0],[""],[""],[0],[0]],[[0,0,17,"100,100",0,2.5,0],[0,0,23,"100,100",0,2.5,0]],[0,"Default",0,1]]],[]],["Layer 20",20,2502126590423521,true,[255,255,255],true,1,1,1,false,1,0,0,[[[502.136,597.182,0,1011,601,0,0,1,0.5,1,0,0,[]],16,150,[[""]],[[0,0,1,1,1],[0,5,0,"100",0,0.7,1],[0,5,0,"0",0,0.3,1]],[1,"Default",0,1]]],[]]],[],[]],["Instancer",1280,1024,false,null,7658412089052483,[["Layer 0",0,6074600041116972,true,[255,255,255],false,1,1,1,false,1,0,0,[[[342,125,0,200,200,0,0,1,0,0,0,0,[]],6,34,[],[],[0,0]],[[437,231,0,300,300,0,0,1,0.5,0.5,0,0,[]],7,35,[],[],[0,"Default",0,1]],[[968.5,-130.5,0,50,69,0,0,1,0.5,0.507246,0,0,[]],93,22,[],[],[0,"Default",0,1]],[[801.5,-139.5,0,127,75,0,0,1,0.503937,0.506667,0,0,[]],94,24,[[0],[0],[0],[100],[200]],[],[0,"Default",0,1]],[[726,12,0,103,98,0,0,1,0.504854,0.5,0,0,[]],103,97,[],[],[0,"Default",0,1]],[[502,-53,0,36,35,0,0,1,0.5,0.514286,0,0,[]],104,98,[],[],[0,"Default",0,1]],[[172,-126,0,109,49,0,0,1,0.504587,0.510204,0,0,[]],105,99,[],[],[0,"Default",0,1]],[[297,-123,0,69,63,0,0,1,0.507246,0.507937,0,0,[]],106,100,[],[],[0,"Default",0,1]],[[1200,-2,0,88,73,0,0,1,0.5,0.506849,0,0,[]],117,121,[[0],[0],[0],[100],[200]],[],[0,"Default",0,1]],[[460,-234,0,58,58,0,0,1,0.5,0.5,0,0,[]],118,155,[[0],[0]],[[1,1,0,2,0,0,0,50,0]],[0,"Default",0,1]],[[1072,-175,0,100,84,0,0,1,0.5,0.5,0,0,[]],121,136,[],[],[0,"Default",0,1]],[[1486,-244,0,105,89,0,0,1,0.504762,0.505618,0,0,[]],122,138,[],[],[0,"Default",0,1]],[[1580,-94,0,100,84,0,0,1,0.5,0.5,0,0,[]],123,139,[],[],[0,"Default",0,1]],[[1502,103,0,115,74,0,0,1,0.504348,0.5,0,0,[]],124,142,[],[],[0,"Default",0,1]],[[1247,-330,0,107,97,0,0,1,0.504673,0.505155,0,0,[]],90,165,[],[],[0,"Default",0,1]]],[]]],[],[]]],[["MusicController",[[1,"MegaFix",0,0,false,false,9780861730006072,false],[1,"PlayOnce",0,0,false,false,9120620070673287,false],[1,"TotalTime",0,0,false,false,4027201263734677,false],[1,"MusicOneTime",0,1,false,false,8370758281785067,false],[1,"IsMusicPlaying",0,1,false,false,3240237187986753,false],[0,[true,"MusicPreloadBoot"],false,null,3559837774047644,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,3559837774047644,false,[[1,[2,"MusicPreloadBoot"]]]]],[],[[0,null,false,null,5172288518022758,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,9836048044738824,false]],[[18,cr.plugins_.Audio.prototype.acts.Preload,null,7863670896314803,false,[[2,["music",true]]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,4108681819318061,false,[[1,[2,"MusicPreloadBoot"]],[3,0]]]]]]],[0,[true,"MusicEvents"],false,null,1015856292660633,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,1015856292660633,false,[[1,[2,"MusicEvents"]]]]],[],[[0,null,false,null,1778603564791414,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,5799472845442197,false]],[[5,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7243795271871144,false,[[3,0]]],[4,cr.plugins_.Sprite.prototype.acts.SetVisible,null,4531063951489864,false,[[3,0]]],[-1,cr.system_object.prototype.acts.Wait,null,7205120435573824,false,[[0,[1,0.05]]]]],[[0,null,false,null,116548574437764,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8680473291514967,false,[[7,[23,"IsMusicPlaying"]],[8,0],[7,[0,1]]]]],[[4,cr.plugins_.Sprite.prototype.acts.SetVisible,null,9546014402722673,false,[[3,1]]]]],[0,null,false,null,7770717299984531,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,3275332348096946,false]],[[5,cr.plugins_.Sprite.prototype.acts.SetVisible,null,4986725667245735,false,[[3,1]]]]]]],[0,null,false,null,3063116807593378,[[4,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,6173873114804673,false,[[10,5],[8,0],[7,[0,1]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,2365564498264109,false]],[[4,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,5230797918938805,false,[[10,5],[7,[0,0]]]],[4,cr.plugins_.Sprite.prototype.acts.SetVisible,null,861296385442157,false,[[3,0]]],[5,cr.plugins_.Sprite.prototype.acts.SetVisible,null,2338060176103276,false,[[3,1]]],[18,cr.plugins_.Audio.prototype.acts.StopAll,null,6591572786624615,false],[-1,cr.system_object.prototype.acts.SetVar,null,2495781364481805,false,[[11,"IsMusicPlaying"],[7,[0,0]]]]]],[0,null,false,null,9612020505075185,[[5,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,165341229017099,false,[[10,5],[8,0],[7,[0,1]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,1320832780669232,false]],[[5,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,9994581397711005,false,[[10,5],[7,[0,0]]]],[4,cr.plugins_.Sprite.prototype.acts.SetVisible,null,4136988489398294,false,[[3,1]]],[5,cr.plugins_.Sprite.prototype.acts.SetVisible,null,2244214775772635,false,[[3,0]]],[-1,cr.system_object.prototype.acts.SetVar,null,9037787726443853,false,[[11,"IsMusicPlaying"],[7,[0,1]]]]],[[0,null,false,null,6327067879267764,[[18,cr.plugins_.Audio.prototype.cnds.PreloadsComplete,null,0,false,false,false,2909787864997333,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,4763786687393955,false,[[7,[23,"MusicOneTime"]],[8,0],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,1338791111905348,false,[[7,[23,"MegaFix"]],[8,0],[7,[0,1]]]],[18,cr.plugins_.Audio.prototype.cnds.IsTagPlaying,null,0,false,true,false,9110729904601459,false,[[1,[2,"theme"]]]]],[[18,cr.plugins_.Audio.prototype.acts.Play,null,7310269070667345,false,[[2,["music",true]],[3,1],[0,[0,0]],[1,[2,"theme"]]]]]]]]]],[0,null,false,null,1727419677842832,[[80,cr.plugins_.Touch.prototype.cnds.OnTouchEnd,null,1,false,false,false,6678583441536097,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8226493302712612,false,[[7,[23,"MusicOneTime"]],[8,0],[7,[0,1]]]]],[],[[0,null,false,null,4986628996600712,[[18,cr.plugins_.Audio.prototype.cnds.PreloadsComplete,null,0,false,false,false,7827835608180287,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,3518915585657762,false,[[11,"MusicOneTime"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,9535276305811433,false,[[1,[2,"MusicFix"]],[3,1]]]]]]],[0,[false,"MusicFix"],false,null,9092506990821482,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,9092506990821482,false,[[1,[2,"MusicFix"]]]]],[],[[0,null,false,null,505086058841821,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,9522603472140402,false]],[[-1,cr.system_object.prototype.acts.AddVar,null,1340027594804974,false,[[11,"TotalTime"],[7,[19,cr.system_object.prototype.exps.dt]]]],[18,cr.plugins_.Audio.prototype.acts.SetSilent,null,6406815000403673,false,[[3,0]]]],[[0,null,false,null,9360539834957328,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3076742391915648,false,[[7,[23,"PlayOnce"]],[8,0],[7,[0,0]]]]],[[18,cr.plugins_.Audio.prototype.acts.Play,null,7491378434383696,false,[[2,["music",true]],[3,1],[0,[0,0]],[1,[2,"theme"]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2549662988208807,false,[[11,"PlayOnce"],[7,[0,1]]]],[18,cr.plugins_.Audio.prototype.acts.SetSilent,null,3289533478026838,false,[[3,0]]]]],[0,null,false,null,7160660931407565,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,7304666533808941,false,[[7,[23,"TotalTime"]],[8,4],[7,[0,8]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8925351679146258,false,[[7,[23,"TotalTime"]],[8,2],[7,[0,9]]]]],[]],[0,null,false,null,1657464530204786,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8555908509639509,false,[[7,[23,"TotalTime"]],[8,4],[7,[0,9]]]]],[[18,cr.plugins_.Audio.prototype.acts.StopAll,null,5464697112366948,false],[18,cr.plugins_.Audio.prototype.acts.SetSilent,null,2187397697567767,false,[[3,1]]]],[[0,null,false,null,3684815393284801,[[4,cr.plugins_.Sprite.prototype.cnds.IsVisible,null,0,false,false,false,6726477091809894,false]],[[18,cr.plugins_.Audio.prototype.acts.Play,null,9768922059200443,false,[[2,["music",true]],[3,1],[0,[0,0]],[1,[2,"theme"]]]]]],[0,null,false,null,4308272965217956,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,5185010557861994,false]],[[-1,cr.system_object.prototype.acts.SetGroupActive,null,7685743757177154,false,[[1,[2,"MusicFix"]],[3,0]]],[-1,cr.system_object.prototype.acts.SetVar,null,2112257595481301,false,[[11,"MegaFix"],[7,[0,1]]]]]]]]]]]]]],["MiscUtils",[[1,"TweenType",1,"",false,false,4375868593957009,false],[0,[false,"UI_Commons"],false,null,6940735122546783,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,6940735122546783,false,[[1,[2,"UI_Commons"]]]]],[],[[1,"WasDistributed",0,0,true,false,1392057677874424,false],[1,"LeftX",0,0,true,false,5424100833567707,false],[1,"RightX",0,0,true,false,6941459769203465,false],[1,"TopY",0,0,true,false,3201687836764059,false],[1,"BottomY",0,0,true,false,8509098961263643,false],[0,null,true,null,764336265914947,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,1034955840493638,false,[[7,[19,cr.system_object.prototype.exps.viewportleft,[[0,0]]]],[8,1],[7,[23,"LeftX"]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3820544656117654,false,[[7,[19,cr.system_object.prototype.exps.viewportright,[[0,0]]]],[8,1],[7,[23,"RightX"]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3166442399694952,false,[[7,[19,cr.system_object.prototype.exps.viewportbottom,[[0,0]]]],[8,1],[7,[23,"BottomY"]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,5721993700265074,false,[[7,[19,cr.system_object.prototype.exps.viewporttop,[[0,0]]]],[8,1],[7,[23,"TopY"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,5224215654891561,false,[[11,"LeftX"],[7,[19,cr.system_object.prototype.exps.viewportleft,[[0,0]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,262633656860369,false,[[11,"RightX"],[7,[19,cr.system_object.prototype.exps.viewportright,[[0,0]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6847120741701721,false,[[11,"BottomY"],[7,[19,cr.system_object.prototype.exps.viewportbottom,[[0,0]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6667512036463542,false,[[11,"TopY"],[7,[19,cr.system_object.prototype.exps.viewporttop,[[0,0]]]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9906296473656886,false,[[1,[2,"onDistribute"]],[13,]]]]],[0,null,false,null,5454602916262354,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,8196861288212488,false,[[1,[2,"onDistribute"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,4242945107103978,false,[[11,"WasDistributed"],[7,[0,1]]]]],[[1,"OriginalWidth",0,1003,false,false,8990876576026555,false],[1,"OriginalHeight",0,590,false,false,405577850684903,false],[1,"origX",0,0,false,false,2855137902155359,false],[1,"origY",0,0,false,false,1194635483079483,false],[0,null,false,null,7995834558972182,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,6990183122899497,false,[[4,143]]]],[],[[1,"restartTweenIn",0,0,false,false,5199925292684265,false],[0,null,false,null,3705888722987756,[[143,cr.behaviors.lunarray_LiteTween.prototype.cnds.IsActive,"TweenIn",0,false,false,false,2392498308172203,false]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.Stop,"TweenIn",9682448539700145,false,[[3,1]]],[-1,cr.system_object.prototype.acts.SetVar,null,183623307850109,false,[[11,"restartTweenIn"],[7,[0,1]]]]]],[0,null,false,null,3531094596266508,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8260162169508048,false,[[10,4],[8,0],[7,[0,0]]]]],[[143,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,81877158098866,false,[[10,2],[7,[20,143,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[143,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,3986002573517667,false,[[10,3],[7,[20,143,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[143,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,8189821543792722,false,[[10,4],[7,[0,1]]]]]],[0,null,false,null,7233644285868743,[],[],[[0,null,false,null,6252465487619241,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,2262582452088908,false,[[10,0],[8,0],[7,[0,1]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6233595048925742,false,[[11,"origX"],[7,[21,143,false,null,2]]]],[143,cr.plugins_.Sprite.prototype.acts.SetX,null,9967260922950171,false,[[0,[4,[19,cr.system_object.prototype.exps.viewportleft,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]],[23,"origX"]]]]]]],[0,null,false,null,5917840148924632,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,235533853651567,false,[[10,0],[8,0],[7,[0,2]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,1662716176758829,false,[[11,"origX"],[7,[5,[21,143,false,null,2],[7,[23,"OriginalWidth"],[0,2]]]]]],[143,cr.plugins_.Sprite.prototype.acts.SetX,null,4379719742720072,false,[[0,[4,[4,[7,[5,[19,cr.system_object.prototype.exps.viewportright,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]],[19,cr.system_object.prototype.exps.viewportleft,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]],[0,2]],[23,"origX"]],[19,cr.system_object.prototype.exps.viewportleft,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]]]]]]],[0,null,false,null,5744365779574236,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,714329852416801,false,[[10,0],[8,0],[7,[0,3]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6309337894903883,false,[[11,"origX"],[7,[5,[21,143,false,null,2],[23,"OriginalWidth"]]]]],[143,cr.plugins_.Sprite.prototype.acts.SetX,null,6534754744760366,false,[[0,[4,[19,cr.system_object.prototype.exps.viewportright,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]],[23,"origX"]]]]]]],[0,null,false,null,8609339061880603,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8523506138649597,false,[[10,1],[8,0],[7,[0,1]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,9352098999489237,false,[[11,"origY"],[7,[21,143,false,null,3]]]],[143,cr.plugins_.Sprite.prototype.acts.SetY,null,4250878411895017,false,[[0,[4,[19,cr.system_object.prototype.exps.viewporttop,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]],[23,"origY"]]]]]]],[0,null,false,null,4089140077667673,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,2764011764548678,false,[[10,1],[8,0],[7,[0,2]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,9001869487699441,false,[[11,"origY"],[7,[5,[21,143,false,null,3],[7,[23,"OriginalHeight"],[0,2]]]]]],[143,cr.plugins_.Sprite.prototype.acts.SetY,null,1703443641877656,false,[[0,[4,[4,[7,[5,[19,cr.system_object.prototype.exps.viewportbottom,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]],[19,cr.system_object.prototype.exps.viewporttop,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]],[0,2]],[23,"origY"]],[19,cr.system_object.prototype.exps.viewporttop,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]]]]]]],[0,null,false,null,9014212977691171,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,4467150372958904,false,[[10,1],[8,0],[7,[0,3]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,4046683528779299,false,[[11,"origY"],[7,[5,[21,143,false,null,3],[23,"OriginalHeight"]]]]],[143,cr.plugins_.Sprite.prototype.acts.SetY,null,5007911776227429,false,[[0,[4,[19,cr.system_object.prototype.exps.viewportbottom,[[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]],[23,"origY"]]]]]]]]],[0,null,false,null,9311196808257985,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,9984109901694596,false,[[10,6],[8,0],[7,[2,"Left"]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"TweenIn",9900794246244235,false,[[3,0],[3,16],[1,[10,[10,[10,[2,""],[5,[20,143,cr.plugins_.Sprite.prototype.exps.X,false,null],[0,700]]],[2,","]],[20,143,cr.plugins_.Sprite.prototype.exps.Y,false,null]]],[0,[21,143,false,null,7]],[3,0]]]]],[0,null,false,null,5013098847819086,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,477520021522187,false,[[10,6],[8,0],[7,[2,"Right"]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"TweenIn",7632427268561465,false,[[3,0],[3,16],[1,[10,[10,[10,[2,""],[4,[20,143,cr.plugins_.Sprite.prototype.exps.X,false,null],[0,700]]],[2,","]],[20,143,cr.plugins_.Sprite.prototype.exps.Y,false,null]]],[0,[21,143,false,null,7]],[3,0]]]]],[0,null,false,null,1077800115154049,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,4943710614250846,false,[[10,6],[8,0],[7,[2,"Bottom"]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"TweenIn",3580600811260845,false,[[3,0],[3,16],[1,[10,[10,[10,[2,""],[20,143,cr.plugins_.Sprite.prototype.exps.X,false,null]],[2,","]],[4,[20,143,cr.plugins_.Sprite.prototype.exps.Y,false,null],[0,700]]]],[0,[21,143,false,null,7]],[3,0]]]]],[0,null,false,null,1408317376422617,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8379336253416612,false,[[10,6],[8,0],[7,[2,"Top"]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"TweenIn",8673244700820254,false,[[3,0],[3,16],[1,[10,[10,[10,[2,""],[20,143,cr.plugins_.Sprite.prototype.exps.X,false,null]],[2,","]],[5,[20,143,cr.plugins_.Sprite.prototype.exps.Y,false,null],[0,700]]]],[0,[21,143,false,null,7]],[3,0]]]]],[0,null,false,null,5159118034637736,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,2446334559023317,false,[[10,8],[8,0],[7,[0,1]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"TweenOut",2216713276656713,false,[[3,5],[3,0],[1,[2,"0"]],[0,[1,0.5]],[3,0]]]]],[0,null,false,null,9177768552690021,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,5734317682237638,false,[[7,[23,"restartTweenIn"]],[8,0],[7,[0,1]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,1389345769165036,false,[[11,"restartTweenIn"],[7,[0,0]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3751194335668997,false,[[1,[2,"TweenIn"]],[13,[7,[20,143,cr.plugins_.Sprite.prototype.exps.UID,false,null]]]]]]]]]]],[0,null,false,null,4675677243575572,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,2960075485627409,false,[[1,[2,"TweenLayerIn"]]]],[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,8051597906779093,false,[[4,143],[0,[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[],[[0,null,false,null,7325306175633239,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,8709573945139244,false,[[4,143]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9544050671488645,false,[[1,[2,"TweenIn"]],[13,[7,[20,143,cr.plugins_.Sprite.prototype.exps.UID,false,null]]]]]]]]],[0,null,false,null,6591129617924305,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,7879450205452408,false,[[1,[2,"TweenLayerOut"]]]],[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,2396960913412067,false,[[4,143],[0,[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[],[[0,null,false,null,7853346021351263,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,6483972014711949,false,[[4,143]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3633824516517326,false,[[1,[2,"TweenOut"]],[13,[7,[20,143,cr.plugins_.Sprite.prototype.exps.UID,false,null]]]]]]]]],[0,null,false,null,8931625854999748,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9205687983685813,false,[[1,[2,"TweenVisiblesIn"]]]]],[],[[0,null,false,null,2039093378920063,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,8272407552161631,false,[[4,143]]],[143,cr.plugins_.Sprite.prototype.cnds.IsVisible,null,0,false,false,false,4239727213103404,false],[-1,cr.system_object.prototype.cnds.LayerVisible,null,0,false,false,false,2080004447177167,false,[[5,[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2232811739854141,false,[[1,[2,"TweenIn"]],[13,[7,[20,143,cr.plugins_.Sprite.prototype.exps.UID,false,null]]]]]]]]],[0,null,false,null,7253695587231451,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9743864218061994,false,[[1,[2,"TweenVisiblesOut"]]]]],[],[[0,null,false,null,2727660716907068,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,5247516976024409,false,[[4,143]]],[143,cr.plugins_.Sprite.prototype.cnds.IsVisible,null,0,false,false,false,7408905396030404,false],[-1,cr.system_object.prototype.cnds.LayerVisible,null,0,false,false,false,2467624727541307,false,[[5,[20,143,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]]],[],[[0,null,false,null,8996690281141226,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,44124401648346,false,[[10,8],[8,0],[7,[0,1]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,7549165409366161,false,[[1,[2,"TweenOut"]],[13,[7,[20,143,cr.plugins_.Sprite.prototype.exps.UID,false,null]]]]]]]]]]],[0,null,false,null,8129886529844007,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,6481683570995031,false,[[1,[2,"TweenIn"]]]],[143,cr.plugins_.Sprite.prototype.cnds.PickByUID,null,0,false,false,true,1946714472031397,false,[[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[],[[0,null,false,null,1157976030399528,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,181806109046059,false,[[7,[23,"WasDistributed"]],[8,0],[7,[0,0]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,4654358925178974,false,[[1,[2,"onDistribute"]],[13,]]]]],[0,null,false,null,2214686929715537,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8892687609930322,false,[[10,7],[8,1],[7,[0,0]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.Start,"TweenIn",2554940997844177,false,[[3,0]]],[143,cr.behaviors.lunarray_LiteTween.prototype.acts.Reverse,"TweenIn",5250843320716724,false,[[3,1]]]]]]],[0,null,false,null,3299776233576498,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9954897751286158,false,[[1,[2,"TweenOut"]]]],[143,cr.plugins_.Sprite.prototype.cnds.PickByUID,null,0,false,false,true,862255028482107,false,[[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[],[[0,null,false,null,9966349537957723,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,1632706796262316,false,[[7,[23,"WasDistributed"]],[8,0],[7,[0,0]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,1476390460356688,false,[[1,[2,"onDistribute"]],[13,]]]]],[0,null,false,null,8196538973729604,[[143,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8568250321992477,false,[[10,8],[8,0],[7,[0,1]]]]],[[143,cr.behaviors.lunarray_LiteTween.prototype.acts.Stop,"TweenOut",1160252746849107,false,[[3,1]]],[143,cr.behaviors.lunarray_LiteTween.prototype.acts.Start,"TweenOut",5785190250211276,false,[[3,0]]]]]]],[0,null,false,null,7003230797247882,[[143,cr.behaviors.lunarray_LiteTween.prototype.cnds.OnEnd,"TweenOut",1,false,false,false,3679881369086133,false]],[[143,cr.plugins_.Sprite.prototype.acts.SetOpacity,null,2640599313356931,false,[[0,[0,0]]]],[143,cr.plugins_.Sprite.prototype.acts.SetVisible,null,5214058803185202,false,[[3,0]]]]],[0,null,false,null,5029378533113212,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,7052231614046546,false,[[1,[2,"FlashIn"]]]]],[[16,cr.plugins_.Sprite.prototype.acts.SetOpacity,null,7100903547915541,false,[[0,[0,80]]]],[16,cr.plugins_.Sprite.prototype.acts.SetVisible,null,9159036037094329,false,[[3,1]]],[16,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"LiteTweenIn",6467863294630371,false,[[3,5],[3,0],[1,[2,"0"]],[0,[1,0.25]],[3,1]]],[16,cr.behaviors.lunarray_LiteTween.prototype.acts.Start,"LiteTweenIn",2103968154569192,false,[[3,0]]]]],[0,null,false,null,2583010607241334,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,3155435372922769,false,[[1,[2,"FlashOut"]]]]],[[16,cr.plugins_.Sprite.prototype.acts.SetOpacity,null,9884417837211995,false,[[0,[0,0]]]],[16,cr.plugins_.Sprite.prototype.acts.SetVisible,null,1815580068961882,false,[[3,1]]],[16,cr.behaviors.lunarray_LiteTween.prototype.acts.SetParameter,"LiteTweenOut",7344502212019626,false,[[3,5],[3,0],[1,[2,"80"]],[0,[1,0.25]],[3,1]]],[16,cr.behaviors.lunarray_LiteTween.prototype.acts.Start,"LiteTweenOut",4178682309097972,false,[[3,0]]]]],[0,null,false,null,2320340794914741,[[-1,cr.system_object.prototype.cnds.OnLayoutEnd,null,1,false,false,false,8634508754071795,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,7186882543048986,false,[[11,"WasDistributed"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,7719829684806493,false,[[1,[2,"UI_Commons"]],[3,0]]]]]]],[0,[true,"UI_Buttons"],false,null,5476783922779376,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,5476783922779376,false,[[1,[2,"UI_Buttons"]]]]],[],[[0,null,false,null,1655902485801975,[[80,cr.plugins_.Touch.prototype.cnds.OnTouchEnd,null,1,false,false,false,9214870072876192,false],[-1,cr.system_object.prototype.cnds.PickAll,null,0,false,false,false,9192632602121321,false,[[4,142]]]],[[142,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,8725511832875207,false,[[0,[0,0]]]]],[[0,null,false,null,6260444103838512,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,6293794663025711,false,[[4,142]]]],[],[[0,null,false,null,4039262866765059,[[80,cr.plugins_.Touch.prototype.cnds.IsTouchingObject,null,0,false,false,false,1839467347439442,false,[[4,142]]],[142,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,6344094887367283,false,[[10,4],[8,0],[7,[0,1]]]]],[[142,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,431423261264543,false,[[10,4],[7,[0,0]]]],[142,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,4831162947952099,false,[[10,5],[7,[0,1]]]]],[[0,null,false,null,5556229528558143,[[142,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,7808115697977905,false,[[10,0],[8,1],[7,[2,""]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8014570598893449,false,[[1,[21,142,true,null,0]],[13,[7,[20,142,cr.plugins_.Sprite.prototype.exps.UID,false,null]]]]]]]]]]]]],[0,null,false,null,6502276516545211,[[80,cr.plugins_.Touch.prototype.cnds.OnTouchObject,null,1,false,false,false,3723378195879847,false,[[4,142]]]],[],[[0,null,false,null,9472264337674246,[[142,cr.plugins_.Sprite.prototype.cnds.IsVisible,null,0,false,false,false,6106070961966253,false],[142,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8479601855066985,false,[[10,1],[8,0],[7,[0,0]]]]],[],[[0,null,false,null,1911698028485326,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,404738069602264,false,[[4,142]]]],[],[[0,null,false,null,630294287258103,[[-1,cr.system_object.prototype.cnds.LayerVisible,null,0,false,false,false,3490377841841983,false,[[5,[20,142,cr.plugins_.Sprite.prototype.exps.LayerNumber,false,null]]]]],[[142,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,2851289666682766,false,[[0,[0,1]]]],[142,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,5648097205153596,false,[[10,4],[7,[0,1]]]],[142,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,7963681777787812,false,[[10,5],[7,[0,0]]]]]]]]]]]],[1,"registerOnce",0,0,true,false,9255277002971048,false],[0,null,false,null,8109889183735346,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,7660283291062184,false]],[],[[0,null,false,null,8828173713034298,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,7951533791536648,false,[[4,142]]]],[[142,cr.plugins_.Sprite.prototype.acts.StopAnim,null,9040109929455016,false],[142,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,5020923643774615,false,[[0,[0,0]]]],[142,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,579540137499674,false,[[10,4],[7,[0,0]]]]]]]],[0,null,false,null,8970992288600498,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,2113025923362102,false,[[1,[2,"onManualButtonsUpdate"]]]]],[],[[0,null,false,null,397229356210237,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,3359906078867169,false,[[4,142]]]],[[142,cr.plugins_.Sprite.prototype.acts.StopAnim,null,7498247820899757,false],[142,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,5593542068231111,false,[[0,[0,0]]]]]]]]]],[0,[true,"IPhoneFixer"],false,null,6231773886920434,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,6231773886920434,false,[[1,[2,"IPhoneFixer"]]]]],[],[[0,null,false,null,6441069166644278,[[17,cr.plugins_.Browser.prototype.cnds.OnResize,null,1,false,false,false,1179257333447376,false]],[],[[0,null,true,null,4157130397788334,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,373516333142671,false,[[7,[19,cr.system_object.prototype.exps.find,[[19,cr.system_object.prototype.exps.lowercase,[[20,17,cr.plugins_.Browser.prototype.exps.UserAgent,true,null]]],[2,"iphone"]]]],[8,4],[7,[0,-1]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,6851453892078938,false,[[7,[19,cr.system_object.prototype.exps.find,[[19,cr.system_object.prototype.exps.lowercase,[[20,17,cr.plugins_.Browser.prototype.exps.UserAgent,true,null]]],[2,"ipod"]]]],[8,4],[7,[0,-1]]]]],[],[[0,null,false,null,3536565016423008,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,1269614179239487,false,[[7,[19,cr.system_object.prototype.exps.windowwidth]],[8,4],[7,[19,cr.system_object.prototype.exps.windowheight]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,1077527961751684,false,[[7,[19,cr.system_object.prototype.exps.windowheight]],[8,4],[7,[0,290]]]]],[[-1,cr.system_object.prototype.acts.SetCanvasSize,null,7509557455323529,false,[[0,[19,cr.system_object.prototype.exps.windowwidth]],[0,[0,260]]]]]]]]]]]],[0,[true,"MathUtils"],false,null,2503256714478391,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,2503256714478391,false,[[1,[2,"MathUtils"]]]]],[],[[0,null,false,null,8907715541594496,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,85894853150371,false,[[1,[2,"approach"]]]]],[],[[1,"value",0,0,false,false,8930062962601832,false],[1,"target",0,0,false,false,5486113389673122,false],[1,"ammount",0,0,false,false,5299000010687617,false],[0,null,false,null,3346679741633869,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,3609371992666715,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,3787491305266391,false,[[11,"value"],[7,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9766833384319939,false,[[11,"target"],[7,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1172819290134835,false,[[11,"ammount"],[7,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,2]]]]]]]],[0,null,false,null,7123623310951694,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,2771215833054373,false,[[7,[23,"value"]],[8,2],[7,[5,[23,"target"],[23,"ammount"]]]]]],[[79,cr.plugins_.Function.prototype.acts.SetReturnValue,null,2542865539614324,false,[[7,[4,[23,"value"],[23,"ammount"]]]]]]],[0,null,false,null,7808315780934075,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,4424432997820781,false]],[],[[0,null,false,null,7712781731046532,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3734037128851128,false,[[7,[23,"value"]],[8,4],[7,[4,[23,"target"],[23,"ammount"]]]]]],[[79,cr.plugins_.Function.prototype.acts.SetReturnValue,null,5042894934999928,false,[[7,[5,[23,"value"],[23,"ammount"]]]]]]],[0,null,false,null,8677564625400979,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,170832251155785,false]],[[79,cr.plugins_.Function.prototype.acts.SetReturnValue,null,2325901017230148,false,[[7,[23,"target"]]]]]]]]]]]],[0,[true,"RotateToLandscape"],false,null,2358241832580295,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,2358241832580295,false,[[1,[2,"RotateToLandscape"]]]]],[],[[1,"PrevTimescale",0,1,true,false,3157044487961144,false],[0,null,false,null,3571087749617283,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,7754972862239385,false]],[],[[0,null,false,null,2142530356393616,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,6167602213328251,false,[[7,[20,17,cr.plugins_.Browser.prototype.exps.ExecJS,false,null,[[2,"window.innerHeight"]]]],[8,2],[7,[20,17,cr.plugins_.Browser.prototype.exps.ExecJS,false,null,[[2,"window.innerWidth"]]]]]]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,9379208756890492,false,[[10,2],[7,[0,1]]]]]],[0,null,false,null,1953020383052301,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,1105172545236931,false]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,169493668454379,false,[[10,2],[7,[0,0]]]]]]]],[0,null,false,null,1844880785695823,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,431666757068623,false]],[],[[0,null,false,null,7478640611145312,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,5363199773455633,false,[[7,[21,82,false,null,2]],[8,0],[7,[0,1]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,8311666082382223,false]],[[-1,cr.system_object.prototype.acts.SetTimescale,null,9726196838283899,false,[[0,[23,"PrevTimescale"]]]],[7,cr.plugins_.Sprite.prototype.acts.Destroy,null,5591328263104201,false],[6,cr.plugins_.TiledBg.prototype.acts.Destroy,null,5633695828907551,false]]],[0,null,false,null,834112126694037,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8258818812939226,false,[[7,[21,82,false,null,2]],[8,0],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,1711196329152139,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,810718917493252,false,[[11,"PrevTimescale"],[7,[19,cr.system_object.prototype.exps.timescale]]]],[-1,cr.system_object.prototype.acts.SetTimescale,null,9559700614644121,false,[[0,[0,0]]]],[-1,cr.system_object.prototype.acts.CreateObject,null,6981028839523105,false,[[4,6],[5,[0,20]],[0,[0,0]],[0,[0,-300]]]],[6,cr.plugins_.TiledBg.prototype.acts.SetWidth,null,1188647692684513,false,[[0,[0,2000]]]],[6,cr.plugins_.TiledBg.prototype.acts.SetHeight,null,582168701152639,false,[[0,[0,2000]]]],[-1,cr.system_object.prototype.acts.CreateObject,null,8637579987022075,false,[[4,7],[5,[0,20]],[0,[1,480]],[0,[1,320]]]]]]]]]],[0,[false,"RotateToPortrait"],false,null,8983321191124367,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,8983321191124367,false,[[1,[2,"RotateToPortrait"]]]]],[],[[1,"PrevTimescale",0,1,true,false,3157044487961144,false],[0,null,false,null,3571087749617283,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,7754972862239385,false]],[],[[0,null,false,null,2142530356393616,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,6167602213328251,false,[[7,[20,17,cr.plugins_.Browser.prototype.exps.ExecJS,false,null,[[2,"window.innerWidth"]]]],[8,2],[7,[20,17,cr.plugins_.Browser.prototype.exps.ExecJS,false,null,[[2,"window.innerHeight"]]]]]]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,9376276039670877,false,[[10,1],[7,[0,1]]]]]],[0,null,false,null,1953020383052301,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,1105172545236931,false]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,1373657525237816,false,[[10,1],[7,[0,0]]]]]]]],[0,null,false,null,1844880785695823,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,431666757068623,false]],[],[[0,null,false,null,7478640611145312,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,5363199773455633,false,[[7,[21,82,false,null,1]],[8,0],[7,[0,1]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,8311666082382223,false]],[[-1,cr.system_object.prototype.acts.SetTimescale,null,9726196838283899,false,[[0,[23,"PrevTimescale"]]]],[7,cr.plugins_.Sprite.prototype.acts.Destroy,null,5591328263104201,false],[6,cr.plugins_.TiledBg.prototype.acts.Destroy,null,5633695828907551,false]]],[0,null,false,null,834112126694037,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,501212246737606,false,[[7,[21,82,false,null,1]],[8,0],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,1711196329152139,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,810718917493252,false,[[11,"PrevTimescale"],[7,[19,cr.system_object.prototype.exps.timescale]]]],[-1,cr.system_object.prototype.acts.SetTimescale,null,9559700614644121,false,[[0,[0,0]]]],[-1,cr.system_object.prototype.acts.CreateObject,null,6981028839523105,false,[[4,6],[5,[0,20]],[0,[0,-1000]],[0,[0,0]]]],[6,cr.plugins_.TiledBg.prototype.acts.SetWidth,null,7341931674129133,false,[[0,[0,3000]]]],[6,cr.plugins_.TiledBg.prototype.acts.SetHeight,null,4310871043634265,false,[[0,[0,2000]]]],[-1,cr.system_object.prototype.acts.CreateObject,null,8637579987022075,false,[[4,7],[5,[0,20]],[0,[1,320]],[0,[1,480]]]]]]]]]],[0,[false,"MaxUnlockedLevel"],false,null,1395451542280305,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,1395451542280305,false,[[1,[2,"MaxUnlockedLevel"]]]]],[],[[0,null,false,null,5924710411248993,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,6942560351870761,false]],[],[[0,null,false,null,5230537538426125,[[20,cr.plugins_.WebStorage.prototype.cnds.LocalStorageExists,null,0,false,false,false,5625325112647459,false,[[1,[2,"REDNECKVSZOMBIES"]]]]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,2159532696359371,false,[[10,3],[7,[19,cr.system_object.prototype.exps["int"],[[20,20,cr.plugins_.WebStorage.prototype.exps.LocalValue,true,null,[[2,"REDNECKVSZOMBIES"]]]]]]]]]],[0,null,false,null,762178400968018,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,9215816455094054,false]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,474843279396695,false,[[10,3],[7,[0,1]]]],[20,cr.plugins_.WebStorage.prototype.acts.StoreLocal,null,5216748922823365,false,[[1,[2,"REDNECKVSZOMBIES"]],[7,[21,82,false,null,3]]]]]]]],[0,null,false,null,8672180626637733,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9250636800938585,false,[[1,[2,"saveMaxUnlockedLevel"]]]]],[[20,cr.plugins_.WebStorage.prototype.acts.StoreLocal,null,8306155286992815,false,[[1,[2,"REDNECKVSZOMBIES"]],[7,[21,82,false,null,3]]]]]]]],[0,[true,"Highscore"],false,null,497812991944818,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,497812991944818,false,[[1,[2,"Highscore"]]]]],[],[[0,null,false,null,5924710411248993,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,6942560351870761,false]],[],[[0,null,false,null,5230537538426125,[[20,cr.plugins_.WebStorage.prototype.cnds.LocalStorageExists,null,0,false,false,false,5625325112647459,false,[[1,[21,82,true,null,4]]]]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,9207607696136985,false,[[10,0],[7,[19,cr.system_object.prototype.exps["int"],[[20,20,cr.plugins_.WebStorage.prototype.exps.LocalValue,true,null,[[21,82,true,null,4]]]]]]]]]],[0,null,false,null,762178400968018,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,9215816455094054,false]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,5347850921407807,false,[[10,0],[7,[0,0]]]]]]]],[0,null,false,null,8672180626637733,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9250636800938585,false,[[1,[2,"saveHighscore"]]]]],[],[[0,null,false,null,5574483121861653,[[79,cr.plugins_.Function.prototype.cnds.CompareParam,null,0,false,false,false,8971320888874389,false,[[0,[0,0]],[8,4],[7,[21,82,false,null,0]]]]],[[82,cr.plugins_.Dictionary.prototype.acts.SetInstanceVar,null,1709049215719524,false,[[10,0],[7,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]]],[0,null,false,null,538373383532494,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3290009816180572,false,[[7,[21,82,false,null,0]],[8,4],[7,[19,cr.system_object.prototype.exps["int"],[[20,20,cr.plugins_.WebStorage.prototype.exps.LocalValue,true,null,[[21,82,true,null,4]]]]]]]]],[[20,cr.plugins_.WebStorage.prototype.acts.StoreLocal,null,8306155286992815,false,[[1,[21,82,true,null,4]],[7,[21,82,false,null,0]]]]]]]]]],[0,[true,"TextFieldHelper"],false,null,9188688417865319,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,9188688417865319,false,[[1,[2,"TextFieldHelper"]]]]],[],[[0,null,false,null,7319164907080489,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9367717223835623,false,[[1,[2,"onSetText"]]]]],[],[[0,null,false,null,4266341262918418,[[144,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,8272281436745767,false,[[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[[144,cr.plugins_.Spritefont2.prototype.acts.SetText,null,3206354250159003,false,[[7,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]]]]]],[0,null,false,null,9940882966519182,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5009966937953623,false,[[1,[2,"setText"]]]]],[],[[0,null,false,null,865935339342584,[[144,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,201366234106051,false,[[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[[144,cr.plugins_.Spritefont2.prototype.acts.SetText,null,5371342930079758,false,[[7,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]]]]]]]],[0,[true,"AnimationHelper"],false,null,5518338850140555,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,5518338850140555,false,[[1,[2,"AnimationHelper"]]]]],[],[[0,null,false,null,7319164907080489,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9367717223835623,false,[[1,[2,"onSetFrame"]]]]],[],[[0,null,false,null,4266341262918418,[[145,cr.plugins_.Sprite.prototype.cnds.PickByUID,null,0,false,false,true,982400253719967,false,[[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]]],[[145,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,5923505882004271,false,[[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]]]]]]]],[0,[true,"Bullets"],false,null,3324081152223832,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,3324081152223832,false,[[1,[2,"Bullets"]]]]],[],[[0,null,false,null,8292037234101844,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,9348820930273179,false],[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,8154827684027229,false,[[4,146]]]],[],[[0,null,false,null,1927455668895006,[[146,cr.plugins_.Sprite.prototype.cnds.IsBoolInstanceVarSet,null,0,false,false,false,1280750050276332,false,[[10,1]]]],[[146,cr.plugins_.Sprite.prototype.acts.SetX,null,8091298130552771,false,[[0,[4,[20,146,cr.plugins_.Sprite.prototype.exps.X,false,null],[6,[6,[21,146,false,null,2],[19,cr.system_object.prototype.exps.dt]],[19,cr.system_object.prototype.exps.cos,[[21,146,false,null,0]]]]]]]],[146,cr.plugins_.Sprite.prototype.acts.SetY,null,2000304754560676,false,[[0,[4,[20,146,cr.plugins_.Sprite.prototype.exps.Y,false,null],[6,[6,[21,146,false,null,2],[19,cr.system_object.prototype.exps.dt]],[19,cr.system_object.prototype.exps.sin,[[21,146,false,null,0]]]]]]]]]]]]]]]],["MainScreenSheet",[[2,"SaveGame",false],[2,"MusicController",false],[2,"MiscUtils",false],[0,null,false,null,7590142062955566,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,1667836603742205,false]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9769434219781945,false,[[1,[2,"setText"]],[13,[7,[0,44]],[7,[21,82,false,null,0]]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,636591404670592,false,[[1,[2,"setText"]],[13,[7,[0,151]],[7,[23,"Stars"]]]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,3808683080811065,false,[[1,[2,"UI_Commons"]],[3,1]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2402105258547802,false,[[1,[2,"TweenVisiblesIn"]],[13,]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9804050614900246,false,[[1,[2,"FlashIn"]],[13,]]]],[[0,null,false,null,252918470367718,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,2247870197904886,false,[[4,150]]]],[[150,cr.plugins_.Sprite.prototype.acts.SetX,null,6642155878106291,false,[[0,[19,cr.system_object.prototype.exps.random,[[0,0],[6,[19,cr.system_object.prototype.exps.scrollx],[0,2]]]]]]],[150,cr.plugins_.Sprite.prototype.acts.SetY,null,7206808814339692,false,[[0,[19,cr.system_object.prototype.exps.random,[[0,0],[6,[19,cr.system_object.prototype.exps.scrolly],[0,2]]]]]]]]]]],[0,null,false,null,5061383992111831,[[80,cr.plugins_.Touch.prototype.cnds.OnTouchObject,null,1,false,false,false,9193207500403583,false,[[4,31]]],[31,cr.plugins_.Sprite.prototype.cnds.IsVisible,null,0,false,false,false,852348171493188,false],[31,cr.plugins_.Sprite.prototype.cnds.CompareOpacity,null,0,false,false,false,439738990176067,false,[[8,0],[0,[0,100]]]]],[[16,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,8144684818127896,false,[[10,0],[7,[2,"gameplay"]]]],[-1,cr.system_object.prototype.acts.SetVar,null,7426830653495159,false,[[11,"Level"],[7,[0,1]]]],[-1,cr.system_object.prototype.acts.SetVar,null,4432188669441755,false,[[11,"BaloonScore"],[7,[0,0]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,7196134118520368,false,[[1,[2,"TweenVisiblesOut"]],[13,]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,6443001440024406,false,[[1,[2,"FlashOut"]],[13,]]]]],[0,null,false,null,4105826709892202,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,3314582358734812,false,[[1,[2,"onShowPlanes"]]]]],[[16,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,2144045756982088,false,[[10,0],[7,[2,"planes"]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,7147106244299769,false,[[1,[2,"TweenVisiblesOut"]],[13,]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2204919180059651,false,[[1,[2,"FlashOut"]],[13,]]]]],[0,null,false,null,458442747446598,[[16,cr.behaviors.lunarray_LiteTween.prototype.cnds.OnEnd,"LiteTweenOut",1,false,false,false,1798737556911561,false]],[],[[0,null,false,null,5032347254418759,[[16,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,4350761319296113,false,[[10,0],[8,0],[7,[2,"gameplay"]]]]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,5707185449233562,false,[[6,"GameplayScreen"]]]]],[0,null,false,null,6868910150306796,[[16,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,1092996714616844,false,[[10,0],[8,0],[7,[2,"planes"]]]]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,4727793237379763,false,[[6,"PlanesShopScreen"]]]]]]]]],["ComicScreenSheet",[[2,"MusicController",false],[2,"MiscUtils",false],[0,null,false,null,9596911648645537,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5447694236968138,false,[[1,[2,"onContinueGame"]]]]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,4336759954798064,false,[[6,"GameplayScreen"]]]]]]],["PreloaderSheet",[[0,null,false,null,6709467569626324,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3711826790887869,false,[[7,[19,cr.system_object.prototype.exps.loadingprogress]],[8,0],[7,[0,1]]]],[-1,cr.system_object.prototype.cnds.TriggerOnce,null,0,false,false,false,844591581168038,false]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,8110321185535048,false,[[6,"MainScreen"]]]]],[0,null,false,null,2517997473466435,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,4749942609873588,false]],[[0,cr.plugins_.Spritefont2.prototype.acts.SetText,null,7383771534224762,false,[[7,[10,[19,cr.system_object.prototype.exps.round,[[6,[19,cr.system_object.prototype.exps.loadingprogress],[0,100]]]],[2,"%"]]]]],[0,cr.plugins_.Spritefont2.prototype.acts.SetX,null,5402067012131289,false,[[0,[5,[5,[7,[4,[19,cr.system_object.prototype.exps.viewportleft,[[2,"Layer 0"]]],[19,cr.system_object.prototype.exps.viewportright,[[2,"Layer 0"]]]],[0,2]],[7,[20,0,cr.plugins_.Spritefont2.prototype.exps.Width,false,null],[0,2]]],[0,4]]]]]]]]],["GameplaySheet",[[1,"Stars",0,0,false,false,6411086102457639,false],[1,"MaxSpeed",0,200,false,false,8197002591221693,false],[1,"TimeToStar",0,0,false,false,2078857633838813,false],[1,"CreateStars",0,0,false,false,120628790972379,false],[1,"CloudSpeed",0,150,false,false,4390298624263753,false],[1,"SinceSmoke",0,0,false,false,7685609268986325,false],[1,"PlayerGotHit",0,0,false,false,8882125625274441,false],[1,"BaloonScore",0,0,false,false,2714907329123114,false],[1,"CreateMovingClouds",0,0,false,false,7427290763366425,false],[1,"CreateStaticClouds",0,0,false,false,2115140832457053,false],[1,"CreateBaloons",0,0,false,false,1937568298704317,false],[1,"Items",0,0,false,false,8566349138092865,false],[1,"Level",0,1,false,false,4830475549596139,false],[1,"BounceCount",0,0,false,false,8249281028128741,false],[1,"Speed",0,0,false,false,1307253796311111,false],[2,"MusicController",false],[2,"MiscUtils",false],[2,"SaveGame",false],[0,[true,"Boot"],false,null,3958861626479515,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,3958861626479515,false,[[1,[2,"Boot"]]]]],[],[[0,null,false,null,286871364570352,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,2359708779733757,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,1310985444649547,false,[[11,"PlayerGotHit"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetVar,null,4329439739350415,false,[[11,"SinceSmoke"],[7,[1,0.1]]]],[-1,cr.system_object.prototype.acts.SetVar,null,4095547159042541,false,[[11,"Speed"],[7,[0,0]]]]],[[0,null,false,null,9652254052891024,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,2747350461846731,false,[[11,"SelectedPlane"],[8,0],[7,[0,1]]]]],[[121,cr.plugins_.Sprite.prototype.acts.Destroy,null,7408457476648455,false],[122,cr.plugins_.Sprite.prototype.acts.Destroy,null,5730415123335502,false],[123,cr.plugins_.Sprite.prototype.acts.Destroy,null,4353407325327237,false],[124,cr.plugins_.Sprite.prototype.acts.Destroy,null,9985326642076038,false]]],[0,null,false,null,9856213223998633,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,6097025108440172,false,[[11,"SelectedPlane"],[8,0],[7,[0,2]]]]],[[90,cr.plugins_.Sprite.prototype.acts.Destroy,null,683261956783053,false],[122,cr.plugins_.Sprite.prototype.acts.Destroy,null,5499810735653007,false],[123,cr.plugins_.Sprite.prototype.acts.Destroy,null,8756343118330356,false],[124,cr.plugins_.Sprite.prototype.acts.Destroy,null,4950278391766805,false]]],[0,null,false,null,9450394139365314,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,8762621154403737,false,[[11,"SelectedPlane"],[8,0],[7,[0,3]]]]],[[90,cr.plugins_.Sprite.prototype.acts.Destroy,null,6385932926814967,false],[121,cr.plugins_.Sprite.prototype.acts.Destroy,null,6417516550893656,false],[123,cr.plugins_.Sprite.prototype.acts.Destroy,null,3059267659056275,false],[124,cr.plugins_.Sprite.prototype.acts.Destroy,null,9806251123669701,false]]],[0,null,false,null,7522489535714867,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,8344032089233994,false,[[11,"SelectedPlane"],[8,0],[7,[0,4]]]]],[[90,cr.plugins_.Sprite.prototype.acts.Destroy,null,3138115617779675,false],[121,cr.plugins_.Sprite.prototype.acts.Destroy,null,9274274080357518,false],[122,cr.plugins_.Sprite.prototype.acts.Destroy,null,5204976857721652,false],[124,cr.plugins_.Sprite.prototype.acts.Destroy,null,5381686700413343,false]]],[0,null,false,null,7524255501146996,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,127845299923057,false,[[11,"SelectedPlane"],[8,0],[7,[0,5]]]]],[[90,cr.plugins_.Sprite.prototype.acts.Destroy,null,271932261453966,false],[121,cr.plugins_.Sprite.prototype.acts.Destroy,null,1034580000178062,false],[122,cr.plugins_.Sprite.prototype.acts.Destroy,null,4341683696329019,false],[123,cr.plugins_.Sprite.prototype.acts.Destroy,null,9541982527741579,false]]],[0,null,false,null,1157081312520088,[[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,6071444935352651,false,[[0,[0,81]]]]],[[1,cr.behaviors.Pin.prototype.acts.Pin,"Pin",7415013997002003,false,[[4,24],[3,0]]]]],[0,null,false,null,2927259556707523,[[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,4776368398005228,false,[[0,[0,122]]]]],[[1,cr.behaviors.Pin.prototype.acts.Pin,"Pin",7774396333522658,false,[[4,29],[3,0]]]]],[0,null,false,null,5553726650084878,[],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,552536192487156,false,[[1,[2,"setText"]],[13,[7,[0,81]],[7,[23,"BaloonScore"]]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,6646583643892417,false,[[1,[2,"setText"]],[13,[7,[0,122]],[7,[23,"Stars"]]]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,4771608299439031,false,[[1,[2,"UI_Commons"]],[3,1]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,5811744848474917,false,[[1,[2,"TweenVisiblesIn"]],[13,]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,5602899651481794,false,[[1,[2,"Gameplay"]],[3,1]]],[-1,cr.system_object.prototype.acts.SetVar,null,7560938657619246,false,[[11,"Items"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6561547524631813,false,[[11,"CreateBaloons"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetVar,null,5760244565112716,false,[[11,"CreateStaticClouds"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6633287618217043,false,[[11,"CreateMovingClouds"],[7,[0,0]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6750776554889193,false,[[11,"CreateStars"],[7,[0,0]]]],[151,cr.plugins_.Sprite.prototype.acts.SetX,null,5825776700608475,false,[[0,[19,cr.system_object.prototype.exps.viewportleft,[[0,0]]]]]]]],[0,null,false,null,6737190038272623,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,4912944059095979,false,[[11,"Level"],[8,0],[7,[0,0]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,2060366742067339,false,[[11,"Level"],[7,[0,1]]]]]],[0,null,false,null,6607438741998381,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1507083928612811,false,[[11,"Level"],[8,0],[7,[0,1]]]]],[[151,cr.plugins_.Sprite.prototype.acts.SetY,null,9194719415199505,false,[[0,[0,340]]]],[119,cr.plugins_.Sprite.prototype.acts.SetX,null,5865885506141255,false,[[0,[4,[20,151,cr.plugins_.Sprite.prototype.exps.X,false,null],[0,150]]]]],[119,cr.plugins_.Sprite.prototype.acts.SetY,null,1877136100613906,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Y,false,null],[0,120]]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8890182164640551,false,[[1,[2,"createBaloon"]],[13,[7,[0,6]],[7,[0,2]]]]]]],[0,null,false,null,7833788070367368,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,3306335517481833,false]],[[151,cr.plugins_.Sprite.prototype.acts.SetY,null,9678696088174531,false,[[0,[4,[19,cr.system_object.prototype.exps.scrolly],[19,cr.system_object.prototype.exps.random,[[0,-200],[0,200]]]]]]]],[[0,null,false,null,7978404062512416,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,9985532562825069,false,[[11,"Level"],[8,0],[7,[0,2]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,9776845855781906,false,[[11,"CreateBaloons"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,7064958693928849,false,[[11,"CreateStars"],[7,[0,1]]]]]],[0,null,false,null,6535973609276248,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,8729938703828977,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,3675796809879905,false,[[11,"Level"],[8,0],[7,[0,3]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,753463891391785,false,[[11,"CreateBaloons"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,4561984429237081,false,[[11,"CreateStaticClouds"],[7,[0,1]]]],[-1,cr.system_object.prototype.acts.SetVar,null,8794805598871193,false,[[11,"CreateStars"],[7,[0,2]]]]]],[0,null,false,null,4845724671653963,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,4034681440239788,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,863554595302133,false,[[11,"Level"],[8,0],[7,[0,3]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,3546403508150431,false,[[11,"CreateBaloons"],[7,[0,3]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9155484039185019,false,[[11,"CreateStaticClouds"],[7,[0,1]]]],[-1,cr.system_object.prototype.acts.SetVar,null,3559152394610224,false,[[11,"CreateStars"],[7,[0,2]]]]]],[0,null,false,null,2539313538508218,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,2044459580068878,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,3946801807134358,false,[[11,"Level"],[8,0],[7,[0,4]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,1177969781249005,false,[[11,"CreateBaloons"],[7,[0,4]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2451527959904447,false,[[11,"CreateStaticClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1152780320057717,false,[[11,"CreateStars"],[7,[0,2]]]]]],[0,null,false,null,2400210102497779,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,9468368543554172,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,6311365946643182,false,[[11,"Level"],[8,0],[7,[0,5]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,463847415112252,false,[[11,"CreateBaloons"],[7,[0,5]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1661253603389188,false,[[11,"CreateStaticClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,351096825403811,false,[[11,"CreateMovingClouds"],[7,[0,1]]]],[-1,cr.system_object.prototype.acts.SetVar,null,101574064933504,false,[[11,"CreateStars"],[7,[0,2]]]]]],[0,null,false,null,4969366108786458,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,7193922233497878,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1513964645923303,false,[[11,"Level"],[8,0],[7,[0,6]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,72627361566824,false,[[11,"CreateBaloons"],[7,[0,6]]]],[-1,cr.system_object.prototype.acts.SetVar,null,5058456030819739,false,[[11,"CreateStaticClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,4161290757853064,false,[[11,"CreateMovingClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9594575507542254,false,[[11,"CreateStars"],[7,[0,2]]]]]],[0,null,false,null,8238394433769372,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,3487119533383058,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,789747444335589,false,[[11,"Level"],[8,0],[7,[0,7]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,9115522997150729,false,[[11,"CreateBaloons"],[7,[0,6]]]],[-1,cr.system_object.prototype.acts.SetVar,null,3545050281601932,false,[[11,"CreateStaticClouds"],[7,[0,3]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6936384419266619,false,[[11,"CreateMovingClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,7037414784146749,false,[[11,"CreateStars"],[7,[0,2]]]]]],[0,null,false,null,9847741053759731,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,8171306290109906,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,8130528272475916,false,[[11,"Level"],[8,0],[7,[0,8]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,4031476743317456,false,[[11,"CreateBaloons"],[7,[0,7]]]],[-1,cr.system_object.prototype.acts.SetVar,null,644572615669696,false,[[11,"CreateStaticClouds"],[7,[0,3]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9251553371846087,false,[[11,"CreateMovingClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9514409804808882,false,[[11,"CreateStars"],[7,[0,3]]]]]],[0,null,false,null,1390677746762866,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,7234718988424661,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,5379521617320894,false,[[11,"Level"],[8,0],[7,[0,9]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,1447104805920686,false,[[11,"CreateBaloons"],[7,[0,7]]]],[-1,cr.system_object.prototype.acts.SetVar,null,7678168943364595,false,[[11,"CreateStaticClouds"],[7,[0,4]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6032051461627023,false,[[11,"CreateMovingClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2993028333735398,false,[[11,"CreateStars"],[7,[0,3]]]]]],[0,null,false,null,9753131209076822,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,5374777631566398,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,4189402483382462,false,[[11,"Level"],[8,0],[7,[0,10]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6625037610236143,false,[[11,"CreateBaloons"],[7,[0,8]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2419989299614706,false,[[11,"CreateStaticClouds"],[7,[0,4]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9798253450304929,false,[[11,"CreateMovingClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1642968346897251,false,[[11,"CreateStars"],[7,[0,3]]]]]],[0,null,false,null,9056656535311045,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,7603476940815148,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1340058192961777,false,[[11,"Level"],[8,0],[7,[0,11]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,1617764497517292,false,[[11,"CreateBaloons"],[7,[0,8]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9327475829457334,false,[[11,"CreateStaticClouds"],[7,[0,5]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6169704062649088,false,[[11,"CreateMovingClouds"],[7,[0,2]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2438959500764378,false,[[11,"CreateStars"],[7,[0,3]]]]]],[0,null,false,null,3710532991686026,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,4727548583896869,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,6344515451470746,false,[[11,"Level"],[8,0],[7,[0,12]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,3002631571386424,false,[[11,"CreateBaloons"],[7,[0,8]]]],[-1,cr.system_object.prototype.acts.SetVar,null,8795049916515753,false,[[11,"CreateStaticClouds"],[7,[0,5]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9954923801614571,false,[[11,"CreateMovingClouds"],[7,[0,3]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9465329093051502,false,[[11,"CreateStars"],[7,[0,3]]]]]],[0,null,false,null,2031538370190463,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,6174557421622833,false],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,6716433640246795,false,[[11,"Level"],[8,2],[7,[0,100000]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6723862416351114,false,[[11,"CreateBaloons"],[7,[0,10]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6014876397938758,false,[[11,"CreateStaticClouds"],[7,[0,6]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6353922872140107,false,[[11,"CreateMovingClouds"],[7,[0,4]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9835120505391626,false,[[11,"CreateStars"],[7,[0,3]]]]]]]],[0,null,false,null,4041954730834676,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,8874377167297184,false,[[11,"SelectedPlane"],[8,0],[7,[0,1]]]]],[[92,cr.plugins_.Sprite.prototype.acts.SetX,null,6237104761211481,false,[[0,[20,151,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[92,cr.plugins_.Sprite.prototype.acts.SetY,null,1614475383296901,false,[[0,[20,151,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[92,cr.behaviors.Pin.prototype.acts.Pin,"Pin",5611724095852563,false,[[4,90],[3,0]]]]],[0,null,false,null,474219931528253,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,7227597039666015,false,[[11,"SelectedPlane"],[8,0],[7,[0,2]]]]],[[92,cr.plugins_.Sprite.prototype.acts.SetX,null,2637051008051992,false,[[0,[20,121,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[92,cr.plugins_.Sprite.prototype.acts.SetY,null,936642467782315,false,[[0,[20,121,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[92,cr.behaviors.Pin.prototype.acts.Pin,"Pin",1571990164502424,false,[[4,121],[3,0]]]]],[0,null,false,null,223276920524108,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,2418855040858811,false,[[11,"SelectedPlane"],[8,0],[7,[0,3]]]]],[[92,cr.plugins_.Sprite.prototype.acts.SetX,null,9835618138015152,false,[[0,[20,122,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[92,cr.plugins_.Sprite.prototype.acts.SetY,null,1494794695261489,false,[[0,[20,122,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[92,cr.behaviors.Pin.prototype.acts.Pin,"Pin",4497210496917302,false,[[4,122],[3,0]]]]],[0,null,false,null,5469184923750268,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,3539600108965645,false,[[11,"SelectedPlane"],[8,0],[7,[0,4]]]]],[[92,cr.plugins_.Sprite.prototype.acts.SetX,null,1541538844993766,false,[[0,[20,123,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[92,cr.plugins_.Sprite.prototype.acts.SetY,null,6063546373299584,false,[[0,[20,123,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[92,cr.behaviors.Pin.prototype.acts.Pin,"Pin",8807056493331871,false,[[4,123],[3,0]]]]],[0,null,false,null,6367237003422997,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,9458239256694874,false,[[11,"SelectedPlane"],[8,0],[7,[0,5]]]]],[[92,cr.plugins_.Sprite.prototype.acts.SetX,null,8031531617442839,false,[[0,[20,124,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[92,cr.plugins_.Sprite.prototype.acts.SetY,null,9372255632717882,false,[[0,[20,124,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[92,cr.behaviors.Pin.prototype.acts.Pin,"Pin",8582187574396653,false,[[4,124],[3,0]]]]],[0,null,false,null,1592774781038093,[[-1,cr.system_object.prototype.cnds.While,null,0,true,false,false,4958352286818146,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,187465083647842,false,[[7,[23,"CreateBaloons"]],[8,4],[7,[0,0]]]]],[],[[0,null,false,null,6374210728408085,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,8039440636229711,false,[[4,95],[0,[21,95,false,null,2]],[8,0],[0,[0,0]]]],[-1,cr.system_object.prototype.cnds.PickRandom,null,0,false,false,false,72591746728203,false,[[4,95]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,7911096659183638,false,[[1,[2,"createBaloon"]],[13,[7,[21,95,false,null,0]],[7,[21,95,false,null,1]]]]],[-1,cr.system_object.prototype.acts.SubVar,null,921628824657803,false,[[11,"CreateBaloons"],[7,[0,1]]]]]]]],[0,null,false,null,9202036542751221,[[-1,cr.system_object.prototype.cnds.While,null,0,true,false,false,6888492682278218,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8628768302285131,false,[[7,[23,"CreateStaticClouds"]],[8,4],[7,[0,0]]]]],[],[[0,null,false,null,5523514857765577,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,8084215257338299,false,[[4,95],[0,[21,95,false,null,2]],[8,0],[0,[0,0]]]],[-1,cr.system_object.prototype.cnds.PickRandom,null,0,false,false,false,5214335172540667,false,[[4,95]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9827713951192976,false,[[1,[2,"createStaticCloud"]],[13,[7,[21,95,false,null,0]],[7,[21,95,false,null,1]]]]],[-1,cr.system_object.prototype.acts.SubVar,null,2397385988582782,false,[[11,"CreateStaticClouds"],[7,[0,1]]]]]]]],[0,null,false,null,3911747495418041,[[-1,cr.system_object.prototype.cnds.While,null,0,true,false,false,8437741399813256,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,8795313103806052,false,[[7,[23,"CreateMovingClouds"]],[8,4],[7,[0,0]]]]],[],[[0,null,false,null,5991233085492709,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,7612695980826971,false,[[4,95],[0,[21,95,false,null,2]],[8,0],[0,[0,0]]]],[-1,cr.system_object.prototype.cnds.PickRandom,null,0,false,false,false,9748420097098542,false,[[4,95]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,4672462043260527,false,[[1,[2,"createMovingCloud"]],[13,[7,[21,95,false,null,0]],[7,[21,95,false,null,1]]]]],[-1,cr.system_object.prototype.acts.SubVar,null,5981565344729155,false,[[11,"CreateMovingClouds"],[7,[0,1]]]]]]]],[0,null,false,null,554826857538953,[[-1,cr.system_object.prototype.cnds.While,null,0,true,false,false,8041712756973646,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,1112523625216848,false,[[7,[23,"CreateStars"]],[8,4],[7,[0,0]]]]],[],[[0,null,false,null,5135020795942116,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,9341323310388702,false,[[4,95],[0,[21,95,false,null,2]],[8,0],[0,[0,0]]]],[-1,cr.system_object.prototype.cnds.PickRandom,null,0,false,false,false,2351565068579783,false,[[4,95]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3402529572235105,false,[[1,[2,"createStar"]],[13,[7,[21,95,false,null,0]],[7,[21,95,false,null,1]]]]],[-1,cr.system_object.prototype.acts.SubVar,null,239777982101918,false,[[11,"CreateStars"],[7,[0,1]]]]]]]],[0,null,false,null,6808361028554357,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,2860698837422709,false,[[4,150]]]],[[150,cr.plugins_.Sprite.prototype.acts.SetX,null,9372481492631017,false,[[0,[19,cr.system_object.prototype.exps.random,[[0,0],[6,[19,cr.system_object.prototype.exps.scrollx],[0,2]]]]]]],[150,cr.plugins_.Sprite.prototype.acts.SetY,null,5336645128555665,false,[[0,[19,cr.system_object.prototype.exps.random,[[0,0],[6,[19,cr.system_object.prototype.exps.scrolly],[0,2]]]]]]]]]]]]],[0,[true,"Gameplay"],false,null,2089745267679996,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,2089745267679996,false,[[1,[2,"Gameplay"]]]]],[],[[0,null,false,null,2612398710804026,[[-1,cr.system_object.prototype.cnds.EveryTick,null,0,false,false,false,5083285610624101,false]],[],[[0,null,false,null,1157507198186888,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,2508318933624527,false,[[11,"Speed"],[8,2],[7,[23,"MaxSpeed"]]]]],[[-1,cr.system_object.prototype.acts.AddVar,null,7139661690629663,false,[[11,"Speed"],[7,[6,[23,"MaxSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[[0,null,false,null,6451605315357226,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,6664903115849027,false,[[11,"Speed"],[8,5],[7,[23,"MaxSpeed"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6831722936593404,false,[[11,"Speed"],[7,[23,"MaxSpeed"]]]]]]]],[0,null,false,null,6123038195358179,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,5295751783014031,false,[[7,[23,"PlayerGotHit"]],[8,0],[7,[0,1]]]]],[[151,cr.plugins_.Sprite.prototype.acts.MoveAtAngle,null,8266009899349123,false,[[0,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null]],[0,[6,[6,[23,"Speed"],[1,1.1]],[19,cr.system_object.prototype.exps.dt]]]]],[151,cr.plugins_.Sprite.prototype.acts.RotateTowardAngle,null,8812987029575776,false,[[0,[6,[0,180],[19,cr.system_object.prototype.exps.dt]]],[0,[0,90]]]],[-1,cr.system_object.prototype.acts.SubVar,null,9403416763933005,false,[[11,"SinceSmoke"],[7,[19,cr.system_object.prototype.exps.dt]]]]],[[0,null,false,null,7313433666493143,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,9280350888553782,false,[[11,"SinceSmoke"],[8,3],[7,[0,0]]]],[151,cr.plugins_.Sprite.prototype.cnds.IsOnScreen,null,0,false,false,false,6364329408278494,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,3966415834551196,false,[[11,"SinceSmoke"],[7,[1,0.1]]]],[-1,cr.system_object.prototype.acts.CreateObject,null,9491540063924016,false,[[4,104],[5,[0,6]],[0,[20,151,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[20,151,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[104,cr.plugins_.Sprite.prototype.acts.SetAngle,null,3984073706542823,false,[[0,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null]]]]]]]],[0,null,false,null,3948722769235668,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1915798283856086,false,[[11,"Items"],[8,1],[7,[0,0]]]]],[[151,cr.plugins_.Sprite.prototype.acts.MoveAtAngle,null,634088738296639,false,[[0,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null]],[0,[6,[23,"Speed"],[19,cr.system_object.prototype.exps.dt]]]]]]],[0,null,false,null,6244247078596945,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,4056770388178186,false,[[11,"Items"],[8,0],[7,[0,0]]]],[151,cr.plugins_.Sprite.prototype.cnds.IsOnScreen,null,0,false,false,false,2074459809797315,false]],[[151,cr.plugins_.Sprite.prototype.acts.MoveAtAngle,null,2618625584681331,false,[[0,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null]],[0,[6,[6,[23,"Speed"],[1,1.5]],[19,cr.system_object.prototype.exps.dt]]]]],[151,cr.plugins_.Sprite.prototype.acts.SetAngle,null,1699308401965075,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null],[6,[0,45],[19,cr.system_object.prototype.exps.dt]]]]]]]],[0,null,false,null,6794011662966267,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,7026062293009009,false,[[7,[23,"BounceCount"]],[8,0],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,6799195594972503,false,[[11,"Items"],[8,1],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,7462563186576262,false,[[7,[23,"PlayerGotHit"]],[8,1],[7,[0,1]]]]],[],[[0,null,false,null,1021474273120063,[[151,cr.plugins_.Sprite.prototype.cnds.CompareX,null,0,false,false,false,9365504442879556,false,[[8,4],[0,[20,91,cr.plugins_.Sprite.prototype.exps.X,false,null]]]]],[[151,cr.plugins_.Sprite.prototype.acts.SetAngle,null,9274187966329717,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null],[0,180]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,3353608186577645,false,[[11,"BounceCount"],[7,[0,1]]]]]],[0,null,false,null,4554249091013032,[[151,cr.plugins_.Sprite.prototype.cnds.CompareX,null,0,false,false,false,6992543299012048,false,[[8,2],[0,[20,96,cr.plugins_.Sprite.prototype.exps.X,false,null]]]]],[[151,cr.plugins_.Sprite.prototype.acts.SetAngle,null,1625905149434707,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null],[0,180]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2240949971382005,false,[[11,"BounceCount"],[7,[0,1]]]]]],[0,null,false,null,8024132104978826,[[151,cr.plugins_.Sprite.prototype.cnds.CompareY,null,0,false,false,false,5752049924140282,false,[[8,2],[0,[20,98,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]]],[[151,cr.plugins_.Sprite.prototype.acts.SetAngle,null,194512111205981,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null],[0,180]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1894604301421751,false,[[11,"BounceCount"],[7,[0,1]]]]]],[0,null,false,null,3971203273558348,[[151,cr.plugins_.Sprite.prototype.cnds.CompareY,null,0,false,false,false,1549906025272205,false,[[8,4],[0,[20,97,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]]],[[151,cr.plugins_.Sprite.prototype.acts.SetAngle,null,80121741080875,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null],[0,180]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6259634141973138,false,[[11,"BounceCount"],[7,[0,1]]]]]]]],[0,null,false,null,9163142194505483,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,4028099908941507,false,[[7,[23,"BounceCount"]],[8,0],[7,[0,1]]]]],[],[[0,null,false,null,9886971711815862,[[151,cr.plugins_.Sprite.prototype.cnds.CompareX,null,0,false,false,false,8683336861203831,false,[[8,2],[0,[20,91,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[151,cr.plugins_.Sprite.prototype.cnds.CompareX,null,0,false,false,false,2358346226275698,false,[[8,4],[0,[20,96,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[151,cr.plugins_.Sprite.prototype.cnds.CompareY,null,0,false,false,false,5061344736139011,false,[[8,4],[0,[20,98,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[151,cr.plugins_.Sprite.prototype.cnds.CompareY,null,0,false,false,false,6084959140109497,false,[[8,2],[0,[20,97,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,2706076244422076,false,[[11,"BounceCount"],[7,[0,0]]]]]]]],[0,null,false,null,5296435006485887,[[80,cr.plugins_.Touch.prototype.cnds.IsInTouch,null,0,false,false,false,7971663593380893,false],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,6509766182689274,false,[[7,[23,"BounceCount"]],[8,0],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,2569341427254649,false,[[7,[23,"PlayerGotHit"]],[8,0],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,4772834071047288,false,[[11,"Items"],[8,1],[7,[0,0]]]]],[[151,cr.plugins_.Sprite.prototype.acts.SetAngle,null,77401305253968,false,[[0,[5,[20,151,cr.plugins_.Sprite.prototype.exps.Angle,false,null],[6,[0,180],[19,cr.system_object.prototype.exps.dt]]]]]]]],[0,null,false,null,3453703525746133,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,5518212892631477,false,[[4,149]]],[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,1059944865857868,false,[[10,0],[8,0],[7,[0,1]]]]],[],[[0,null,false,null,9736665322320213,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,689173205645789,false,[[10,1],[8,0],[7,[0,1]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetX,null,9453505907699285,false,[[0,[4,[20,149,cr.plugins_.Sprite.prototype.exps.X,false,null],[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[149,cr.plugins_.Sprite.prototype.acts.SubInstanceVar,null,5111692627572767,false,[[10,3],[7,[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[[0,null,false,null,370863715557254,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,3546345171267404,false,[[10,3],[8,3],[7,[0,0]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,8916171305423879,false,[[10,3],[7,[21,149,false,null,4]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,9435661746725832,false,[[10,1],[7,[6,[21,149,false,null,1],[0,-1]]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,8777668785771749,false,[[10,2],[7,[6,[21,149,false,null,2],[0,-1]]]]]]]]],[0,null,false,null,8712155752050308,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,6619591679468179,false,[[10,1],[8,0],[7,[0,-1]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetX,null,8414375448632237,false,[[0,[5,[20,149,cr.plugins_.Sprite.prototype.exps.X,false,null],[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[149,cr.plugins_.Sprite.prototype.acts.SubInstanceVar,null,2833155662609602,false,[[10,3],[7,[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[[0,null,false,null,2915962499700933,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,544630918893514,false,[[10,3],[8,3],[7,[0,0]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,3836037831188567,false,[[10,3],[7,[21,149,false,null,4]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,2708276816022529,false,[[10,1],[7,[6,[21,149,false,null,1],[0,-1]]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,9470058713780334,false,[[10,2],[7,[6,[21,149,false,null,2],[0,-1]]]]]]]]],[0,null,false,null,9011075537012183,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,5148188598591278,false,[[10,2],[8,0],[7,[0,1]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetY,null,7970795162256174,false,[[0,[4,[20,149,cr.plugins_.Sprite.prototype.exps.Y,false,null],[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[149,cr.plugins_.Sprite.prototype.acts.SubInstanceVar,null,9857968963673869,false,[[10,3],[7,[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[[0,null,false,null,4096518674918598,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8218312119761467,false,[[10,3],[8,3],[7,[0,0]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,9106150472441216,false,[[10,3],[7,[21,149,false,null,4]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,8745257470376423,false,[[10,1],[7,[6,[21,149,false,null,1],[0,-1]]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,1950167162091629,false,[[10,2],[7,[6,[21,149,false,null,2],[0,-1]]]]]]]]],[0,null,false,null,5883658531048737,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,7500388205773263,false,[[10,2],[8,0],[7,[0,-1]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetY,null,717086220811024,false,[[0,[5,[20,149,cr.plugins_.Sprite.prototype.exps.Y,false,null],[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[149,cr.plugins_.Sprite.prototype.acts.SubInstanceVar,null,2213087001569468,false,[[10,3],[7,[6,[23,"CloudSpeed"],[19,cr.system_object.prototype.exps.dt]]]]]],[[0,null,false,null,7622693034136448,[[149,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,1116039647438408,false,[[10,3],[8,3],[7,[0,0]]]]],[[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,4212632566405157,false,[[10,3],[7,[21,149,false,null,4]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,5757979025396769,false,[[10,1],[7,[6,[21,149,false,null,1],[0,-1]]]]],[149,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,9822034480791022,false,[[10,2],[7,[6,[21,149,false,null,2],[0,-1]]]]]]]]]]]]],[0,null,false,null,5577086872584348,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,5861167760608583,false,[[4,118]]]],[[118,cr.plugins_.Sprite.prototype.acts.SetX,null,7076206689395442,false,[[0,[4,[20,118,cr.plugins_.Sprite.prototype.exps.X,false,null],[6,[6,[21,118,false,null,1],[19,cr.system_object.prototype.exps.dt]],[21,118,false,null,0]]]]]]]],[0,null,false,null,9288671999452803,[[92,cr.plugins_.Sprite.prototype.cnds.IsOverlapping,null,0,false,false,false,1810974965703201,false,[[4,93]]],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1913489095117598,false,[[11,"Items"],[8,1],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,2655689937015752,false,[[7,[23,"PlayerGotHit"]],[8,0],[7,[0,0]]]]],[[93,cr.plugins_.Sprite.prototype.acts.Destroy,null,8231336591072268,false],[-1,cr.system_object.prototype.acts.SubVar,null,1479131120761357,false,[[11,"Items"],[7,[0,1]]]],[-1,cr.system_object.prototype.acts.AddVar,null,3314540303978,false,[[11,"BaloonScore"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,5722129883312134,false,[[1,[2,"setText"]],[13,[7,[0,81]],[7,[23,"BaloonScore"]]]]],[105,cr.plugins_.Sprite.prototype.acts.Destroy,null,6069911032193892,false]],[[0,null,false,null,2773116315969598,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1531532179829492,false,[[11,"Items"],[8,0],[7,[0,0]]]]],[[-1,cr.system_object.prototype.acts.AddVar,null,6869707288073088,false,[[11,"Level"],[7,[0,1]]]],[106,cr.plugins_.Sprite.prototype.acts.Destroy,null,5917489295089058,false],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2128078529632818,false,[[1,[2,"onGameCompleted"]],[13,]]],[119,cr.plugins_.Sprite.prototype.acts.Destroy,null,7338882673137979,false]]]]],[0,null,false,null,9825275765529425,[[92,cr.plugins_.Sprite.prototype.cnds.IsOverlapping,null,0,false,false,false,7003607313611871,false,[[4,118]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,476363179568866,false,[[7,[23,"PlayerGotHit"]],[8,0],[7,[0,0]]]]],[[118,cr.plugins_.Sprite.prototype.acts.Destroy,null,8223628282322121,false],[-1,cr.system_object.prototype.acts.AddVar,null,3085962090525948,false,[[11,"Stars"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8094122675271877,false,[[1,[2,"setText"]],[13,[7,[0,122]],[7,[23,"Stars"]]]]]]],[0,null,false,null,4803591755658661,[[92,cr.plugins_.Sprite.prototype.cnds.IsOverlapping,null,0,false,false,false,1809497758079572,false,[[4,149]]],[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,5022665080489183,false,[[11,"Items"],[8,1],[7,[0,0]]]],[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,233586352410501,false,[[7,[23,"PlayerGotHit"]],[8,0],[7,[0,0]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,7559827266283788,false,[[1,[2,"onGameOver"]],[13,]]],[-1,cr.system_object.prototype.acts.CreateObject,null,182862165354763,false,[[4,103],[5,[0,5]],[0,[20,151,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[20,151,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[-1,cr.system_object.prototype.acts.SetVar,null,9010919791728436,false,[[11,"PlayerGotHit"],[7,[0,1]]]],[106,cr.plugins_.Sprite.prototype.acts.Destroy,null,6625064491296104,false]]]]],[0,[true,"Buttons"],false,null,3855961996291174,[[-1,cr.system_object.prototype.cnds.IsGroupActive,null,0,false,false,false,3855961996291174,false,[[1,[2,"Buttons"]]]]],[],[[0,null,false,null,2302774889582807,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,1456373154016217,false,[[1,[2,"onRestart"]]]]],[[16,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,1700433386583647,false,[[10,0],[7,[2,"cover"]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,6816496175007481,false,[[1,[2,"TweenVisiblesOut"]],[13,]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,1382824798586739,false,[[1,[2,"FlashOut"]],[13,]]]]],[0,null,false,null,5521632170254018,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9291414034167694,false,[[1,[2,"onNextLevel"]]]]],[[16,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,6832542231729592,false,[[10,0],[7,[2,"nextLevel"]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,4065422242574017,false,[[1,[2,"TweenVisiblesOut"]],[13,]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,996720840861932,false,[[1,[2,"FlashOut"]],[13,]]]]],[0,null,false,null,4247315900835733,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,860608666431226,false,[[1,[2,"onContinue"]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3204727253695156,false,[[1,[2,"TweenVisiblesOut"]],[13,]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,6134052737216802,false,[[1,[2,"FlashOut"]],[13,]]]]],[0,null,false,null,5707294678971934,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,358069233608278,false,[[1,[2,"onGameOver"]]]]],[[10,cr.plugins_.Sprite.prototype.acts.SetVisible,null,1651059736772249,false,[[3,0]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8312824875402258,false,[[1,[2,"TweenLayerIn"]],[13,[7,[0,15]]]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,8438163403282199,false,[[5,[0,15]],[3,1]]]],[[0,null,false,null,1243041535590971,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1963934206782715,false,[[11,"BaloonScore"],[8,4],[7,[21,82,false,null,0]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,6158453404861323,false,[[1,[2,"saveHighscore"]],[13,[7,[23,"BaloonScore"]]]]],[125,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3239972314578683,false,[[3,1]]]]]]],[0,null,false,null,7353146834206752,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,3347951924893825,false,[[1,[2,"onGameCompleted"]]]]],[[10,cr.plugins_.Sprite.prototype.acts.SetVisible,null,9169467343388585,false,[[3,0]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3454561918968545,false,[[1,[2,"TweenLayerIn"]],[13,[7,[0,16]]]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,8670397469262077,false,[[5,[0,16]],[3,1]]]]],[0,null,false,null,417831412499195,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5738096350913013,false,[[1,[2,"onPause"]]]]],[[10,cr.plugins_.Sprite.prototype.acts.SetVisible,null,1122341228548687,false,[[3,0]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,4038753288522671,false,[[5,[0,19]],[3,1]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,2200050580190066,false,[[1,[2,"LogicLoop"]],[3,0]]],[-1,cr.system_object.prototype.acts.SetTimescale,null,1207265236424894,false,[[0,[1,1e-005]]]]]],[0,null,false,null,9158729984658281,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,6061790785674074,false,[[1,[2,"onUnpause"]]]]],[[10,cr.plugins_.Sprite.prototype.acts.SetVisible,null,9940508857285461,false,[[3,1]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,450739504921023,false,[[5,[0,19]],[3,0]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,6095468225840556,false,[[1,[2,"LogicLoop"]],[3,1]]],[-1,cr.system_object.prototype.acts.SetTimescale,null,2286879659568849,false,[[0,[0,1]]]],[-1,cr.system_object.prototype.acts.Wait,null,7213939798093768,false,[[0,[1,0.1]]]]]],[0,null,false,null,7456236521253195,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5552449397677323,false,[[1,[2,"onMoreGames"]]]]],[]],[0,null,false,null,9772514048970982,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,2003174475691375,false,[[1,[2,"onBackToMain"]]]]],[[-1,cr.system_object.prototype.acts.SetLayerVisible,null,8499786851211443,false,[[5,[0,15]],[3,0]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,2900983121878577,false,[[5,[0,16]],[3,0]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,9166474814584236,false,[[5,[0,19]],[3,0]]],[-1,cr.system_object.prototype.acts.GoToLayout,null,9858003086325566,false,[[6,"MainScreen"]]]]],[0,null,false,null,6404642181334818,[[16,cr.behaviors.lunarray_LiteTween.prototype.cnds.OnEnd,"LiteTweenOut",1,false,false,false,3196917415481193,false]],[[-1,cr.system_object.prototype.acts.SetLayerVisible,null,2523162753271015,false,[[5,[0,15]],[3,0]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,1711117889877905,false,[[5,[0,16]],[3,0]]],[-1,cr.system_object.prototype.acts.SetLayerVisible,null,8091818641964722,false,[[5,[0,19]],[3,0]]]],[[0,null,false,null,3207670391452355,[[16,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8491510657588882,false,[[10,0],[8,0],[7,[2,"cover"]]]]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,9618190093309834,false,[[6,"MainScreen"]]]]],[0,null,false,null,7310843575297154,[[16,cr.plugins_.Sprite.prototype.cnds.CompareInstanceVar,null,0,false,false,false,8506989677670897,false,[[10,0],[8,0],[7,[2,"nextLevel"]]]]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,1783558601929773,false,[[6,"GameplayScreen"]]]]]]]]],[0,null,false,null,6762827105319075,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5231410830181936,false,[[1,[2,"createBaloon"]]]]],[],[[0,null,false,null,8278298907194403,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,8368802416259179,false,[[4,95],[0,[21,95,false,null,0]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]],[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,8306518477583231,false,[[4,95],[0,[21,95,false,null,1]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]]],[[-1,cr.system_object.prototype.acts.CreateObject,null,244414733971736,false,[[4,93],[5,[0,3]],[0,[20,95,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[20,95,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[-1,cr.system_object.prototype.acts.AddVar,null,851927096274054,false,[[11,"Items"],[7,[0,1]]]],[95,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,6000802529120472,false,[[10,2],[7,[0,1]]]]],[[0,null,false,null,8907602368188974,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,865095853838089,false,[[11,"Level"],[8,0],[7,[0,1]]]]],[[-1,cr.system_object.prototype.acts.CreateObject,null,4707612068687695,false,[[4,105],[5,[0,7]],[0,[20,93,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[5,[20,93,cr.plugins_.Sprite.prototype.exps.Y,false,null],[0,65]]]]]]]]]]],[0,null,false,null,8343397210542349,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,2507249867744501,false,[[1,[2,"createStaticCloud"]]]]],[],[[0,null,false,null,2597248360491016,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,7242395025348368,false,[[4,95],[0,[21,95,false,null,0]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]],[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,4095598458710978,false,[[4,95],[0,[21,95,false,null,1]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]]],[[-1,cr.system_object.prototype.acts.CreateObject,null,8164254918648823,false,[[4,94],[5,[0,3]],[0,[20,95,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[20,95,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[94,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,1399083763518678,false,[[0,[19,cr.system_object.prototype.exps.choose,[[0,0],[0,1],[0,2],[0,3],[0,4],[0,5],[0,6],[0,7]]]]]],[95,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,4161350988475767,false,[[10,2],[7,[0,1]]]]],[[0,null,false,null,5628448694083962,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,2225190122751185,false,[[11,"Level"],[8,0],[7,[0,3]]]]],[[-1,cr.system_object.prototype.acts.CreateObject,null,9485229526038075,false,[[4,106],[5,[0,7]],[0,[20,94,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[5,[20,94,cr.plugins_.Sprite.prototype.exps.Y,false,null],[0,65]]]]]]]]]]],[0,null,false,null,4762036583222303,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5956065656119335,false,[[1,[2,"createMovingCloud"]]]]],[],[[0,null,false,null,9719842534576788,[[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,5916210040814812,false,[[4,95],[0,[21,95,false,null,0]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,0]]]]]],[-1,cr.system_object.prototype.cnds.PickByComparison,null,0,false,false,false,924363093302532,false,[[4,95],[0,[21,95,false,null,1]],[8,0],[0,[20,79,cr.plugins_.Function.prototype.exps.Param,false,null,[[0,1]]]]]]],[[-1,cr.system_object.prototype.acts.CreateObject,null,1769397737964722,false,[[4,117],[5,[0,3]],[0,[20,95,cr.plugins_.Sprite.prototype.exps.X,false,null]],[0,[20,95,cr.plugins_.Sprite.prototype.exps.Y,false,null]]]],[95,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,9265825899698168,false,[[10,2],[7,[0,1]]]],[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,1870849726263867,false,[[10,0],[7,[0,1]]]],[117,cr.plugins_.Sprite.prototype.acts.SetAnimFrame,null,2886884627034787,false,[[0,[19,cr.system_object.prototype.exps.choose,[[0,0],[0,1],[0,2],[0,3],[0,4],[0,5],[0,6],[0,7]]]]]]],[[0,null,false,null,8469177458884175,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,4649229381274277,false,[[7,[19,cr.system_object.prototype.exps.choose,[[0,1],[0,2]]]],[8,0],[7,[0,1]]]]],[],[[0,null,false,null,7781284620770077,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,3218409540353949,false,[[7,[19,cr.system_object.prototype.exps.choose,[[0,1],[0,2]]]],[8,0],[7,[0,1]]]]],[[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,6589581863497249,false,[[10,1],[7,[0,1]]]],[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,2513618132606735,false,[[10,2],[7,[0,0]]]]]],[0,null,false,null,9021476544360168,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,3484676310625708,false]],[[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,4666349259620977,false,[[10,1],[7,[0,-1]]]],[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,2956027000202786,false,[[10,2],[7,[0,0]]]]]]]],[0,null,false,null,2830832089425125,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,1649941268990402,false]],[],[[0,null,false,null,1336433804848729,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,2304534040899512,false,[[7,[19,cr.system_object.prototype.exps.choose,[[0,1],[0,2]]]],[8,0],[7,[0,1]]]]],[[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,7595307508057116,false,[[10,1],[7,[0,0]]]],[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,2005373452827032,false,[[10,2],[7,[0,1]]]]]],[0,null,false,null,3931001226760213,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,3415371955737009,false]],[[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,518001755578033,false,[[10,1],[7,[0,0]]]],[117,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,6169303283306982,false,[[10,2],[7,[0,-1]]]]]]]]]]]],[0,null,false,null,296916267670002,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9320321720881489,false,[[1,[2,"createStar"]]]]],[],[[0,null,false,null,7219033343564119,[[-1,cr.system_object.prototype.cnds.Compare,null,0,false,false,false,2844771820443043,false,[[7,[19,cr.system_object.prototype.exps.choose,[[0,1],[0,2]]]],[8,0],[7,[0,1]]]]],[[-1,cr.system_object.prototype.acts.CreateObject,null,590130645639394,false,[[4,118],[5,[0,6]],[0,[19,cr.system_object.prototype.exps.random,[[0,50],[0,200]]]],[0,[19,cr.system_object.prototype.exps.random,[[0,100],[0,500]]]]]],[118,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,8599262165410815,false,[[10,1],[7,[19,cr.system_object.prototype.exps.choose,[[0,30],[0,50],[0,70],[0,100]]]]]],[118,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,2143617538869657,false,[[10,0],[7,[0,1]]]]]],[0,null,false,null,177162297243607,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,1894640184695769,false]],[[-1,cr.system_object.prototype.acts.CreateObject,null,5275156424280029,false,[[4,118],[5,[0,6]],[0,[19,cr.system_object.prototype.exps.random,[[0,800],[0,950]]]],[0,[19,cr.system_object.prototype.exps.random,[[0,100],[0,500]]]]]],[118,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,1483536763225566,false,[[10,1],[7,[19,cr.system_object.prototype.exps.choose,[[0,30],[0,50],[0,70],[0,100]]]]]],[118,cr.plugins_.Sprite.prototype.acts.SetInstanceVar,null,6386103023748835,false,[[10,0],[7,[0,-1]]]]]]]]]],["PlanesShop",[[1,"Price_5",0,100,false,false,1212998315732739,false],[1,"Price_4",0,50,false,false,5294640290806407,false],[1,"Price_3",0,25,false,false,8879915062454301,false],[1,"Price_2",0,10,false,false,718825312621681,false],[2,"SaveGame",false],[2,"MiscUtils",false],[2,"MusicController",false],[0,null,false,null,3162202176517867,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,9699365255953321,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,9906030573832021,false,[[11,"Stars"],[7,[0,15]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8543215210388555,false,[[1,[2,"setText"]],[13,[7,[0,152]],[7,[21,82,false,null,0]]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,858975076792736,false,[[1,[2,"setText"]],[13,[7,[0,153]],[7,[23,"Stars"]]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,4958120878231366,false,[[1,[2,"FlashIn"]],[13,]]]],[[0,null,false,null,4181519522101122,[[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,1728758253886305,false,[[0,[0,180]]]]],[[1,cr.behaviors.Pin.prototype.acts.Pin,"Pin",9332295182082736,false,[[4,131],[3,0]]]]],[0,null,false,null,1745644196987696,[[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,178350857145657,false,[[0,[0,181]]]]],[[1,cr.behaviors.Pin.prototype.acts.Pin,"Pin",1206117160516085,false,[[4,134],[3,0]]]]],[0,null,false,null,8885445416692101,[[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,4320899823138831,false,[[0,[0,182]]]]],[[1,cr.behaviors.Pin.prototype.acts.Pin,"Pin",7656724285678132,false,[[4,135],[3,0]]]]],[0,null,false,null,2418503276001775,[[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,9039436248718988,false,[[0,[0,183]]]]],[[1,cr.behaviors.Pin.prototype.acts.Pin,"Pin",854681329213917,false,[[4,136],[3,0]]]]],[0,null,false,null,9052306372670302,[],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,4636476311338532,false,[[1,[2,"updatePlanesSelection"]],[13,]]],[-1,cr.system_object.prototype.acts.SetGroupActive,null,9343875245933772,false,[[1,[2,"UI_Commons"]],[3,1]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3931778175282576,false,[[1,[2,"TweenVisiblesIn"]],[13,]]]]],[0,null,false,null,9627844250635163,[[-1,cr.system_object.prototype.cnds.ForEach,null,0,true,false,false,3241964840643608,false,[[4,150]]]],[[150,cr.plugins_.Sprite.prototype.acts.SetX,null,6732106944015263,false,[[0,[19,cr.system_object.prototype.exps.random,[[0,0],[6,[19,cr.system_object.prototype.exps.scrollx],[0,2]]]]]]],[150,cr.plugins_.Sprite.prototype.acts.SetY,null,6390520070706161,false,[[0,[19,cr.system_object.prototype.exps.random,[[0,0],[6,[19,cr.system_object.prototype.exps.scrolly],[0,2]]]]]]]]]]],[0,null,false,null,6575489516556533,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5811917140133167,false,[[1,[2,"onBackToMain"]]]]],[[-1,cr.system_object.prototype.acts.GoToLayout,null,3111445616275099,false,[[6,"MainScreen"]]]]],[0,null,false,null,1795227326012014,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,9104520061785114,false,[[1,[2,"updatePlanesSelection"]]]]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9734936750880177,false,[[1,[2,"setText"]],[13,[7,[0,153]],[7,[23,"Stars"]]]]],[74,cr.plugins_.Sprite.prototype.acts.SetVisible,null,6982417904708135,false,[[3,1]]]],[[0,null,false,null,6966893404885017,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,7885488154583694,false,[[11,"Stars"],[8,5],[7,[23,"Price_2"]]]]],[[69,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3700458747735878,false,[[3,1]]],[138,cr.plugins_.Sprite.prototype.acts.SetVisible,null,5755395171449599,false,[[3,0]]]]],[0,null,false,null,49331688451238,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,1434509317461833,false]],[[69,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7969052137357368,false,[[3,0]]],[138,cr.plugins_.Sprite.prototype.acts.SetVisible,null,8579581975491752,false,[[3,1]]]]],[0,null,false,null,154369601482951,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,7051015738959886,false,[[11,"Stars"],[8,5],[7,[23,"Price_3"]]]]],[[70,cr.plugins_.Sprite.prototype.acts.SetVisible,null,8575931917966797,false,[[3,1]]],[139,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3844064299682958,false,[[3,0]]]]],[0,null,false,null,2739986882506852,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,5729771045029108,false]],[[70,cr.plugins_.Sprite.prototype.acts.SetVisible,null,385202589791995,false,[[3,0]]],[139,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7843739969255134,false,[[3,1]]]]],[0,null,false,null,6416809685119358,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,3795170827719218,false,[[11,"Stars"],[8,5],[7,[23,"Price_4"]]]]],[[71,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7202303366543213,false,[[3,1]]],[140,cr.plugins_.Sprite.prototype.acts.SetVisible,null,5095136329227895,false,[[3,0]]]]],[0,null,false,null,9912413603488673,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,1079918779084945,false]],[[71,cr.plugins_.Sprite.prototype.acts.SetVisible,null,5939029222634845,false,[[3,0]]],[140,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7836204248473004,false,[[3,1]]]]],[0,null,false,null,9135092455861628,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,5127645495119406,false,[[11,"Stars"],[8,5],[7,[23,"Price_5"]]]]],[[72,cr.plugins_.Sprite.prototype.acts.SetVisible,null,1376662457776901,false,[[3,1]]],[141,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7015444571850874,false,[[3,0]]]]],[0,null,false,null,3663687555426992,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,7432972511077137,false]],[[72,cr.plugins_.Sprite.prototype.acts.SetVisible,null,1988007256901983,false,[[3,0]]],[141,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3635949342434538,false,[[3,1]]]]],[0,null,false,null,4394630470451815,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,2566331650698238,false,[[11,"Unlocked_Plane2"],[8,0],[7,[0,0]]]]],[[75,cr.plugins_.Sprite.prototype.acts.SetVisible,null,6440340024682484,false,[[3,0]]]]],[0,null,false,null,4813393378983973,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,615865739559604,false],[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,3301927456469277,false,[[0,[0,180]]]]],[[75,cr.plugins_.Sprite.prototype.acts.SetVisible,null,517416529243508,false,[[3,1]]],[69,cr.plugins_.Sprite.prototype.acts.SetVisible,null,2781739180919447,false,[[3,0]]],[131,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7131441120167996,false,[[3,0]]],[1,cr.plugins_.Spritefont2.prototype.acts.SetVisible,null,7875751465094172,false,[[3,0]]],[138,cr.plugins_.Sprite.prototype.acts.SetVisible,null,219847697387893,false,[[3,0]]]]],[0,null,false,null,2548580096731024,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,5064560020919537,false,[[11,"Unlocked_Plane3"],[8,0],[7,[0,0]]]]],[[76,cr.plugins_.Sprite.prototype.acts.SetVisible,null,918515176581366,false,[[3,0]]]]],[0,null,false,null,5625177671940367,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,5761758880264399,false],[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,9930904526750688,false,[[0,[0,181]]]]],[[76,cr.plugins_.Sprite.prototype.acts.SetVisible,null,5641824345967872,false,[[3,1]]],[70,cr.plugins_.Sprite.prototype.acts.SetVisible,null,303083538751333,false,[[3,0]]],[134,cr.plugins_.Sprite.prototype.acts.SetVisible,null,610113196981153,false,[[3,0]]],[1,cr.plugins_.Spritefont2.prototype.acts.SetVisible,null,6577452292882355,false,[[3,0]]],[139,cr.plugins_.Sprite.prototype.acts.SetVisible,null,8766736546576944,false,[[3,0]]]]],[0,null,false,null,4168423635038126,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,8016840457326753,false,[[11,"Unlocked_Plane4"],[8,0],[7,[0,0]]]]],[[77,cr.plugins_.Sprite.prototype.acts.SetVisible,null,5562644852677179,false,[[3,0]]]]],[0,null,false,null,3847960160759263,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,5375495264924658,false],[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,2655015229684493,false,[[0,[0,182]]]]],[[77,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7176315119562931,false,[[3,1]]],[71,cr.plugins_.Sprite.prototype.acts.SetVisible,null,8090623549471355,false,[[3,0]]],[135,cr.plugins_.Sprite.prototype.acts.SetVisible,null,425197865110217,false,[[3,0]]],[1,cr.plugins_.Spritefont2.prototype.acts.SetVisible,null,1789350326421129,false,[[3,0]]],[140,cr.plugins_.Sprite.prototype.acts.SetVisible,null,8046239973459879,false,[[3,0]]]]],[0,null,false,null,2892777118518834,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,2362124888720127,false,[[11,"Unlocked_Plane5"],[8,0],[7,[0,0]]]]],[[78,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3417378730944253,false,[[3,0]]]]],[0,null,false,null,3645701785871087,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,3683161967303474,false],[1,cr.plugins_.Spritefont2.prototype.cnds.PickByUID,null,0,false,false,true,2623819836498646,false,[[0,[0,183]]]]],[[78,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3224976179513778,false,[[3,1]]],[72,cr.plugins_.Sprite.prototype.acts.SetVisible,null,2746703341554046,false,[[3,0]]],[136,cr.plugins_.Sprite.prototype.acts.SetVisible,null,3132957409098369,false,[[3,0]]],[1,cr.plugins_.Spritefont2.prototype.acts.SetVisible,null,1801241894423839,false,[[3,0]]],[77,cr.plugins_.Sprite.prototype.acts.SetVisible,null,4112639815242786,false,[[3,1]]],[141,cr.plugins_.Sprite.prototype.acts.SetVisible,null,8813938332256199,false,[[3,0]]]]],[0,null,false,null,2586369025539462,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,8043373031205118,false,[[11,"SelectedPlane"],[8,0],[7,[0,1]]]]],[[137,cr.plugins_.Sprite.prototype.acts.SetX,null,8559130418353357,false,[[0,[20,130,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[137,cr.behaviors.Pin.prototype.acts.Pin,"Pin",9559002267788452,false,[[4,130],[3,0]]],[74,cr.plugins_.Sprite.prototype.acts.SetVisible,null,7461461817511707,false,[[3,0]]]]],[0,null,false,null,1345634808783972,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,262619153222681,false,[[11,"SelectedPlane"],[8,0],[7,[0,2]]]]],[[137,cr.plugins_.Sprite.prototype.acts.SetX,null,8787751043688845,false,[[0,[20,126,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[137,cr.behaviors.Pin.prototype.acts.Pin,"Pin",4709114188662813,false,[[4,126],[3,0]]],[75,cr.plugins_.Sprite.prototype.acts.SetVisible,null,9603403537304651,false,[[3,0]]]]],[0,null,false,null,4058018954675606,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,5123899789373985,false,[[11,"SelectedPlane"],[8,0],[7,[0,3]]]]],[[137,cr.plugins_.Sprite.prototype.acts.SetX,null,1078089447302743,false,[[0,[20,127,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[137,cr.behaviors.Pin.prototype.acts.Pin,"Pin",4874801722569977,false,[[4,127],[3,0]]],[76,cr.plugins_.Sprite.prototype.acts.SetVisible,null,2442938247167427,false,[[3,0]]]]],[0,null,false,null,2529042484939011,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,5321995917861026,false,[[11,"SelectedPlane"],[8,0],[7,[0,4]]]]],[[137,cr.plugins_.Sprite.prototype.acts.SetX,null,3130991324569933,false,[[0,[20,128,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[137,cr.behaviors.Pin.prototype.acts.Pin,"Pin",3204070562511758,false,[[4,128],[3,0]]],[77,cr.plugins_.Sprite.prototype.acts.SetVisible,null,2710988621237518,false,[[3,0]]]]],[0,null,false,null,6348375631301492,[[-1,cr.system_object.prototype.cnds.CompareVar,null,0,false,false,false,1963451624207973,false,[[11,"SelectedPlane"],[8,0],[7,[0,5]]]]],[[137,cr.plugins_.Sprite.prototype.acts.SetX,null,8359960010651242,false,[[0,[20,129,cr.plugins_.Sprite.prototype.exps.X,false,null]]]],[137,cr.behaviors.Pin.prototype.acts.Pin,"Pin",1704003641982094,false,[[4,129],[3,0]]],[78,cr.plugins_.Sprite.prototype.acts.SetVisible,null,6643552370702041,false,[[3,0]]]]]]],[0,null,false,null,5124254396578641,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,7916212154634141,false,[[1,[2,"unlockPlane_2"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,9414763142284234,false,[[11,"Stars"],[7,[5,[23,"Stars"],[23,"Price_2"]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1371478854374154,false,[[11,"Unlocked_Plane2"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2671185757800037,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,5455705789931912,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,2332905542171571,false,[[1,[2,"unlockPlane_3"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,9684102790102372,false,[[11,"Stars"],[7,[5,[23,"Stars"],[23,"Price_3"]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,3684884468334989,false,[[11,"Unlocked_Plane3"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2318657855462205,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,8300357531926813,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,7786271608048299,false,[[1,[2,"unlockPlane_4"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6703028793866237,false,[[11,"Stars"],[7,[5,[23,"Stars"],[23,"Price_4"]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,8519308807127484,false,[[11,"Unlocked_Plane4"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,477869606760767,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,7227087716318107,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,1628012733100398,false,[[1,[2,"unlockPlane_5"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,6710707876864097,false,[[11,"Stars"],[7,[5,[23,"Stars"],[23,"Price_5"]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,5783353261407809,false,[[11,"Unlocked_Plane5"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,3035797871662513,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,7064924789527978,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5041052890361411,false,[[1,[2,"onSelected_1"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,3983356996213424,false,[[11,"SelectedPlane"],[7,[0,1]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,2054078556512881,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,8613466418778718,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,1235693513332978,false,[[1,[2,"onSelected_2"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,7574420621189373,false,[[11,"SelectedPlane"],[7,[0,2]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,4408469306192642,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,3029252696006825,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,5271806307152097,false,[[1,[2,"onSelected_3"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,4677901432461723,false,[[11,"SelectedPlane"],[7,[0,3]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8170589073552638,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,1019032792077141,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,3061268027769082,false,[[1,[2,"onSelected_4"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,4415255135309198,false,[[11,"SelectedPlane"],[7,[0,4]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9759921758743799,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]],[0,null,false,null,2977784328287912,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,1473302861286732,false,[[1,[2,"onSelected_5"]]]]],[[-1,cr.system_object.prototype.acts.SetVar,null,360957027861199,false,[[11,"SelectedPlane"],[7,[0,5]]]],[79,cr.plugins_.Function.prototype.acts.CallFunction,null,9263202783325833,false,[[1,[2,"updatePlanesSelection"]],[13,]]]]]]],["SaveGame",[[1,"SelectedPlane",0,1,false,false,2900002265857599,false],[1,"Unlocked_Plane2",0,0,false,false,5722409754913218,false],[1,"Unlocked_Plane3",0,0,false,false,8226155379859582,false],[1,"Unlocked_Plane4",0,0,false,false,9276555308479545,false],[1,"Unlocked_Plane5",0,0,false,false,5424868717810625,false],[0,null,false,null,930422906002983,[[-1,cr.system_object.prototype.cnds.OnLayoutStart,null,1,false,false,false,8393824274964772,false],[120,cr.plugins_.JSON.prototype.cnds.IsEmpty,null,0,false,false,false,455656758991442,false,[[3,0],[13,]]]],[[120,cr.plugins_.JSON.prototype.acts.NewObject,null,9011487234820088,false,[[3,0],[13,]]]],[[0,null,false,null,8315507745509026,[[20,cr.plugins_.WebStorage.prototype.cnds.LocalStorageExists,null,0,false,false,false,2426733032689741,false,[[1,[10,[21,82,true,null,4],[2,"_sv"]]]]]],[[120,cr.plugins_.JSON.prototype.acts.LoadJSON,null,2409689298586264,false,[[1,[20,20,cr.plugins_.WebStorage.prototype.exps.LocalValue,true,null,[[10,[21,82,true,null,4],[2,"_sv"]]]]],[3,0],[13,]]],[-1,cr.system_object.prototype.acts.SetVar,null,9062555490780763,false,[[11,"Unlocked_Plane2"],[7,[20,120,cr.plugins_.JSON.prototype.exps.Value,false,null,[[0,0],[2,"plane2"]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,6122915547480823,false,[[11,"Unlocked_Plane3"],[7,[20,120,cr.plugins_.JSON.prototype.exps.Value,false,null,[[0,0],[2,"plane3"]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,1573761392217661,false,[[11,"Unlocked_Plane4"],[7,[20,120,cr.plugins_.JSON.prototype.exps.Value,false,null,[[0,0],[2,"plane4"]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,7145754324192443,false,[[11,"Unlocked_Plane5"],[7,[20,120,cr.plugins_.JSON.prototype.exps.Value,false,null,[[0,0],[2,"plane5"]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,2088402580571128,false,[[11,"Stars"],[7,[20,120,cr.plugins_.JSON.prototype.exps.Value,false,null,[[0,0],[2,"stars"]]]]]],[-1,cr.system_object.prototype.acts.SetVar,null,5624565357789374,false,[[11,"SelectedPlane"],[7,[20,120,cr.plugins_.JSON.prototype.exps.Value,false,null,[[0,0],[2,"selectedplane"]]]]]]]],[0,null,false,null,3454978320162003,[[-1,cr.system_object.prototype.cnds.Else,null,0,false,false,false,9208252697117634,false]],[[-1,cr.system_object.prototype.acts.SetVar,null,2999730243220353,false,[[11,"SelectedPlane"],[7,[0,1]]]]]]]],[0,null,false,null,2075850945443841,[[-1,cr.system_object.prototype.cnds.OnLayoutEnd,null,1,false,false,false,5255895136289583,false]],[[79,cr.plugins_.Function.prototype.acts.CallFunction,null,8820001922229536,false,[[1,[2,"saveGame"]],[13,]]]]],[0,null,false,null,4767072557020303,[[79,cr.plugins_.Function.prototype.cnds.OnFunction,null,2,false,false,false,912076344839469,false,[[1,[2,"saveGame"]]]]],[[120,cr.plugins_.JSON.prototype.acts.SetValue,null,5424686956263284,false,[[7,[23,"Unlocked_Plane2"]],[3,0],[13,[7,[2,"plane2"]]]]],[120,cr.plugins_.JSON.prototype.acts.SetValue,null,2295951363554944,false,[[7,[23,"Unlocked_Plane3"]],[3,0],[13,[7,[2,"plane3"]]]]],[120,cr.plugins_.JSON.prototype.acts.SetValue,null,5113142483177496,false,[[7,[23,"Unlocked_Plane4"]],[3,0],[13,[7,[2,"plane4"]]]]],[120,cr.plugins_.JSON.prototype.acts.SetValue,null,7959530279646827,false,[[7,[23,"Unlocked_Plane5"]],[3,0],[13,[7,[2,"plane5"]]]]],[120,cr.plugins_.JSON.prototype.acts.SetValue,null,2182250179997474,false,[[7,[23,"SelectedPlane"]],[3,0],[13,[7,[2,"selectedplane"]]]]],[120,cr.plugins_.JSON.prototype.acts.SetValue,null,4648010760183049,false,[[7,[23,"Stars"]],[3,0],[13,[7,[2,"stars"]]]]],[20,cr.plugins_.WebStorage.prototype.acts.StoreLocal,null,4392073122246433,false,[[1,[10,[21,82,true,null,4],[2,"_sv"]]],[7,[20,120,cr.plugins_.JSON.prototype.exps.AsJson,true,null,[[0,0]]]]]]]]]]],"media/",true,1003,590,3,true,true,false,"1.0.0.0",0,true,2,true,188,false,[]];};