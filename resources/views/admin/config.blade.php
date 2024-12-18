@extends('layout.admin')

@section('title')Configuraciones | CodeTechEvolution @stop

@section('styles')
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Inicio @stop
@section('bred2')Configuraciones @stop

@section('contenido')
<div class="card border-top-secondary border-top-3 mb-4">
    <div class="card-header d-flex align-items-center">
      <i class="fa-duotone fa-gears" style="font-size: 1.2rem;"></i>
      <strong class="ms-2">Configuraciones</strong>
    </div>
    <div class="card-body">
      <div class="tab-content rounded-bottom">
        @if ($errors->all())
          <div class="alert alert-danger" role="alert">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
          {{ html()->form('POST', '/admin/configuration/')->attributes(['autocomplete' => 'off','class'=>'row g-3'])->open() }}
            <div class="card mb-4">
              <div class="card-body">
                <h3>General</h3><hr/>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label for="area" class="form-label">Zona Horaria - Área:</label>
                    <select class="form-select" aria-label="Selector de area" name="area" id="area" onchange="cambiarArea()">
                      <option selected>Seleccione un área</option>
                      @php
                        $area = explode('/',$configs['APP_TIMEZONE'])[0];
                      @endphp
                      <option value="Africa" @if ($area=='Africa')selected @endif>África</option>
                      <option value="America" @if ($area=='America')selected @endif>América</option>
                      <option value="Antarctica" @if ($area=='Antarctica')selected @endif>Antártida</option>
                      <option value="Artic" @if ($area=='Artic')selected @endif>Ártico</option>
                      <option value="Asia" @if ($area=='Asia')selected @endif>Asia</option>
                      <option value="Atlantic" @if ($area=='Atlantic')selected @endif>Atlántico</option>
                      <option value="Australia" @if ($area=='Australia')selected @endif>Australia</option>
                      <option value="Europe" @if ($area=='Europe')selected @endif>Europa</option>
                      <option value="Indian" @if ($area=='Indian')selected @endif>India</option>
                      <option value="Pacific" @if ($area=='Pacific')selected @endif>Pacífico</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="zona" class="form-label">Zona Horaria:</label>
                    <select class="form-select" aria-label="Selector de zona" name="zona" id="zona">
                      <option selected>Seleccione una zona</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="locale" class="form-label">Idioma:</label>
                    <select class="form-select" aria-label="Selector de area" name="locale" id="locale">
                      <option selected>Seleccione un idioma</option>
                      <option value="en" @if ($configs['APP_LOCALE']=='en')selected @endif>Ingles</option>
                      <option value="es" @if ($configs['APP_LOCALE']=='es')selected @endif>Español</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-body">
                <h3>Mail</h3><hr/>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label for="mhost" class="form-label">Host:</label>
                    <input type="text" class="form-control" name="mhost" id="mhost" placeholder="Ingrese el host del servicio" value="{{ $configs['MAIL_HOST'] }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="mport" class="form-label">Puerto:</label>
                    <input type="text" class="form-control" name="mport" id="mport" placeholder="Ingrese el puerto del servicio" value="{{ $configs['MAIL_PORT'] }}">
                  </div>
                  <div class="col-md-6">
                    <label for="musername" class="form-label">Correo:</label>
                    <input type="text" class="form-control" name="musername" id="musername" placeholder="Ingrese el correo de la cuenta" value="{{ $configs['MAIL_USERNAME'] }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="mpassword">Contraseña:</label>
                    <div class="input-group">
                      <input class="form-control in-pass-s" name="mpassword" id="mpassword" type="password" placeholder="Ingrese la contraseña de la cuenta" value="{{ $configs['MAIL_PASSWORD'] }}">
                      <button class="btn btn-outline-secondary btn-pass-s" type="button" id="showpass">
                        <i class="fa-duotone fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-body">
                <h3>Imap</h3><hr/>
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <label for="ihost" class="form-label">Host:</label>
                    <input type="text" class="form-control" name="ihost" id="ihost" placeholder="Ingrese el host del servicio" value="{{ $configs['IMAP_HOST'] }}">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="iport" class="form-label">Puerto:</label>
                    <input type="text" class="form-control" name="iport" id="iport" placeholder="Ingrese el puerto del servicio" value="{{ $configs['IMAP_PORT'] }}">
                  </div>
                  <div class="col-md-6">
                    <label for="iusername" class="form-label">Correo:</label>
                    <input type="text" class="form-control" name="iusername" id="iusername" placeholder="Ingrese el correo de la cuenta" value="{{ $configs['IMAP_USERNAME'] }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="ipassword">Contraseña:</label>
                    <div class="input-group">
                      <input class="form-control in-pass-s" name="ipassword" id="ipassword" type="password" placeholder="Ingrese la contraseña de la cuenta" value="{{ $configs['IMAP_PASSWORD'] }}">
                      <button class="btn btn-outline-secondary btn-pass-s" type="button" id="showpassi">
                        <i class="fa-duotone fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-body">
                <h3>Oauth Google</h3><hr/>
                <div class="row">
                  <div class="col-md-6">
                    <label for="clientID" class="form-label">Id del cliente:</label>
                    <input type="text" class="form-control" name="clientID" id="clientID" placeholder="Ingrese el Id del Cliente" value="{{ $configs['GOOGLE_CLIENT_ID'] }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="secret">Secreto del Cliente:</label>
                    <div class="input-group">
                      <input class="form-control in-pass-s" name="secret" id="secret" type="password" placeholder="Ingrese el Secreto del Cliente" value="{{ $configs['GOOGLE_CLIENT_SECRET'] }}">
                      <button class="btn btn-outline-secondary btn-pass-s" type="button" id="showsecret">
                        <i class="fa-duotone fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-4">
              <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" >Cancelar</a>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          {{ html()->form()->close() }}
        </div>
      </div>
    </div>
  </div>
