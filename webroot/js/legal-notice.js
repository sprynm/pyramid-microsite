(function () {
  "use strict";

  var notice = document.querySelector("[data-legal-notice]");
  if (!notice) return;

  var storageKey = "legal_notice_dismissed";
  var dismissValue = "1";

  try {
    if (window.localStorage && window.localStorage.getItem(storageKey) === dismissValue) {
      notice.setAttribute("hidden", "hidden");
      return;
    }
  } catch (_error) {
    // If localStorage is unavailable, keep showing the notice.
  }

  notice.addEventListener("rh:closed", function () {
    try {
      if (window.localStorage) {
        window.localStorage.setItem(storageKey, dismissValue);
      }
    } catch (_error) {
      // Ignore storage write failures.
    }
  });
})();
