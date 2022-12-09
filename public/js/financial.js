/* This package contains formulas for common financial calculations */

/***********************************************
 *              Present Value                  *
 * pv = fv / (1 + (rate / freq))^periods       *
 * pv = Present Value                          *
 * fv = Future Value                           *
 * rate = interest rate (expressed as %)       *
 * freq = compounding frequency                *
 * periods = number of periods until maturity  *
 ***********************************************/
function presentValue(fv, freq, rate, periods) {
  return (fv / Math.pow((1 + (rate / 100 / freq)), periods));
}

/************************************************
 *                Future Value                  *
 * fv = pv * (1 + (rate / freq))^periods        *
 * fv = Future Value                            *
 * pv = Present Value                           *
 * rate = interest rate (expressed as %)        *
 * freq = compounding frequency                 *
 * periods = number of periods until maturity   *
 ************************************************/
function futureValue(pv, freq, rate, periods) {
  return (pv * Math.pow(1 + (rate / 100 / freq), periods));
}

/************************************************
 *            Annualized Return                 *
 * r = (fv - pv) / pv / years                   *
 * fv = future value                            *
 * pv = present value                           *
 * years = term of loan in years                *
 ************************************************/
function annualizedReturn(fv, pv, years) {
  return (fv - pv) / pv / years;
}

function monthlyPayment(pv, freq, rate, periods) {
  rate = rate / 100 / freq;

  var x = Math.pow(1 + rate, periods);
  return (pv * x * rate) / (x - 1);
}

/***********************************************
 *                 Annuity                     *
 * a = fv / (((1 + r / c)^n) - 1) / (r/c)      *
 * fv = future value                           *
 * r = interest rate                           *
 * c = compounding frequency                   *
 * n = total number of periods                 *
 ***********************************************/
function annuity(fv, freq, rate, periods) {
  rate = rate / 100 / freq;
  return (fv / ((Math.pow(1 + rate, periods) - 1)) * rate);
}

function calcAmortPrincipal(pymt, freq, rate, periods) {
  rate = rate / 100 / freq;
  return (pymt * (1 - (1 / Math.pow(1 + rate, periods))) / rate);
}

/***********************************************
 *  Convert to currency notation               *
 ***********************************************/
function toCurrency(num) {
  num = Math.round(num * 100) / 100;
  var currstring = num.toString();
  if (currstring.match(/\./)) {
    var curr = currstring.split('.');
  } else {
    var curr = [currstring, "00"];
  }
  curr[1] += "00";
  curr[2] = "";
  var returnval = "";
  var length = curr[0].length;

  // add 0 to decimal if necessary
  for (var i = 0; i < 2; i++)
    curr[2] += curr[1].substr(i, 1);

  // insert commas for readability
  for (i = length; (i - 3) > 0; i = i - 3) {
    returnval = "," + curr[0].substr(i - 3, 3) + returnval;
  }
  returnval = curr[0].substr(0, i) + returnval + "." + curr[2];
  return (returnval);
}

function regularDeposit(payment, freq, rate, periods) {
  rate = rate / 100 / freq;
  return (payment * (Math.pow(1 + rate, periods) - 1) / rate * (1 + rate));
}

function PMT(i, n, p) {
  // var pmt = ( ir * ( pv * Math.pow ( (ir+1), np ) + fv ) ) / ( ( ir + 1 ) * ( Math.pow ( (ir+1), np) -1 ) );
  var pmt = i * p * Math.pow((1 + i), n) / (1 - Math.pow((1 + i), n));
  return pmt;
}

// margin to pinjaman
function bungaEfektif(bunga, bulan, saldo) {
  var bungaPA = (bunga / 100) / 12;
  var angs = Math.abs(PMT(bungaPA, bulan, saldo));
  var efektif = (((angs * bulan) - saldo) * 12) / (bulan * saldo);
  return efektif * 100;
}

