<!DOCTYPE html>
<html lang="en">
@include('includes.head')
<body>
    <div id="app">
    </div>
</body>
<script>
    window.authUser = {!! json_encode($user); !!};
</script>
</html>