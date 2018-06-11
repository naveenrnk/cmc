// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
var app=angular.module('starter', ['ionic',]);

app.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(false);

      // Don't remove this line unless you know what you are doing. It stops the viewport
      // from snapping when text inputs are focused. Ionic handles this internally for
      // a much nicer keyboard experience.
      cordova.plugins.Keyboard.disableScroll(true);
    }

  setTimeout(function() {
  if (window.StatusBar) {

    StatusBar.backgroundColorByName('black');
  }
}, 300);
  });

})
app.config(function($stateProvider,$urlRouterProvider){
  $stateProvider.state('login',{
    url : '/login',
    templateUrl : 'templates/login.html'
  });
  $stateProvider.state('waitboard',{
    url : '/waitboard',
    templateUrl : 'templates/waitboard.html'
  });
  $stateProvider.state('home',{
    url : '/home',
    templateUrl : 'templates/home.html'
  });
  $stateProvider.state('patientprofile',{
    url :'/patientprofile',
    cache : false,
    templateUrl : 'templates/patientprofile.html'
  });
  $stateProvider.state('checkappointments',{
    url :'/checkappointments',
    cache : false,
    templateUrl : 'templates/checkappointments.html'
  });
  $stateProvider.state('displaytimeslots',{
    url : '/displaytimeslots',
    templateUrl : 'templates/displaytimeslots.html'
  });
  $stateProvider.state('notifications',{
    url : '/notifications',
    cache : false,
    templateUrl : 'templates/notifications.html'
  });
  $stateProvider.state('contactsecratary',{
    url : '/contactsecratary',
    templateUrl : 'templates/contactsecratary.html'
  });
  $stateProvider.state('register',{
    url : '/register',
    templateUrl : 'templates/register.html'
  });
   $stateProvider.state('forgotpassword',{
    url : '/forgotpassword',
    templateUrl : 'templates/forgotpassword.html',
    cache : false
  });
  $stateProvider.state('clinichours',{
    url :'/clinichours',
    templateUrl : 'templates/clinichours.html',
    cache : false
  });
 $stateProvider.state('checkin',{
  url : '/checkin',
  templateUrl : 'templates/checkin.html',
  cache : false
 });
 $stateProvider.state('dlist',{
  url : '/dlist',
  templateUrl : 'templates/displaydoctors.html',
  cache : false
 });
 $stateProvider.state('schedule',{
  url : '/displayschedule',
  templateUrl : 'templates/displayschedule.html',
  cache : false
 });
  $urlRouterProvider.otherwise('/login');
});
app.controller('waitboardctrl',function($scope,$http,$interval){
  $scope.goBack = function(){
    window.history.back();
  }
  $http.get('http://cedarbraemedicalcenter.com/getnewwaittime.php').then(function(response){
    getWaitingtimes(response,$scope);
  });
  var toMinutes;
  var d = new Date();
  var n = d.getTime();
  $scope.remains = 'now';
  var interval = function(){
    var z = new Date();
    var m = z.getTime();
    if(m > n){
      var remains = (m-n)/1000;
      if(remains < 60){
        remains = Math.round(remains)+" seconds ago";
      }else if(remains > 60 && remains <3600){
        remains = Math.round(remains/60)+" minute(s) ago";
      }else if(remains > 3600 && remains <86400){
        remains = Math.round(remains/3600)+" hour(s) ago";
      }else{
        remains = Math.round(remains/86400)+" day(s) ago";
      }
    }
    $scope.remains = remains;
        $http.get('http://cedarbraemedicalcenter.com/getnewwaittime.php').then(function(response){
          getWaitingtimes(response,$scope);
        });
  }
  $interval(interval,15000);


   $scope.doRefresh = function(){
     var d = new Date();
      n = d.getTime();
     $scope.remains = 'now';
    $http.get('http://cedarbraemedicalcenter.com/getnewwaittime.php').then(function(response){
      getWaitingtimes(response,$scope);
  }).finally(function(){
    $scope.$broadcast('scroll.refreshComplete');
  });
  };

});
function getWaitingtimes(response,$scope){
    var d = response.data;
  for(var i=0;i<d.length;i++){
    var wt = parseInt(d[i]['timestamp']);
    var currenttimestamp = new Date();
    currenttimestamp = currenttimestamp.getTime();
    var difference = (wt - currenttimestamp)/1000/60;
toMinutes = Math.round(difference%60);
    console.log(difference);
    if(difference > 60){
      console.log(toMinutes);
      hours = Math.floor(difference/60);

      d[i]['timestamp'] = hours+' hour(s) '+toMinutes+' minute(s)';
    }else if(difference <=0.75){
      d[i]['timestamp'] = 'You can now visit the clinic';
    }
    else{
      d[i]['timestamp'] = toMinutes+' minutes(s)';
    }
  }
  $scope.response=d;
}
app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.controller('CheckIn',function($scope,$http,$state){
  $scope.show = true;
  var date = new Date();
  var mm = date.getMonth()+1;
  var dd = date.getDate();
  var yy = date.getFullYear();
  if(mm<10){
    mm = "0"+mm;
  }
  if(dd<10){
    dd = "0"+dd;
  }
  today = yy+"-"+mm+"-"+dd;
  var username = localStorage.getItem('username');
  var provider = localStorage.getItem('selectedDoctor');
  $http.post('http://cedarbraemedicalcenter.com/getcheckedinapt.php',{username : username,date : today,provider : provider}).then(function(response){

    $scope.confirmedlist2 = response.data;

    if(response.data.length >0){
       $scope.show= false;
       $http.get('http://cedarbraemedicalcenter.com/getwaitingtime.php').then(function(response){
        console.log(response.data);
       });
    }


  },function(response){
    if(response.status !=200){
      $scope.reloadcon = "Connection Error/Pull Down to refresh";
    }
  });
  $http.post('http://cedarbraemedicalcenter.com/getconfirmedactivewaittime.php',{username : username,date : today,provider : provider}).then(function(response){

    $scope.confirmedlist = response.data;

    if(response.data.length >0){
       $scope.show= false;
    }


  },function(response){
    if(response.status !=200){
      $scope.reloadcon = "Connection Error/Pull Down to refresh";
    }
  });
  $scope.doRefresh = function(){
    $http.post('http://cedarbraemedicalcenter.com/getconfirmedactivewaittime.php',{username : username,date : today,provider : provider}).then(function(response){
    $scope.confirmedlist = response.data;
     $scope.reloadcon="";
      if(response.data.length >0){
       $scope.show= false;
    }
    $http.post('http://cedarbraemedicalcenter.com/getcheckedinapt.php',{username : username,date : today,provider : provider}).then(function(response){
    $scope.confirmedlist2 = response.data;
     $scope.reloadcon="";
      if(response.data.length >0){
       $scope.show= false;
    }
  });
  }).finally(function(){

    $scope.$broadcast('scroll.refreshComplete');
  });
  };

  var st = false;
   if($state.current.name =="checkin"){
   if(st == false){
   var interval = setInterval(function(){
    st = true;
    $http.post('http://cedarbraemedicalcenter.com/getdbwaittime.php',{provider : provider}).then(function(response){
        var total = response.data.status;
        $scope.waitstatus = total;
       });

   },5000);
  }
}




  $scope.checkin = function(list){
    $http.post('http://cedarbraemedicalcenter.com/getcheckin.php',{time : list.time,date : list.date,provider : list.provider,username : username}).then(function(response){
        $http.post('http://cedarbraemedicalcenter.com/getcheckedinapt.php',{username : username,date : today}).then(function(response){
    $scope.doRefresh();
    $scope.confirmedlist2 = response.data;

    if(response.data.length >=0){
       $scope.show= false;

    }


  },function(response){
    if(response.status !=200){
      $scope.reloadcon = "Connection Error/Pull Down to refresh";
    }
  });



    },function(response){
      if(response.status !=200){
      $scope.reloadcon = "Connection Error/Pull Down to refresh";
    }
    });

  }

  $scope.goBack = function(){
    clearInterval(interval);
    window.history.back();
  }
});
app.controller('clinicHours',function($scope,$http){
  $scope.goBack = function(){
    window.history.back();
  }
  var doctor = localStorage.getItem('selectedDoctorSchedule');
  $http.post('http://cedarbraemedicalcenter.com/getschedule.php',{doctor : doctor}).then(function(response){
    $scope.sunday = response.data.sunday;
    $scope.monday = response.data.monday;
    $scope.tuesday = response.data.tuesday;
    $scope.wednesday = response.data.wednesday;
    $scope.thursday = response.data.thursday;
    $scope.friday = response.data.friday;
    $scope.saturday = response.data.saturday;
    $scope.dayleave = response.data.dayleave;
    $scope.startday = response.data.start;
    $scope.endday = response.data.end;
  });
   $scope.doRefresh = function(){
    $http.post('http://cedarbraemedicalcenter.com/getschedule.php',{doctor : doctor}).then(function(response){
     $scope.sunday = response.data.sunday;
    $scope.monday = response.data.monday;
    $scope.tuesday = response.data.tuesday;
    $scope.wednesday = response.data.wednesday;
    $scope.thursday = response.data.thursday;
    $scope.friday = response.data.friday;
    $scope.saturday = response.data.saturday;
    $scope.dayleave = response.data.dayleave;
    $scope.startday = response.data.start;
    $scope.endday = response.data.end;
  }).finally(function(){
    $scope.$broadcast('scroll.refreshComplete');
  });
  };

});
app.controller('Forgot',function($scope,$http,$ionicPopup){
  $scope.goBack = function(){
    window.history.back();
  }
 $scope.send = function(form){

  var email = $scope.email;


console.log(email);
  if(email !=null && email !=""){
      if(form.$valid){
        email = email.replace(/<[^>]+>/g, '');
        $http.post('http://cedarbraemedicalcenter.com/forgot.php',{email : email}).then(function(response){

      var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: response.data.status
   });

   alertPopup.then(function(res) {

   });

    },function(response){
      if(response.status != 200){
                 var alertPopup = $ionicPopup.alert({
             title: 'Alert',
             template: 'Connection Error/Try again later'
           });

           alertPopup.then(function(res) {

           });
      }
    });
      }else{
     var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Please Enter a valid Email'
   });

   alertPopup.then(function(res) {

   });
  }

  }else{
     var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Please Enter a valid Email'
   });

   alertPopup.then(function(res) {

   });
  }
 }
});

