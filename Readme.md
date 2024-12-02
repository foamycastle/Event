## foamycastle/event

Very basic event triggering system.  The classes in this package
are meant to be extended to suit the use of the user.

### Things to be aware of
* Classes extending `Event` are invokable
* Listeners can be lambda functions or extend the `Listener` class.

### Event
Implements `ArrayAccess` and `Iterator`. Invokable.
#### Properties

| Property | Type   | Description                                                                                    |
|----------|--------|------------------------------------------------------------------------------------------------|
| name     | string | The name of the event. This string will be used to trigger all listeners attached to an event. |   

#### Methods

| Method           | Arguments                              | Returns                     | Description                                                             |
|------------------|----------------------------------------|-----------------------------|-------------------------------------------------------------------------|
| `dispatch`       | ...any                                 | void                        | Call all listeners attached to the event                                |       
| `getListerners`  |                                        | `array<array-key,callable>` | Return all of the listener callables                                    |
| `addListener`    | callable `$listener`<br/>?string `$id` | void                        | Add a listener callable to the call stack                               |
| `removeListener` | string `$id`                           | void                        | Remove a listener callable from the call stack                          |
| `hasListener`    | string `$id`                           | `ListenerApi` or `null`     | Find the listener identified by `$id` and return it. Else, return null. |

### Listener
#### Invokable

| Method  | Arguments | Returns   | Description                                                 |
|---------|-----------|-----------|-------------------------------------------------------------|
| `getId` | none      | `string`  | The ID by which a listener may be known for future removal. |
