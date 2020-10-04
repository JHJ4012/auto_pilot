<template>
  <div class="container">
    <div class="left_container">    <!-- left container start-->
        <div class=rc_status>       <!--  rc car real-time status start -->
          <div id="rc_status_header">
            実時間運行狀態</div>
          <div class="status_list">
            <div class = "status_list_item1">
              <span style="color:#78AAFB;">全体</span>
              <strong><div style="color:white;">{{rc.entire_rc}}</div></strong>
            </div>
            <div class = "status_list_item2">
              <span style="color:#78AAFB;">運行中</span>
              <strong><div style="color:white;">{{rc.proceeding_rc}}</div></strong>
            </div>
            <div class = "status_list_item3">
              <span style="color:#78AAFB;">運行待機</span>
              <strong><div style="color:white;">{{rc.waiting_rc}}</div></strong>
            </div>
            <div class = "status_list_item4">
              <span style="color:#78AAFB;">エラー</span>
              <strong><div style="color:white;">{{rc.error_rc}}</div></strong>
            </div>
            <div class = "status_list_item5">
              <span style="color:#78AAFB;">稼働率</span>
              <strong><div style="color:white;">{{rc.operation_rate}}%</div></strong>
            </div>
          </div>
        </div>                                <!--  rc car real-time status end -->
        <div class="dlvy_status">             <!--  delivery status start -->
          <div id="dlvy_status_header">
            <div id="dlvy_status_icon"></div>
            <div id="dlvy_status_title">実時間配達現況</div>
            </div>
          <div id="chart">
            <DoughnutChart id="doughnut_chart"
                :percent=call_info.complete_rate
                :visibleValue="true"
                :entire_call=call_info.entire_call 
                :call_avg_month_ago=call_info.call_avg_month_ago
                :width="120"
                :height="100" />
            </div>
            <div id="dlvy_status_summary">
              <table class= "dlvy_status_list">
              <tbody>
                <tr>
                  <td>全体件数</td>
                  <td><div style="color:#676767;">{{call_info.entire_call}}</div></td>
                </tr>
                <tr>
                  <td>完了件数</td>
                  <td><div style="color:#676767;">{{call_info.complete_call}}</div></td>
                </tr>
                <tr>
                  <td>先月の1日平均件数</td>
                  <td><div style="color:#676767;">{{call_info.call_avg_month_ago}}</div></td>
                </tr>
              </tbody>
              </table>
            </div>
        </div>                              <!--  delivery status end -->
        <div class="cancel_waiting">        <!--  cancelled waiting start -->
            <div id="cancel_waiting_header">
              <div id="cancel_waiting_icon"></div>
              <div id="cancel_waiting_title">実時間待機取取り消し状況</div>
            </div>
            <div id="cancel_waiting_summary">
              <table class="cancel_waiting_list">
              <tbody>
                <tr>
                  <td>総待機数</td>
                  <td><div style="color:#676767;">{{wait_info.entire_waiting}} 件</div></td>
                </tr>
                <tr>
                  <td>現在待機中</td>
                  <td><div style="color:#676767;">{{wait_info.now_waiting}} 件</div></td>
                </tr>
                <tr>
                  <td>待機取り消し件数</td>
                  <td><div style="color:#676767;">{{wait_info.canceled_waiting}} 件</div></td>
                </tr>
                <tr>
                 <td>待機取り消し率</td>
                  <td><div style="color:#676767;">{{wait_info.canceled_waiting_rate}}%</div></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>                          <!--  cancelled waiting end -->
        <div class="rank_bldg">         <!--  building ranking start -->
          <div id="rank_bldg_header">
            <div id="rank_bldg_icon"></div>
            <div id="rank_bldg_title">先週の呼出建物の順位</div>
          </div>
          <div id="rank_bldg_summary">   
            <table class="rank_bldg_list">
              <tbody>
                <tr>
                  <td>1位</td>
                  <td><div style="color:#676767;">{{rank_bldg[0]}}</div></td>
                </tr>
                <tr>
                  <td>2位</td>
                  <td><div style="color:#676767;">{{rank_bldg[1]}}</div></td>
                </tr>
                <tr>
                  <td>3位</td>
                  <td><div style="color:#676767;">{{rank_bldg[2]}}</div></td>
                </tr>
              </tbody>
            </table>
         </div>
        </div>                          <!--  building ranking end -->
        <div class="avg_waiting_time">   <!--  average waiting time start -->
            <div id="avg_waiting_time_header">
              <div id="avg_waiting_time_icon"></div>
              <div id="avg_waiting_time_title">実時間平均待ち時間</div>
            </div>
            <div id="avg_waiting_time_summary">
            <strong><span style="color:#676767;">{{wait_time.avg_waiting_time}}分/ {{wait_time.avg_waiting_time_month_ago}}分</span></strong><br>
            <small>(当日 / 先月一日平均)</small>
          </div>
        </div>                            <!--  average waiting time end -->
      </div>                              <!-- left container end -->
      <div class="right_container">       <!-- right container start -->
        <div class="right_map">           <!-- map start -->
          <div id="map">
          </div>
              <div class="map_info">            <!-- map information start -->
          <div class="map_box1"></div>
          <span style="margin-right:10px; color:#676767;">使用中</span>
          <div class="map_box2"></div>
          <span style="margin-right:10px; color:#676767;">使用可能</span>
          <div class="map_box3"></div>
          <span style="margin-right:10px; color:#676767;">エラー</span>
          <div class="map_box4"></div>
          <span style="margin-right:10px; color:#676767;">停留場</span>
        </div>                              <!-- map information end -->
        </div>                            <!-- map end -->

        <div class="right_dlvy_info">       <!-- delivery information start -->
          <div id="right_dlvy_info_header">
            <div id="right_dlvy_info_icon"></div>
            <div id="right_dlvy_info_title">運行情報</div>
          </div>
          <div id="info_item1">
            <table class="info_item1_list">
              <tbody>
                <tr>
                  <td>自動走行車名前</td>
                  <td>{{rc_info.rc_name}}</td>
                </tr>
                <tr>
                  <td>自動走行車状態</td>
                  <td>{{rc_info.rc_status}}</td>
                </tr>
                <tr>
                  <td>エラー内訳</td>
                  <td>{{rc_info.rc_error_info}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="info_item2">
            <table class="info_item2_list">
              <tbody>
                <tr>
                  <td>出発停留所 :</td>
                  <td>{{point.start_point}}</td>
                </tr>
                <tr>
                  <td>名前 :</td>
                  <td>{{user_info.sender_name}}</td>
                </tr>
                <tr>
                  <td>電話番号 :</td>
                  <td>{{user_info.sender_phone}}</td>
                </tr>
                 <tr>
                  <td>出発時間 :</td>
                  <td>{{dlvy_time.start_time}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="info_item3">
            <table class="info_item3_list">
              <tbody>
                <tr>
                  <td>到着停留所 :</td>
                  <td>{{point.end_point}}</td>
                </tr>
                <tr>
                  <td>名前 :</td>
                  <td>{{user_info.receiver_name}}</td>
                </tr>
                <tr>
                  <td>電話番号 :</td>
                  <td>{{user_info.receiver_phone}}</td>
                </tr>
                 <tr>
                  <td>予想到着時間 :</td>
                  <td>{{dlvy_time.end_time}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>                            <!-- delivery information end -->
      </div>                              <!-- right container end -->
      <b-modal id="modal-center" centered title="エラー発生!!">        <!--rc car error message -->
        <p class="my-4">{{error_info.err_rc_num}}番自動運転車にエラー発生!!</p>
        <p class="my-4">{{error_info.err_content}}</p>
      </b-modal>
</div>
</template>


<script>
import DoughnutChart from './DoughnutChart.vue';
import io from 'socket.io-client';

export default {
  components: {
    DoughnutChart //완료율 그래프
  },
  data(){
    return{
      map_info : {
        container : '',                 //div for map
        mapOptions : '',                //map option
        map : '',                       //map
        map_x : 35.8962,                //map's latitude
        map_y : 128.6220                //map's longitude
      },
      rc : {
        entire_rc : 0,                  //entire rc car's number
        proceeding_rc : 0,              //proceeding rc car's number
        waiting_rc : 0,                 //waiting rc car's number
        error_rc : 0,                   //error rc car's number
        operation_rate : 0,             //rc car's operating rate
      },
      call_info : {
        entire_call : 0,                //entire call's number
        call_avg_month_ago : 0,         //call's number a month ago
        complete_call : 0,              //completed call's number
        complete_rate : 0,              //completed percentage
      },
      wait_info : {
        entire_waiting : 0,             //entire waiting's number
        complete_waiting : 0,           //completed waiting's number 
        now_waiting : 0,                //waiting's number now
        canceled_waiting : 0,           //canceled waiting's number
        canceled_waiting_rate : 0,      //waiting's canceled rate
      },
      rank_bldg : [],                   //building's rank about call's number
      wait_time : {
        avg_waiting_time : 0,           //average waiting time
        avg_waiting_time_month_ago : 0, //average waiting time a month ago
      },
      rc_list : [],                     //rc car's info list
      station_list : [],                //station's info list
      rc_info : {
        rc_name : '',                   //rc car's name
        rc_status : '',                 //rc car's status
        rc_error_info : ''              //rc car's error
      },
      point : {
        start_point : '',               //start point's name
        end_point : '',                 //end point's name
        start_point_lat : '',           //start point's latitude
        start_point_lon : '',           //start point's longitude
        end_point_lat : '',             //end point's latitude
        end_point_lon : ''              //end point's longitude
      },
      user_info : {
        sender_name : '',               //sender's name
        sender_phone : '',              //sender' phone number
        receiver_name : '',             //receiver's name
        receiver_phone : ''             //receiver's phone number
      },
      dlvy_time : {
        start_time : '',                //start time 
        end_time : ''                   //predicted end time
      },
      socket : io.connect('https://1fe80a1d664e.ngrok.io', {    //socket io client
        port : 3000
      }),
      marker : [],
      error_info : {                    //error info
        err_rc_num : '',
        err_content : ''
      },
      markerImg : { //marker's images
        stationMarker : new kakao.maps.MarkerImage('/image/station.png', new kakao.maps.Size(30,30)),
        proceedingMarker : new kakao.maps.MarkerImage('/image/proceeding_rc.png', new kakao.maps.Size(30,30)),
        freeMarker : new kakao.maps.MarkerImage('/image/free_rc.png', new kakao.maps.Size(30,30)),
        errMarker : new kakao.maps.MarkerImage('/image/err_rc.png', new kakao.maps.Size(30,30))
      }
    }
  },
  mounted(){
    this.socket.on("call_count", (data) => {  //when user's call rc car
      this.call_info.entire_call = data[0].count;
      this.cal_Rate("call", this.call_info.complete_call, this.call_info.entire_call);
    });
    this.socket.on("complete_dlvy_count", (data) => { //when the delivery is finished
      this.call_info.complete_call = data[0].count;
      this.cal_Rate("call", this.call_info.complete_call, this.call_info.entire_call);
      this.changeMarkerImage();
    });
    this.socket.on("rc_status", (data) => { //when change the rc car's status
      this.rc.proceeding_rc = data.call + data.dlvy;
      this.rc.waiting_rc = data.wait;
      this.rc.error_rc = data.err;
      this.rc.entire_rc = this.rc.proceeding_rc + this.rc.waiting_rc + this.rc.error_rc;
      this.cal_Rate("operation", this.rc.proceeding_rc, this.rc.entire_rc);
      this.changeMarkerImage();
    });
    this.socket.on("wait_data", (data) => { //when change waiting info
      this.wait_info.now_waiting = data.wait_now;
      this.wait_info.complete_waiting = data.wait_complete;
      this.wait_info.canceled_waiting = data.wait_cancel;
      this.wait_info.entire_waiting = this.wait_info.now_waiting + this.wait_info.complete_waiting + this.wait_info.canceled_waiting;
      this.cal_Rate("cancel", this.wait_info.canceled_waiting, this.wait_info.entire_waiting);
    });
    this.socket.on("car_data", (data) => {  //when change rc car's location\
      console.log('들오옴');
      for(var i = 0, len = this.marker.length ; i < len; i++){
        if(this.marker[i].getTitle() == data.car_num){  //특정 RC카 찾아 위치 바꿔줌
          this.marker[i].setPosition(new kakao.maps.LatLng(data.car_lat, data.car_lon));
        } 
      }
    });

    this.socket.on("car_err", (data) => { //when occur the error to rc car
      this.rc.proceeding_rc = data.call + data.dlvy;
      this.rc.waiting_rc = data.wait;
      this.rc.error_rc = data.err;
      this.rc.entire_rc = this.rc.proceeding_rc + this.rc.waiting_rc + this.rc.error_rc;

      this.error_info.err_rc_num = data.car_num;
      this.error_info.err_content = data.err_msg;
      this.$bvModal.show("modal-center");  //modal show

      this.cal_Rate("operation", this.rc.proceeding_rc, this.rc.entire_rc);
      this.changeMarkerImage();
    })

    this.map_info.container = document.getElementById("map");
    this.map_info.mapOptions = { //create map
      center: new kakao.maps.LatLng(this.map_info.map_x, this.map_info.map_y),
      level: 3, //map's level
      mapTypeId : kakao.maps.MapTypeId.ROADMAP
    };

    this.map_info.map = new kakao.maps.Map(this.map_info.container, this.map_info.mapOptions);

    Axios.get('/api/dlvy/control')    //when enter control page
    .then((response) => {
      this.rc.proceeding_rc = response.data.proceeding_rc; //rc car's status info
      this.rc.waiting_rc = response.data.waiting_rc;
      this.rc.error_rc = response.data.error_rc;
      this.rc.entire_rc = this.rc.proceeding_rc + this.rc.waiting_rc + this.rc.error_rc;
      this.cal_Rate("operation", this.rc.proceeding_rc, this.rc.entire_rc);

      this.call_info.entire_call = response.data.entire_call; //delivery's status info
      this.call_info.complete_call = response.data.complete_call;
      this.call_info.call_avg_month_ago = Math.floor(response.data.call_avg_month_ago);
      this.cal_Rate("call", this.call_info.complete_call, this.call_info.entire_call);

      this.rank_bldg = response.data.build_rank;  //buliding's rank 

      this.wait_info.complete_waiting = response.data.complete_waiting; //waiting's info
      this.wait_info.now_waiting = response.data.now_waiting;
      this.wait_info.canceled_waiting = response.data.canceled_waiting;
      this.wait_info.entire_waiting = this.wait_info.complete_waiting + this.wait_info.now_waiting + this.wait_info.canceled_waiting;
      this.cal_Rate("cancel", this.wait_info.canceled_waiting, this.wait_info.entire_waiting);

      this.wait_time.avg_waiting_time = Math.floor(response.data.avg_waiting_time); //average waiting time
      this.wait_time.avg_waiting_time_month_ago = Math.floor(response.data.avg_waiting_time_month_ago)

      this.rc_list = response.data.map_car_status;  //rc info's list
      this.station_list = response.data.station_info; //station info's list

      for(var i = 0, len = this.rc_list.length ; i < len; i++){ //create markers for rc cars
        const marker = new kakao.maps.Marker({  //create marker
          map: this.map_info.map, // set map
          position: new kakao.maps.LatLng(this.rc_list[i].car_lat, this.rc_list[i].car_lon), // marker's location
          title : this.rc_list[i].car_num //marker's title
        });
        if(this.rc_list[i].car_status == "配達中" || this.rc_list[i].car_status == "呼び出し中"){ //setting image
          marker.setImage(this.markerImg.proceedingMarker);
        }else if(this.rc_list[i].car_status == "配達待機"){
          marker.setImage(this.markerImg.freeMarker);
        }else if(this.rc_list[i].car_status == "エラー"){
          marker.setImage(this.markerImg.errMarker);
        }
        this.marker[i] = marker;
        kakao.maps.event.addListener(marker, 'click', () => { //marker's click event
          Axios.get('/api/dlvy/control/show/' + marker.getTitle())  //get marker's info
          .then((response) => {
            this.rc_info.rc_name = '';    //delete content before
            this.rc_info.rc_status = '';
            this.rc_info.rc_error_info = '';
            this.user_info.sender_name = '';
            this.user_info.sender_phone = '';
            this.user_info.receiver_name = '';
            this.user_info.receiver_phone = '';
            this.point.start_point = '';
            this.point.end_point = '';
            this.dlvy_time.start_time = '';
            this.dlvy_time.end_time = '';

            if(response.data.car_status == "配達待機"){   //put the value according to car_status
              this.rc_info.rc_name = response.data.car_name;
              this.rc_info.rc_status = response.data.car_status;
            }else if(response.data.car_status == "エラー"){
              this.rc_info.rc_name = response.data.car_name;
              this.rc_info.rc_status = response.data.car_status;
              this.rc_info.rc_error_info = response.data.car_error;
            }else{
              this.rc_info.rc_name = response.data.car.car_name;
              this.rc_info.rc_status = response.data.car.car_status;
              this.user_info.sender_name = response.data.sender_info.user_name;
              this.user_info.sender_phone = response.data.sender_info.user_phone;
              this.user_info.receiver_name = response.data.receiver_info.user_name;
              this.user_info.receiver_phone = response.data.receiver_info.user_phone;
              this.point.start_point = response.data.dlvy_start_point.station_name;
              this.point.start_point_lat = response.data.dlvy_start_point.station_lat;
              this.point.start_point_lon = response.data.dlvy_start_point.station_lon;
              this.point.end_point = response.data.dlvy_end_point.station_name;
              this.point.end_point_lat = response.data.dlvy_end_point.station_lat;
              this.point.end_point_lon = response.data.dlvy_end_point.station_lon;
              if(this.rc_info.rc_status == "呼び出し中"){
                this.dlvy_time.start_time = '呼び出し中'
                this.dlvy_time.end_time = '呼び出し中'
              }else if(this.rc_info.rc_status == "配達中"){ 
                var split_time = response.data.dlvy_status.dlvy_start.split(":"); //for excepting second
                var split_time = [split_time[0], split_time[1]];
                this.dlvy_time.start_time = split_time.join(':'); //start time

                var rc_lat = response.data.car.car_lat;
                var rc_lon = response.data.car.car_lon;
                var distance = this.predict_time(rc_lat, rc_lon, this.point.end_point_lat, this.point.end_point_lon);
                var time = Math.ceil(distance / (1/12)) //on the assumption rc car's speed is 5km/h
                if(Number(split_time[1]) + time >= 60){ 
                  split_time[0] = Number(split_time[0]) + 1
                  split_time[1] = Number(split_time[1]) - 60
                  if(Number(split_time[1] < 10)){ 
                    split_time[1] = '0' + Number(split_time[1])
                  }
                  this.dlvy_time.end_time = split_time.join(':'); //predicted end time
                }else{
                  split_time[1] = Number(split_time[1]) + time;
                  if(Number(split_time[1] < 10)){ 
                    split_time[1] = '0' + Number(split_time[1])
                  }
                  this.dlvy_time.end_time = split_time.join(':'); //predicted end time
                }
              }
            }
          })
          .catch(err => {
            console.log(err);
          })
        });
      }
      for(var i = 0, len = this.station_list.length; i < len; i++){    //create marker for stations
        const marker = new kakao.maps.Marker({
          map: this.map_info.map,
          position: new kakao.maps.LatLng(this.station_list[i].station_lat, this.station_list[i].station_lon),
          title : this.station_list[i].station_name,
          image : this.markerImg.stationMarker
        });
      }
    })
    .catch(error => {
      console.log(error)
    })
  },
  methods : {
    predict_time(rc_lat, rc_lon, start_lat, start_lon){ //calculate distance.
      var startLat = this.degreesToRadians(rc_lat);
      var startLon = this.degreesToRadians(rc_lon);
      var endLat = this.degreesToRadians(start_lat);
      var endLon = this.degreesToRadians(start_lon);
      var Radius = 6371; //지구의 반경(km

      var distance = Math.acos(Math.sin(startLat) * Math.sin(endLat) + 
                    Math.cos(startLat) * Math.cos(endLat) *
                    Math.cos(startLon - endLon)) * Radius;

      return distance;
    },
    degreesToRadians(degrees){  //change location to radian
      var radians = (degrees * Math.PI)/180

      return radians;
    },
    changeMarkerImage(){  //change marker's image
      Axios.get('/api/dlvy/control/car')
      .then((response) => {
        this.rc_list = response.data;
        for(var i = 0, len = this.rc_list.length ; i < len; i++){
          if(this.rc_list[i].car_status == "配達中" || this.rc_list[i].car_status == "呼び出し中"){
            this.marker[i].setImage(this.markerImg.proceedingMarker);
          }else if(this.rc_list[i].car_status == "配達待機"){
            this.marker[i].setImage(this.markerImg.freeMarker);
          }else if(this.rc_list[i].car_status == "エラー"){
            this.marker[i].setImage(this.markerImg.errMarker);
          }
        }
      })
      .catch((err) => {
        console.log(err);
      })
    },
    cal_Rate(rate, numerator, denominator){ //calculate percentage
      if(rate == "call"){
        if(denominator != 0){
          this.call_info.complete_rate = Math.floor((numerator / denominator) * 100);
        }else{
          this.call_info.complete_rate = 0;
        }
      }else if(rate == "operation"){
        if(denominator != 0){
          this.rc.operation_rate = Math.floor((numerator / denominator) * 100);
        }else{
          this.rc.operation_rate = 0;
        }
      }else if(rate == "cancel"){
        if(denominator != 0){
          this.wait_info.canceled_waiting_rate = Math.floor((numerator / denominator) * 100);
        }else{
            this.wait_info.canceled_waiting_rate = 0;
        }
      }
    }
  }
}
</script>

<style scoped>



.container{
  display: flex;
  width: 2200px;
  height:675px;
  max-width:1535px;
  background-color: #E9E9F2;
  color:#A6A6A6;
  margin-right: 25px;
}
.left_container{ /*rc_status, dlvy_status, cancel_waiting, rank_bldg, avg_waiting_time*/
  display: grid;
  grid-template-columns: 50% 50%;
  grid-template-rows: 20% 47% 33%;
  width: 33%;
  height: 95%;
  text-align: center;
  margin-top: 15px;
}

.rc_status{
  display: grid;
  grid-column-start: 1;
  grid-column-end: 3;
  grid-template-rows: 25% 75%;
  border-style: solid;
  border-width: 1.5px;
  border-color: #2862D0;
  border-radius: 15px;
  background-color: #2862D0;
  height: 100%;
}

#rc_status_header{
  padding: 5px;
  margin-right: 2%;
  margin-left: 2%;
  text-align: start;
  font-size: 1em;
  color: white;
 
}

.status_list{         /* rc car status list 1~5 start */
  display: flex;
  margin-top: 10px;
  margin-bottom: 20px;
  border-radius: 15px;
}

.status_list_item1{
  width : 100%;
  text-align : center;
  border-right:1.5px solid #78AAFB;
}

.status_list_item1 div{
font-size: 2em;
}

.status_list_item2{
  width : 100%;
  text-align : center;
  border-right:1.5px solid #78AAFB;
}

.status_list_item2 div{
font-size: 2em;
}
.status_list_item3{
  width : 100%;
  text-align : center;
  border-right:1.5px solid #78AAFB;
}
.status_list_item3 div{
font-size: 2em;
}

.status_list_item4{
  width : 100%;
  text-align : center;
  border-right:1.5px solid #78AAFB;
}
.status_list_item4 div{
font-size: 2em;
}

.status_list_item5{
  width : 100%;
  text-align : center;

}
.status_list_item5 div{     /* rc car status list 1~5 end */
font-size: 2em;
}

.dlvy_status{               /* delivery status start */
  display: grid;
  grid-template-rows: 15% 45% 40%;
  border-style: solid;
  border-width: 1.5px;
  border-color: #E6E9ED;
  border-radius: 15px;
  margin-top: 10px;
  margin-right: 20px;
  margin-bottom: 15px;
  background-color:white;
}

#dlvy_status_header{
  display: grid;
  grid-template-columns: 20% 80%;
  border-bottom:3px solid #E6E9ED;
  padding: 10px;
  margin-right: 4%;
  margin-left: 4%;
  text-align: start;
  font-size: 0.9em;
  color:#929293;
  height: 50px;
}

#chart{
  margin-bottom: 20px;
}

