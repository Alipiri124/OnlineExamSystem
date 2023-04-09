@extends('layout/admin-layout')

@section('space-work')
<h2 class="mb-4">İmtahan</h2>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModal">
  İmtahanı yarat
</button>

<table class="table mt-4">
  <thead>
    <tr>
      <th>#</th>
      <th>İmtahan adı</th>
      <th>Mövzu</th>
      <th>Tarix</th>
      <th>Vaxt</th>
      <th>İmtahan müddəti</th>
      <!-- <th>Plan</th>
      <th>Prices</th> -->
      <th>Sual əlave et</th>
      <th>Sualları seç</th>
      <th>Əmsal</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    @if(count($exams) > 0)
        @foreach($exams as $exam)
          <tr>
              <th>{{ $exam->id}}</th>
              <td>{{ $exam->exam_name}}</td>
              <td>{{ $exam->subjects[0]['subject']}}</td>
              <td>{{ $exam->date}}</td>
              <td>{{ $exam->time}} Hrs</td>
              <td>{{ $exam->attempt}} Time</td>
              <!-- <td>
                @if($exam->plan !=0)
                <span style="color: red">PAID</span>
                @else
                <span style="color: green;">FREE</span>
                @endif
              </td>
              <td>
                @if($exam->prices !=null)
                  @php $planPrices = json_decode($exam->prices); @endphp
                  @foreach($planPrices as $key => $price)
                     <span>{{ $key }} {{ $price}},</span>
                  @endforeach
                @else
                <span>Not prices</span>
                @endif
              </td> -->
              <td>
                <a href="#" class="addQuestion" data-id="{{ $exam->id}}" data-toggle="modal" data-target="#addQnaModal">Add Question</a>
              </td>
              <td>
                <a href="#" class="seeQuestions" data-id="{{ $exam->id}}" data-toggle="modal" data-target="#seeQnaModal">See Questions</a>
              </td>
              <td>{{ $exam->marks}}</td>
              <td>
                <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#editExamModal">Edit</button> 
              </td>
              <td>
                <button class="btn btn-danger deleteButton" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#deleteExamModal">Delete</button> 
              </td>
          </tr>
        @endforeach
    @else
    <tr>
      <td colspan="5">Exams not found.</td>
    </tr>
    @endif
  </tbody>
</table>

<div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addExam">
   	  @csrf
      <div class="modal-body">
        <label for="subject">Subject</label>
        <input type="text" name="exam_name" placeholder="Enter Exam name" class="w-100" required>
        <br><br>
        <select name="subject_id" required class="w-100">
          <option value="">Select Subject</option>
          @if(count($subjects) > 0)
           @foreach($subjects as $subject)
            <option value="{{$subject->id}}">{{ $subject->subject}}</option>           
           @endforeach
          @endif          
        </select>
        <br><br>
        <input type="date" name="date" class="w-100" required min="@php echo date('Y-m-d') @endphp">
        <br><br>
        <input type="time" name="time" class="w-100" required>
        <br><br>
        <input type="number" min="1" name="attempt" placeholder="Enter Exam Attempt Time" class="w-100" required>
        <br><br>
        <input type="number" min="1" name="marks" placeholder="Enter Exam Marks" class="w-100" required>
        <!-- <br><br>
        <select name="plan" required class="w-100 mb-4 plan">
            <option value="">Select Plan</option>
            <option value="0">Free</option>
            <option value="1">Paid</option>
        </select>
        <input type="number" name="inr" placeholder="In INR" disabled>
        <input type="number" name="usd" placeholder="In USD" disabled> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
        <button type="submit" class="btn btn-primary">Add Exam</button>
      </div>
      </form>
    </div>   
  </div>
