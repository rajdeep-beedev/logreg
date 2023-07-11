<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="position-absolute bottom-50 end-50">
        <div class="card bg-dark" style="width: 18rem;">
            <div class="card-body">
              @include('layout.flashmsg')
              <h5 class="card-title text-white">Resend Email verification</h5>
              <p class="card-text text-white">pls click on email verification send button. you will get email to register email, once you click that link your email is verified</p>
              <form action="{{route('verification.send')}}" method="POST">
                @csrf
                <input type="submit" class="btn btn-info" value="send verification">
              </form>
            </div>
          </div>

    </div>
        {{-- </div>
    </div> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>