app.controller('MyCtrl',function($scope,$http,$state,$window,$ionicPopup){


  $scope.loaderror = true;
  $scope.login = function(){

    $scope.loaderror = false;
    var u = $scope.username;
    var p = $scope.password;

    if(u !="" && p !="" && u !=null && p!= null){
      u = u.replace(/<[^>]+>/g, '');
      p = p.replace(/<[^>]+>/g, '');

    $http.post('http://cedarbraemedicalcenter.com/login.php',{username : $scope.username,password : $scope.password}).then(function(response){
      var r = response.data.status;


      if(r == "success"){
        console.log(response);
        $window.localStorage.setItem('firstname',response.data.firstname);
        $window.localStorage.setItem('lastname',response.data.lastname);
        $window.localStorage.setItem('phone',response.data.phone);
        $window.localStorage.setItem('address',response.data.address);
        $window.localStorage.setItem('email',response.data.email);
        $window.localStorage.setItem('username',$scope.username);

        $state.go('home');
        $scope.loaderror = true;
        $scope.username="";
        $scope.password="";
      }
      else{
        $scope.loaderror = true;
         var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: response.data.status
   });

   alertPopup.then(function(res) {
    $scope.username="";
    $scope.password="";
   });
      }

    },function(response){
      console.log(response);
      if(response.status != 200){
        $scope.loaderror = true;
          var alertPopup = $ionicPopup.alert({
             title: 'Alert',
             template: response.status
           });

           alertPopup.then(function(res) {

           });
      }
    });
  }else{
    if(!u){
      var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Invalid Username/Password'
   });
    }else if(!p){
      var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Invalid Password/Password'
   });}else{
         var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Please Complete the above Fields'
   });
      }

    $scope.loaderror = true;


   alertPopup.then(function(res) {

   });
  }

  };
});