</div>
<!--Edit Exam Modal-->
<div class="modal fade" id="editExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editExam">
      @csrf
      <div class="modal-body">
        <label for="subject">Subject</label>
        <input type="hidden" name="exam_id" id="exam_id">
        <input type="text" name="exam_name" id="exam_name" placeholder="Enter Exam name" class="w-100" required>
        <br><br>
        <select name="subject_id" id="subject_id" required class="w-100">
          <option value="">Select Subject</option>
          @if(count($subjects) > 0)
           @foreach($subjects as $subject)
            <option value="{{$subject->id}}">{{ $subject->subject}}</option>           
           @endforeach
          @endif          
        </select>
        <br><br>
        <input type="date" name="date" id="date" class="w-100" required min="@php echo date('Y-m-d') @endphp">
        <br><br>
        <input type="time" name="time" id="time" class="w-100" required>
        <br><br>
        <input type="number" min="1" id="attempt" name="attempt" placeholder="Enter Exam Attempt Time" class="w-100" required>
        <br><br>
        <input type="number" min="1" id="marks" name="marks" placeholder="Enter Exam Marks" class="w-100" required>
        <!-- <br><br>
        <select name="plan" id="plan" required class="w-100 mb-4 plan">
            <option value="">Select Plan</option>
            <option value="0">Free</option>
            <option value="1">Paid</option>
        </select>
        <input type="number" name="inr" id="inr" placeholder="In INR" disabled>
        <input type="number" name="usd" id="usd" placeholder="In USD" disabled> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>   
  </div>
</div>
<!--Delete Exam Modal-->
<div class="modal fade" id="deleteExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteExam">
      @csrf
      <div class="modal-body">
        <label for="subject">Subject</label>
        <input type="hidden" name="exam_id" id="deleteExamId">       
        <h4>Are you sure?</h4> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
      </form>
    </div>   
  </div>
</div>
<!--Add Answer Modal-->
<div class="modal fade" id="addQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addQna">
      @csrf
      <div class="modal-body">
        <input type="hidden" name="exam_id" id="addExamId">
        <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" placeholder="Search here">
        <br><br>     
        <table class="table" id="questionsTable"> 
          <thead>
             <th>Select</th>
             <th>Question</th>
          </thead>
          <tbody class="addBody">  
            
          </tbody>
        </table>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
        <button type="submit" class="btn btn-primary">Add Q&A</button>
      </div>
      </form>
    </div>   
  </div>
</div>
<!--See Questions Modal-->
<div class="modal fade" id="seeQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">   
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Questions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">           
        <table class="table"> 
          <thead> 
             <th>S.No</th>            
             <th>Question</th>
             <th>Delete</th>
          </thead>
          <tbody class="seeQuestionTable">  
            
          </tbody>
        </table>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>        
      </div>      
    </div>   
  </div>
