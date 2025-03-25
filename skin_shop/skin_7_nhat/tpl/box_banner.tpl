<!-- Banner_top -->
<div class="top-banner position-relative" style="background: #ec720e">
    <div class="container text-center px-0">
      {noidung_header}
      <button type="button" class="close" aria-label="Close" style="z-index: 9">
        <button type="button" class="close" onclick="toggleBanner(true)" aria-label="Close" style="z-index: 9">
          <span aria-hidden="true">×</span>
        </button>
      </button>
    </div>
  </div>

  <script>
    $(document).ready(() => {
      $(".top-banner .close").click(() => {
        $(".top-banner").slideToggle();
        sessionStorage.setItem("top-banner", true);
      });
    });
  </script>