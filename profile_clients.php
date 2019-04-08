<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="home_clients.php">
      <img src="res/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Project
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="home_clients.php"><i class="fas fa-home"></i>Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="profile_clients.php"><i class="fas fa-user"></i>Profile<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders_clients.php"><i class="fas fa-book"></i>Orders</a>
        </li>
      </ul>
    </div>
  </nav>

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
      <a class="nav-item nav-link" id="nav-allergene-tab" data-toggle="tab" href="#nav-allergene" role="tab" aria-controls="nav-profile" aria-selected="false">Allergenes</a>
      <a class="nav-item nav-link" id="nav-address-tab" data-toggle="tab" href="#nav-address" role="tab" aria-controls="nav-profile" aria-selected="false">Addresses</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
    </div>
    <div class="tab-pane fade" id="nav-allergene" role="tabpanel" aria-labelledby="nav-allergene-tab">
      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Allergene</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Example allergene 1</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Example allergene 2</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Example allergene 3</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">4</th>
              <form>
                <td>
                  <label for="selectAllergene">Example select allergene</label>
                  <select class="form-control" id="selectAllergene">
                    <option>Allergene 1</option>
                    <option>Allergene 2</option>
                    <option>Allergene 3</option>
                    <option>Allergene 4</option>
                    <option>Allergene 5</option>
                  </select>
                </td>
                <td>
                  <button type="button" class="btn btn-primary">
                    Add
                  </button>
                </td>
              </form>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Address</th>
              <th scope="col">Additional info</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Example address 1</td>
              <td>Example info 1</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Example address 2</td>
              <td>Example info 2</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Example address 3</td>
              <td>Example info 3</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">4</th>
              <form>
                <td>
                  <input type="text" class="form-control" placeholder="Address">
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Additional info">
                </td>
                <td>
                  <button type="button" class="btn btn-primary">
                    Add
                  </button>
                </td>
              </form>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>



  <footer class="footer">
    <p class="text-muted">Dummy Copyrights</p>
  </footer>
</body>

</html>
