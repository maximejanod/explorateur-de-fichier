
/**** **** **** **** **** **** **** ****
  > POST
**** **** **** **** **** **** **** ****/

const post = (data, cb) => { //console.log(data)

  const xhr = new XMLHttpRequest()

  xhr.open('post', 'php/ajax.php')

  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

  xhr.send(`data=${JSON.stringify(data)}`)

  xhr.onreadystatechange = () => { //console.log(xhr)

    if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
      cb(data.exercise, xhr.responseText)

  }

}

/**** **** **** **** **** **** **** ****
  > INIT
**** **** **** **** **** **** **** ****/

const init = function() {



}()
