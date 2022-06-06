<template>
    <div id="app">
        <div class="d-flex py-2" style="justify-content:space-between ;">
            <button type="button" class="btn btn-outline-primary px-5"
            @click="previousDate"
            > <i class="fa-solid fa-angle-left" style="font-size:20px;font-weight:bold ;"></i></button>
            <button type="button" class="btn btn-outline-primary px-5"
            @click="nextDate"
            > <i class="fa-solid fa-angle-right" style="font-size:20px;font-weight:bold ;"></i></button>
        </div>
        <div class="d-flex py-3" style="justify-content:center;">
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
        <input type="hidden" name="meeting" :value="meeting.date">
    </div>
</template>

<script>
export default {
  name: "App",
    props: {
        meetings:Array,
    },
    data() {
        return {
            date: new Date(),
            meetingsDays: [],
            meeting: {},
        };
    },
    methods: {
    getMeetings(date) {
        var week= new Array(); 
        date.setDate(date.getDate() );
        for (var i = 0; i < 7; i++) {
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
            for (let index = 0; index < 10; index++) {
                element.slots.push({
                    "date":  Datetime,
                    "status":true 
                })
                Datetime = new Date(Datetime.getTime() + minutesToAdd*60*1000)
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
                        // event.date = ""
                        event.status = false
                    }
                })
                if( d1.getTime()<d3.getTime()){
                    // event.date = ""
                    event.status = false
                }
            })
        });
        return week;
    },
    // don't know what to do here <-------------------------
    async nextDate() {
        this.loading = true;
        const date = new Date(this.date);
        date.setDate(date.getDate() );
        this.meetingsDays = await this.getMeetings(date);
        this.date = date;
        this.loading = false;
    },
    // don't know what to do here <-------------------------
    async previousDate() {
        this.loading = true;
        const date = new Date(this.date);
        date.setDate(date.getDate() - 14);
        this.meetingsDays = await this.getMeetings(date);
        this.date = date;
        this.loading = false;
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
    this.loading = true;
    this.meetingsDays = await this.getMeetings(this.date);
    this.loading = false;
    
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
