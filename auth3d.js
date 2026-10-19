(function () {
  var t = document.getElementById('tilt');
  if (!t || matchMedia('(prefers-reduced-motion: reduce)').matches || !matchMedia('(hover: hover)').matches) return;
  document.addEventListener('mousemove', function (e) {
    var x = e.clientX / innerWidth - 0.5, y = e.clientY / innerHeight - 0.5;
    t.style.transform = 'rotateY(' + (x * 14) + 'deg) rotateX(' + (-y * 14) + 'deg)';
  });
  document.addEventListener('mouseleave', function () { t.style.transform = ''; });
})();
