<template>
<div class="background">
    <div class="container">
        <div class="left_container">
            <div class="left_container_item1">    <!--category -->
            <div id="category_header">配達</div>

                <div id="category_body">
                    <div style="margin-bottom:5px;">
                    <b-button variant="primary" class="button0" @click="categori_change('complete')">
                        配達完了件数
                    </b-button>
                    </div>
                    <div style="margin-bottom:5px;">
                    <b-button variant="primary" class="button0" @click="categori_change('waiting_status')">
                        待機完了/キャンセル
                    </b-button>
                    </div>
                    <div>
                    <b-button variant="primary" class="button0" @click="categori_change('waiting_time_avg')">
                        平均待機時間
                    </b-button>
                    </div>
                </div>                         <!-- category -->
            </div>
        </div>
        <div class="right_container">
            <div class="right_container_item1">
                <div id="datepicker">  <!-- chart datepicker -->
                            <vc-date-picker
                                v-if="term=='day'"
                                v-model="date"
                                @dayfocusin="selected"
                                :max-date='yesterday'
                                />
                            <vc-date-picker
                                v-if="term=='week'"
                                :attributes='attributes'
                                @dayfocusin="selected"
                                :max-date='for_week_disable'
                                :masks="{ input: `${input_text}`}"
                                :input-props='{ 
                                    placeholder: `${attributes[0].dates.start.getFullYear()}.${attributes[0].dates.start.getMonth()+1}.${attributes[0].dates.start.getDate()} ~ ${attributes[0].dates.end.getFullYear()}.${attributes[0].dates.end.getMonth()+1}.${attributes[0].dates.end.getDate()}`,
                                }'
                                />
                            <vue-monthly-picker
                                v-if="term=='month'"
                                @selected="showDate"
                                :max="new Date(today.getFullYear(), today.getMonth()-1,1)"
                                v-model="selected_month"
                                />
                </div>  
                 <div id="buttons1">
                                <b-button variant="primary" class ="chart_button" @click="clicked(mode, 'day')">
                                    日間
                                </b-button>
                                <b-button  variant="primary" class ="chart_button" @click="clicked(mode, 'week')">
                                    週間
                                </b-button>
                                <b-button  variant="primary" class ="chart_button" @click="clicked(mode, 'month')">
                                    月間
                                </b-button>
                </div>
            </div>
               
            <div class="right_container_item2">    <!-- chart header, datepicker, button, body -->  
                <div id="buttons2">
                     <b-button variant= "primary" class ="chart_button" @click="clicked('acc', term)" v-if="term != 'day' & categori != '平均待機時間'">
                                    累積
                            </b-button>
                            <b-button variant="primary" class ="chart_button" @click="clicked('avg', term)" v-if="term != 'day' & categori != '平均待機時間'">
                                    平均
                            </b-button>
                </div>       
                <div id="chart_header">  <!-- chart header -->
                        {{categori}}
                </div>
                <div id="chart">
                <bar-chart
                                :chart-data="datacollection"/>
                        
                </div>     
            </div>

        </div>
    </div>
