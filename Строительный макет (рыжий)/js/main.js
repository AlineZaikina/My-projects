document.addEventListener('DOMContentLoaded', function() {
    var sidenav = document.querySelectorAll('.sidenav');
    var instances_sidenav = M.Sidenav.init(sidenav);
    var modal = document.querySelectorAll('.modal');
    var instances_modal = M.Modal.init(modal);
    var galery = document.querySelectorAll('.materialboxed');
    var instances_galery = M.Materialbox.init(galery);
  });