@stop

@section('scripts')
<script>
  var datos = {
    africa : [
      {value:"Africa/Abidjan", text:"Africa/Abidjan"},  
      {value:"Africa/Accra", text:"Africa/Accra"},    
      {value:"Africa/Addis_Ababa", text:"Africa/Addis_Ababa"},
      {value:"Africa/Algiers", text:"Africa/Algiers"},  
      {value:"Africa/Asmara", text:"Africa/Asmara"},
      {value:"Africa/Bamako", text:"Africa/Bamako"},  
      {value:"Africa/Bangui", text:"Africa/Bangui"},   
      {value:"Africa/Banjul", text:"Africa/Banjul"},   
      {value:"Africa/Bissau", text:"Africa/Bissau"},   
      {value:"Africa/Blantyre", text:"Africa/Blantyre"},
      {value:"Africa/Brazzaville", text:"Africa/Brazzaville"},
      {value:"Africa/Bujumbura", text:"Africa/Bujumbura"},
      {value:"Africa/Cairo", text:"Africa/Cairo"},    
      {value:"Africa/Casablanca", text:"Africa/Casablanca"},
      {value:"Africa/Ceuta", text:"Africa/Ceuta"},    
      {value:"Africa/Conakry", text:"Africa/Conakry"},  
      {value:"Africa/Dakar", text:"Africa/Dakar"},    
      {value:"Africa/Dar_es_Salaam", text:"Africa/Dar_es_Salaam"},
      {value:"Africa/Djibouti", text:"Africa/Djibouti"}, 
      {value:"Africa/Douala", text:"Africa/Douala"},   
      {value:"Africa/El_Aaiun", text:"Africa/El_Aaiun"}, 
      {value:"Africa/Freetown", text:"Africa/Freetown"},
      {value:"Africa/Gaborone", text:"Africa/Gaborone"}, 
      {value:"Africa/Harare", text:"Africa/Harare"},
      {value:"Africa/Johannesburg", text:"Africa/Johannesburg"},
      {value:"Africa/Juba", text:"Africa/Juba"},
      {value:"Africa/Kampala", text:"Africa/Kampala"},  
      {value:"Africa/Khartoum", text:"Africa/Khartoum"}, 
      {value:"Africa/Kigali", text:"Africa/Kigali"},   
      {value:"Africa/Kinshasa", text:"Africa/Kinshasa"}, 
      {value:"Africa/Lagos", text:"Africa/Lagos"},    
      {value:"Africa/Libreville", text:"Africa/Libreville"},
      {value:"Africa/Lome", text:"Africa/Lome"},
      {value:"Africa/Luanda", text:"Africa/Luanda"},   
      {value:"Africa/Lubumbashi", text:"Africa/Lubumbashi"},
      {value:"Africa/Lusaka", text:"Africa/Lusaka"},   
      {value:"Africa/Malabo", text:"Africa/Malabo"},
      {value:"Africa/Maputo", text:"Africa/Maputo"},   
      {value:"Africa/Maseru", text:"Africa/Maseru"},   
      {value:"Africa/Mbabane", text:"Africa/Mbabane"},  
      {value:"Africa/Mogadishu", text:"Africa/Mogadishu"},
      {value:"Africa/Monrovia", text:"Africa/Monrovia"}, 
      {value:"Africa/Nairobi", text:"Africa/Nairobi"},  
      {value:"Africa/Ndjamena", text:"Africa/Ndjamena"}, 
      {value:"Africa/Niamey", text:"Africa/Niamey"},   
      {value:"Africa/Nouakchott", text:"Africa/Nouakchott"},
      {value:"Africa/Ouagadougou", text:"Africa/Ouagadougou"},
      {value:"Africa/Porto-Novo", text:"Africa/Porto-Novo"},
      {value:"Africa/Sao_Tome", text:"Africa/Sao_Tome"}, 
      {value:"Africa/Tripoli", text:"Africa/Tripoli"},  
      {value:"Africa/Tunis", text:"Africa/Tunis"},    
      {value:"Africa/Windhoek", text:"Africa/Windhoek"}, 
    ],
    america : [
      {value:"America/Adak",text:"America/Adak"},
      {value:"America/Anchorage",text:"America/Anchorage"},
      {value:"America/Anguilla",text:"America/Anguilla"},
      {value:"America/Antigua",text:"America/Antigua"},
      {value:"America/Araguaina",text:"America/Araguaina"},
      {value:"America/Argentina/Buenos_Aires",text:"America/Argentina/Buenos_Aires"},
      {value:"America/Argentina/Catamarca",text:"America/Argentina/Catamarca"},
      {value:"America/Argentina/Cordoba",text:"America/Argentina/Cordoba"},
      {value:"America/Argentina/Jujuy",text:"America/Argentina/Jujuy"},
      {value:"America/Argentina/La_Rioja",text:"America/Argentina/La_Rioja"},
      {value:"America/Argentina/Mendoza",text:"America/Argentina/Mendoza"},
      {value:"America/Argentina/Rio_Gallegos",text:"America/Argentina/Rio_Gallegos"},
      {value:"America/Argentina/Salta",text:"America/Argentina/Salta"},
      {value:"America/Argentina/San_Juan",text:"America/Argentina/San_Juan"},
      {value:"America/Argentina/San_Luis",text:"America/Argentina/San_Luis"},
      {value:"America/Argentina/Tucuman",text:"America/Argentina/Tucuman"},
      {value:"America/Argentina/Ushuaia",text:"America/Argentina/Ushuaia"},
      {value:"America/Aruba",text:"America/Aruba"},
      {value:"America/Asuncion",text:"America/Asuncion"},
      {value:"America/Atikokan",text:"America/Atikokan"},
      {value:"America/Bahia",text:"America/Bahia"},
      {value:"America/Bahia_Banderas",text:"America/Bahia_Banderas"},
      {value:"America/Barbados",text:"America/Barbados"},
      {value:"America/Belem",text:"America/Belem"},
      {value:"America/Belize",text:"America/Belize"},
      {value:"America/Blanc-Sablon",text:"America/Blanc-Sablon"},
      {value:"America/Boa_Vista",text:"America/Boa_Vista"},
      {value:"America/Bogota",text:"America/Bogota"},
      {value:"America/Boise",text:"America/Boise"},
      {value:"America/Cambridge_Bay",text:"America/Cambridge_Bay"},
      {value:"America/Campo_Grande",text:"America/Campo_Grande"},
      {value:"America/Cancun",text:"America/Cancun"},
      {value:"America/Caracas",text:"America/Caracas"},
      {value:"America/Cayenne",text:"America/Cayenne"},
      {value:"America/Cayman",text:"America/Cayman"},
      {value:"America/Chicago",text:"America/Chicago"},
      {value:"America/Chihuahua",text:"America/Chihuahua"},
      {value:"America/Ciudad_Juarez",text:"America/Ciudad_Juarez"},
      {value:"America/Costa_Rica",text:"America/Costa_Rica"},
      {value:"America/Creston",text:"America/Creston"},
      {value:"America/Cuiaba",text:"America/Cuiaba"},
      {value:"America/Curacao",text:"America/Curacao"},
      {value:"America/Danmarkshavn",text:"America/Danmarkshavn"},
      {value:"America/Dawson",text:"America/Dawson"},
      {value:"America/Dawson_Creek",text:"America/Dawson_Creek"},
      {value:"America/Denver",text:"America/Denver"},
      {value:"America/Detroit",text:"America/Detroit"},
      {value:"America/Dominica",text:"America/Dominica"},
      {value:"America/Edmonton",text:"America/Edmonton"},
      {value:"America/Eirunepe",text:"America/Eirunepe"},
      {value:"America/El_Salvador",text:"America/El_Salvador"},
      {value:"America/Fort_Nelson",text:"America/Fort_Nelson"},
      {value:"America/Fortaleza",text:"America/Fortaleza"},
      {value:"America/Glace_Bay",text:"America/Glace_Bay"},
      {value:"America/Goose_Bay",text:"America/Goose_Bay"},
      {value:"America/Grand_Turk",text:"America/Grand_Turk"},
      {value:"America/Grenada",text:"America/Grenada"},
      {value:"America/Guadeloupe",text:"America/Guadeloupe"},
      {value:"America/Guatemala",text:"America/Guatemala"},
      {value:"America/Guayaquil",text:"America/Guayaquil"},
      {value:"America/Guyana",text:"America/Guyana"},
      {value:"America/Halifax",text:"America/Halifax"},
      {value:"America/Havana",text:"America/Havana"},
      {value:"America/Hermosillo",text:"America/Hermosillo"},
      {value:"America/Indiana/Indianapolis",text:"America/Indiana/Indianapolis"},
      {value:"America/Indiana/Knox",text:"America/Indiana/Knox"},
      {value:"America/Indiana/Marengo",text:"America/Indiana/Marengo"},
      {value:"America/Indiana/Petersburg",text:"America/Indiana/Petersburg"},
      {value:"America/Indiana/Tell_City",text:"America/Indiana/Tell_City"},
      {value:"America/Indiana/Vevay",text:"America/Indiana/Vevay"},
      {value:"America/Indiana/Vincennes",text:"America/Indiana/Vincennes"},
      {value:"America/Indiana/Winamac",text:"America/Indiana/Winamac"},
      {value:"America/Inuvik",text:"America/Inuvik"},
      {value:"America/Iqaluit",text:"America/Iqaluit"},
      {value:"America/Jamaica",text:"America/Jamaica"},
      {value:"America/Juneau",text:"America/Juneau"},
      {value:"America/Kentucky/Louisville",text:"America/Kentucky/Louisville"},
      {value:"America/Kentucky/Monticello",text:"America/Kentucky/Monticello"},
      {value:"America/Kralendijk",text:"America/Kralendijk"},
      {value:"America/La_Paz",text:"America/La_Paz"},
      {value:"America/Lima",text:"America/Lima"},
      {value:"America/Los_Angeles",text:"America/Los_Angeles"},
      {value:"America/Lower_Princes",text:"America/Lower_Princes"},
      {value:"America/Maceio",text:"America/Maceio"},
      {value:"America/Managua",text:"America/Managua"},
      {value:"America/Manaus",text:"America/Manaus"},
      {value:"America/Marigot",text:"America/Marigot"},
      {value:"America/Martinique",text:"America/Martinique"},
      {value:"America/Matamoros",text:"America/Matamoros"},
      {value:"America/Mazatlan",text:"America/Mazatlan"},
      {value:"America/Menominee",text:"America/Menominee"},
      {value:"America/Merida",text:"America/Merida"},
      {value:"America/Metlakatla",text:"America/Metlakatla"},
      {value:"America/Mexico_City",text:"America/Mexico_City"},
      {value:"America/Miquelon",text:"America/Miquelon"},
      {value:"America/Moncton",text:"America/Moncton"},
      {value:"America/Monterrey",text:"America/Monterrey"},
      {value:"America/Montevideo",text:"America/Montevideo"},
      {value:"America/Montserrat",text:"America/Montserrat"},
      {value:"America/Nassau",text:"America/Nassau"},
      {value:"America/New_York",text:"America/New_York"},
      {value:"America/Nome",text:"America/Nome"},
      {value:"America/Noronha",text:"America/Noronha"},
      {value:"America/North_Dakota/Beulah",text:"America/North_Dakota/Beulah"},
      {value:"America/North_Dakota/Center",text:"America/North_Dakota/Center"},
      {value:"America/North_Dakota/New_Salem",text:"America/North_Dakota/New_Salem"},
      {value:"America/Nuuk",text:"America/Nuuk"},
      {value:"America/Ojinaga",text:"America/Ojinaga"},
      {value:"America/Panama",text:"America/Panama"},
      {value:"America/Paramaribo",text:"America/Paramaribo"},
      {value:"America/Phoenix",text:"America/Phoenix"},
      {value:"America/Port-au-Prince",text:"America/Port-au-Prince"},
      {value:"America/Port_of_Spain",text:"America/Port_of_Spain"},
      {value:"America/Porto_Velho",text:"America/Porto_Velho"},
      {value:"America/Puerto_Rico",text:"America/Puerto_Rico"},
      {value:"America/Punta_Arenas",text:"America/Punta_Arenas"},
      {value:"America/Rankin_Inlet",text:"America/Rankin_Inlet"},
      {value:"America/Recife",text:"America/Recife"},
      {value:"America/Regina",text:"America/Regina"},
      {value:"America/Resolute",text:"America/Resolute"},
      {value:"America/Rio_Branco",text:"America/Rio_Branco"},
      {value:"America/Santarem",text:"America/Santarem"},
      {value:"America/Santiago",text:"America/Santiago"},
      {value:"America/Santo_Domingo",text:"America/Santo_Domingo"},
      {value:"America/Sao_Paulo",text:"America/Sao_Paulo"},
      {value:"America/Scoresbysund",text:"America/Scoresbysund"},
      {value:"America/Sitka",text:"America/Sitka"},
      {value:"America/St_Barthelemy",text:"America/St_Barthelemy"},
      {value:"America/St_Johns",text:"America/St_Johns"},
      {value:"America/St_Kitts",text:"America/St_Kitts"},
      {value:"America/St_Lucia",text:"America/St_Lucia"},
      {value:"America/St_Thomas",text:"America/St_Thomas"},
      {value:"America/St_Vincent",text:"America/St_Vincent"},
      {value:"America/Swift_Current",text:"America/Swift_Current"},
      {value:"America/Tegucigalpa",text:"America/Tegucigalpa"},
      {value:"America/Thule",text:"America/Thule"},
      {value:"America/Tijuana",text:"America/Tijuana"},
      {value:"America/Toronto",text:"America/Toronto"},
      {value:"America/Tortola",text:"America/Tortola"},
      {value:"America/Vancouver",text:"America/Vancouver"},
      {value:"America/Whitehorse",text:"America/Whitehorse"},
      {value:"America/Winnipeg",text:"America/Winnipeg"},
      {value:"America/Yakutat",text:"America/Yakutat"},                                    
    ],
    antarctica : [
      {value:"Antarctica/Casey", text:"Antarctica/Casey"},
      {value:"Antarctica/Davis", text:"Antarctica/Davis"},
      {value:"Antarctica/DumontDUrville", text:"Antarctica/DumontDUrville"},
      {value:"Antarctica/Macquarie", text:"Antarctica/Macquarie"},
      {value:"Antarctica/Mawson", text:"Antarctica/Mawson"},
      {value:"Antarctica/McMurdo", text:"Antarctica/McMurdo"},
      {value:"Antarctica/Palmer", text:"Antarctica/Palmer"},
      {value:"Antarctica/Rothera", text:"Antarctica/Rothera"},
      {value:"Antarctica/Syowa", text:"Antarctica/Syowa"},
      {value:"Antarctica/Troll", text:"Antarctica/Troll"},
      {value:"Antarctica/Vostok", text:"Antarctica/Vostok"},
    ],
    artic : [
      {value:"Arctic/Longyearbyen", text:"Arctic/Longyearbyen"},
    ],
    asia : [
      {value:"Asia/Aden",text:"Asia/Aden"},
      {value:"Asia/Almaty",text:"Asia/Almaty"},
      {value:"Asia/Amman",text:"Asia/Amman"},
      {value:"Asia/Anadyr",text:"Asia/Anadyr"},
      {value:"Asia/Aqtau",text:"Asia/Aqtau"},
      {value:"Asia/Aqtobe",text:"Asia/Aqtobe"},
      {value:"Asia/Ashgabat",text:"Asia/Ashgabat"},
      {value:"Asia/Atyrau",text:"Asia/Atyrau"},
      {value:"Asia/Baghdad",text:"Asia/Baghdad"},
      {value:"Asia/Bahrain",text:"Asia/Bahrain"},
      {value:"Asia/Baku",text:"Asia/Baku"},
      {value:"Asia/Bangkok",text:"Asia/Bangkok"},
      {value:"Asia/Barnaul",text:"Asia/Barnaul"},
      {value:"Asia/Beirut",text:"Asia/Beirut"},
      {value:"Asia/Bishkek",text:"Asia/Bishkek"},
      {value:"Asia/Brunei",text:"Asia/Brunei"},
      {value:"Asia/Chita",text:"Asia/Chita"},
      {value:"Asia/Choibalsan",text:"Asia/Choibalsan"},
      {value:"Asia/Colombo",text:"Asia/Colombo"},
      {value:"Asia/Damascus",text:"Asia/Damascus"},
      {value:"Asia/Dhaka",text:"Asia/Dhaka"},
      {value:"Asia/Dili",text:"Asia/Dili"},
      {value:"Asia/Dubai",text:"Asia/Dubai"},
      {value:"Asia/Dushanbe",text:"Asia/Dushanbe"},
      {value:"Asia/Famagusta",text:"Asia/Famagusta"},
      {value:"Asia/Gaza",text:"Asia/Gaza"},
      {value:"Asia/Hebron",text:"Asia/Hebron"},
      {value:"Asia/Ho_Chi_Minh",text:"Asia/Ho_Chi_Minh"},
      {value:"Asia/Hong_Kong",text:"Asia/Hong_Kong"},
      {value:"Asia/Hovd",text:"Asia/Hovd"},
      {value:"Asia/Irkutsk",text:"Asia/Irkutsk"},
      {value:"Asia/Jakarta",text:"Asia/Jakarta"},
      {value:"Asia/Jayapura",text:"Asia/Jayapura"},
      {value:"Asia/Jerusalem",text:"Asia/Jerusalem"},
      {value:"Asia/Kabul",text:"Asia/Kabul"},
      {value:"Asia/Kamchatka",text:"Asia/Kamchatka"},
      {value:"Asia/Karachi",text:"Asia/Karachi"},
      {value:"Asia/Kathmandu",text:"Asia/Kathmandu"},
      {value:"Asia/Khandyga",text:"Asia/Khandyga"},
      {value:"Asia/Kolkata",text:"Asia/Kolkata"},
      {value:"Asia/Krasnoyarsk",text:"Asia/Krasnoyarsk"},
      {value:"Asia/Kuala_Lumpur",text:"Asia/Kuala_Lumpur"},
      {value:"Asia/Kuching",text:"Asia/Kuching"},
      {value:"Asia/Kuwait",text:"Asia/Kuwait"},
      {value:"Asia/Macau",text:"Asia/Macau"},
      {value:"Asia/Magadan",text:"Asia/Magadan"},
      {value:"Asia/Makassar",text:"Asia/Makassar"},
      {value:"Asia/Manila",text:"Asia/Manila"},
      {value:"Asia/Muscat",text:"Asia/Muscat"},
      {value:"Asia/Nicosia",text:"Asia/Nicosia"},
      {value:"Asia/Novokuznetsk",text:"Asia/Novokuznetsk"},
      {value:"Asia/Novosibirsk",text:"Asia/Novosibirsk"},
      {value:"Asia/Omsk",text:"Asia/Omsk"},
      {value:"Asia/Oral",text:"Asia/Oral"},
      {value:"Asia/Phnom_Penh",text:"Asia/Phnom_Penh"},
      {value:"Asia/Pontianak",text:"Asia/Pontianak"},
      {value:"Asia/Pyongyang",text:"Asia/Pyongyang"},
      {value:"Asia/Qatar",text:"Asia/Qatar"},
      {value:"Asia/Qostanay",text:"Asia/Qostanay"},
      {value:"Asia/Qyzylorda",text:"Asia/Qyzylorda"},
      {value:"Asia/Riyadh",text:"Asia/Riyadh"},
      {value:"Asia/Sakhalin",text:"Asia/Sakhalin"},
      {value:"Asia/Samarkand",text:"Asia/Samarkand"},
      {value:"Asia/Seoul",text:"Asia/Seoul"},
      {value:"Asia/Shanghai",text:"Asia/Shanghai"},
      {value:"Asia/Singapore",text:"Asia/Singapore"},
      {value:"Asia/Srednekolymsk",text:"Asia/Srednekolymsk"},
      {value:"Asia/Taipei",text:"Asia/Taipei"},
      {value:"Asia/Tashkent",text:"Asia/Tashkent"},
      {value:"Asia/Tbilisi",text:"Asia/Tbilisi"},
      {value:"Asia/Tehran",text:"Asia/Tehran"},
      {value:"Asia/Thimphu",text:"Asia/Thimphu"},
      {value:"Asia/Tokyo",text:"Asia/Tokyo"},
      {value:"Asia/Tomsk",text:"Asia/Tomsk"},
      {value:"Asia/Ulaanbaatar",text:"Asia/Ulaanbaatar"},
      {value:"Asia/Urumqi",text:"Asia/Urumqi"},
      {value:"Asia/Ust-Nera",text:"Asia/Ust-Nera"},
      {value:"Asia/Vientiane",text:"Asia/Vientiane"},
      {value:"Asia/Vladivostok",text:"Asia/Vladivostok"},
      {value:"Asia/Yakutsk",text:"Asia/Yakutsk"},
      {value:"Asia/Yangon",text:"Asia/Yangon"},
      {value:"Asia/Yekaterinburg",text:"Asia/Yekaterinburg"},
      {value:"Asia/Yerevan",text:"Asia/Yerevan"},          
    ],
    atlantic : [
      {value:"Atlantic/Azores", text:"Atlantic/Azores"},
      {value:"Atlantic/Bermuda", text:"Atlantic/Bermuda"},
      {value:"Atlantic/Canary", text:"Atlantic/Canary"},
      {value:"Atlantic/Cape_Verde", text:"Atlantic/Cape_Verde"},
      {value:"Atlantic/Faroe", text:"Atlantic/Faroe"},
      {value:"Atlantic/Madeira", text:"Atlantic/Madeira"},
      {value:"Atlantic/Reykjavik", text:"Atlantic/Reykjavik"},
      {value:"Atlantic/South_Georgia", text:"Atlantic/South_Georgia"},
      {value:"Atlantic/St_Helena", text:"Atlantic/St_Helena"},
      {value:"Atlantic/Stanley", text:"Atlantic/Stanley"},
    ],
    australia : [
      {value:"Australia/Adelaide", text:"Australia/Adelaide"},
      {value:"Australia/Brisbane", text:"Australia/Brisbane"},
      {value:"Australia/Broken_Hill", text:"Australia/Broken_Hill"},
      {value:"Australia/Currie", text:"Australia/Currie"},
      {value:"Australia/Darwin", text:"Australia/Darwin"},
      {value:"Australia/Eucla", text:"Australia/Eucla"},
      {value:"Australia/Hobart", text:"Australia/Hobart"},
      {value:"Australia/Lindeman", text:"Australia/Lindeman"},
      {value:"Australia/Lord_Howe", text:"Australia/Lord_Howe"},
      {value:"Australia/Melbourne", text:"Australia/Melbourne"},
      {value:"Australia/Perth", text:"Australia/Perth"},
      {value:"Australia/Sydney", text:"Australia/Sydney"},
    ],
    europe : [
      {value:"Europe/Amsterdam",text:"Europe/Amsterdam"},
      {value:"Europe/Andorra",text:"Europe/Andorra"},
      {value:"Europe/Astrakhan",text:"Europe/Astrakhan"},
      {value:"Europe/Athens",text:"Europe/Athens"},
      {value:"Europe/Belgrade",text:"Europe/Belgrade"},
      {value:"Europe/Berlin",text:"Europe/Berlin"},
      {value:"Europe/Bratislava",text:"Europe/Bratislava"},
      {value:"Europe/Brussels",text:"Europe/Brussels"},
      {value:"Europe/Bucharest",text:"Europe/Bucharest"},
      {value:"Europe/Budapest",text:"Europe/Budapest"},
      {value:"Europe/Busingen",text:"Europe/Busingen"},
      {value:"Europe/Chisinau",text:"Europe/Chisinau"},
      {value:"Europe/Copenhagen",text:"Europe/Copenhagen"},
      {value:"Europe/Dublin",text:"Europe/Dublin"},
      {value:"Europe/Gibraltar",text:"Europe/Gibraltar"},
      {value:"Europe/Guernsey",text:"Europe/Guernsey"},
      {value:"Europe/Helsinki",text:"Europe/Helsinki"},
      {value:"Europe/Isle_of_Man",text:"Europe/Isle_of_Man"},
      {value:"Europe/Istanbul",text:"Europe/Istanbul"},
      {value:"Europe/Jersey",text:"Europe/Jersey"},
      {value:"Europe/Kaliningrad",text:"Europe/Kaliningrad"},
      {value:"Europe/Kirov",text:"Europe/Kirov"},
      {value:"Europe/Kyiv",text:"Europe/Kyiv"},
      {value:"Europe/Lisbon",text:"Europe/Lisbon"},
      {value:"Europe/Ljubljana",text:"Europe/Ljubljana"},
      {value:"Europe/London",text:"Europe/London"},
      {value:"Europe/Luxembourg",text:"Europe/Luxembourg"},
      {value:"Europe/Madrid",text:"Europe/Madrid"},
      {value:"Europe/Malta",text:"Europe/Malta"},
      {value:"Europe/Mariehamn",text:"Europe/Mariehamn"},
      {value:"Europe/Minsk",text:"Europe/Minsk"},
      {value:"Europe/Monaco",text:"Europe/Monaco"},
      {value:"Europe/Moscow",text:"Europe/Moscow"},
      {value:"Europe/Oslo",text:"Europe/Oslo"},
      {value:"Europe/Paris",text:"Europe/Paris"},
      {value:"Europe/Podgorica",text:"Europe/Podgorica"},
      {value:"Europe/Prague",text:"Europe/Prague"},
      {value:"Europe/Riga",text:"Europe/Riga"},
      {value:"Europe/Rome",text:"Europe/Rome"},
      {value:"Europe/Samara",text:"Europe/Samara"},
      {value:"Europe/San_Marino",text:"Europe/San_Marino"},
      {value:"Europe/Sarajevo",text:"Europe/Sarajevo"},
      {value:"Europe/Saratov",text:"Europe/Saratov"},
      {value:"Europe/Simferopol",text:"Europe/Simferopol"},
      {value:"Europe/Skopje",text:"Europe/Skopje"},
      {value:"Europe/Sofia",text:"Europe/Sofia"},
      {value:"Europe/Stockholm",text:"Europe/Stockholm"},
      {value:"Europe/Tallinn",text:"Europe/Tallinn"},
      {value:"Europe/Tirane",text:"Europe/Tirane"},
      {value:"Europe/Ulyanovsk",text:"Europe/Ulyanovsk"},
      {value:"Europe/Vaduz",text:"Europe/Vaduz"},
      {value:"Europe/Vatican",text:"Europe/Vatican"},
      {value:"Europe/Vienna",text:"Europe/Vienna"},
      {value:"Europe/Vilnius",text:"Europe/Vilnius"},
      {value:"Europe/Volgograd",text:"Europe/Volgograd"},
      {value:"Europe/Warsaw",text:"Europe/Warsaw"},
      {value:"Europe/Zagreb",text:"Europe/Zagreb"},
      {value:"Europe/Zurich",text:"Europe/Zurich"},
    ],
    indian : [
      {value:"Indian/Antananarivo", text:"Indian/Antananarivo"},
      {value:"Indian/Chagos", text:"Indian/Chagos"},
      {value:"Indian/Christmas", text:"Indian/Christmas"},
      {value:"Indian/Cocos", text:"Indian/Cocos"},
      {value:"Indian/Comoro", text:"Indian/Comoro"},
      {value:"Indian/Kerguelen", text:"Indian/Kerguelen"},
      {value:"Indian/Mahe", text:"Indian/Mahe"},
      {value:"Indian/Maldives", text:"Indian/Maldives"},
      {value:"Indian/Mauritius", text:"Indian/Mauritius"},
      {value:"Indian/Mayotte", text:"Indian/Mayotte"},
      {value:"Indian/Reunion", text:"Indian/Reunion"},
    ],
    pacific : [
      {value:"Pacific/Apia",text:"Pacific/Apia"},
      {value:"Pacific/Auckland",text:"Pacific/Auckland"},
      {value:"Pacific/Bougainville",text:"Pacific/Bougainville"},
      {value:"Pacific/Chatham",text:"Pacific/Chatham"},
      {value:"Pacific/Chuuk",text:"Pacific/Chuuk"},
      {value:"Pacific/Easter",text:"Pacific/Easter"},
      {value:"Pacific/Efate",text:"Pacific/Efate"},
      {value:"Pacific/Fakaofo",text:"Pacific/Fakaofo"},
      {value:"Pacific/Fiji",text:"Pacific/Fiji"},
      {value:"Pacific/Funafuti",text:"Pacific/Funafuti"},
      {value:"Pacific/Galapagos",text:"Pacific/Galapagos"},
      {value:"Pacific/Gambier",text:"Pacific/Gambier"},
      {value:"Pacific/Guadalcanal",text:"Pacific/Guadalcanal"},
      {value:"Pacific/Guam",text:"Pacific/Guam"},
      {value:"Pacific/Honolulu",text:"Pacific/Honolulu"},
      {value:"Pacific/Kanton",text:"Pacific/Kanton"},
      {value:"Pacific/Kiritimati",text:"Pacific/Kiritimati"},
      {value:"Pacific/Kosrae",text:"Pacific/Kosrae"},
      {value:"Pacific/Kwajalein",text:"Pacific/Kwajalein"},
      {value:"Pacific/Majuro",text:"Pacific/Majuro"},
      {value:"Pacific/Marquesas",text:"Pacific/Marquesas"},
      {value:"Pacific/Midway",text:"Pacific/Midway"},
      {value:"Pacific/Nauru",text:"Pacific/Nauru"},
      {value:"Pacific/Niue",text:"Pacific/Niue"},
      {value:"Pacific/Norfolk",text:"Pacific/Norfolk"},
      {value:"Pacific/Noumea",text:"Pacific/Noumea"},
      {value:"Pacific/Pago_Pago",text:"Pacific/Pago_Pago"},
      {value:"Pacific/Palau",text:"Pacific/Palau"},
      {value:"Pacific/Pitcairn",text:"Pacific/Pitcairn"},
      {value:"Pacific/Pohnpei",text:"Pacific/Pohnpei"},
      {value:"Pacific/Port_Moresby",text:"Pacific/Port_Moresby"},
      {value:"Pacific/Rarotonga",text:"Pacific/Rarotonga"},
      {value:"Pacific/Saipan",text:"Pacific/Saipan"},
      {value:"Pacific/Tahiti",text:"Pacific/Tahiti"},
      {value:"Pacific/Tarawa",text:"Pacific/Tarawa"},
      {value:"Pacific/Tongatapu",text:"Pacific/Tongatapu"},
      {value:"Pacific/Wake",text:"Pacific/Wake"},
      {value:"Pacific/Wallis",text:"Pacific/Wallis"},
    ]
  }
  var area = document.getElementById('area');
  function cambiarArea() {
    var value = area.value.toLowerCase();
    var zona = datos[value];
    var select = document.getElementById('zona');
    select.innerHTML = '';
    select.innerHTML = '<option selected>Seleccione una zona</option>';
    zona.forEach(function(item) {
      var option = document.createElement("option");
      option.value = item.value;
      option.text = item.text;
      select.appendChild(option);
    });
  }
  cambiarArea();
  var options = document.querySelectorAll('#zona option');
  var zona = "{{ $configs['APP_TIMEZONE'] }}";
  options.forEach(function (item) {
    if (item.value === zona) {
      item.setAttribute('selected','true');
    }
  })