</div>
<script>
  $(document).ready(function(){
      $("#addExam").submit(function(e){
         e.preventDefault();

         var formData = $(this).serialize();

         $.ajax({
           url:"{{ route('addExam')}}",
           type:"POST",
           data:formData,
           success:function(data){
            if (data.success == true) {
              location.reload();
            }
            else{
              alert(data.msg);
            }
           }
         });
      });

      $(".editButton").click(function(){
          var id = $(this).attr('data-id');
          $("#exam_id").val(id);
          
          var url = '{{ route("getExamDetail","id")}}';
          url = url.replace('id',id);  
          
          // $('#inr').val('');
          // $('#usd').val('');

          $.ajax({
             url:url,
             type:"Get",
             success:function(data){
              if (data.success == true) {
                var exam = data.data;
                $("#exam_name").val(exam[0].exam_name);
                $("#subject_id").val(exam[0].subject_id);
                $("#date").val(exam[0].date);
                $("#time").val(exam[0].time);
                $("#attempt").val(exam[0].attempt);
                $("#marks").val(exam[0].marks);


                // $('#plan').val(exam[0].plan);

                // if (exam[0].plan == 1) {
                //   let prices = JSON.parse(exam[0].prices);
                //   $('#inr').val(prices.INR);
                //   $('#usd').val(prices.USD);


                //   $('#inr').prop('disabled',false);
                //   $('#usd').prop('disabled',false);

                //   $('#inr').attr('required','required');
                //   $('#inr').attr('required','required');
                // }else{
                //   $('#inr').prop('disabled',true);
                //   $('#usd').prop('disabled',true);

                //   $('#inr').remoteAttr('required');
                //   $('#inr').remoteAttr('required');
                // }
              }else{
                alert(data.msg);
              }
             }
          });
      });
      
      $("#editExam").submit(function(e){
         e.preventDefault();

         var formData = $(this).serialize();

         $.ajax({
           url:"{{ route('updateExam')}}",
           type:"POST",
           data:formData,
           success:function(data){
            if (data.success == true) {
              location.reload();
            }
            else{
              alert(data.msg);
            }
           }
         });
      });

      //delete exam
      $(".deleteButton").click(function(){
         var id = $(this).attr('data-id');
         $("#deleteExamId").val(id);
      });

      $("#deleteExam").submit(function(e){
         e.preventDefault();

         var formData = $(this).serialize();

         $.ajax({
           url:"{{ route('deleteExam')}}",
           type:"POST",
           data:formData,
           success:function(data){
            if (data.success == true) {
              location.reload();
            }
            else{
              alert(data.msg);
            }
           }
         });
      });

      //add questions part

      $('.addQuestion').click(function(){
        var id = $(this).attr('data-id');
        $('#addExamId').val(id);

        $.ajax({
          url:" {{ route('getQuestions') }}",
          type:"get",
          data:{exam_id:id},
          success:function(data)
          {
            if (data.success == true) {

              var questions = data.data;
              var html = '';
              if (questions.length > 0) {
                  for (let i = 0; i < questions.length; i++) {
                     html+=`
                       <tr>
                          <td><input type="checkbox" value="`+questions[i]['id']+`" name="questions_ids[]"></td>
                          <td>`+questions[i]['questions']+`</td>
                       </tr>
                     `;
                  }
              }else{
                html +=`
                  <tr>
                    <td colspan="2">Questions not Available!<td>
                  </tr>
                `;
              }

              $('.addBody').html(html);
              
            }else{
              alert(data.msg);
            }
          }
        });
      });

      $("#addQna").submit(function(e){
         e.preventDefault();

         var formData = $(this).serialize();

         $.ajax({
           url:"{{ route('addQuestions')}}",
           type:"POST",
           data:formData,
           success:function(data){
            if (data.success == true) {
              location.reload();
            }
            else{
              alert(data.msg);
            }
           }
         });
      });

      //see questions
      $('.seeQuestions').click(function(){
        var id = $(this).attr('data-id');

        $.ajax({
           url:"{{route('getExamQuestions')}}",
           type:"Get",
           data:{exam_id:id},
           success:function(data){

            var html = '';
            var questions = data.data;
            if (questions.length > 0) {
               
               for(let i = 0; i < questions.length; i++){
                  html +=`
                    <tr>
                       <td>`+(i+1)+`</td>
                       <td>`+questions[i]['question'][0]['question']+`</td>
                       <td>
                          <button class="btn btn-danger deleteQuestion" data-id="`+questions[i]['id']+`">Delete</button>
                       </td>
                    </tr>   
                  `;
               }
            }else{
              html +=`
                <tr>
                   <td colspan="1">Questions not available!</td>
                <tr>
              `;
            }
            $('.seeQuestionTable').html(html);
           }
        });
      });

      //delete question
      $(document).on('click','.deleteQuestion',function(){
         var id = $(this).attr('data-id');
         var obj = $(this);
         $.ajax({
           url:"{{route('deleteExamQuestions')}}",
           type:"GET",
           data:{id:id},
           success:function(data)
           {
             if (data.success == true) {
              obj.parent().parent().remove();
            }
            else{
              alert(data.msg);
            }
           }
 
         });
      });

      // $('.plan').change(function(){
         
      //    var plan = $(this).val();
      //    if(plan == 1) {
      //      $(this).next().attr('required','required');
      //      $(this).next().next().attr('required','required');
      //      $(this).next().prop('disabled',false);
      //      $(this).next().next().prop('disabled',false);
      //    }
      //    else{
      //      $(this).next().removeAttr('required','required');
      //      $(this).next().next().removeAttr('required','required');
      //      $(this).next().prop('disabled',true);
      //      $(this).next().next().prop('disabled',true);
      //    }
      // });
  });

</script>
<script>
    function searchTable()
    {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById('search');
      filter = input.value.toUpperCase();
      table = document.getElementById('questionsTable');
      tr = table.getElementsByTagName("tr");
      for(i = 0; i < tr.length; i++){
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";            
          }else{
            tr[i].style.display = "none";
          }
        }
      }
    }
</script>
@endsection
