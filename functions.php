<?php
add_action('wp_footer','hawthornelogistics_script');
function hawthornelogistics_script()
{
?>
<!-- Google Place Api added -->
<script   type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eC9mylX4YJJMlWCiRpKZB8k1VmFeqdA&#038;libraries=places&#038;language=en&#038;ver=1' id='google_autocomplete-js'></script>
<script>
jQuery(document).ready(function($) {
    jQuery(document).on('gform_post_render', function(event, form_id, current_page) {
    // gravity form code rander
        var units = "inlbs";
        var origin_city_autocomplete;
        var dest_city_autocomplete;

    $('#input_4_71').blur(function(e){
         var results;
    if (origin_city_autocomplete) {
      results = origin_city_autocomplete.getPlace();
    }
        if(!results){
        }
    });


    var origin_city = document.getElementById('input_4_71');
var options = {
    //types: ['(regions)']
     types: ['(cities)']
    //types: ['geocode','establishment']
};
//  auto complete city name in origin
origin_city_autocomplete = new google.maps.places.Autocomplete(origin_city, options);
google.maps.event.addListener(origin_city_autocomplete, 'place_changed', function() {
    $("#input_4_71").attr('data-error','').attr('data-selected-autocomplete',1);
    $("#input_4_71").closest('.inputCon').find('.error').removeClass('vis');
});
    $('#input_4_72').blur(function(e){
         var results;
    if (dest_city_autocomplete) {
      results = dest_city_autocomplete.getPlace();
    }
        if(!results){
        }
    });


var destenation_city = document.getElementById('input_4_72');
var options = {
 //types: ['(regions)']
     types: ['(cities)']
  //types: ['geocode','establishment']
};


//  auto complete city name in destination
dest_city_autocomplete = new google.maps.places.Autocomplete(destenation_city, options);
google.maps.event.addListener(dest_city_autocomplete, 'place_changed', function() {
    $("#input_4_72").attr('data-error','').attr('data-selected-autocomplete',1);
    $("#input_4_72").closest('.inputCon').find('.error').removeClass('vis');
});
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        //  calculation of volumes base on width length height 
        function calculation(units) {
            var totalVoleume = 0;
            var totalWeight = 0;
            //alert(totalVoleume);
            jQuery('.gfield_list_group').each(function() {
                if ($('.gfield_list_37_cell1 input', this).val() != '' && $('.gfield_list_37_cell2 input', this).val() != '' && $('.gfield_list_37_cell4 input', this).val() != '' && $('.gfield_list_37_cell3 input', this).val() != '') {
                    //alert('d');
                    thisVolume = Number($('.gfield_list_37_cell1 input', this).val()) * Number($('.gfield_list_37_cell2 input', this).val()) * Number($('.gfield_list_37_cell4 input', this).val()) * Number($('.gfield_list_37_cell3 input', this).val());
                    //totalVoleume +=thisVolume;
                    switch (units) {
                        case 'kgcm':
                            thisVolume = thisVolume / 1000000;
                            break;
                        case 'inlbs':
                            //thisVolume = (thisVolume*2.54*2.54*2.54)/1000000
                            thisVolume = thisVolume / 1728;
                            break;
                    }
                    totalVoleume += thisVolume;
                }
                if ($('.gfield_list_37_cell1 input', this).val() != '' && $('.gfield_list_37_cell5 input', this).val() != '') {
                    thisWeight = Number($('.gfield_list_37_cell1 input', this).val()) * Number($('.gfield_list_37_cell5 input', this).val());
                    totalWeight += thisWeight;
                }
            });
            //alert(totalVoleume);
            if (totalVoleume != 0 && !isNaN(totalVoleume)) {
                $('#input_4_35').attr('value', (numberWithCommas(totalVoleume.toFixed(2))));
                total_volume_val = totalVoleume.toFixed(2);
            } else {
                $('#input_4_35').attr('value', '0');
                total_volume_val = 0;
            }
            if (totalWeight != 0 && !isNaN(totalWeight)) {
                $('#input_4_36').attr('value', (numberWithCommas(totalWeight.toFixed(2))));
                total_weight_val = totalWeight.toFixed(2);
            } else {
                $('#input_4_36').attr('value', '0');
                total_weight_val = 0;
            }
        }
        //  auto load units Class
        function autoloadclass() {
            jQuery(".gfield_list_37_cell2").addClass("inlbs");
            jQuery(".gfield_list_37_cell4").addClass("inlbs");
            jQuery(".gfield_list_37_cell3").addClass("inlbs");
            jQuery(".gfield_list_37_cell5").addClass("kgcmlbs");
            jQuery("#gfield_description_4_36").text('LBS')
            jQuery("#gfield_description_4_35").text('CFT')
            jQuery("#field_4_37 > div > table > thead > tr > th:nth-child(5)").text('Weight per Cartons');
        }
        autoloadclass()
        jQuery("input[name='input_39']").on("change", function() {
            var boxtypevalue = jQuery("input[name='input_39']:checked").val();
            if (boxtypevalue == 'cartons') {
                jQuery("#field_4_37 > div > table > thead > tr > th:nth-child(5)").text('Weight per Cartons');
            } else if (boxtypevalue == 'pallets') {
                jQuery("#field_4_37 > div > table > thead > tr > th:nth-child(5)").text('Weight per Pallet');
            }
        });
        // switch L W H Units 
        function AddClassAfter(units) {
            switch (units) {
                case 'kgcm':
                    jQuery(".gfield_list_37_cell2").removeClass("inlbs");
                    jQuery(".gfield_list_37_cell4").removeClass("inlbs");
                    jQuery(".gfield_list_37_cell3").removeClass("inlbs");
                    jQuery(".gfield_list_37_cell5").removeClass("kgcmlbs");
                    jQuery("#gfield_description_4_36").text('KG')
                    jQuery("#gfield_description_4_35").text('CBM')
                    jQuery(".gfield_list_37_cell2").addClass("kgcm");
                    jQuery(".gfield_list_37_cell4").addClass("kgcm");
                    jQuery(".gfield_list_37_cell3").addClass("kgcm");
                    jQuery(".gfield_list_37_cell5").addClass("kgcmw");
                    break;
                case 'inlbs':
                    jQuery(".gfield_list_37_cell2").removeClass("kgcm");
                    jQuery(".gfield_list_37_cell4").removeClass("kgcm");
                    jQuery(".gfield_list_37_cell3").removeClass("kgcm")
                    jQuery(".gfield_list_37_cell5").removeClass("kgcmw");
                    jQuery("#gfield_description_4_36").text('LBS')
                    jQuery("#gfield_description_4_35").text('CFT')
                    jQuery(".gfield_list_37_cell2").addClass("inlbs");
                    jQuery(".gfield_list_37_cell4").addClass("inlbs");
                    jQuery(".gfield_list_37_cell3").addClass("inlbs");
                    jQuery(".gfield_list_37_cell5").addClass("kgcmlbs");
                    break;
            }
        }

        jQuery("input[name='input_40']").on("click", function() {
            units = jQuery("input[name='input_40']:checked").val();
            calculation(units);
            AddClassAfter(units);
        });

        jQuery('.gfield_list_group').on('keyup', 'input', function() {
            calculation(units);
        })

        jQuery(document).on('click', '.add_list_item', function(event) {
            jQuery('.gfield_list_group').on('keyup', 'input', function() {
                calculation(units);
            })
        });

        jQuery(document).on('click', '.delete_list_item', function(event) {
            calculation(units);
        });
        
    });
});
</script>
<?php 
}