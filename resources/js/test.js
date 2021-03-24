var app = new Vue({
    el: '#app2',
    data: {
        message: 'Hello Vue.js!'
    },
    methods: {
        reverseMessage: function () {
            this.message = this.message.split('').reverse().join('');
        }
    }
});

// 'use strict';

// let country = document.getElementById('country'),
//     region = document.getElementById('region');
//     city = document.getElementById('city');

// region.disabled = true;
// city.disabled = true;

// country.addEventListener('change', function () {
//     let val = country.options[country.selectedIndex].value;
//     let x = '"' + country.name + '"=' + val;
//     console.log(x);
//     console.log(val);
//     region.disabled = false;
'use strict';

window.$ = window.jQuery = require('jquery');

$(document).ready(function () {
    $('#region').prop('disabled', true);
    $('#city').prop('disabled', true);

    $('#country').on('change', function () {
        let countryId = $(this).val();
        let nameElement = $(this).prop('name');
        let data = {[nameElement]: countryId};
        $('#region').prop('disabled', false);
        
        $.ajax({
            type: 'POST',
            url: '/regions',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(response) {
                $('#region > option').remove();
                $.each(response, function(index, value) {
                    $('#region').append($('<option>', {
                        value: value.id,
                        text: value.region_name
                    }));
                });
            }
        });

    $('#region').on('change', function () {
        let cityId = $(this).val();
        let nameElement = $(this).prop('name');
        let data = {[nameElement]: cityId};
        $('#city').prop('disabled', false);

        $.ajax({
            type: 'POST',
            url: '/cities',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(response) {
                $('#city > option').remove();
                $.each(response, function(index, value) {
                    $('#city').append($('<option>', {
                        value: value.id,
                        text: value.city_name
                    }));
                });
            }
        });
    });
    });
});

//     let request = new XMLHttpRequest();
//     request.open('POST', '/regions');
//     request.setRequestHeader('X-CSRF-TOKEN', $("meta[name='csrf-token']").attr('content'));
//     request.send(x);

//     // let formData = new FormData(x);
//     // request.send(formData);

//     request.addEventListener('readystatechange', function() {
//         if (request.readyState === 4 && request.status == 200) {
//             // let reg = JSON.parse(request.responseText);
//             let response = request.response;
//             // console.log(reg);
//         }
//     });

// });
// region.setAttribute('disabled', 'disabled');
// city.setAttribute('disabled', 'disabled');

// console.log(country);
// console.log(region);
// console.log(city);
