<?php
require 'footer.php';
?>


<script src="/resources/js/bootstrap.bundle.min.js">
</script>
<script>
    // Remove the error and message params
    const url = new URL(window.location.href);
    url.searchParams.delete('message');
    url.searchParams.delete('error');

    window.history.replaceState({}, '', url);
</script>
</body>

</html>