.dlvy_status_list td {
  padding: 10px;
  line-height: 10px;
  border-bottom: 1px solid #eeeeee;
  font-size: 1em;
}

#dlvy_status_icon{
  width: 100%;
  height: 100%;
  background-image: url( "../../../public/image/dlvy_status.jpg" );
  background-repeat: no-repeat;
}

#dlvy_status_summary{     /* delivery status end */  
  width: 100%;
  text-align: start;
  margin-left: 10%;
}

#doughnut_chart{
margin-top: 30px;
}

.cancel_waiting{           /* canclled waiting */
  border-style: solid;
  border-width: 1.5px;
  border-color: #E6E9ED;
  margin-top: 10px;
  margin-bottom: 15px;
  background-color: white;
  border-radius: 15px;
}

#cancel_waiting_header{
  display: grid;
  grid-template-columns: 15% 85%;
  border-bottom:3px solid #E6E9ED;
  padding: 10px;
  margin-right: 4%;
  margin-left: 4%;
  text-align: start;
  font-size: 0.85em;
  color:#929293;
  height: 50px;
}

#cancel_waiting_icon{
  width: 100%;
  height: 100%;
  background-image: url( "../../../public/image/cancel_waiting.jpg" );
  background-repeat: no-repeat;
}

#cancel_waiting_summary{
   margin-top: 50px;
   margin-left: 25px;
   font-size: 1em;
   text-align: left;
}

