<script>	
	function ChangePlace()	
	{		
		if(document.getElementById('Place').selectedIndex != 0)		
		{			
			var PlaceID = getPlace();			
			//document.cookie="PlaceNum="+PlaceID;			
			setCookie("PlaceNum",PlaceID,null);			
			//alert(Lori);			
			//location.href = 'index.php?PlaceNum='+PlaceID;			
			FreshTable();		
		}	
	}	
	function FreshTable()	
	{		
		$.ajax(
		{			
			url : "getServeList.php",			
			type : "POST",			
			data : {"PlaceID" : getCookie("PlaceNum")},			
			success: function(returnd, textStatus, jqXHR)			
			{				
				//alert(returnd);				
				document.getElementById('ServeTable').innerHTML = returnd;				
				window.scrollTo(0,document.body.scrollHeight);			
			},		
			error: function (jqXHR, textStatus, errorThrown)			
			{				
				//console.log(data);				
				alert(textStatus);			
			}		
		});	
	}	
	function setCookie(cname, cvalue, exdays) 
	{			
		if(exdays!=null)		
		{		    
			var d = new Date();		    
			d.setTime(d.getTime() + (exdays*24*60*60*1000));		    
			var expires = "expires="+d.toUTCString();		    
			document.cookie = cname + "=" + cvalue + "; " + expires;	    
		}	    
		else	    
		{		    
			document.cookie = cname + "=" + cvalue;	    
		}	
	}	
	function getCookie(cname) 
	{	    
		var name = cname + "=";	    
		var ca = document.cookie.split(';');	    
		for(var i=0; i<ca.length; i++) 
		{	        
			var c = ca[i];	        
			while (c.charAt(0)==' ') 
				c = c.substring(1);	        
			if (c.indexOf(name) == 0) 
				return c.substring(name.length,c.length);	    
		}	    
		return "";	
	}	
	function ChangeType()	
	{		
		if(document.getElementById('MenuType').selectedIndex != 0)		
		{			
			var MenuID = getMenuType();			
			document.cookie="Type="+MenuID;			
			setCookie("Type",MenuID,null);			
			//alert(Lori);			
			//location.href = 'index.php?PlaceNum='+PlaceID+'&Type='+MenuID;		
		}	
	}	
	function getPlace()	
	{		
		var e = document.getElementById("Place");		
		var PlaceID = e.options[e.selectedIndex].value;		
		return PlaceID;	
	}	
	function getMenuType()	
	{		
		var e = document.getElementById("MenuType");		
		var MenuTypeID = e.options[e.selectedIndex].value;		
		return MenuTypeID;	
	}	
	function getPlaceText()	
	{		
		var e = document.getElementById("Place");		
		var PlaceText = document.getElementById('Place').options[document.getElementById('Place').selectedIndex].text;		
		return PlaceText;	
	}	
	function getPlces()	
	{		
		$.ajax({			
			url : "getPlace.php",			
			type : "POST",			
			//data : data,			
			success: function(returnd, textStatus, jqXHR)			
			{				
				var Convert = JSON.parse(returnd);				
				//console.log(Convert);				
				$("#Place").html("");				
				if(Convert.length>0)				
				{					
					$("#Place").append("<option></option>");					
					var PlaceCookies = getCookie("PlaceNum");					
					for(i=0;i<Convert.length;i++)					
					{						
						var DataInside = Convert[i];						
						//console.log(DataInside);						
						if(getCookie("PlaceNum") == DataInside['PlaceID'])						
						{							
							$("#Place").append("<option value='"+DataInside['PlaceID']+"' selected>"+DataInside['PlaceName']+"</option>");						
						}						
						else						
						{							
							$("#Place").append("<option value='"+DataInside['PlaceID']+"'>"+DataInside['PlaceName']+"</option>");						
						}					
					}				
				}				
				else				
				{					
					alert("error");				
				}				
				//alert(data);			
			},			
			error: function (jqXHR, textStatus, errorThrown)			
			{				
				//console.log(data);				
				alert(textStatus);			
			}
		});	
	}	
	function getType()	
	{		
		$.ajax({			
			url : "getType.php",			
			type : "POST",			
			//data : data,			
			success: function(returnd, textStatus, jqXHR)			
			{				
				var Convert = JSON.parse(returnd);				
				//console.log(Convert);				
				$("#MenuType").html("");				
				if(Convert.length>0)				
				{					
					$("#MenuType").append("<option></option>");					
					for(i=0;i<Convert.length;i++)					
					{						
						var DataInside = Convert[i];						
						//console.log(DataInside);						
						if(getCookie("Type") == DataInside['MenuTypeID'])						
						{							
							$("#MenuType").append("<option value='"+DataInside['MenuTypeID']+"' selected>"+DataInside['TypeTitle']+"</option>");						
						}						
						else						
						{							
							$("#MenuType").append("<option value='"+DataInside['MenuTypeID']+"'>"+DataInside['TypeTitle']+"</option>");					
						}					
					}				
				}				
				else				
				{					
					alert("error");				
				}				
				//alert(data);			
			},			
			error: function (jqXHR, textStatus, errorThrown)		
			{				
				//console.log(data);				
				alert(textStatus);			
			}		
		});	
	}	
	function ListName()	
	{		
		var input = document.getElementById("MenuName").value;		
		if(input == "")		
		{			
			$("#SuggestList").html("");		
		}		
		else		
		{			
			var data = {};			
			data.Input = document.getElementById("MenuName").value;			
			$.ajax({				
				url : "SuggestList.php",				
				type : "POST",				
				data : data,				
				success: function(data, textStatus, jqXHR)				
				{					
					var Convert = JSON.parse(data);					
					//console.log(Convert);					
					$("#SuggestList").html("");					
					if(Convert.length>0)					
					{						
						for(i=0;i<Convert.length;i++)						
						{							
							var value = Convert[i];							
							$("#SuggestList").append("<li><a onclick='ChangeText(this.text)'>"+value+"</li>");							
							window.scrollTo(0, 0);						
						}					
					}					
					else if(Convert.length<1)					
					{						
						FreshTable();					
					}					
					//alert(data);				
				},				
				error: function (jqXHR, textStatus, errorThrown)				
				{					
					//console.log(data);					
					alert(textStatus);				
				}			
			});		
		}	
	}
	function ChangeText(TextToChange)	
	{		
		document.getElementById("MenuName").value = TextToChange;		
		$("#SuggestList").html("");
		document.getElementById("session").focus();	
	}	
	function AddMenu()	
	{		
		var MenuTitle = document.getElementById("MenuName").value;		
		var Price = document.getElementById("Price").value;		
		var Place = getPlace();		
		var MenuType = getMenuType();		
		var Session = 0;		
		//alert("MenuType"+MenuType);
		if(document.getElementById("session").checked)		
		{			
			Session = 1;		
		}		
		if(MenuTitle == "" || Price == "" || Place == "" || MenuType == "")		
		{			
			alert("Required fill empty found.");			
			if(MenuTitle == "")			
			{				
				document.getElementById("MenuName").style.backgroundColor = "red";				
				document.getElementById("MenuName").style.color = "white";			
			}			
			if(Price == "")			
			{				
				document.getElementById("Price").style.backgroundColor = "red";				
				document.getElementById("Price").style.color = "white";			
			}			
			if(document.getElementById("Place").selectedIndex == 0)			
			{				
				document.getElementById("Place").style.backgroundColor = "red";				
				document.getElementById("Place").style.color = "white";			
			}			
			if(document.getElementById("MenuType").selectedIndex == 0)			
			{			
				document.getElementById("MenuType").style.backgroundColor = "red";				
				document.getElementById("MenuType").style.color = "white";			
			}		
		}		
		else		
		{			
			var r=confirm("Menu Title : "+MenuTitle+"\nPrice : "+Price+"\nPlace : "+getPlaceText()+"?");			
			if(r==true)			
			{				
				$.ajax({					
					url : "addMenuAndServe.php",					
					type : "POST",					
					data : {"PlaceID" : getPlace() , "MenuTitle" : MenuTitle , "Price" : Price, "Type" : getMenuType() , "Session" : Session},					
					success: function(data, textStatus, jqXHR)					
					{						
						//alert(data);						
						FreshTable();
						document.getElementById("MenuName").value="";
						document.getElementById("Price").value="";
						document.getElementById("session").checked = false;
						document.getElementById("MenuName").focus();					
					},					
					error: function (jqXHR, textStatus, errorThrown)					
					{						
						//console.log(data);						
						console.log(jqXHR);					
					}				
				});			
			}	
		}	
	}
