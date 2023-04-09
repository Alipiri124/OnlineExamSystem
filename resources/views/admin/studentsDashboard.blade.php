@extends('layout/admin-layout')

@section('space-work')
<h2 class="mb-4">Students</h2>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
  Add Student
</button>
<a href="{{ route('exportStudents')}}" class="btn btn-warning">Export Students</a>

<table class="table mt-4">
  <thead>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Edit</th> 
    <th>Delete</th>  
  </thead>
  <tbody>
    @if(count($students) > 0)
      @foreach($students as $student)
      <tr>
        <td>{{ $student->id }}</td>
        <td>{{ $student->name }}</td> 
        <td>{{ $student->email }}</td>   
        <td>
          <button class="btn btn-info editButton" data-id="{{ $student->id}}" data-name="{{ $student->name}}" data-email="{{ $student->email}}" data-toggle="modal" data-target="#editStudentModal">Edit</button>
        </td> 
        <td>
          <button class="btn btn-danger deleteButton" data-id="{{ $student->id}}" data-toggle="modal" data-target="#deleteStudentModal">Delete</button>
        </td>            
      </tr>
      @endforeach
    @else
    <tr>
      <td colspan="3">Questions & Answers not found!</td>
    </tr>
    @endif
  </tbody>
</table>

<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <form id="addStudent">
      @csrf     
       <div class="modal-body">
         <div class="row">
           <div class="col">
             <input type="text" name="name" class="w-100" required placeholder="Enter Student Name">
           </div>           
         </div>
         <div class="row mt-3">
           <div class="col">
             <input type="email" name="email" class="w-100" required placeholder="Enter Student Email">
           </div>           
         </div>
       </div>
       <div class="modal-footer">
        <span class="error" style="color:red;"></span>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
         <button type="submit" class="btn btn-primary">Add Student</button>
       </div>  
     </form>    
    </div>   
  </div>
</div>
<!-- Edit Student -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Student</h5>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <form id="editStudent">
      @csrf     
       <div class="modal-body">
         <div class="row">
           <div class="col">
            <input type="hidden" name="id" id="id">
             <input type="text" name="name" id="name" class="w-100" required placeholder="Enter Student Name">
           </div>           
         </div>
         <div class="row mt-3">
           <div class="col">
             <input type="email" name="email" id="email" class="w-100" required placeholder="Enter Student Email">
           </div>           
         </div>
       </div>
       <div class="modal-footer">
        <span class="error" style="color:red;"></span>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
         <button type="submit" class="btn btn-primary updateButton">Update Student</button>
       </div>  
     </form>    
    </div>   
  </div>
</div>
<!-- Delete Student -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Student</h5>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <form id="deleteStudent">
      @csrf     
       <div class="modal-body">
         <div class="row">
           <div class="col">
            <h4>Are you sure?</h4> 
            <input type="hidden" name="id" id="student_id">            
           </div>           
         </div>         
       </div>
       <div class="modal-footer">
        <span class="error" style="color:red;"></span>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
         <button type="submit" class="btn btn-danger">Delete Student</button>
       </div>  
     </form>    
    </div>   
  </div>
</div>
<script>
  $(document).ready(function(){
     $("#addStudent").submit(function(e){
       e.preventDefault();

       var formData = $(this).serialize();

       $.ajax({
          url:"{{ route('addStudent')}}",
          type:"post",
          data:formData,
          success:function(data){
            if (data.success == true) {
              location.reload();
            }else{
              alert(data.msg);
            }
          }
       });
     });
     //edit button click and show values
     $(".editButton").click(function(){
        $("#id").val($(this).attr('data-id'));
        $("#name").val($(this).attr('data-name'));
        $("#email").val($(this).attr('data-email'));
 
     });

       $("#editStudent").submit(function(e){
         e.preventDefault();
         $('.updateButton').prop('disabled',true);

         var formData = $(this).serialize();

         $.ajax({
            url:"{{ route('editStudent')}}",
            type:"post", 
            data:formData,
            success:function(data){
              if (data.success == true) {
                location.reload();
              }else{
                alert(data.msg);
              }
            }
         });
       });
       //delete student
       $(".deleteButton").click(function(){
          var id = $(this).attr('data-id');
          $("#student_id").val(id);
       });

       $("#deleteStudent").submit(function(e){
         e.preventDefault();        

         var formData = $(this).serialize();

         $.ajax({
            url:"{{ route('deleteStudent')}}",
            type:"post", 
            data:formData,
            success:function(data){
              if (data.success == true) {
                location.reload();
              }else{
                alert(data.msg);
              }
            }
         });
       });
  });
</script>
@endsection
