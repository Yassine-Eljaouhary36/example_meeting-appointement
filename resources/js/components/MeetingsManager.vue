<template>
    <div id="app">
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
            @change="select"
        />
        <input type="hidden" name="meeting" :value="meeting.date">
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
                    "status":index % 2 == 0 ? true : false
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
                        event.date = ""
                        event.status = ""
                    }
                })
                if( d1.getTime()<d3.getTime()){
                    event.date = ""
                    event.status = ""
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
  },
  mounted(){
console.log(this.meetingsDays);
 console.log(this.meetings);
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