</script>
<script>
  var pass = document.getElementById('mpassword');
  var pass2 = document.getElementById('ipassword');
  var pass3 = document.getElementById('secret');
  var btn1 = document.querySelector('#showpass');
  var btn2 = document.querySelector('#showpassi');
  var btn3 = document.querySelector('#showsecret');
  var icon1 = document.querySelector('#showpass i');
  var icon2 = document.querySelector('#showpassi i');
  var icon3 = document.querySelector('#showsecret i');

  btn1.addEventListener('click', ()=>{
    if (pass.type == 'password') {
      pass.type='text';
      icon1.classList.remove('fa-eye');
      icon1.classList.add('fa-eye-slash');
    } else{
      pass.type='password';
      icon1.classList.remove('fa-eye-slash');
      icon1.classList.add('fa-eye');
    }
  });
  btn2.addEventListener('click', ()=>{
    if (pass2.type == 'password') {
      pass2.type='text';
      icon2.classList.remove('fa-eye');
      icon2.classList.add('fa-eye-slash');
    } else{
      pass2.type='password';
      icon2.classList.remove('fa-eye-slash');
      icon2.classList.add('fa-eye');
    }
  });
  btn3.addEventListener('click', ()=>{
    if (pass3.type == 'password') {
      pass3.type='text';
      icon3.classList.remove('fa-eye');
      icon3.classList.add('fa-eye-slash');
    } else{
      pass3.type='password';
      icon3.classList.remove('fa-eye-slash');
      icon3.classList.add('fa-eye');
    }
  });
</script>
@stop