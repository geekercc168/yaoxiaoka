(window.webpackJsonp=window.webpackJsonp||[]).push([[11],{697:function(e,t,a){e.exports={vipGradeWrap:"_3pJhTumzO7sPROBGrDo5cm",fadeIn:"_2dxpj3p4t46rl8tT1lR35H",gradeBox:"_33H8JWbjIBxJogAtlCAgB8",bounceInUp:"_36dRvSh6h9IVRFYktWktQi",privilege:"_1DnQcBGXm-Fxz-oCDgHNqj",title:"_2D1FjnqRIJlA3LQNPwoMVv",privilegeDetail:"_15HEF3DzdtKsIpLHIy8M50",item:"_3JonkzlYYZYicd02XVG7m3",itemImg:"_2HHc1Rpkc11qscPzDUFS9F",bonus:"_1TNBJyAOExLnRs08s-vgsT",redPack:"_14gZpd6CURJgotyxr1l9EM",discount:"_2NmORJwtCzJkyT5shK9YNI",birthday:"_1bn2QmGs9T1xmikpsQT4nt",return:"_3iNZ1po5daG1NDlj7jqcqm",haoli:"Ro8k7HWqN5qC-7WMN6PCO",viewDetail:"tjCgvbu9RY3Q8qGl8p2gp",light:"A2zi7f7c3BVL6gfieSydj",moveButtonLight:"_2X8wBpPBYsaZzJMtI6_8Xn",card:"_2cHX1uW12AkQ6fTDpRVS1L",upgradeLevel:"_2YLCOkdia3IijvDzK8lB7z",upgradeTip:"_38W2aUR04Gh7VNuwunzJCI",level:"_22T-meS6gFZE6VzgsjNEoF",levelInfo:"_1sVhfAt7H4cvUT_R9EMUBr",downVip:"_2fPmaUELL50dlDCrqM3tzs",fadeInDown:"_3hROQhzx6wyD_qcSWUnWFu",upVip:"TYfaC_ZUWfYHHUO3xSzqR",fadeInUp:"_1vCe6_VsBeXuBlUcN2eAIg",line:"Xc_B2veaw5aWKIXLm6xDQ",upgradeAmounts:"_2tjCgBdf5MLbihSKQUVO-T",upgradeFlag:"dbtkqrLMUbXagJSGyq6Y-",upgradeMoney:"aVvNtzdXrQL_iOaRSCFw",moveCardLight:"TLh-FMBjqbTbpEa2ynZM8",vipBg:"_3TbdiAG_Eb0OvNIXK_G6UL"}},880:function(e,t,a){"use strict";a.r(t);var n=a(4),r=a(43),l=a(6),i=a(87),s=a(0),m=a(697),c=a.n(m),o=function(){var e=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var a in t)t.hasOwnProperty(a)&&(e[a]=t[a])};return function(t,a){function n(){this.constructor=t}e(t,a),t.prototype=null===a?Object.create(a):(n.prototype=a.prototype,new n)}}(),d=function(e,t,a,n){var r,l=arguments.length,i=l<3?t:null===n?n=Object.getOwnPropertyDescriptor(t,a):n;if("object"===typeof Reflect&&"function"===typeof Reflect.decorate)i=Reflect.decorate(e,t,a,n);else for(var s=e.length-1;s>=0;s--)(r=e[s])&&(i=(l<3?r(i):l>3?r(t,a,i):r(t,a))||i);return l>3&&i&&Object.defineProperty(t,a,i),i},u=function(e){function t(t){var a=e.call(this,t)||this;return a.upGradeDetail=function(e){var t=[{imgClass:"bonus",title:"\u5347\u7ea7\u5956\u91d1"},{imgClass:"redPack",title:"\u6bcf\u6708\u7ea2\u5305"},{imgClass:"discount",title:"\u664b\u7ea7\u4f18\u60e0"},{imgClass:"return",title:"VIP"+e+"\u8fd4\u6c34"}],a={imgClass:"birthday",title:"\u751f\u65e5\u793c\u91d1"};return Number(e)<5?t:5===Number(e)?(t.splice(3,0,a),t):(t.splice(3,0,a),t.push({imgClass:"haoli",title:"VIP\u8c6a\u793c"}),t)},a.renderPrivilege=function(){var e=a.state.modalStatus;return n.createElement(n.Fragment,null,n.createElement("div",{className:c.a.title},n.createElement("span",null),n.createElement("h2",null,"\u6211\u7684\u65b0\u7279\u6743"),n.createElement("span",null)),n.createElement("div",{className:c.a.privilegeDetail},a.upGradeDetail(e.memberGrade).map((function(e,t){return n.createElement("div",{key:t,className:c.a.item},n.createElement("div",{className:s.b.reactClassNameJoin(c.a.itemImg,c.a[e.imgClass])}),n.createElement("span",null,e.title))}))),n.createElement("div",{className:c.a.viewDetail},n.createElement(i.a,{onTap:function(){l.b.push("/app/vip"),a.props.dispatch({type:"funds/setVipUpGradeModalReducer",payload:{data:{show:!1,memberGrade:0,amount:0}}}),a.props.dispatch({type:"vip/setRefeshVipPageReducer",payload:!0})}},n.createElement("button",null,"\u67e5\u770b\u8be6\u60c5")),n.createElement("i",{className:c.a.light})))},a.renderCard=function(){var e=a.state,t=e.modalStatus,r=e.startAnimation;return n.createElement(n.Fragment,null,n.createElement("div",{className:c.a.upgradeLevel},n.createElement("div",{className:c.a.upgradeTip},n.createElement("h3",null,"\u606d\u559c\u5347\u7ea7\u6210\u4e3a"),n.createElement("h1",null,"VIP",n.createElement("span",{className:s.b.isJudge(r)(c.a.fadeIn,null)},t.memberGrade))),n.createElement("div",{className:c.a.level},n.createElement("div",{className:c.a.levelInfo},n.createElement("h4",null,"VIP"),n.createElement("h3",{className:s.b.isJudge(r)(c.a.downVip,null)},t.memberGrade),s.b.isJudge(r)(n.createElement("h3",{className:s.b.isJudge(r)(c.a.upVip,null)},t.memberGrade),null)))),n.createElement("div",{className:c.a.line}),n.createElement("div",{className:c.a.upgradeAmounts},n.createElement("div",{className:c.a.upgradeFlag}),n.createElement("div",{className:c.a.upgradeMoney},n.createElement("h3",null,"\u5347\u7ea7\u793c\u91d1",n.createElement("span",null,t.amount),"\u5143"),n.createElement("h6",null,"\u5df2\u6d3e\u53d1\u81f3\u60a8\u7684\u4e2d\u5fc3\u94b1\u5305\u54e6\uff5e"))),n.createElement("i",{className:c.a.light}))},a.state={modalStatus:{show:!1,memberGrade:0,amount:0},startAnimation:!1},a}return o(t,e),t.prototype.componentDidMount=function(){},t.prototype.componentWillReceiveProps=function(e){var t=this,a=e.state.vipUpGradeModalStatus;JSON.stringify(a)&&JSON.stringify(a)!==JSON.stringify(this.props.state.vipUpGradeModalStatus)&&(this.setState({modalStatus:{show:a.show,memberGrade:a.memberGrade-1,amount:a.amount}}),setTimeout((function(){var e=Object.assign({},t.state.modalStatus,{memberGrade:a.memberGrade});t.setState({modalStatus:e,startAnimation:!0})}),1300))},t.prototype.render=function(){var e=this;return this.state.modalStatus.show&&n.createElement(i.a,{onTap:function(){e.props.dispatch({type:"funds/setVipUpGradeModalReducer",payload:{data:{show:!1,memberGrade:0,amount:0}}})}},n.createElement("div",{className:c.a.vipGradeWrap},n.createElement("div",{className:c.a.gradeBox},n.createElement("div",{className:c.a.privilege},this.renderPrivilege()),n.createElement("div",{className:c.a.card},this.renderCard()),n.createElement("div",{className:c.a.vipBg}))))},t=d([Object(r.b)((function(e){return{state:e.fundsFlow,all:e}}))],t)}(n.PureComponent);t.default=u}}]);