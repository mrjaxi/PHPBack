</div>
</div>
<hr>
<div class="footer">  &copy; <?php echo date("Y") ?> - Работает на <a href="http://www.phpback.org/" target="_blank">PHPBack</a></div>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap-select.js"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap-switch.js"></script>
<script src="<?php echo base_url(); ?>public/js/flatui-checkbox.js"></script>
<script src="<?php echo base_url(); ?>public/js/flatui-radio.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.tagsinput.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.placeholder.js"></script>
<script src="<?php echo base_url(); ?>public/bootstrap/js/application.js"></script>
<script>
    $('.popover-with-html').popover({ html : true });
    $('.contentdiv').css('width', '100%').css('width', '-=400px')
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
</script>
</body>
</html>