.cancel_waiting_list{
margin-top: 50px;
}

.cancel_waiting_list td {
  padding: 8px;
  line-height: 15px;
  border-bottom: 1px solid #eeeeee;
  font-size: 1em;
}


.rank_bldg{               /* most called building ranking*/
  border-style: solid;  
  border-width: 1.5px;
  border-color: #E6E9ED;
  background-color: white;
  margin-right: 20px;
  border-radius: 15px;
  
}

#rank_bldg_summary{
  margin-left: 20px;
  font-size: 1.2em;
  text-align: left;
}

.rank_bldg_list {
 margin-top: 30px;
}

.rank_bldg_list td {
  padding: 10px;
  line-height: 20px;
  border-bottom: 1px solid #eeeeee;
  font-size: 1em;
}

#rank_bldg_header{
  display: grid;
  grid-template-columns: 20% 80%;
  border-bottom:3px solid #E6E9ED;
  padding: 10px;
  margin-right: 4%;
  margin-left: 4%;
  text-align: start;
  font-size: 0.85em;
  color:#929293;
    height: 50px;
}

#rank_bldg_icon{
  width: 100%;
  height: 100%;
  background-image: url( "../../../public/image/rank_bldg.jpg" );
  background-repeat: no-repeat;
}

.avg_waiting_time{        /* average waiting time */
  border-style: solid;
  border-width: 1.5px;
  border-color: #E6E9ED;
  background-color: white;
  border-radius: 15px;
}

