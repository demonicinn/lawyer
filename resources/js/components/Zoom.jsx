import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import ZoomConfrence from './ZoomConfrence';

const Zoom = () => {

	const [meeting, setMeeting] = useState(false);

	return (
		<div className="App">
			<main>
				<ZoomConfrence />
				{/*{meeting ?
					<ZoomConfrence />
					:
					<button className="btn btn-primary" onClick={() => setMeeting(true)}></button>
				}*/}
			</main>
		</div>
	);
}


export default Zoom;


const container = document.getElementById('zoom_conference');
//if(container){
	const root = createRoot(container);
	root.render(<Zoom />);
//}