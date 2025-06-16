import { Args, Mutation, Query, Resolver } from "@nestjs/graphql";

@Resolver('Attendance')
export class AttendanceResolver{
    private attendances = [
        {
            session: 'Math',
            status: 'P',
            student_id: 'e001',
            marker: ''
        },
        {
            session: 'Physic',
            status: 'L',
            student_id: 'e001',
            marker: 'Late by 20mins'
        }, 
        {
            session: 'Literature',
            status: 'P',
            student_id: 'e001',
            marker: ''
        },
        {
            session: 'Math',
            status: 'A',
            student_id: 'e002',
            marker: 'Caught a cold'
        },
        {
            session: 'Physic',
            status: 'L',
            student_id: 'e002',
            marker: 'Late by 35mins'
        },
        {
            session: 'Literature',
            status: 'P',
            student_id: 'e002',
            marker: ''
        },
        {
            session: 'Math',
            status: 'P',
            student_id: 'e003',
            marker: ''
        },
        {
            session: 'Physic',
            status: 'A',
            student_id: 'e003',
            marker: 'Bed rot'
        },
        {
            session: 'Literature',
            status: 'P',
            student_id: 'e003',
            marker: ''
        },
    ]

    @Query('attendances')
    getAttendances(){
        return this.attendances;
    }

    @Query('countAttByClass')
    countAttByClass(@Args('classname') classname: string) {
        return this.attendances.filter(att => att.session === classname);
    }

    @Query('countAttById')
    countAttById(@Args('student_id') student_id: string) {
        return this.attendances.filter(att => att.student_id === student_id);
    }

    @Mutation('markAtt')
    markAtt(@Args('session') session: string, @Args('status') status: string, @Args('student_id') student_id: string, @Args('marker') marker: string) {
        let attendance = this.attendances.find(
            att => att.session === session && att.student_id === student_id
        );
        if (attendance) {
            attendance.status = status;
            attendance.marker = marker;
        }
        else{
            attendance = { session, status, student_id, marker };
            this.attendances.push(attendance);
        }
        return attendance;
    }

    @Mutation('removeAtt')
    removeAtt(@Args('student_id') student_id: string) {
        const initialLength = this.attendances.length;
        this.attendances = this.attendances.filter(att => att.student_id !== student_id);
        return this.attendances.length < initialLength;
    }
}
