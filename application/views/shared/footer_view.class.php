<?php

class Footer_View extends Trident_Abstract_View
{
    public function render()
    {
?>
<script>
    setTimeout(function() { $('.alert-dismissible').alert('close'); }, 5000);
</script>
</body>
</html>
<?php
    }
}