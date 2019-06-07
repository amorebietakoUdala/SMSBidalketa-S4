(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./assets/css/app.scss":
/*!*****************************!*\
  !*** ./assets/css/app.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var popper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js");
/* harmony import */ var _css_app_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../css/app.scss */ "./assets/css/app.scss");
/* harmony import */ var _css_app_scss__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_css_app_scss__WEBPACK_IMPORTED_MODULE_3__);




jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).ready(function () {
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('#js-locale-es').on('click', function (e) {
    e.preventDefault();
    var current_locale = jquery__WEBPACK_IMPORTED_MODULE_0___default()('html').attr("lang");

    if (current_locale === 'es') {
      return;
    }

    var location = window.location.href;
    var location_new = location.replace("/eu/", "/es/");
    window.location.href = location_new;
  });
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('#js-locale-eu').on('click', function (e) {
    e.preventDefault();
    var current_locale = jquery__WEBPACK_IMPORTED_MODULE_0___default()('html').attr("lang");

    if (current_locale === 'eu') {
      return;
    }

    var location = window.location.href;
    var location_new = location.replace("/es/", "/eu/");
    window.location.href = location_new;
  });
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('.js-back').on('click', function (e) {
    e.preventDefault();
    var url = e.currentTarget.dataset.url;
    document.location.href = url;
  });
});