app.controller('HomeCtrl',function($scope,$ionicHistory,$window,$http,$state){
  $scope.username = $window.localStorage.getItem('username');
  $scope.firstname = $window.localStorage.getItem('firstname');
  $scope.lastname = $window.localStorage.getItem('lastname');
  $scope.phone = $window.localStorage.getItem('phone');
  $scope.address = $window.localStorage.getItem('address');
  $scope.email = $window.localStorage.getItem('email');

    var date = new Date();
  var mm = date.getMonth()+1;
  var dd = date.getDate();
  var yy = date.getFullYear();
  if(mm<10){
    mm = "0"+mm;
  }
  if(dd<10){
    dd = "0"+dd;
  }
  today = yy+"-"+mm+"-"+dd;
   $scope.doRefresh = function(){
    $http.get('http://cedarbraemedicalcenter.com/getdoctors.php').then(function(response){
    $scope.list = response.data;
    $scope.reload="";
  }).finally(function(){
    $scope.$broadcast('scroll.refreshComplete');
  });
  };
  $scope.show = true;
   $http.get('http://cedarbraemedicalcenter.com/getdoctors.php').then(function(response){

    $scope.list = response.data;

  }).finally(function(){
    if($scope.list == "" || $scope.list == null){
      $scope.reload = "Error Connecting,Pull down to refresh";
    }
    $scope.show = false;
  });
   $http.post('http://cedarbraemedicalcenter.com/getappnotification_confirmed.php',{username : $scope.username,today : today}).then(function(response){

            $scope.notification = response.data.rows;

        });
   var count =0;
   var st = false;
   if($state.current.name =="home"){
   if(st == false){
   var interval = setInterval(function(){
    st = true;

    $http.post('http://cedarbraemedicalcenter.com/getappnotification_confirmed.php',{username : $scope.username,today : today}).then(function(response){

            $scope.notification = response.data.rows;

        });
   },15000);
  }
}

   $scope.clearnotification = function(){
      $http.post('http://cedarbraemedicalcenter.com/markread.php',{username : $scope.username,today : today}).then(function(response){

             });
   };




  $scope.getSelectedDoctor = function(x){
    var fname = x.lastname+" "+x.firstname;
    $window.localStorage.setItem('selectedDoctor',fname);
  };
    $scope.getSelectedDoctorSchedule = function(x){
    var fname = x.lastname+" "+x.firstname;
    $window.localStorage.setItem('selectedDoctorSchedule',fname);
  };
  $scope.goBack = function(){
    window.history.back();
  };
  $scope.logout = function(){
    $window.localStorage.removeItem('address');
    $window.localStorage.removeItem('email');
    $window.localStorage.removeItem('firstname');
    $window.localStorage.removeItem('lastname');
    $window.localStorage.removeItem('phone');
    $window.localStorage.removeItem('selectedDoctor');
    $window.localStorage.removeItem('username');
    $state.go('login');
    clearInterval(interval);
  };
});