</div>
</template>
<script>
import BarChart from './Bar_Chart.js';
import VueMonthlyPicker from 'vue-monthly-picker'

    export default {
        data(){
            return {
                categori : '配達完了',
                date : new Date(),  //graph's date
                today : new Date(), //today's date
                for_week_disable : '', //disabled week
                selected_month : new Date().getFullYear()+'/'+new Date().getMonth(),    //selected month
                yesterday : '', //yesterday's date
                mode : 'acc',       //mode(accumulation, average)
                term : 'day',       //term(day, week, month)
                input_text : '',    //week picker's input value
                attributes: [       //week picker's style
                    {
                    highlight: {
                        color: 'purple'
                    },
                    dates : {
                        start: '',
                        end: '',
                    },
                    }
                ],
                complete_date : [],         //completed delivery graph's date
                complete_number : [],       //completed delivery graph's value
                waiting_status_date : [],   //waiting info graph's date
                waiting_complete : [],      //completed waiting graph's value
                waiting_cancel : [],        //canceled waiting graph's value
                wait_time_avg_date : [],    //average waiting time graph's date
                wait_time_avg : [],         //average waiting time graph's value
                datacollection: null,       //graph's option
            }
        },
        components: {
            VueMonthlyPicker,
            BarChart
        },
        mounted(){
            this.yesterday = this.date.getTime() - (1 * 24 * 60 * 60 * 1000);   //date of yesterday
            this.date.setTime(this.yesterday)        //for disabled picker

            this.loaded();
            var week_start =  this.today.getDate() - (this.today.getDay()+7);   //set the date for default week
            var week_end = this.today.getDate() - (this.today.getDay()+1);
            this.attributes[0].dates = {
                start : new Date(this.today.getFullYear(), this.today.getMonth(), week_start),
                end : new Date(this.today.getFullYear(), this.today.getMonth(),week_end)
            }
            this.for_week_disable = new Date(this.today.getFullYear(), this.today.getMonth(), week_end);
        },
        methods : {
            categori_change(val){                       //change categori
                if(val == 'complete'){
                    this.categori = "配達完了";
                }else if(val == 'waiting_status'){
                    this.categori = "待機完了・キャンセル";
                }else if(val == 'waiting_time_avg'){
                    this.categori = "平均待機時間";
                }
                this.mode = "acc"
                this.term = "day"
                this.loaded();
            },
            clicked(mode, term){    //change mode or term
                this.mode = mode;
                this.term = term;
                this.loaded(); 
            },
            selected(day){  //user selected date
                if(this.categori == "配達完了"){   //when categori is completed delivery
                    if(this.term == 'day'){     //when term is day
                        Axios.get('/api/dlvy/statistics/complete/'+this.mode+'/'+this.term+'/'+this.getFormDate(day.date))   
                        .then((response) => {
                            this.complete_date = response.data.date_info;
                            this.complete_number = response.data.statis_info;
                            this.datacollection = { //set graph's option
                                    labels : this.complete_date,
                                    datasets: [
                                        {
                                            label : '配達完了件数',
                                            backgroundColor: '#f87979',
                                            data : this.complete_number
                                        },
                                    ]
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        })
                    }else if(this.term == 'week'){ //when term is week
                        if(day.date <= this.for_week_disable){
                            var week_start = day.day - (day.weekday-1); //calculate week
                            var week_end = day.day + (7-day.weekday);
                            this.attributes[0].dates = {
                                start : new Date(day.year, day.month-1, week_start),
                                end : new Date(day.year, day.month-1,week_end)
                            }
                        }
                        this.loaded();
                    }
                }else if(this.categori == "待機完了・キャンセル"){    //when categori is waiting info
                    if(this.term == 'day'){ //when term is day
                        Axios.get('/api/dlvy/statistics/waitcancel/'+this.mode+'/'+this.term+'/'+this.getFormDate(day.date))
                        .then((response) => {
                            this.waiting_status_date = response.data.date_info;
                            this.waiting_complete = response.data.wait_count;
                            this.waiting_cancel = response.data.wait_cancel;
                            this.datacollection = { 
                                labels : this.waiting_status_date,
                                datasets: [
                                    {
                                        label : '待機完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.waiting_complete
                                    },
                                    {
                                        label : '待機キャンセル件数',
                                        backgroundColor : '#2E2EFE',
                                        data : this.waiting_cancel
                                    }
                                ]
                            }
                        })
                    }else if(this.term == 'week'){  //when term is week
                        if(day.date <= this.for_week_disable){
                            var week_start = day.day - (day.weekday-1);
                            var week_end = day.day + (7-day.weekday);
                            this.attributes[0].dates = {
                                start : new Date(day.year, day.month-1, week_start),
                                end : new Date(day.year, day.month-1,week_end)
                            }
                        }
                        this.loaded();
                    }
                }else if(this.categori == "平均待機時間"){    //when categori is average waiting time
                    if(this.term == 'day'){
                        Axios.get('/api/dlvy/statistics/waittimeavg/'+this.term+'/'+this.getFormDate(day.date))
                        .then((response) => {
                            this.wait_time_avg_date = response.data.date_info;
                            this.wait_time_avg = response.data.statis_info;
                            this.datacollection = {
                                labels : this.wait_time_avg_date,
                                datasets: [
                                    {
                                        label : '平均待機時間',
                                        backgroundColor: '#f87979',
                                        data : this.wait_time_avg
                                    },
                                ]
                            }
                        })
                    }else if(this.term == 'week'){
                        if(day.date <= this.for_week_disable){
                            var week_start = day.day - (day.weekday-1); 
                            var week_end = day.day + (7-day.weekday);
                            this.attributes[0].dates = {
                                start : new Date(day.year, day.month-1, week_start),
                                end : new Date(day.year, day.month-1,week_end)
                            }
                        }
                        this.loaded();
                    }
                }
            },
            showDate(date){                     //user selected date when term is month
                this.selected_month = date._i
                this.loaded();
            },
            getFormDate(date){  //set the format of date
                var year = date.getFullYear();              //yyyy
                var month = (1 + date.getMonth());          //M
                month = month >= 10 ? month : '0' + month;  //month
                var day = date.getDate();                   //d
                day = day >= 10 ? day : '0' + day;          //day
                return  year + '-' + month + '-' + day;
            },
            loaded(){       //graph load method
                if(this.categori == "配達完了"){
                    if(this.term=='day'){
                        Axios.get('/api/dlvy/statistics/complete/'+this.mode+'/'+this.term+'/'+this.getFormDate(this.date))
                        .then((response) => {
                            this.complete_date = response.data.date_info;
                            this.complete_number = response.data.statis_info;
                            this.datacollection = {
                                labels : this.complete_date,
                                datasets: [
                                    {
                                        label : '配達完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.complete_number
                                    },
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });                        
                    }else if(this.term == 'week'){
                        Axios.get('/api/dlvy/statistics/complete/'+this.mode+'/'+this.term+'/'+this.getFormDate(this.attributes[0].dates.start))
                        .then((response) => {
                            this.complete_date = response.data.date_info;
                            this.complete_number = response.data.statis_info;
                            this.datacollection = {
                                labels : this.complete_date,
                                datasets: [
                                    {
                                        label : '配達完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.complete_number
                                    },
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }else if(this.term == 'month'){
                        var parse_month = this.selected_month.split('/');
                        Axios.get('/api/dlvy/statistics/complete/'+this.mode+'/'+this.term+'/'+this.getFormDate(new Date(parse_month[0], parse_month[1]-1, 1)))
                        .then((response) => {
                            this.complete_date = response.data.date_info;
                            this.complete_number = response.data.statis_info;
                            this.datacollection = {
                                labels : this.complete_date,
                                datasets: [
                                    {
                                        label : '配達完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.complete_number
                                    },
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }
                }else if(this.categori == "待機完了・キャンセル"){
                    if(this.term=='day'){
                        Axios.get('/api/dlvy/statistics/waitcancel/'+this.mode+'/'+this.term+'/'+this.getFormDate(this.date)) 
                        .then((response) => {
                            this.waiting_status_date = response.data.date_info;
                            this.waiting_complete = response.data.wait_count;
                            this.waiting_cancel = response.data.wait_cancel;
                            this.datacollection = {
                                labels : this.waiting_status_date,
                                datasets: [
                                    {
                                        label : '待機完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.waiting_complete
                                    },
                                    {
                                        label : '待機キャンセル件数',
                                        backgroundColor : '#2E2EFE',
                                        data : this.waiting_cancel
                                    }
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });                        
                    }else if(this.term == 'week'){
                        Axios.get('/api/dlvy/statistics/waitcancel/'+this.mode+'/'+this.term+'/'+this.getFormDate(this.attributes[0].dates.start))
                        .then((response) => {
                            this.waiting_status_date = response.data.date_info;
                            this.waiting_complete = response.data.wait_count;
                            this.waiting_cancel = response.data.wait_cancel;
                            this.datacollection = {
                                labels : this.waiting_status_date,
                                datasets: [
                                    {
                                        label : '待機完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.waiting_complete
                                    },
                                    {
                                        label : '待機キャンセル件数',
                                        backgroundColor : '#2E2EFE',
                                        data : this.waiting_cancel
                                    }
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }else if(this.term == 'month'){
                        var parse_month = this.selected_month.split('/'); 
                        Axios.get('/api/dlvy/statistics/waitcancel/'+this.mode+'/'+this.term+'/'+this.getFormDate(new Date(parse_month[0], parse_month[1]-1, 1)))
                        .then((response) => {
                            this.waiting_status_date = response.data.date_info;
                            this.waiting_complete = response.data.wait_count;
                            this.waiting_cancel = response.data.wait_cancel;
                            this.datacollection = {
                                labels : this.waiting_status_date,
                                datasets: [
                                    {
                                        label : '待機完了件数',
                                        backgroundColor: '#f87979',
                                        data : this.waiting_complete
                                    },
                                    {
                                        label : '待機キャンセル件数',
                                        backgroundColor : '#2E2EFE',
                                        data : this.waiting_cancel
                                    }
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }
                }else if(this.categori == "平均待機時間"){
                    if(this.term=='day'){
                        Axios.get('/api/dlvy/statistics/waittimeavg/'+this.term+'/'+this.getFormDate(this.date))
                        .then((response) => {
                            this.wait_time_avg_date = response.data.date_info;
                            this.wait_time_avg = response.data.statis_info;
                            this.datacollection = {
                                labels : this.wait_time_avg_date,
                                datasets: [
                                    {
                                        label : '平均待機時間',
                                        backgroundColor: '#f87979',
                                        data : this.wait_time_avg
                                    },
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });                        
                    }else if(this.term == 'week'){
                        Axios.get('/api/dlvy/statistics/waittimeavg/'+this.term+'/'+this.getFormDate(this.attributes[0].dates.start))
                        .then((response) => {
                            this.wait_time_avg_date = response.data.date_info;
                            this.wait_time_avg = response.data.statis_info;
                            this.datacollection = {
                                labels : this.wait_time_avg_date,
                                datasets: [
                                    {
                                        label : '平均待機時間',
                                        backgroundColor: '#f87979',
                                        data : this.wait_time_avg
                                    },
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }else if(this.term == 'month'){
                        var parse_month = this.selected_month.split('/');
                        Axios.get('/api/dlvy/statistics/waittimeavg/'+this.term+'/'+this.getFormDate(new Date(parse_month[0], parse_month[1]-1, 1))) 
                        .then((response) => {
                            this.wait_time_avg_date = response.data.date_info;
                            this.wait_time_avg = response.data.statis_info;
                            this.datacollection = {
                                labels : this.wait_time_avg_date,
                                datasets: [
                                    {
                                        label : '平均待機時間',
                                        backgroundColor: '#f87979',
                                        data : this.wait_time_avg
                                    },
                                ]
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }
                }
            }
        },
        watch : {      //change input value when user select date
            attributes : {
                deep: true,
                handler(){
                    this.input_text = this.attributes[0].dates.start.getFullYear()+'.'+(this.attributes[0].dates.start.getMonth()+1)+'.'+
                                      this.attributes[0].dates.start.getDate()+" ~ "+ this.attributes[0].dates.end.getFullYear()+'.'+
                                      (this.attributes[0].dates.end.getMonth()+1)+'.'+this.attributes[0].dates.end.getDate();
                }
                
            }
        }
    }
</script>

<style scoped>

.background{
     background-color: #E9E9F2;
     height: 685px;
}


.container{          /* left, right container */
    display:grid;
    grid-template-columns: 16% 84%;
    width: 100%;
    max-width:1500px;
    margin-right: 140px;
}

.left_container_item1{ /* category */
    display: grid;
    grid-template-rows: 10% 40% 50% ;
    border-style: solid;
    border-width: 1px;
    border-color: #E6E9ED;
    border-radius: 15px;
    margin-right: 25px;
    margin-bottom: 15px;
    background-color:white;
    width: 100%;
    height: 640px;
    margin-top: 30px;
}

#category_header{
    border-bottom:1.5px solid #E6E9ED;
    padding: 10px;
    margin-top: 10px;
    margin-left: 15px;
}

#category_body{
    padding: 10px;
    margin-top: 5px;
}

.button0{
    border-color : white;
    color:#929293;
    background-color : white;
}

.right_container{ 
    display:grid;
    grid-template-columns: 100%;
    grid-template-rows: 13% 87%;
    width: 100%;
    height: 610px;
    margin-top: 30px;
}


.right_container_item1{   /* margin */
    display:grid;
    grid-template-columns: 66% 34%;
    border-style: solid;
    border-width: 1px;
    border-color: #E6E9ED;
    padding: 20px;
    width: 101%;
    height: 100%;
    border-radius: 15px;
    margin-left: 25px;
    background-color: white;
 
}

#datepicker{
    margin-right: 100px;

}
#buttons1{
    display:grid;
    grid-template-columns: 33% 33% 33%;
}



.right_container_item2{   /*chart header, buttons, date picker ,body  */
    display:grid;
    grid-template-columns: 100%;
    grid-template-rows: 7% 13% 80%;
    grid-column-start: 1;
    grid-column-end: 4;
    border-style: solid;
    border-width: 1px;
    border-color: #E6E9ED;
    margin-top: 20px;
    margin-left: 25px;
    width: 99%;
    height: 540px;
    border-radius: 15px;
    padding:10px;
    background-color: white;
}

#buttons2{
    margin-left: 10px;
}
#chart_header{
    display: flex;
  justify-content: center;
  font-size: 2.2em;
}

#chart{
    height: 50%;
}
.button{  /* category buttons */
    color : black;
    background-color : white;
    border : none;
    margin-top : 5%;
    
}
 
.chart_button{ 
    font-size: 1em;
    background-color: white;
    color: black;
    border: none;
    margin-right: 10px;
}

</style>