/***/ })

},[["./assets/js/app.js","runtime","vendors~app~contact_edit_view~contact_import_view~contact_list_view~contact_new_view~label_edit_view~b8e0cfcd","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5zY3NzIiwid2VicGFjazovLy8uL2Fzc2V0cy9qcy9hcHAuanMiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50IiwicmVhZHkiLCJvbiIsImUiLCJwcmV2ZW50RGVmYXVsdCIsImN1cnJlbnRfbG9jYWxlIiwiYXR0ciIsImxvY2F0aW9uIiwid2luZG93IiwiaHJlZiIsImxvY2F0aW9uX25ldyIsInJlcGxhY2UiLCJ1cmwiLCJjdXJyZW50VGFyZ2V0IiwiZGF0YXNldCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUEsdUM7Ozs7Ozs7Ozs7OztBQ0FBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFFQTtBQUVBQSw2Q0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsS0FBWixDQUFrQixZQUFVO0FBQ3hCRiwrQ0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQkcsRUFBbkIsQ0FBc0IsT0FBdEIsRUFBOEIsVUFBVUMsQ0FBVixFQUFhO0FBQzdDQSxLQUFDLENBQUNDLGNBQUY7QUFDQSxRQUFJQyxjQUFjLEdBQUdOLDZDQUFDLENBQUMsTUFBRCxDQUFELENBQVVPLElBQVYsQ0FBZSxNQUFmLENBQXJCOztBQUNBLFFBQUtELGNBQWMsS0FBSyxJQUF4QixFQUE4QjtBQUM3QjtBQUNBOztBQUNELFFBQUlFLFFBQVEsR0FBR0MsTUFBTSxDQUFDRCxRQUFQLENBQWdCRSxJQUEvQjtBQUNBLFFBQUlDLFlBQVksR0FBR0gsUUFBUSxDQUFDSSxPQUFULENBQWlCLE1BQWpCLEVBQXdCLE1BQXhCLENBQW5CO0FBQ0FILFVBQU0sQ0FBQ0QsUUFBUCxDQUFnQkUsSUFBaEIsR0FBcUJDLFlBQXJCO0FBQ0csR0FURDtBQVVBWCwrQ0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQkcsRUFBbkIsQ0FBc0IsT0FBdEIsRUFBOEIsVUFBVUMsQ0FBVixFQUFhO0FBQzdDQSxLQUFDLENBQUNDLGNBQUY7QUFDQSxRQUFJQyxjQUFjLEdBQUdOLDZDQUFDLENBQUMsTUFBRCxDQUFELENBQVVPLElBQVYsQ0FBZSxNQUFmLENBQXJCOztBQUNBLFFBQUtELGNBQWMsS0FBSyxJQUF4QixFQUE4QjtBQUM3QjtBQUNBOztBQUNELFFBQUlFLFFBQVEsR0FBR0MsTUFBTSxDQUFDRCxRQUFQLENBQWdCRSxJQUEvQjtBQUNBLFFBQUlDLFlBQVksR0FBR0gsUUFBUSxDQUFDSSxPQUFULENBQWlCLE1BQWpCLEVBQXdCLE1BQXhCLENBQW5CO0FBQ0FILFVBQU0sQ0FBQ0QsUUFBUCxDQUFnQkUsSUFBaEIsR0FBcUJDLFlBQXJCO0FBQ0csR0FURDtBQVVIWCwrQ0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjRyxFQUFkLENBQWlCLE9BQWpCLEVBQXlCLFVBQVNDLENBQVQsRUFBVztBQUNuQ0EsS0FBQyxDQUFDQyxjQUFGO0FBQ0EsUUFBSVEsR0FBRyxHQUFHVCxDQUFDLENBQUNVLGFBQUYsQ0FBZ0JDLE9BQWhCLENBQXdCRixHQUFsQztBQUNBWixZQUFRLENBQUNPLFFBQVQsQ0FBa0JFLElBQWxCLEdBQXVCRyxHQUF2QjtBQUNBLEdBSkQ7QUFLQSxDQTFCRCxFIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5pbXBvcnQgJ2Jvb3RzdHJhcCc7XG5pbXBvcnQgJ3BvcHBlci5qcyc7XG5cbmltcG9ydCAnLi4vY3NzL2FwcC5zY3NzJztcblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcbiAgICAkKCcjanMtbG9jYWxlLWVzJykub24oJ2NsaWNrJyxmdW5jdGlvbiAoZSkge1xuXHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0XHR2YXIgY3VycmVudF9sb2NhbGUgPSAkKCdodG1sJykuYXR0cihcImxhbmdcIik7XG5cdFx0aWYgKCBjdXJyZW50X2xvY2FsZSA9PT0gJ2VzJykge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblx0XHR2YXIgbG9jYXRpb24gPSB3aW5kb3cubG9jYXRpb24uaHJlZjtcblx0XHR2YXIgbG9jYXRpb25fbmV3ID0gbG9jYXRpb24ucmVwbGFjZShcIi9ldS9cIixcIi9lcy9cIik7XG5cdFx0d2luZG93LmxvY2F0aW9uLmhyZWY9bG9jYXRpb25fbmV3O1xuICAgIH0pO1xuICAgICQoJyNqcy1sb2NhbGUtZXUnKS5vbignY2xpY2snLGZ1bmN0aW9uIChlKSB7XG5cdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdHZhciBjdXJyZW50X2xvY2FsZSA9ICQoJ2h0bWwnKS5hdHRyKFwibGFuZ1wiKTtcblx0XHRpZiAoIGN1cnJlbnRfbG9jYWxlID09PSAnZXUnKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXHRcdHZhciBsb2NhdGlvbiA9IHdpbmRvdy5sb2NhdGlvbi5ocmVmO1xuXHRcdHZhciBsb2NhdGlvbl9uZXcgPSBsb2NhdGlvbi5yZXBsYWNlKFwiL2VzL1wiLFwiL2V1L1wiKTtcblx0XHR3aW5kb3cubG9jYXRpb24uaHJlZj1sb2NhdGlvbl9uZXc7XG4gICAgfSk7XG5cdCQoJy5qcy1iYWNrJykub24oJ2NsaWNrJyxmdW5jdGlvbihlKXtcblx0XHRlLnByZXZlbnREZWZhdWx0KCk7XG5cdFx0dmFyIHVybCA9IGUuY3VycmVudFRhcmdldC5kYXRhc2V0LnVybDtcblx0XHRkb2N1bWVudC5sb2NhdGlvbi5ocmVmPXVybDtcblx0fSk7XG59KTtcblxuIl0sInNvdXJjZVJvb3QiOiIifQ==