#avg_waiting_time_summary{
  margin-top: 50px;
  font-size: 1.3em;
}

#avg_waiting_time_header{
  display: grid;
  grid-template-columns: 20% 80%;
  border-bottom:3px solid #E6E9ED;
  padding: 10px;
  margin-right: 4%;
  margin-left: 4%;
  text-align: start;
  font-size: 0.9em;
  color:#929293;
  height: 50px;
}

#avg_waiting_time_icon{
  width: 100%;
  height: 100%;
  background-image: url( "../../../public/image/avg_waiting_time.jpg" );
  background-repeat: no-repeat;
}

.right_container{       /* map, dlvy_info*/
  display: grid;
  grid-template-columns:100%;
  grid-template-rows: 67% 33%;
  width: 67%;
  height: 95%;
  margin-left: 20px;
  margin-top: 15px;
}

.right_map{
  display: grid;
  grid-template-columns:100%;
  grid-template-rows: 95% 5%;
  border-style: solid;
  border-width: 1.5px;
  border-color: #E6E9ED;
  margin-bottom: 15px;
  border-radius: 15px;
  padding: 1.5%;
  background-color: white;
}

#map{
  width:100%;
  height:100%;
  border-radius: 15px;
}

.map_info{
display:flex;
height:100%;
justify-content: left;
margin-top: 5px;
}

