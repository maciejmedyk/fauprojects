var rand = 0;
var temp = 0;
var verf = 0;
var arr = [];

for(var i=0; i < 12; i++)
{
temp += Math.random();
temp += Math.round(temp);
arr[i]=temp*132;
}
for(var k=0; k < 12; k++)
{
arr[k] = Math.round(arr[k]);
arr[k] = arr[k] % 6 + arr[k] % 3;
rand += " ";
rand += arr[k] + "";
verf += arr[k] + "";
}
console.log(rand);
console.log(verf);
document.getElementById("rand").value = verf;

