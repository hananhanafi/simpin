

    function currencyFormat(el) {
        el.value = '$' + el.value.replace(/[^\d]/g,'').replace(/(\d\d?)$/,'.$1');
      }


      function formatNumber(s) {
        var parts = s.split(/,/)
          , spaced = parts[0]
               .split('').reverse().join('') // Reverse the string.
               .match(/\d{1,3}/g).join(' ') // Join groups of 3 digits with spaces.
               .split('').reverse().join(''); // Reverse it back.
        return spaced + (parts[1] ? ','+parts[1] : ''); // Add the fractional part.
      }

function formatRupiah(angka, prefix)
{
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
      }
      
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah :'');
}

var numberToCurrency = function (input_val, fixed = false, blur = false) {
    // don't validate empty input
    if(!input_val) {
        return "";
    }
    
    if(blur) {
        if (input_val === "" || input_val == 0) { return 0; }
    }

    if(input_val.length == 1) {
        return parseInt(input_val);
    }

    input_val = ''+input_val;
    
    let negative = '';
    if(input_val.substr(0, 1) == '-'){
        negative = '-';
    }
    // check for decimal
    if (input_val.indexOf(",") >= 0) {
        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = left_side.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        if(fixed && right_side.length > 3) {
            right_side = parseFloat(0+right_side).toFixed(2);
            right_side =  right_side.substr(1, right_side.length);
        }

        // validate right side
        right_side = right_side.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        // Limit decimal to only 2 digits
        if(right_side.length > 2) {
            right_side = right_side.substring(0, 2);
        }
    
        if(blur && parseInt(right_side) == 0) {
            right_side = '';
        }

        // join number by .
        // input_val = left_side + "." + right_side;

        if(blur && right_side.length < 1) {
            input_val = left_side;
        } else {
            input_val = left_side + "," + right_side;
        }
    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = input_val.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    if(input_val.length > 1 && input_val.substr(0, 1) == '0' && input_val.substr(0, 2) != '0,' ) {
        input_val = input_val.substr(1, input_val.length);
    } else if(input_val.substr(0, 2) == '0.') {
        input_val = input_val.substr(2, input_val.length);
    }
    
    return negative+input_val;
};

function hitungBungaEfektif(bungaPA,bulan){
    var get      = Math.ceil(bulan/12);
    var jlhBulan = get * 12;
    var bunga    = 1 + ((bungaPA/100)/jlhBulan);
   
    var hitung  = (Math.pow(bunga,jlhBulan) - 1) * 100;
    return hitung;
}