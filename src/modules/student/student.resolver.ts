import { Mutation, Query } from "@nestjs/graphql";
import { Args, Resolver } from "@nestjs/graphql";

@Resolver('Student')
export class StudentResolver {
    private students = [
        {  
            id: 1, 
            name: 'John Doe', 
            idCard: 'e001',
            classname: 'GIC-A',
        },
        { 
            id: 2, 
            name: 'Jane Smith', 
            idCard: 'e002',
            classname: 'GIC-B',        
        },
        { 
            id: 3, 
            name: 'Alice Johnson', 
            idCard: 'e003',
            classname: 'GIC-A',        
        },
    ]

    @Query('students')
    getStudents() {
        console.log('getStudents called');
        return this.students;
    }

    @Mutation('enrollStudent')
    enrollStudent(@Args('name') name: string, @Args('idCard') idCard: string, @Args('classname') classname: string) {
        const sortedStudents = this.students.sort((a, b) => a.id - b.id);
        const lastId = sortedStudents.length > 0 ? sortedStudents[sortedStudents.length - 1].id : 0;
        const newStudent = {
            id: lastId + 1,
            name,
            idCard,
            classname,
        };
        this.students.push(newStudent);
        return newStudent;
    }

    @Mutation('removeStudent')
    removeStudent(@Args('id') id: number) {
        try{
            const studentIndex = this.students.findIndex(s => s.id === id);
            if (studentIndex === -1) {
                return false;
            }
            this.students.splice(studentIndex, 1);
            return true;
        } catch (e) {
            console.error(e);
            return false;
        }
    }

    @Mutation('updateStudent')
    updateStudent(@Args('id') id: number, @Args('name') name: string, @Args('idCard') idCard: string, @Args('classname') classname: string) {
        const studentIndex = this.students.findIndex(s => s.id === id);
        if (studentIndex === -1) {
            throw new Error('Student not found');
        }
        const updatedStudent = {
            ...this.students[studentIndex],
            name,
            idCard,
            classname
        };
        this.students[studentIndex] = updatedStudent;
        return updatedStudent;
    }

    @Query('getStudent')
    getStudentByClass(@Args('classname') classname: string) {
        return this.students.filter(student => student.classname === classname);
    }
}