<template>
    <div id="app">
        <div class="container mt-5">
            <div class="alert " 
            v-bind:class="{'alert-danger': hasError, 'alert-success': !hasError }"
            role="alert" v-if="message">
                <strong>{{message}}</strong>
            </div>
            <div class="card">
                <div class="card-body p-5">
                    <vue-meeting-selector
                        class="simple-example__meeting-selector"
                        v-model="meeting"
                        :date="date"
                        :loading="loading"
                        :class-names="classNames"
                        :meetings-days="meetingsDays"
                        v-if="meetingsDays"
                        @next-date="nextDate"
                        @previous-date="previousDate"
                        @disabledDate='reservedDate'
                    />
                    <div class="d-grid gap-1 col-6 mx-auto mt-4">
                        <button @click="submit" type="button" class="btn btn-outline-dark" >
                            <strong>submit</strong>
                        </button>
                    </div>
                </div>
                <p>meeting Selected: {{ meeting ? meeting : 'No Meeting selected' }}</p>
            </div>
             
        </div>
    </div>
</template>

<script>
import VueMeetingSelector from "vue-meeting-selector";
export default {
  name: "App",
    components: {
        VueMeetingSelector,
    },
    computed: {
        classNames() {
        return {
            tabMeeting: 'tabMeetingStyle',
        };
        },
    },
    props: {
        meetings:Array,
    },
    data() {
        return {
            date: new Date(),
            meetingsDays: [],
            meeting: {},
            loading: true,
            message :null,
            hasError:null,
            isReserved:[]
        };
    },
    methods: {
    reservedDate(){
        axios('api/data') 
           .then(response=>{
               this.isReserved = response.data
               console.log(this.isReserved)
           })
           .catch(error=>{
               console.log(error)
           })
    },
    getMeetings(date) {
        this.reservedDate()
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
                    "status":index % 2 == 0 ? true : false
                })
                Datetime = new Date(Datetime.getTime() + minutesToAdd*60*1000)
            }
        });

        week.forEach(element => {
            element.slots.forEach(event => {
                this.meetings.forEach(item=>{
                    var d1 = new Date(event.date);
                    var d2 = new Date(item.DateMeeting);
                    if(d1.getTime() === d2.getTime()){
                        event.date = ""
                        event.status = ""
                    }
                })
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
    submit(){
        if(this.meeting.date == ""){
            this.message = "No Date Selected"
            this.hasError=true
            return;
        }
        axios.post('api/',{
                data:this.meeting
            })
            .then(response=>{
                if(response.status == 201){
                    this.message ="Stored Successfuly"
                    this.hasError=false
                }
                this.mounted
            })
            .catch(error=>{
                this.message = error
                this.hasError=true
            })
            
    },
  },
  mounted(){
// console.log(this.meetingsDays);
this.reservedDate()
//  console.log(this.meetings);
  },
  async created() {
    this.loading = true;
    this.meetingsDays = await this.getMeetings(this.date);
    this.loading = false;
    
  },
};
</script>

<style>

</style>
