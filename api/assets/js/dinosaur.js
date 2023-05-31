import * as THREE from "./three/three";
import {OrbitControls} from "three/examples/jsm/controls/OrbitControls.js";
// import { FBXLoader } from "three/examples/jsm/loaders/FBXLoader";
// import { OBJLoader } from "three/examples/jsm/loaders/OBJLoader";
import { GLTFLoader } from "three/examples/jsm/loaders//GLTFLoader";

// TO-DO si l'élément existe exécuter
// Models

const dinoUrl = new URL("../source/trex1.glb", import.meta.url);

// Initialization

const renderer = new THREE.WebGLRenderer();

renderer.shadowMap.enabled = true;

renderer.setSize(window.innerWidth, window.innerHeight);

const dinoRender = document.querySelector("#dino-render");

dinoRender.appendChild(renderer.domElement);

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(
  75,
  window.innerWidth / window.innerHeight,
  0.1,
  1000
);

const orbit = new OrbitControls(camera, renderer.domElement);
camera.position.set(9, 10, 10);
orbit.update();

// Helpers

const axesHelper = new THREE.AxesHelper(5);
scene.add(axesHelper);
// const gridHelper = new THREE.GridHelper(30);
// scene.add(gridHelper);

// Objects

//Plane

const vertexShader = `
  varying vec2 vUv;
  uniform float time;
  
	void main() {

    vUv = uv;
    
    // VERTEX POSITION
    
    vec4 mvPosition = vec4( position, 1.0 );
    #ifdef USE_INSTANCING
    	mvPosition = instanceMatrix * mvPosition;
    #endif
    
    // DISPLACEMENT
    
    // here the displacement is made stronger on the blades tips.
    float dispPower = 1.0 - cos( uv.y * 3.1416 / 2.0 );
    
    float displacement = sin( mvPosition.z + time * 10.0 ) * ( 0.1 * dispPower );
    mvPosition.z += displacement;
    
    //
    
    vec4 modelViewPosition = modelViewMatrix * mvPosition;
    gl_Position = projectionMatrix * modelViewPosition;

	}
`;

const fragmentShader = `
  varying vec2 vUv;
  
  void main() {
  	vec3 baseColor = vec3( 0.41, 1.0, 0.5 );
    float clarity = ( vUv.y * 0.5 ) + 0.5;
    gl_FragColor = vec4( baseColor * clarity, 1 );
  }
`;

const uniforms = {
	time: {
  	value: 0
  }
}

const leavesMaterial = new THREE.ShaderMaterial({
	vertexShader,
  fragmentShader,
  uniforms,
  side: THREE.DoubleSide
});

/////////
// MESH
/////////

const instanceNumber = 5000;
const dummy = new THREE.Object3D();

const geometry = new THREE.PlaneGeometry( 0.1, 1, 1, 4 );
geometry.translate( 0, 0.5, 0 ); // move grass blade geometry lowest point at 0.

const instancedMesh = new THREE.InstancedMesh( geometry, leavesMaterial, instanceNumber );

scene.add( instancedMesh );

// Position and scale the grass blade instances randomly.

for ( let i=0 ; i<instanceNumber ; i++ ) {

	dummy.position.set(
  	( Math.random() - 0.5 ) * 10,
    0,
    ( Math.random() - 0.5 ) * 10
  );
  
  dummy.scale.setScalar( 0.5 + Math.random() * 0.5 );
  
  dummy.rotation.y = Math.random() * Math.PI;
  
  dummy.updateMatrix();
  instancedMesh.setMatrixAt( i, dummy.matrix );

}


//Dino

const assetLoader = new GLTFLoader();
let mixer;
const animationClips = [];
assetLoader.load(
  dinoUrl.href,
  function (gltf) {
    const model = gltf.scene;
    console.log(gltf.animations);
    scene.add(model);
    model.position.set(0, 0, 0);
    model.scale.set(1, 1, 1);

    const m = new THREE.AnimationMixer(gltf.scene);
    mixer = m;

    for (let i = 0; i < gltf.animations.length; ++i) {
      if (['bite', 'roar', 'run', 'attack_tail', 'idle'].includes(gltf.animations[i].name)) {
        const clip = gltf.animations[i];

        animationClips.push(clip);
        // const action = mixer.clipAction(clip);
        // action.play();
      }
    }
    // Play animation randomly every 1-10s.
// setInterval(() => {
//   action
//     .reset()
//     .play();
// }, Math.random() * 9000 + 1000);
    // const mixer = new THREE.AnimationMixer(model);
    // const animationAction = mixer.clipAction((model).animations[0]);
    // animationActions.push(animationAction);
    // activeAction = animationActions[0];
  },
  undefined,
  function (error) {
    console.error(error);
  }
);

function playRandomAnimation() {
  const randomIndex = Math.floor(Math.random() * animationClips.length);
  const clip = animationClips[randomIndex];
  const action = mixer.clipAction(clip);
  action.reset().play();
}


// const anim = new GLTFLoader();
// anim.load(dinoUrl.href, (anim) => {
//   this.mixer = new THREE.AnimationMixer(gltf);
//   const idle = this.mixer.clipAction(anim.animations[0]);
//   idle.play();
// });
// 

// Light

const ambientLight = new THREE.AmbientLight(0x333333);
scene.add(ambientLight);

const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
scene.add(directionalLight);
directionalLight.position.x = 30;
directionalLight.position.y = 20;
directionalLight.castShadow = true;
directionalLight.shadow.camera.top = 12;

const dLightHelper = new THREE.DirectionalLightHelper(directionalLight);
scene.add(dLightHelper);

const clock = new THREE.Clock();
function animate() {
  if (mixer) {
    mixer.update(clock.getDelta());
  }
  setInterval(playRandomAnimation, 1000000);

  
  leavesMaterial.uniforms.time.value = clock.getElapsedTime();
  leavesMaterial.uniformsNeedUpdate = true;
  
  renderer.render(scene, camera);
}

renderer.setAnimationLoop(animate);