</script>
<html>	
	<head>		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="../images/Logo.png" type="image/png">		
		<title>Register</title>		
		<style type="text/css">			
			ul
			{				
				list-style-type: none;			
			}			
			li
			{				
				cursor:pointer;			
			}
			input
			{
				background-color:black;
				color:white;
			}		
		</style>	
	</head>	
	<body style="background-color:black;color:white">		
		<div style="position:fixed;top:0;left:0;background-color:black;width:100%;padding:5">			
			<div class="styled-select">
				Place : <select name="Place" id="Place" onchange="ChangePlace();"></select>			
				Type : 	<select name = "MenuType" id="MenuType" onchange="ChangeType()"></select>
			</div>			
			<hr>			
			Menu Name : <input type=text id="MenuName" onkeyup="ListName();">			
			Session Meal? : <input type="checkbox" name="session" id="session">			
			Price : <input type=text id = "Price" onkeydown="if (event.keyCode == 13) document.getElementById('AddMenu').click()">			
			<input type="button" id="AddMenu" value="Add Menu" onclick="AddMenu();">
			<hr>		
		</div>		
		<br><br><br><br>		
		<div style="overflow:auto">			
			<ul id="SuggestList" name="SuggestList"></ul>		
		</div>		
		<span id="ServeTable"></span>		
		<script type="text/javascript">			
			document.getElementById("MenuName").focus();			
			$( document ).ready(function() 
				{			    
					getPlces();			    
					getType();			    
					FreshTable();			
				}
			);		
		</script>	
	</body>
</html>