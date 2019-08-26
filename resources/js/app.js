/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(document).ready(function() {
    counter = 1;

    $(".text-danger").fadeTo(2500, 500).slideUp(500, function() {
        $("#success-alert").slideUp(500);
    });
    //DASHBOARD MENU
    $('#btn_show_dbs').on('click', function() {
        $('.hide_information').hide();
        $('#dbs_information').fadeIn();
    });

    $('#btn_show_tables').on('click', function() {
        $('.hide_information').hide();
        $('#tables_information').fadeIn();
    });

    $('#btn_show_views').on('click', function() {
        $('.hide_information').hide();
        $('#views_information').fadeIn();
    });

    $('#btn_show_index').on('click', function() {
        $('.hide_information').hide();
        $('#index_information').fadeIn();
    });

    $('#btn_show_constraints').on('click', function() {
        $('.hide_information').hide();
        $('#constraints_information').fadeIn();
    });

    $('#btn_show_triggers').on('click', function() {
        $('.hide_information').hide();
        $('#triggers_information').fadeIn();
    });

    $('#btn_show_sequences').on('click', function() {
        $('.hide_information').hide();
        $('#sequences_information').fadeIn();
    });

    $('#btn_show_stored_procedures').on('click', function() {
        $('.hide_information').hide();
        $('#stored_procedures_information').fadeIn();
    });



    //CREATE TABLE
    $("#addColumn").on("click", function() {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control" name="field_name' + counter + '" placeholder="Nombre"/></td>';
        cols += '<td> <select name="field_type' + counter + '" class="form-control custom-select"> ' +
            '<option value="varchar" selected>Varchar</option>' +
            '<option value="int">Number</option>' +
            '<option value="date">Date</option>' +
            '<option value="char">Char</option>' +
            '</select></td>';
        // cols += '<td><input type="text" class="form-control" name="field_limit' + counter + '" placeholder="Limite"/></td>';

        cols += '<td><input type="button" class="deleteRow btn btn-md btn-danger "  value="Eliminar"></td>';
        newRow.append(cols);
        $("#new_table").append(newRow);
        counter++;
    });

    $("#new_table").on("click", ".deleteRow", function(event) {
        if (counter > 1) {
            $(this).closest("tr").remove();
            counter -= 1
        } else {
            Snackbar.show({
                text: 'La tabla debe tener almenos 1 campo.',
                pos: 'bottom-center',
                actionText: 'OK',
            });
        }
    });

    $('#send_create_table').on('click', function(event) {
        event.preventDefault();

        var fields = [];
        var types = [];
        // var limits = [];

        for (let i = 0; i < counter; i++) {
            fields.push($('[name="field_name' + i + '"').val());
            types.push($('[name="field_type' + i + '"]').val());
            // limits.push($('[name="field_limit' + i + '"]').val());
        }
        $('#array_fields').val(fields);
        $('#array_types').val(types);
        $('#create_table_form').submit();
    });



    $('#send_edit_table').on('click', function(event) {
        event.preventDefault();
        var inputs = $(".table_item");
        var selects = $('.new_type');
        var new_cols = [];
        var new_types = [];

        for (var i = 0; i < inputs.length; i++) {
            new_cols.push($(inputs[i]).val());
        }

        for (var i = 0; i < selects.length; i++) {
            new_types.push($(selects[i]).val());
        }

        $('#new_cols').val(new_cols);
        $('#new_types').val(new_types);
        $('#edit_table_form').submit();
    });
});