"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_dashboard_js"],{

/***/ "./resources/js/dashboard.js":
/*!***********************************!*\
  !*** ./resources/js/dashboard.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var funcs = {
  selectQuiz: function selectQuiz(e) {
    console.log(e.target.value);
    var broadcastBtn = document.getElementById('begin-broadcast-button');
    var deleteBtn = document.getElementById('delete-quiz-button');
    broadcastBtn.setAttribute('disabled', '');
    deleteBtn.setAttribute('disabled', '');
  },
  broadcastBtnClick: function broadcastBtnClick() {
    console.log('hello');
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (funcs);

/***/ })

}]);