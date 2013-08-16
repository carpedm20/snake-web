<?php
$url = 'http://hexa.perl.sh/~carpedm30/snake/snakeblack_secure.php';
$w = 540; // css 수정해야함
$h = 280; // css 수정해야함

include "mac.php";

$pk = '-----BEGIN RSA PRIVATE KEY-----
MIIBOwIBAAJBAKKKrwm8vUqsb05rHQpnZLVKUXVT1Hw+1jNnteD0nhg/jKviFzvl
Ja+mKSznPXdukpY19QCMBAFNgwTATh9U7w0CAwEAAQJAT21HlZGGSmwyw/YxrbjS
jIhxf8zkI4atM1d1mCTQ8HWt1GASPAqNlqJcCiJpOtAy12XAWvNZqX9C1Yx/+OgC
AQIhANZLfkg+x3Liw7mrjap6FlIFncW0ibNboYXBpRGKAIGBAiEAwizEWizTDkNs
oE+qRKo/COAkwcTUOePhPbWVELflG40CIAPCo16lK17Kt+CEMCIzrjyWOKSFfH0X
OIheU4UxRL0BAiEAtW3EzYkCb1paffPR4TS9jxp33cF+ltSw2cr3jFZ3MOUCIQCM
r7U7bZZjWvyca3sStwXSWrAP7WMDtUu2fQNbfD5bFQ==
-----END RSA PRIVATE KEY-----';

$kh = openssl_pkey_get_private($pk);
$details = openssl_pkey_get_details($kh);

function to_hex($data)
{
    return strtoupper(bin2hex($data));
}

$data = pack('H*', $_POST['data']);
if (openssl_private_decrypt($data, $r, $kh)) {
  $success = true;
}

if(get_magic_quotes_gpc()) {
  $name = stripslashes($_POST['name']);
} else {
  $name = $_POST['name'];
}
$pieces = explode("-", $r);
$score = $pieces[2];

$result = mysql_query("SELECT * from `snake` WHERE `name`='$name'");
$rowCount = mysql_num_rows($result);