app.controller('GetSlots',function($scope,$window,$http,$ionicPopup){
  //

  var date = new Date();
  var mm = date.getMonth()+1;
  var dd = date.getDate();
  var yy = date.getFullYear();
  if(mm<10){
    mm = "0"+mm;
  }
  if(dd<10){
    dd = "0"+dd;
  }
  today = yy+","+mm+","+dd;
  var mmmm = date.getMonth()+3;
  if(mmmm<10){
    mmmm = "0"+mmmm;
  }
  var datefrom2m = yy+","+mmmm+","+dd;
  //
  $scope.goBack = function(){
    window.history.back();
  };
  $scope.getslots = function(){
   var c =  document.getElementById('d').getAttribute('class');
    if($scope.appt != null){
    var date= $scope.appt.toString();

  var month = date.substring(4,7);
  var day = date.substring(8,10);
  var year = date.substring(11,15);
  month = monthname(month);

  var newdate = year+","+month+","+day;


  if(newdate < today){
    var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Invalid Date'
   });

   alertPopup.then(function(res) {
    $scope.select.length=0;
     document.getElementById('d').value="";
     $scope.appt="";
     $scope.timeslot="";
   });
    document.getElementById('d').value="";
  }else if(newdate > datefrom2m){
    var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'You can book appointments within 2months'
   });

   alertPopup.then(function(res) {
   $scope.select.length=0;
    document.getElementById('d').value="";
    $scope.appt="";
     $scope.timeslot="";
   });
    document.getElementById('d').value="";
  }else{
    newdate = year+"-"+month+"-"+day;
    var selectedDate = newdate;

    var selectedDoctor = $window.localStorage.getItem('selectedDoctor');
    $http.post('http://cedarbraemedicalcenter.com/postslots.php',{selectedDate : selectedDate,selectedDoctor : selectedDoctor}).then(function(response){


     if(response.data.status){
     var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: response.data.status
   });

   alertPopup.then(function(res) {
     document.getElementById('d').value="";
      $scope.select.length=0;
      $scope.appt="";
     $scope.timeslot="";
   });
     }else{
      if(response.data){
         $scope.select = response.data;
      }

     }

    },function(response){
      if(response.status != 200){
        var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Cannot Get Available Slots for this Date,Please retry Choosing the date'
   });

   alertPopup.then(function(res) {
      document.getElementById('d').value="";
   });
      }
    });
  }
}
  };

  $scope.book = function(){
    var date = $scope.appt;
    var time = $scope.timeslot;

    var email = $window.localStorage.getItem('email');
    var firstname = $window.localStorage.getItem('firstname');
    var lastname = $window.localStorage.getItem('lastname');
    var phone = $window.localStorage.getItem('phone');
    var username = $window.localStorage.getItem('username');
    var provider = $window.localStorage.getItem('selectedDoctor');
    var fullname = lastname+" "+firstname;


    if($scope.appt && $scope.timeslot){
        var confirmPopup = $ionicPopup.confirm({
     title: 'Book Appointment',
     template: 'Are you sure you want to Book this TimeSlot?'
   });
      confirmPopup.then(function(res) {
     if(res) {
       $http.post('http://cedarbraemedicalcenter.com/checkappt.php',{date : date,time : time,email : email,fullname:fullname,phone : phone,username : username,provider : provider}).then(function(response){

        var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: response.data.status
   });

   alertPopup.then(function(res) {

   });
        $scope.appt = "";
        $scope.timeslot="";

      },function(response){
        if(response.status != 200){
          var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: "Connection Error/Try again later"
   });

   alertPopup.then(function(res) {

   });
        }
      });
     } else {

     }
   });
    }else{
      var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: 'Please Complete the above Fields'
   });

   alertPopup.then(function(res) {

   });

    }
  };

});
app.controller('Notifications',function($scope,$http,$window,$ionicPopup){
  $scope.goBack = function(){
    window.history.back();
  };
  var username = $window.localStorage.getItem('username');
  var date = new Date();
  var mm = date.getMonth()+1;
  var dd = date.getDate();
  var yy = date.getFullYear();
  if(mm<10){
    mm = "0"+mm;
  }
  if(dd<10){
    dd = "0"+dd;
  }
  today = yy+"-"+mm+"-"+dd;
  $http.post('http://cedarbraemedicalcenter.com/getpendingappt.php',{username : username,date : today}).then(function(response){

    $scope.pendinglist = response.data;

  },function(response){
    if(response.status != 200){
      $scope.reloadpen = "Connection Error/Pull Down to refresh";
    }
  });
  $http.post('http://cedarbraemedicalcenter.com/getconfirmedappt.php',{username : username,date : today}).then(function(response){

    $scope.confirmedlist = response.data;

  },function(response){
    if(response.status !=200){
      $scope.reloadcon = "Connection Error/Pull Down to refresh";
    }
  });
  $scope.doRefresh = function(){
     $http.post('http://cedarbraemedicalcenter.com/getpendingappt.php',{username : username,date : today}).then(function(response){
    $scope.pendinglist = response.data;
    $scope.reloadpen = "";
  });$http.post('http://cedarbraemedicalcenter.com/getconfirmedappt.php',{username : username,date : today}).then(function(response){
    $scope.confirmedlist = response.data;
     $scope.reloadcon="";
  }).finally(function(){

    $scope.$broadcast('scroll.refreshComplete');
  });
  };
  $scope.cancel = function(item){
    var date = item.date;
    var time = item.time;
    var provider = item.provider;
    var username = $window.localStorage.getItem('username');

    var alertPopup = $ionicPopup.confirm({
     title: 'Alert',
     template: "Are you Sure?"
   });
    alertPopup.then(function(res) {
      if(res){
        $http.post('http://cedarbraemedicalcenter.com/cancelfromapp.php',{date : date,time : time,provider : provider,username : username}).then(function(response){
        var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: response.data.status
   });

   alertPopup.then(function(res) {
    $scope.doRefresh();
   });
      },function(response){
        if(response.status !=200){
           var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: "Connection Error/Try Cancelling again"
   });

   alertPopup.then(function(res) {
    $scope.doRefresh();
   });
        }
      });
      }

   });
  }
});
app.controller('contact',function($scope,$http){
   $scope.goBack = function(){
    window.history.back();
  };
   $http.get('http://cedarbraemedicalcenter.com/getclinichours.php').then(function(response){

    $scope.phone = response.data.phone;
    $scope.email = response.data.email;

  },function(response){
    if(response.status != 200){
      $scope.reload = "Connection Error/Please Pull down to refresh";
    }
  });
   $scope.doRefresh = function(){
    $http.get('http://cedarbraemedicalcenter.com/getclinichours.php').then(function(response){
    $scope.phone = response.data.phone;
    $scope.email = response.data.email;
    $scope.reload="";
  }).finally(function(){
    $scope.$broadcast('scroll.refreshComplete');
  });
  };
});
app.controller('RegisterCtrl',function($scope,$http,$window,$ionicPopup,$state){
   $scope.hc = false;

    $scope.register = function(form){
      window.addEventListener('native.keyboardhide', keyboardHideHandler);

function keyboardHideHandler(e){

}
       var fname = $scope.fname;

      var lname = $scope.lname;

      var email = $scope.email;

      var phone = $scope.phone;

      var username = $scope.uname;

      var password = $scope.password;

      var postalcode = $scope.postalcode;

      var hc = $scope.hc;

      if(fname !="" && fname !=null && lname !=""&& lname !=null && email != ""&& email !=null && phone !="" && phone !=null && username !=""&& username !=null && password !=""&& password !=null&& postalcode !=""&& postalcode !=null){

          if(form.$valid){

        $http.post('http://cedarbraemedicalcenter.com/register.php',{fname : fname,lname : lname,email:email,phone:phone,username:username,password : password,hc:hc,postalcode : postalcode}).then(function(response){

           var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: response.data.status
   });
           if(response.data.error){

              $scope.fname ="";
              $scope.lname ="";
              $scope.email ="";
              $scope.phone ="";
              $scope.uname ="";
              $scope.password="";
              $scope.hc = false;
              $scope.postalcode="";
            }

   alertPopup.then(function(res) {
    if(response.data.error == "success"){

    $state.go('login');
  }
   });
        },function(response){
        if(response.status != 200){
           var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: "Connection Error"
   });
         alertPopup.then(function(res) {

   });
        }
       });
}else{
        var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: "invalid: "
   });

   alertPopup.then(function(res) {

   });
      }
     }else{
      var template1 ="";
      var template2="";
      var template3="";
      var template4="";
      var template5="";
      var template6 = "";
      var template7="";
      if(!fname){

     template1 =  "Firstname must be all letters<br>";

    }
     if(!lname){

     template2 = "Lastname must be all letters<br>";

    }
     if(!email){

     template3 = "Email must be valid<br>";

    }
     if(!phone){

     template4 = "Please enter a valid phone number<br>";

    }
     if(!username){
     template5 = "Username must be only letters and/or numbers & between 3 to 10 characters<br>";
    }
    if(!password){
     template6 = "Password must be only letters and/or numbers & between 5 to 10 characters<br>";
    }
    if(!postalcode){
      template7 = "Postal Code must match the following pattern Ex: A1A2A3 or a1a2a3";
    }
     var alertPopup = $ionicPopup.alert({
     title: 'Alert',
     template: template1+template2+template3+template4+template5+template6+template7
   });
   alertPopup.then(function(res) {

   });
     }
    }

   $scope.goBack = function(){
    window.history.back();
  }


});
app.directive('disallowSpaces', function() {
    return {
        restrict: 'A',

        link: function($scope, $element) {
            $element.bind('keydown', function(e) {
                if (e.which === 32) {
                    e.preventDefault();
                }
            });
        }
    }
});
app.directive('stopccp', function(){
    return {
        scope: {},
        link:function(scope,element){
            element.on('cut copy paste', function (event) {
              event.preventDefault();
            });
        }
    };
});
function monthname(name){
  if(name == "Jan"){
      return "01";
  }
  if(name == "Feb"){
      return "02";
  }

if(name == "Mar"){
      return "03";
  }

if(name == "Apr"){
      return "04";
  }

if(name == "May"){
      return "05";
  }

if(name == "Jun"){
      return "06";
  }
if(name == "Jul"){
      return "07";
  }
if(name == "Aug"){
      return "08";
  }
if(name == "Sep"){
      return "09";
  }
if(name == "Oct"){
      return "10";
  }
if(name == "Nov"){
      return "11";
  }
if(name == "Dec"){
      return "12";
  }

}
