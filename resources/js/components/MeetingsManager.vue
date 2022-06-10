<template>
    <div id="app">
        <div class="d-flex py-2" style="justify-content:space-between ;">
            <button type="button" class="btn btn-dark px-4"
            @click="previousDate"
            > <i class="fa-solid fa-angle-left" style="font-size:20px;font-weight:bold ;"></i></button>
            <div class="d-flex">
                <div class="d-flex">
                    <div class="d-flex mx-1 " style="align-items:center ;">
                        <div class="px-2 ">Day</div>
                        <input type="radio" name="displayValue" @click="setDisplayValue(true)">
                    </div>
                    <div class="d-flex mx-1 " style="align-items:center ;">
                        <div class="px-2 ">Week</div>
                        <input type="radio" name="displayValue" @click="setDisplayValue(false)">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-dark px-4"
            @click="nextDate"
            > <i class="fa-solid fa-angle-right" style="font-size:20px;font-weight:bold ;"></i></button>
        </div>
        <div class="d-flex py-3" style="justify-content:center;" v-if="!this.displayValue.display">
            <div class="d-flex mostly-customized-scrollbar" style="max-height:50vh ;overflow-y:auto ; overflow-x: auto;">
                <div class="d-flex mx-3" style="flex-direction: column; min-width:120px;" v-for="item in meetingsDays" :key="item.id">
                    <div class="py-1">
                        <div class="d-flex" style="flex-direction:column ; align-items:center ;">
                            <h5 style="font-weight:900;">
                                {{formatDateDay(item.date)}}
                            </h5>
                            <span class="py-1">
                                {{formatDateMonth(item.date)}}
                            </span>
                        </div>
                    </div>
                    <button class="mb-3 btn" v-for="ele in item.slots" :key="ele.date" 
                        :style="!ele.status ? 'cursor: not-allowed;' : 'cursor: pointer;' "
                        :class="{
                        'btn-primary': ele.status,
                        'btn-danger': !ele.status,
                        }"
                        @click="selectDate(ele)"
                        >
                        {{ formatTime(ele.date) }}
                    </button>
                </div>
            </div>
        </div>
        <div class="d-flex py-3 mostly-customized-scrollbar" style="justify-content:center;" v-if="this.displayValue.display">
            <div class="d-flex mx-3" style="flex-direction: column; width: 100%;" v-for="item in meetingsDays" :key="item.id">
                <div class="py-1">
                    <div class="d-flex" style="flex-direction:column ; align-items:center ;">
                        <h5 style="font-weight:900;">
                            {{formatDateDay(item.date)}}
                        </h5>
                        <span class="py-1">
                            {{formatDateMonth(item.date)}}
                        </span>
                    </div>
                </div>
                <div class="d-flex" style="flex-direction:column; flex-wrap: wrap;max-height:50vh;overflow-x: auto;">
                    <button class="m-3 btn" v-for="ele in item.slots" :key="ele.date" 
                        :style="!ele.status ? 'cursor: not-allowed;' : 'cursor: pointer;' "
                        :class="{
                        'btn-primary': ele.status,
                        'btn-danger': !ele.status,
                        }"
                        @click="selectDate(ele)"
                        >
                        {{ formatTime(ele.date) }}
                    </button>   
                </div>
            </div>
        </div>
        <input type="hidden" name="meeting" :value="meeting.date">
    </div>
</template>

<script>
export default {
  name: "App",
    props: {
        meetings:Array,
        hours:String,
        minutes:String
    },
    data() {
        return {
            date: new Date(),
            meetingsDays: [],
            meeting: {},
            displayValue: {
                display:true,
                loopValue : 1,
                previousValue:2
            }
        };
    },
    methods: {
    verifyDate(){
        return false
    },
    async setDisplayValue(value){
        if(value){
           this.displayValue = {
                display:true,
                loopValue : 1,
                previousValue:2
            } 
        }else{
            this.displayValue = {
                display:false,
                loopValue : 7,
                previousValue:14
            } 
        }
        this.meetingsDays = await this.getMeetings(this.date);
    },
    getMeetings(date) {
        var week= new Array(); 
        date.setDate(date.getDate() );
        for (var i = 0; i < this.displayValue.loopValue; i++) {
            week.push(
                {
                    "date":new Date(date).toJSON(),
                    "slots": [],
                }
            ); 
            date.setDate(date.getDate() + 1);
        }
        week.forEach((element,index) => {
            var Datetime = new Date(element.date);
            Datetime.setHours(8);
            Datetime.setMinutes(0);
            Datetime.setSeconds(0);
            Datetime.setMilliseconds(0);
            var minutesToAdd=60;
            var dTime = new Date()
            dTime.setHours(this.hours);
            dTime.setMinutes(this.minutes);
            if(this.hours <=23 && this.minutes <59){
                var CounterTime = (((dTime.getHours()-8)*60)/30)+parseInt(dTime.getMinutes()/30)+1
            }else{
                var CounterTime = 0
            }
            for (let index = 0; index < CounterTime; index++) {
                element.slots.push({
                    "date":  Datetime,
                    "status":true 
                })
                Datetime = new Date(Datetime.getTime() + minutesToAdd*30*1000)
            }
        });

        week.forEach(element => {
            element.slots.forEach(event => {
                var d1 = new Date(event.date);
                var d3 = new Date()
                d3.setHours(8);
                d3.setMinutes(0);
                d3.setSeconds(0);
                d3.setMilliseconds(0);
                this.meetings.forEach(item=>{
                    var d2 = new Date(item.DateMeeting);
                    if(d1.getTime() === d2.getTime()){
                        event.status = false
                    }
                })
            })
        });
        return week;
    },
    // don't know what to do here <-------------------------
    async nextDate() {
        const date = new Date(this.date);
        date.setDate(date.getDate() );
        this.meetingsDays = await this.getMeetings(date);
        this.date = date;
    },
    // don't know what to do here <-------------------------
    async previousDate() {
        const date = new Date(this.date);
        var d3 = new Date()
        d3.setHours(date.getHours());
        d3.setMinutes(date.getMinutes());
        d3.setSeconds(date.getSeconds());
        d3.setMilliseconds(date.getMilliseconds());
        date.setDate(date.getDate() - this.displayValue.previousValue);
        if(date.getTime()>=d3.getTime()){
            this.meetingsDays = await this.getMeetings(date);
            this.date = date;    
        }
    },
    formatTime(DateTime){
        var min = DateTime.getMinutes();
        if (min < 10) {
            min = "0" + min;
        }
        return DateTime.getHours()+ ":" + min
    },
    formatDateMonth(date){
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var d = new Date(date);
        return d.getDate()+" "+months[d.getMonth()];
    },
    formatDateDay(date){
        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var d = new Date(date);
        return days[d.getDay()];
    },
    selectDate(data){
        if(data.status){
            this.meeting =data   
        }else{
            this.meeting ={} 
        }
    }
  },
  async created() {
    this.meetingsDays = await this.getMeetings(this.date);
  },
};
</script>

<style>
.mostly-customized-scrollbar::-webkit-scrollbar {
  width: 10px;
  height: 10px;
  border-radius: 2em;
  background-color: #aaa;
}
.mostly-customized-scrollbar::-webkit-scrollbar-thumb {
    background: rgb(0, 146, 231);
    border-radius: 2em;
}
</style>
