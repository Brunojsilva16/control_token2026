<?php $title = "Pesquisa"; ?>
<?php include 'includes/timezone.php'; ?>

<?php include 'includes/sessao.php'; ?>
<?php
if ($_SESSION['usuario']['tipo'] != 2) {
    $sideb = 'includes/siderbar_pf.php';

//     $dropProf = '<select name="idprof[]" class="form-control">
// <option value=' . $_SESSION['usuario']['id'] . '>' . $_SESSION['usuario']['nome'] . '</option>
// </select>';
} else {
    $sideb = 'includes/siderbar.php';
    // $dropProf = '<select id="nomeprof" name="idprof[]" multiple class="form-control" selected="true" size=8>
    //             </select>';
}
?>

<?php include 'includes/head.php'; ?>

<body id="indexs">

    <div class="wrapper">


        <select class="selectpicker" id="selopt" multiple>
            <option value="0">Select From List</option>
            <option value="1">Volvo</option>
            <option value="2">Saab</option>
            <option value="3">Mercedes</option>
            <option value="4">Audi</option>
        </select>
        <br>
        <button id="resetForm" class="btn btn-success">Reset</button>





    </div>


    <div>
        <select class="selectpicker" id="selopt" multiple>
            <option value="0">Select From List</option>
            <option value="1">Volvo</option>
            <option value="2">Saab</option>
            <option value="3">Mercedes</option>
            <option value="4">Audi</option>
        </select>
        <br>
        <select class="selectpicker" id="newselopt" multiple>
            <option value="0">Select From List</option>
            <option value="1">Volvo</option>
            <option value="2">Saab</option>
            <option value="3">Mercedes</option>
            <option value="4">Audi</option>
        </select>
    </div>



    <?php include 'includes/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            // two way to select text 
            $("#element :selected").text();

            $("#newselopt :selected").text();
            $("#selopt option:selected").text();


            $('.selectpicker').selectpicker();
            $('#resetForm').on("click", function() {
                $("#selopt").selectpicker('deselectAll');
                // $('select[name=mesref]').selectpicker('val', '');
                // $('#selopt').selectpicker('val', 'Saab');

            });


            // $('#selopt').on('change', function() {
            //     var selectText = $("#selopt option:selected").text();
            //     alert(selectText);
            // });

            // $('#newselopt').on('change', function() {
            //     var newselectText = $("#newselopt :selected").text();
            //     alert(newselectText);
            // });

        });


        var hamburger = document.querySelector(".hamburger");
        hamburger.addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        })

        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>

</body>

</html>