function bungaEfektifRate(bunga, bulan, saldo) {
  return bungaPA(bunga, bulan, saldo);
  // return RATE(bulan, (0 - angs), saldo) * 12;
}

function angsuran(bunga, pinjaman, bulan) {
  bunga = bunga / 100;
  var pinjaman = (pinjaman + (pinjaman * bunga * bulan / 12)) / bulan;
  return pinjaman;
}

function bungaPA(bunga, bulan, pinjaman) {
  var angs = angsuran(bunga, pinjaman, bulan)
  return rate(bulan, (0 - angs), pinjaman) * 12 * 100;
  // return angs
}

// function RATE(periods, payment, present, future, type, guess) {
//   guess = (guess === undefined) ? 0.01 : guess;
//   future = (future === undefined) ? 0 : future;
//   type = (type === undefined) ? 0 : type;

//   // Set maximum epsilon for end of iteration
//   var epsMax = 1e-10;

//   // Set maximum number of iterations
//   var iterMax = 10;

//   // Implement Newton's method
//   var y, y0, y1, x0, x1 = 0,
//     f = 0,
//     i = 0;
//   var rate = guess;
//   if (Math.abs(rate) < epsMax) {
//     y = present * (1 + periods * rate) + payment * (1 + rate * type) * periods + future;
//   } else {
//     f = Math.exp(periods * Math.log(1 + rate));
//     y = present * f + payment * (1 / rate + type) * (f - 1) + future;
//   }
//   y0 = present + payment * periods + future;
//   y1 = present * f + payment * (1 / rate + type) * (f - 1) + future;
//   i = x0 = 0;
//   x1 = rate;
//   while ((Math.abs(y0 - y1) > epsMax) && (i < iterMax)) {
//     rate = (y1 * x0 - y0 * x1) / (y1 - y0);
//     x0 = x1;
//     x1 = rate;
//     if (Math.abs(rate) < epsMax) {
//       y = present * (1 + periods * rate) + payment * (1 + rate * type) * periods + future;
//     } else {
//       f = Math.exp(periods * Math.log(1 + rate));
//       y = present * f + payment * (1 / rate + type) * (f - 1) + future;
//     }
//     y0 = y1;
//     y1 = y;
//     ++i;
//   }
//   return rate;
// }

var rate = function (nper, pmt, pv, fv, type, guess) {
  // Sets default values for missing parameters
  fv = typeof fv !== 'undefined' ? fv : 0;
  type = typeof type !== 'undefined' ? type : 0;
  guess = typeof guess !== 'undefined' ? guess : 0.1;

  // Sets the limits for possible guesses to any
  // number between 0% and 100%
  var lowLimit = 0;
  var highLimit = 1;

  // Defines a tolerance of up to +/- 0.00005% of pmt, to accept
  // the solution as valid.
  var tolerance = Math.abs(0.00000005 * pmt);

  // Tries at most 40 times to find a solution within the tolerance.
  for (var i = 0; i < 40; i++) {
    // Resets the balance to the original pv.
    var balance = pv;

    // Calculates the balance at the end of the loan, based
    // on loan conditions.
    for (var j = 0; j < nper; j++) {
      if (type == 0) {
        // Interests applied before payment
        balance = balance * (1 + guess) + pmt;
      } else {
        // Payments applied before insterests
        balance = (balance + pmt) * (1 + guess);
      }
    }

    // Returns the guess if balance is within tolerance.  If not, adjusts
    // the limits and starts with a new guess.
    if (Math.abs(balance + fv) < tolerance) {
      return guess;
    } else if (balance + fv > 0) {
      // Sets a new highLimit knowing that
      // the current guess was too big.
      highLimit = guess;
    } else {
      // Sets a new lowLimit knowing that
      // the current guess was too small.
      lowLimit = guess;
    }

    // Calculates the new guess.
    guess = (highLimit + lowLimit) / 2;
  }

  // Returns null if no acceptable result was found after 40 tries.
  return null;
};