@extends('layout/admin-layout')

@section('space-work')
<h2 class="mb-4">Mövzular</h2>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModal">
  Mövzu Əlavə Et
</button>

<table class="table mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Mövzu</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    @if(count($subjects)>0)
      @foreach($subjects as $subject)
        <tr>
        	 <th> {{ $subject->id }} </th>
        	 <td> {{ $subject->subject }} </td>
        	 <td>
            <button class="btn btn-info editButton" data-id="{{ $subject->id }}" data-subject="{{ $subject->subject }}" data-toggle="modal" data-target="#editSubjectModal">Edit</button> 
           </td>
        	 <td>
            <button class="btn btn-danger deleteButton" data-id="{{ $subject->id }}" data-toggle="modal" data-target="#deleteSubjectModal">Delete</button> 
           </td>
        </tr>
      @endforeach
    @else
    <tr>
    	<td colspan="4">Subjects not found!</td>
    </tr>
    @endif
  </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
   <form id="addSubject">
   	@csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Mövzu Əlavə Et</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="subject">Mövzu: </label>
        <input type="text" name="subject" placeholder="Mövzu adını daxil et" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
        <button type="submit" class="btn btn-primary">Əlavə Et</button>
      </div>
    </div>
   </form>
  </div>
</div>
<!--Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editSubject">
       @csrf
          <div class="modal-body">
            <label for="subject">Subject</label>
            <input type="text" name="subject" placeholder="Enter Subject name" required id="edit_subject">
            <input type="hidden" name="id" id="edit_subject_id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
      </form>
    </div>   
  </div>
</div>
<!--Delete Subject Modal -->
<div class="modal fade" id="deleteSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Subject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteSubject">
       @csrf
          <div class="modal-body">
            <h4>Are you sure ?</h4>
            <input type="hidden" name="id" id="delete_subject_id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
      </form>
    </div>   
  </div>
</div>
<script>
	$(document).ready(function(){
        $("#addSubject").submit(function(e){
           e.preventDefault();

           var formData = $(this).serialize();

           $.ajax({
               url:"{{route('addSubject')}}",
               type:"POST",
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

        //edit subject

        $(".editButton").click(function(){
           var subject_id = $(this).attr('data-id');
           var subject = $(this).attr('data-subject');
            $("#edit_subject").val(subject); //bu ve asaqidaki subjecte kohne ad gelsin deyedi
            $("#edit_subject_id").val(subject_id); //bu ise gorsenmir ama id sin goturur           
        });

         $("#editSubject").submit(function(e){
           e.preventDefault();

           var formData = $(this).serialize();

           $.ajax({
               url:"{{route('editSubject')}}",
               type:"POST",
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

         //delete subject

         $(".deleteButton").click(function(){
           var subject_id = $(this).attr('data-id');
           $("#delete_subject_id").val(subject_id);
         });

         $("#deleteSubject").submit(function(e){
           e.preventDefault();

           var formData = $(this).serialize();

           $.ajax({
               url:"{{route('deleteSubject')}}",
               type:"POST",
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