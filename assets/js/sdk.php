
<script type="module">


let mpSdk;
import { connect } from 'MP_SDK';

(async function connectSdk() {
	const iframe = document.getElementById('showcase-iframe');
	try {
		const mpSdk = await connect(iframe);
		printFloorsData(mpSdk);
		printFloorsData2(mpSdk);
		document.getElementById('changeFloor').addEventListener('click', () => { changeFloor(mpSdk) });
		tags(mpSdk);
		
	} catch (e) {
		console.error(e);
	}
})();


</script>