.map_box1{
  background-color:#FFB72B;
  width:17px;
  height:17px;
  margin-right:10px;
  margin-top:5px;
}

.map_box2{
  background-color:#5071C0;
  width:17px;
  height:17px;
  margin-right:10px;
  margin-top:5px;
}

.map_box3{
  background-color:#EA4A85;
  width:17px;
  height:17px;
  margin-right:10px;
  margin-top:5px;
}

.map_box4{
  background-color:#7ACCBD;
  width:17px;
  height:17px;
  margin-right:10px;
  margin-top:5px;
}

.right_dlvy_info{                           /* delivery information start */
  display: grid;
  grid-template-columns: 30% 35% 35%;
  grid-template-rows: 20% 80%;
  border-style: solid;
  border-width: 1.5px;
  border-color: #E6E9ED;
  background-color: white;
  color:#676767;
  border-radius: 15px;
}

#dlvy_info_table{                          
  margin-top: 70px;
  margin-left: 30px;
}

#info_item1{
  margin-top: 15px;
  margin-left: 15%;
}

#info_item2{
  margin-top: 15px;

}

#info_item3{                            /* delivery information end */
  margin-top: 15px;
}

#right_dlvy_info_header{
  display: grid;
  grid-template-columns: 4% 96%;
  grid-column-start: 1;
  grid-column-end: 4;
  border-bottom:3px solid #E6E9ED;
  padding: 10px;
  margin-right: 2%;
  margin-left: 2%;
  text-align: start;
  font-size: 0.9em;
  color:#929293;
  height: 50px;
}

#right_dlvy_info_icon{
  width: 100%;
  height: 100%;
  background-image: url( "../../../public/image/right_dlvy_info.jpg" );
  background-repeat: no-repeat;
}

.info_item1_list{
  margin-top: 40px;
}

.info_item2_list td {
  padding: 10px;
  line-height: 20px;
  border-bottom: 1px solid #eeeeee;
  font-size: 0.9em;
}
.info_item3_list td {
  padding: 10px;
  line-height: 20px;
  border-bottom: 1px solid #eeeeee;
  font-size: 0.9em;
}

.info_item1_list td {
  padding: 10px;
  line-height: 20px;
  border-bottom: 1px solid #eeeeee;
  font-size: 0.9em;
}

</style>