if($rowCount !=0 ) {
	$data = mysql_fetch_array($result);
	$old_score = $data['score'];
	if($score > $old_score) {
		$que = "UPDATE `snake` set `score`=$score WHERE `name`='$name'";
		mysql_query($que);
	}
} else if($name != "" && $score != 0) {
	if(preg_match("/[a-zA-Z]/",$name))
		$name = substr($name,0,9);
	else if(preg_match("/[\xA1-\xFE\xA1-\xFE]/",$name))
		$name = substr($name,0,18);
	else
		$name = substr($name,0,9);

	$que = "INSERT INTO `snake` (name, score) VALUES('$name',$score)";
	mysql_query($que);
}
mysql_close();
?>
<!documentTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="snake.css" media="screen" />
<title>
Snake
</title>
<style type="text/css">
* {
font-family: Arial;
color: white !important;
}
input[type="button"] {
padding: 16px 10px;
	 margin-left: 10;
color: #FFF;
border: 2px solid #000;
}
div {
background-color:black;
float:left;
}
tr, th, input{
background-color:black;
}
body {
	text-align:center;
}
canvas {
border:5px solid #ccc;
background-color:black;
}
div.msg {
border:5px solid #ccc;
float:left;
width: 540;
height: 280;
}
div.msg_inner {
	margin-top: 85;
	margin-left: 150;
	text-align:left;
}
h1 {
	font-size:50px;
	text-align: center;
margin: 0;
	padding-bottom: 25px;
}
</style>
<script type="text/javascript">
var dbits;var canary=0xdeadbeefcafe;var j_lm=((canary&0xffffff)==0xefcafe);function BigInteger(a,b,c){if(a!=null)if("number"==typeof a)this.fromNumber(a,b,c);else if(b==null&&"string"!=typeof a)this.fromString(a,256);else this.fromString(a,b)}function nbi(){return new BigInteger(null)}function am1(i,x,w,j,c,n){while(--n>=0){var v=x*this[i++]+w[j]+c;c=Math.floor(v/0x4000000);w[j++]=v&0x3ffffff}return c}function am2(i,x,w,j,c,n){var a=x&0x7fff,xh=x>>15;while(--n>=0){var l=this[i]&0x7fff;var h=this[i++]>>15;var m=xh*l+h*a;l=a*l+((m&0x7fff)<<15)+w[j]+(c&0x3fffffff);c=(l>>>30)+(m>>>15)+xh*h+(c>>>30);w[j++]=l&0x3fffffff}return c}function am3(i,x,w,j,c,n){var a=x&0x3fff,xh=x>>14;while(--n>=0){var l=this[i]&0x3fff;var h=this[i++]>>14;var m=xh*l+h*a;l=a*l+((m&0x3fff)<<14)+w[j]+c;c=(l>>28)+(m>>14)+xh*h;w[j++]=l&0xfffffff}return c}if(j_lm&&(navigator.appName=="Microsoft Internet Explorer")){BigInteger.prototype.am=am2;dbits=30}else if(j_lm&&(navigator.appName!="Netscape")){BigInteger.prototype.am=am1;dbits=26}else{BigInteger.prototype.am=am3;dbits=28}BigInteger.prototype.DB=dbits;BigInteger.prototype.DM=((1<<dbits)-1);BigInteger.prototype.DV=(1<<dbits);var BI_FP=52;BigInteger.prototype.FV=Math.pow(2,BI_FP);BigInteger.prototype.F1=BI_FP-dbits;BigInteger.prototype.F2=2*dbits-BI_FP;var BI_RM="0123456789abcdefghijklmnopqrstuvwxyz";var BI_RC=new Array();var rr,vv;rr="0".charCodeAt(0);for(vv=0;vv<=9;++vv)BI_RC[rr++]=vv;rr="a".charCodeAt(0);for(vv=10;vv<36;++vv)BI_RC[rr++]=vv;rr="A".charCodeAt(0);for(vv=10;vv<36;++vv)BI_RC[rr++]=vv;function int2char(n){return BI_RM.charAt(n)}function intAt(s,i){var c=BI_RC[s.charCodeAt(i)];return(c==null)?-1:c}function bnpCopyTo(r){for(var i=this.t-1;i>=0;--i)r[i]=this[i];r.t=this.t;r.s=this.s}function bnpFromInt(x){this.t=1;this.s=(x<0)?-1:0;if(x>0)this[0]=x;else if(x<-1)this[0]=x+this.DV;else this.t=0}function nbv(i){var r=nbi();r.fromInt(i);return r}function bnpFromString(s,b){var k;if(b==16)k=4;else if(b==8)k=3;else if(b==256)k=8;else if(b==2)k=1;else if(b==32)k=5;else if(b==4)k=2;else{this.fromRadix(s,b);return}this.t=0;this.s=0;var i=s.length,mi=false,sh=0;while(--i>=0){var x=(k==8)?s[i]&0xff:intAt(s,i);if(x<0){if(s.charAt(i)=="-")mi=true;continue}mi=false;if(sh==0)this[this.t++]=x;else if(sh+k>this.DB){this[this.t-1]|=(x&((1<<(this.DB-sh))-1))<<sh;this[this.t++]=(x>>(this.DB-sh))}else this[this.t-1]|=x<<sh;sh+=k;if(sh>=this.DB)sh-=this.DB}if(k==8&&(s[0]&0x80)!=0){this.s=-1;if(sh>0)this[this.t-1]|=((1<<(this.DB-sh))-1)<<sh}this.clamp();if(mi)BigInteger.ZERO.subTo(this,this)}function bnpClamp(){var c=this.s&this.DM;while(this.t>0&&this[this.t-1]==c)--this.t}function bnToString(b){if(this.s<0)return"-"+this.negate().toString(b);var k;if(b==16)k=4;else if(b==8)k=3;else if(b==2)k=1;else if(b==32)k=5;else if(b==4)k=2;else return this.toRadix(b);var a=(1<<k)-1,d,m=false,r="",i=this.t;var p=this.DB-(i*this.DB)%k;if(i-->0){if(p<this.DB&&(d=this[i]>>p)>0){m=true;r=int2char(d)}while(i>=0){if(p<k){d=(this[i]&((1<<p)-1))<<(k-p);d|=this[--i]>>(p+=this.DB-k)}else{d=(this[i]>>(p-=k))&a;if(p<=0){p+=this.DB;--i}}if(d>0)m=true;if(m)r+=int2char(d)}}return m?r:"0"}function bnNegate(){var r=nbi();BigInteger.ZERO.subTo(this,r);return r}function bnAbs(){return(this.s<0)?this.negate():this}function bnCompareTo(a){var r=this.s-a.s;if(r!=0)return r;var i=this.t;r=i-a.t;if(r!=0)return(this.s<0)?-r:r;while(--i>=0)if((r=this[i]-a[i])!=0)return r;return 0}function nbits(x){var r=1,t;if((t=x>>>16)!=0){x=t;r+=16}if((t=x>>8)!=0){x=t;r+=8}if((t=x>>4)!=0){x=t;r+=4}if((t=x>>2)!=0){x=t;r+=2}if((t=x>>1)!=0){x=t;r+=1}return r}function bnBitLength(){if(this.t<=0)return 0;return this.DB*(this.t-1)+nbits(this[this.t-1]^(this.s&this.DM))}function bnpDLShiftTo(n,r){var i;for(i=this.t-1;i>=0;--i)r[i+n]=this[i];for(i=n-1;i>=0;--i)r[i]=0;r.t=this.t+n;r.s=this.s}function bnpDRShiftTo(n,r){for(var i=n;i<this.t;++i)r[i-n]=this[i];r.t=Math.max(this.t-n,0);r.s=this.s}function bnpLShiftTo(n,r){var a=n%this.DB;var b=this.DB-a;var d=(1<<b)-1;var e=Math.floor(n/this.DB),c=(this.s<<a)&this.DM,i;for(i=this.t-1;i>=0;--i){r[i+e+1]=(this[i]>>b)|c;c=(this[i]&d)<<a}for(i=e-1;i>=0;--i)r[i]=0;r[e]=c;r.t=this.t+e+1;r.s=this.s;r.clamp()}function bnpRShiftTo(n,r){r.s=this.s;var a=Math.floor(n/this.DB);if(a>=this.t){r.t=0;return}var b=n%this.DB;var c=this.DB-b;var d=(1<<b)-1;r[0]=this[a]>>b;for(var i=a+1;i<this.t;++i){r[i-a-1]|=(this[i]&d)<<c;r[i-a]=this[i]>>b}if(b>0)r[this.t-a-1]|=(this.s&d)<<c;r.t=this.t-a;r.clamp()}function bnpSubTo(a,r){var i=0,c=0,m=Math.min(a.t,this.t);while(i<m){c+=this[i]-a[i];r[i++]=c&this.DM;c>>=this.DB}if(a.t<this.t){c-=a.s;while(i<this.t){c+=this[i];r[i++]=c&this.DM;c>>=this.DB}c+=this.s}else{c+=this.s;while(i<a.t){c-=a[i];r[i++]=c&this.DM;c>>=this.DB}c-=a.s}r.s=(c<0)?-1:0;if(c<-1)r[i++]=this.DV+c;else if(c>0)r[i++]=c;r.t=i;r.clamp()}function bnpMultiplyTo(a,r){var x=this.abs(),y=a.abs();var i=x.t;r.t=i+y.t;while(--i>=0)r[i]=0;for(i=0;i<y.t;++i)r[i+x.t]=x.am(0,y[i],r,i,0,x.t);r.s=0;r.clamp();if(this.s!=a.s)BigInteger.ZERO.subTo(r,r)}function bnpSquareTo(r){var x=this.abs();var i=r.t=2*x.t;while(--i>=0)r[i]=0;for(i=0;i<x.t-1;++i){var c=x.am(i,x[i],r,2*i,0,1);if((r[i+x.t]+=x.am(i+1,2*x[i],r,2*i+1,c,x.t-i-1))>=x.DV){r[i+x.t]-=x.DV;r[i+x.t+1]=1}}if(r.t>0)r[r.t-1]+=x.am(i,x[i],r,2*i,0,1);r.s=0;r.clamp()}function bnpDivRemTo(m,q,r){var a=m.abs();if(a.t<=0)return;var b=this.abs();if(b.t<a.t){if(q!=null)q.fromInt(0);if(r!=null)this.copyTo(r);return}if(r==null)r=nbi();var y=nbi(),ts=this.s,ms=m.s;var c=this.DB-nbits(a[a.t-1]);if(c>0){a.lShiftTo(c,y);b.lShiftTo(c,r)}else{a.copyTo(y);b.copyTo(r)}var d=y.t;var f=y[d-1];if(f==0)return;var g=f*(1<<this.F1)+((d>1)?y[d-2]>>this.F2:0);var h=this.FV/g,d2=(1<<this.F1)/g,e=1<<this.F2;var i=r.t,j=i-d,t=(q==null)?nbi():q;y.dlShiftTo(j,t);if(r.compareTo(t)>=0){r[r.t++]=1;r.subTo(t,r)}BigInteger.ONE.dlShiftTo(d,t);t.subTo(y,y);while(y.t<d)y[y.t++]=0;while(--j>=0){var k=(r[--i]==f)?this.DM:Math.floor(r[i]*h+(r[i-1]+e)*d2);if((r[i]+=y.am(0,k,r,j,0,d))<k){y.dlShiftTo(j,t);r.subTo(t,r);while(r[i]<--k)r.subTo(t,r)}}if(q!=null){r.drShiftTo(d,q);if(ts!=ms)BigInteger.ZERO.subTo(q,q)}r.t=d;r.clamp();if(c>0)r.rShiftTo(c,r);if(ts<0)BigInteger.ZERO.subTo(r,r)}function bnMod(a){var r=nbi();this.abs().divRemTo(a,null,r);if(this.s<0&&r.compareTo(BigInteger.ZERO)>0)a.subTo(r,r);return r}function Classic(m){this.m=m}function cConvert(x){if(x.s<0||x.compareTo(this.m)>=0)return x.mod(this.m);else return x}function cRevert(x){return x}function cReduce(x){x.divRemTo(this.m,null,x)}function cMulTo(x,y,r){x.multiplyTo(y,r);this.reduce(r)}function cSqrTo(x,r){x.squareTo(r);this.reduce(r)}Classic.prototype.convert=cConvert;Classic.prototype.revert=cRevert;Classic.prototype.reduce=cReduce;Classic.prototype.mulTo=cMulTo;Classic.prototype.sqrTo=cSqrTo;function bnpInvDigit(){if(this.t<1)return 0;var x=this[0];if((x&1)==0)return 0;var y=x&3;y=(y*(2-(x&0xf)*y))&0xf;y=(y*(2-(x&0xff)*y))&0xff;y=(y*(2-(((x&0xffff)*y)&0xffff)))&0xffff;y=(y*(2-x*y%this.DV))%this.DV;return(y>0)?this.DV-y:-y}function Montgomery(m){this.m=m;this.mp=m.invDigit();this.mpl=this.mp&0x7fff;this.mph=this.mp>>15;this.um=(1<<(m.DB-15))-1;this.mt2=2*m.t}function montConvert(x){var r=nbi();x.abs().dlShiftTo(this.m.t,r);r.divRemTo(this.m,null,r);if(x.s<0&&r.compareTo(BigInteger.ZERO)>0)this.m.subTo(r,r);return r}function montRevert(x){var r=nbi();x.copyTo(r);this.reduce(r);return r}function montReduce(x){while(x.t<=this.mt2)x[x.t++]=0;for(var i=0;i<this.m.t;++i){var j=x[i]&0x7fff;var a=(j*this.mpl+(((j*this.mph+(x[i]>>15)*this.mpl)&this.um)<<15))&x.DM;j=i+this.m.t;x[j]+=this.m.am(0,a,x,i,0,this.m.t);while(x[j]>=x.DV){x[j]-=x.DV;x[++j]++}}x.clamp();x.drShiftTo(this.m.t,x);if(x.compareTo(this.m)>=0)x.subTo(this.m,x)}function montSqrTo(x,r){x.squareTo(r);this.reduce(r)}function montMulTo(x,y,r){x.multiplyTo(y,r);this.reduce(r)}Montgomery.prototype.convert=montConvert;Montgomery.prototype.revert=montRevert;Montgomery.prototype.reduce=montReduce;Montgomery.prototype.mulTo=montMulTo;Montgomery.prototype.sqrTo=montSqrTo;function bnpIsEven(){return((this.t>0)?(this[0]&1):this.s)==0}function bnpExp(e,z){if(e>0xffffffff||e<1)return BigInteger.ONE;var r=nbi(),r2=nbi(),g=z.convert(this),i=nbits(e)-1;g.copyTo(r);while(--i>=0){z.sqrTo(r,r2);if((e&(1<<i))>0)z.mulTo(r2,g,r);else{var t=r;r=r2;r2=t}}return z.revert(r)}function bnModPowInt(e,m){var z;if(e<256||m.isEven())z=new Classic(m);else z=new Montgomery(m);return this.exp(e,z)}BigInteger.prototype.copyTo=bnpCopyTo;BigInteger.prototype.fromInt=bnpFromInt;BigInteger.prototype.fromString=bnpFromString;BigInteger.prototype.clamp=bnpClamp;BigInteger.prototype.dlShiftTo=bnpDLShiftTo;BigInteger.prototype.drShiftTo=bnpDRShiftTo;BigInteger.prototype.lShiftTo=bnpLShiftTo;BigInteger.prototype.rShiftTo=bnpRShiftTo;BigInteger.prototype.subTo=bnpSubTo;BigInteger.prototype.multiplyTo=bnpMultiplyTo;BigInteger.prototype.squareTo=bnpSquareTo;BigInteger.prototype.divRemTo=bnpDivRemTo;BigInteger.prototype.invDigit=bnpInvDigit;BigInteger.prototype.isEven=bnpIsEven;BigInteger.prototype.exp=bnpExp;BigInteger.prototype.toString=bnToString;BigInteger.prototype.negate=bnNegate;BigInteger.prototype.abs=bnAbs;BigInteger.prototype.compareTo=bnCompareTo;BigInteger.prototype.bitLength=bnBitLength;BigInteger.prototype.mod=bnMod;BigInteger.prototype.modPowInt=bnModPowInt;BigInteger.ZERO=nbv(0);BigInteger.ONE=nbv(1);function parseBigInt(a,r){return new BigInteger(a,r)}function linebrk(s,n){var a="";var i=0;while(i+n<s.length){a+=s.substring(i,i+n)+"\n";i+=n}return a+s.substring(i,s.length)}function byte2Hex(b){if(b<0x10)return"0"+b.toString(16);else return b.toString(16)}function pkcs1pad2(s,n){if(n<s.length+11){alert("Message too long for RSA");return null}var a=new Array();var i=s.length-1;while(i>=0&&n>0){var c=s.charCodeAt(i--);if(c<128){a[--n]=c}else if((c>127)&&(c<2048)){a[--n]=(c&63)|128;a[--n]=(c>>6)|192}else{a[--n]=(c&63)|128;a[--n]=((c>>6)&63)|128;a[--n]=(c>>12)|224}}a[--n]=0;var b=new SecureRandom();var x=new Array();while(n>2){x[0]=0;while(x[0]==0)b.nextBytes(x);a[--n]=x[0]}a[--n]=2;a[--n]=0;return new BigInteger(a)}function RSAKey(){this.n=null;this.e=0;this.d=null;this.p=null;this.q=null;this.dmp1=null;this.dmq1=null;this.coeff=null}function RSASetPublic(N,E){if(N!=null&&E!=null&&N.length>0&&E.length>0){this.n=parseBigInt(N,16);this.e=parseInt(E,16)}else alert("Invalid RSA public key")}function RSADoPublic(x){return x.modPowInt(this.e,this.n)}function RSAEncrypt(a){var m=pkcs1pad2(a,(this.n.bitLength()+7)>>3);if(m==null)return null;var c=this.doPublic(m);if(c==null)return null;var h=c.toString(16);if((h.length&1)==0)return h;else return"0"+h}RSAKey.prototype.doPublic=RSADoPublic;RSAKey.prototype.setPublic=RSASetPublic;RSAKey.prototype.encrypt=RSAEncrypt;var rng_state;var rng_pool;var rng_pptr;function rng_seed_int(x){rng_pool[rng_pptr++]^=x&255;rng_pool[rng_pptr++]^=(x>>8)&255;rng_pool[rng_pptr++]^=(x>>16)&255;rng_pool[rng_pptr++]^=(x>>24)&255;if(rng_pptr>=rng_psize)rng_pptr-=rng_psize}function rng_seed_time(){rng_seed_int(new Date().getTime())}if(rng_pool==null){rng_pool=new Array();rng_pptr=0;var t;if(window.crypto&&window.crypto.getRandomValues){var ua=new Uint8Array(32);window.crypto.getRandomValues(ua);for(t=0;t<32;++t)rng_pool[rng_pptr++]=ua[t]}if(navigator.appName=="Netscape"&&navigator.appVersion<"5"&&window.crypto){var z=window.crypto.random(32);for(t=0;t<z.length;++t)rng_pool[rng_pptr++]=z.charCodeAt(t)&255}while(rng_pptr<rng_psize){t=Math.floor(65536*Math.random());rng_pool[rng_pptr++]=t>>>8;rng_pool[rng_pptr++]=t&255}rng_pptr=0;rng_seed_time()}function rng_get_byte(){if(rng_state==null){rng_seed_time();rng_state=prng_newstate();rng_state.init(rng_pool);for(rng_pptr=0;rng_pptr<rng_pool.length;++rng_pptr)rng_pool[rng_pptr]=0;rng_pptr=0}return rng_state.next()}function rng_get_bytes(a){var i;for(i=0;i<a.length;++i)a[i]=rng_get_byte()}function SecureRandom(){}SecureRandom.prototype.nextBytes=rng_get_bytes;function Arcfour(){this.i=0;this.j=0;this.S=new Array()}function ARC4init(a){var i,j,t;for(i=0;i<256;++i)this.S[i]=i;j=0;for(i=0;i<256;++i){j=(j+this.S[i]+a[i%a.length])&255;t=this.S[i];this.S[i]=this.S[j];this.S[j]=t}this.i=0;this.j=0}function ARC4next(){var t;this.i=(this.i+1)&255;this.j=(this.j+this.S[this.i])&255;t=this.S[this.i];this.S[this.i]=this.S[this.j];this.S[this.j]=t;return this.S[(t+this.S[this.i])&255]}Arcfour.prototype.init=ARC4init;Arcfour.prototype.next=ARC4next;function prng_newstate(){return new Arcfour()}var rng_psize=256;var rsa=new RSAKey();rsa.setPublic('<?php echo to_hex($details['rsa']['n']) ?>','<?php echo to_hex($details['rsa']['e']) ?>');var score=0;var dead=false;function proceed(){var a=document.createElement("form");a.setAttribute("method","POST");a.setAttribute("action","<?echo $url;?>");var b=document.createElement("input");b.setAttribute("type","hidden");b.setAttribute("name","data");var c=document.getElementById("name").value;var d=new Date();b.setAttribute("value",rsa.encrypt(d.getSeconds()+'-'+c+'-'+score.toString()));a.appendChild(b);var b=document.createElement("input");b.setAttribute("type","hidden");b.setAttribute("name","name");b.setAttribute("value",c);a.appendChild(b);document.body.appendChild(a);a.submit()}

