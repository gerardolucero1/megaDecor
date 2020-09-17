
<section class="row">
    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('name', 'nombre') }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}  
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('testimonial', 'Testimonio') }}
                    {{ Form::text('testimonial', null, ['class' => 'form-control', 'id' => 'testimonial']) }}  
                </div>
            </div>
        </div>


    </div>
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-material">
                    {{ Form::label('imagen', 'Imagen') }}
                    {{ Form::file('imagen', ['class' => 'form-control']) }} 
                </div>
            </div>
        </div>
       
    </div>
    
        @if(strpos($_SERVER['REQUEST_URI'], 'edit'))
        @else
    <div class="col-md-8">
       
        
    </div>
@endif
    <div class="row">
        <div class="col-md-12" style="padding: 10px">
            <button type="submit" class="btn btn-sm btn-info" style="margin-left: 10px">Guardar</button>
        </div>
        
    </div>
   
</section>
<script>

</script>