function play_game() 
{
	var hacked = "Hacked by HeXA ";
	var hacked_idx = 0;
	var rec_size = 20;
	var level = 100;
	// Game level, by decreasing will speed up
	var rect_w = <?echo $w;?> / rec_size;
	// Width 
	var rect_h = <?echo $h;?> / rec_size;
	// Height
	//var inc_score = 50;
	// Score
	var color_array = ["#809799","#FFD82D","#6E67E8","#4769FF","#BBB","#FF583A"];
	var color_array2 = ["#C9C9C7","#FFF39C","#8E8FE8","#96A5FF","#EEE","#FF9E89"];
	var color_idx = Math.floor(Math.random() * color_array.length);
	var snake_color = color_array[color_idx];
	var food_color = color_array2[color_idx];
	// Snake Color
	var ctx;
	// Canvas attributes
	var tn = [];
	// temp directions storage
	var x_dir = [-1, 0, 1, 0];
	// position adjusments
	var y_dir = [0, -1, 0, 1];
	// position adjusments
	var queue = [];

	var frog = 1;
	// defalut food
	var map = [];
	var MR = Math.random;

	var X = 5 + (MR() * (rect_w - rec_size))|0;
	// Calculate positions
	var Y = 5 + (MR() * (rect_h - rec_size))|0;
	// Calculate positions
	var direction = MR() * 3 | 0;

	var interval = 0;
	score = 0;
	var sum = 0, easy = 0;
	var i, dir;
	// getting play area 
	var c = document.getElementById('playArea');
	ctx = c.getContext('2d');
	// Map positions
	for (i = 0; i < rect_w; i++)
	{
		map[i] = [];
	}
	// random placement of snake food
	function rand_frog() 
	{
		var x, y;
		do 
		{
			x = MR() * rect_w|0;
			y = MR() * rect_h|0;
		}

		while (map[x][y]);
		map[x][y] = 1;
		ctx.fillStyle = food_color;
		//ctx.strokeRect(x * rec_size+1, y * rec_size+1, rec_size-2, rec_size-2);
		ctx.fillRect(x * rec_size, y * rec_size, rec_size-1, rec_size-1);
		ctx.fillStyle = snake_color;
	}
	// Default somewhere placement 
	rand_frog();

	function set_game_speed() 
	{
		if (easy) 
		{
			X = (X+rect_w)%rect_w;
			Y = (Y+rect_h)%rect_h;
		}
		//--inc_score;
		if (tn.length) 
		{
			dir = tn.pop();
			if ((dir % 2) !== (direction % 2)) 
			{
				direction = dir;
			}
		}
		if ((easy || (0 <= X && 0 <= Y && X < rect_w && Y < rect_h)) && 2 !== map[X][Y]) 
		{
			if (1 === map[X][Y]) 
			{
				//score+= Math.max(5, inc_score);
				score+=1;
				var s = document.getElementById("score");
				s.innerText = score;
				//inc_score = 50;
				rand_frog();
				frog++;
			}
			//ctx.fillStyle("#ffffff");
			ctx.fillStyle = snake_color;
			ctx.fillRect(X * rec_size, Y * rec_size, rec_size-1, rec_size-1);
			ctx.fillStyle = food_color;
			ctx.font = "13pt Arial";
			if(hacked_idx == hacked.length)
				hacked_idx = 0;
			ctx.fillText(hacked[hacked_idx],X * rec_size+4, Y * rec_size+16);
			hacked_idx += 1;

			map[X][Y] = 2;
			queue.unshift([X, Y]);
			X+= x_dir[direction];
			Y+= y_dir[direction];
			if (frog < queue.length) 
			{
				dir = queue.pop()
					map[dir[0]][dir[1]] = 0;
				ctx.clearRect(dir[0] * rec_size, dir[1] * rec_size, rec_size, rec_size);
			}
		}
		else if (!tn.length) 
		{
			var msg_score = document.getElementById("msg");
			dead = true;
			//msg_score.innerHTML = "Thank you for playing game.<br /> Your Score : <b>"+score+"</b><br /><br /><input type='button' value='Play Again' onclick='window.location.reload();' />";
			msg_score.innerHTML = '<div class="msg"><div class="msg_inner"><div style="display: inline-block;"> &nbsp;&nbsp; Hacker\'s eXciting Academy</div><br style="line-height:39px;"/><div>Score : <b>'+score+'</b></br>Name : <input id="name" type="text" size="16" value="<?=$_POST['name']?>"></br></div><div><input type="button" style="background-color: '+snake_color+';border-color:'+food_color+';" value="Submit" onclick="proceed();"></div></div></div>';
			document.getElementById("playArea").style.display = 'none';
			window.clearInterval(interval);
		}
	}

	interval = window.setInterval(set_game_speed, level);
	
	document.onkeydown = function(e) {
		var key = e.keyCode;
		if(key==35||key==36||key==37||key==39||key==40||key==38) {
			e.preventDefault();
		}
		if(e.keyCode == 13 && dead == true) {
			var name = document.getElementById("name");

			if(name.value!='')
				proceed();
			else
				name.focus();
		}
		var code = e.keyCode - 37;
		if (0 <= code && code < 4 && code !== tn[0]) 
		{
			tn.unshift(code);
		}

		else if (-5 == code) 
		{
			if (interval) 
			{
				window.clearInterval(interval);
				interval = 0;
			}

			else 
			{
				interval = window.setInterval(set_game_speed, 60);
			}
		}
		else 
		{

			dir = sum + code;
			if (dir == 44||dir==94||dir==126||dir==171) {
				sum+= code
			}
			else if (dir === 218) easy = 1;
		}
	}
}
</script>
</head>
<body onload="play_game()">
<div id="msg">
</div>
<canvas style="float:left" id="playArea" width="<?echo $w;?>" height="<?echo $h;?>">
Sorry your browser does not support HTML5
</canvas>
<div>
<div style="float:none; border-right:5px solid #ccc; border-top:5px solid #ccc; width:150; height:25;">
Score: <span id="score">0</span>
</div>
<div style="float:none; border-right:5px solid #ccc; border-top:5px solid #ccc; border-bottom:5px solid #ccc; width:150; height:250; overflow:auto;">
<table id="hor-minimalist-b" cellspacing="0" cellpadding="0" style="margin:0; width:150;" summary="Snake Ranking">
<thead>
<tr>
<th scope="col" style="padding: 5px 9px;">#</th>
<th scope="col" style="padding: 5px 5px;">id</th>
<th scope="col" style="padding: 5px 5px;">sc</th>
</tr>
</thead>
<tbody>
<?
include "mac.php";
$result = mysql_query("select * from `snake` ORDER BY `score` DESC, `index` ASC");
$count = 1;
while($data = mysql_fetch_array($result))
{
	$idx = $data['index'];
	$name = $data['name'];
	$score = $data['score'];

	echo "<tr><td>$count</td>";
	echo "<td>$name</td>";
	echo "<td>$score</td></tr>";
	$count += 1;
}
?>
</tbody>
</table>
</div>
</div>
</body>
</html>
